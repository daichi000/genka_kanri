<?php
$kanri_month = $_POST['select_kanri_month'];
$select_user = $_POST['select_user'];
// $kanri_month_time = date('H:i:s',mktime(0,0,0));
$kanri_month_time = date('H:i',mktime(0,0));

//DB
try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','13qe!#QE');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

try{
  $select_month_name = $pdo->prepare('SELECT * FROM sample WHERE Userid = ? AND day like ? AND master_code = ? ORDER BY start ASC');

  //レコード数
  $master_count_sql = $pdo->query('SELECT cdmst_id FROM code_master');
  $master_count_sql -> execute();
  $master_count = $master_count_sql -> rowCount();

  $master_code = 1;
  $arrs = array();
  while($master_code <= $master_count){
    $arr = array();
    $select_month_name -> execute(array($select_user, $kanri_month.'%', $master_code));

    //マスターコードの名前検索
    $master_name = $pdo->prepare('SELECT * FROM code_master WHERE cdmst_id LIKE :cdmst_id');
    $master_name -> bindValue(':cdmst_id', $master_code, PDO::PARAM_INT);
    $master_name -> execute();
    $master_name_front = $master_name -> fetch(PDO::FETCH_ASSOC);
    // if($res != $select_month_name -> fetch(PDO::FETCH_ASSOC)){
    //   $arr = array_merge($arr,array(" " => "00:00"));
    // }

    // if($res = $select_month_name -> fetch(PDO::FETCH_ASSOC) == false){
    //   $arr += array("null" => '00:00');
    //   continue;
    //   // break;
    // }
    while($res = $select_month_name -> fetch(PDO::FETCH_ASSOC)){
        //サブコードの名前検索
        $sub_name = $pdo->prepare('SELECT * FROM dbcode WHERE code_id LIKE :code_id');
        $sub_name -> bindValue(':code_id', $res['sub_code'], PDO::PARAM_STR);
        $sub_name -> execute();
        $sub_name_front = $sub_name -> fetch(PDO::FETCH_ASSOC);

        // if($res['del'] == 1){
        //   continue;
        // }
        if($res['del'] == 0){
          if(array_key_exists($sub_name_front['code'], $arr)){
            $arr[$sub_name_front['code']] = addclock($arr[$sub_name_front['code']], substr($res['sumtime'], 0, -3));
          }else{
            // $arr = array_merge($arr,array($res['sub_code'] => $res['sumtime']));
            // $arr = array_merge($arr, array($sub_name_front['code'] => $res['sumtime']));
            $arr += array($sub_name_front['code'] => substr($res['sumtime'], 0, -3));
          }
        }
      }
      // if($res = $select_month_name -> fetch(PDO::FETCH_ASSOC) == false){
      //   $arr += array("null" => '00:00');
      //   // continue;
      //   break;
      // }

    // $master_time = date('H:i:s',mktime(0,0,0));
    $master_time = date('H:i',mktime(0,0));
    // $master_time = '00:00:00';
    //マスターコード合計時間
    foreach($arr as $key => $value){
      $master_time = addclock($master_time, $value);
    }

    $kanri_month_time = addclock($kanri_month_time, $master_time);

    if($arr == null){
      $arrs[] = array('master' => $master_name_front['cdmst'], 'sub' => array(' ' => '00:00'), 'time' => '00:00', 'm_time' => $kanri_month_time);
    }else{
      $arrs[] = array('master' => $master_name_front['cdmst'], 'sub' => $arr, 'time' => $master_time, 'm_time' => $kanri_month_time);
    }
    $master_code += 1;
  }

}catch(PDOException $e){
  print "エラー:". $e->getMessage()."<br/>";
}

function addclock($a, $b){
  if($a == null || $b == null){
    return;
  }
  $aArray = explode(':',$a);
  // $a_s = $aArray[0]*60*60 + $aArray[1]*60 + $aArray[2];
  $a_h = $aArray[0];
  $a_m = $aArray[1];
  $bArray = explode(':',$b);
  $b_h = $bArray[0];
  $b_m = $bArray[1];
  // $b_s = $bArray[0]*60*60 + $bArray[1]*60 + $bArray[2];

  // $c_s = $a_s + $b_s;
  $h = 0;
  $c_m = $a_m + $b_m;
  while($c_m >= 60){
    $c_m -= 60;
    $h++;
  }
  $c_h = $a_h + $b_h + $h;
  // $m = 0;
  // while ($c_s >= 60) {
  //     if ($c_s >= 3600) {
  //         $c_s -= 3600;
  //         $h++;
  //     } else {
  //         $c_s -= 60;
  //         $m++;
  //     }
  // }
  // return date('h:i:s',mktime($h,$m,$c_s));

  if($c_h >= 24){

    if($c_m == 0){
      $ret = $c_h. ':' . '00'. ':'. date('s',0);
      $ret = 3;
      // return $c_h. ':' . '00'. ':'. date('s',0);
      return $c_h. ':' . '00';
    }else{
      $ret = $c_h. ':' . $c_m. ':'. date('s',0);
      $ret = 3;
      // return $c_h. ':' . $c_m. ':'. date('s',0);
      return $c_h. ':' . $c_m;
    }
    // $ret = $c_h. date(':i:s',mktime($c_m,'0'));

  }else{

    $ret2 = date('H:i',mktime($c_h,$c_m));
    $ret2 = 4;
    // return date('H:i:s',mktime($c_h,$c_m,0));
    return date('H:i',mktime($c_h,$c_m));
  }

}

header('Content-type:application/json; charset=utf8');
echo json_encode($arrs);
// echo $kanri_month;
 ?>
