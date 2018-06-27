<?php
session_start();
$select_date = $_POST['select_date'];
$name = $_SESSION['NAME'];
// echo $x.$name;

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','13qe!#QE');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

//Uid検索
//id検索
try{
  $stz = $pdo->prepare('SELECT * FROM petauser WHERE Name LIKE :name');
  $stz -> bindValue(':name',htmlspecialchars($name, ENT_QUOTES), PDO::PARAM_STR);
  $stz -> execute();
  $row = $stz -> fetch(PDO::FETCH_ASSOC);
  // echo $row[Uid]
}catch(PDOException $e){
  print "エラー:". $e->getMessage()."<br/>";
}
// echo $row['Uid'];

//task_select
$array = array();
try{
  $sss = $pdo->prepare('SELECT * FROM sample WHERE Userid = ? AND day = ? ORDER BY start ASC');
  // $sss -> bindValue($row['Uid'], $select_date, PDO::PARAM_STR);
  // $sss -> bindValue(':day',$select_date, PDO::PARAM_STR);
  $sss -> execute(array($row['Uid'], $select_date));
  $sumtime = date('H:i',mktime(0,0));
  while($sel = $sss -> fetch(PDO::FETCH_ASSOC)){
    $sub_id = $sel['sub_code'];
    $mst_id = $sel['master_code'];
    //sub_id問い合わせ
    try{
      $sub = $pdo->prepare('SELECT * FROM dbcode WHERE code_id LIKE :code_id');
      $sub -> bindValue(':code_id', $sub_id, PDO::PARAM_STR);
      $sub -> execute();
      $sub_ex = $sub -> fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
      print "エラー:". $e->getMessage()."<br/>";
    }
    //mst_id問い合わせ
    try{
      $mst = $pdo->prepare('SELECT * FROM code_master WHERE cdmst_id LIKE :cdmst_id');
      $mst -> bindValue(':cdmst_id', $mst_id, PDO::PARAM_STR);
      $mst -> execute();
      $mst_ex = $mst -> fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
      print "エラー:". $e->getMessage()."<br/>";
    }

    //一日の合計時間
    $time = substr($sel['sumtime'],0,-3);
    if($sel['del'] == 0){
      $sumtime = addclock($sumtime, $time);
    }
    $send = array('key' => $sel['work_id'], 'mst_id' => $mst_ex['cdmst'], 'sub_id' => $sub_ex['code'], 'obj' => $sel['obj'], 'start' => $sel['start'], 'ends' => $sel['ends'], 'break' => $sel['break'], 'sumtime' => $sel['sumtime'], 'del' => $sel['del'], 'd_time' => $sumtime);
    $array[] = $send;
    // $sss -> MoveNext();
    // echo $sel['work_id'];
  }
  // echo $row[Uid];
}catch(PDOException $e){
  print "エラー:". $e->getMessage()."<br/>";
}

header('Content-type:application/json; charset=utf8');
echo json_encode($array);
// $send = array('key' => $key, 'value' => $sel['master_code']);
// header('Content-type:application/json; charset=utf8');
// echo json_encode($send);
// if($sel){
//   echo $sel['obj'];
// }else{
//   echo ('not object');
// }
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
?>
