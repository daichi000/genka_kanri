<?php
session_start();
$name = $_SESSION['NAME'];

$now_Months = $_POST['select_month'];
$format = $_POST['format'];

$lastDate = date('Y-m-d', strtotime('last day of'.$now_Months));

$lastMonths = date('Y-m', strtotime($now_Months.'-01'.' -1 month'));

$now_Month = substr($now_Months, 5,6);
$lastMonth = substr($lastMonths, 5,6);

//先月の月末日
$lastMonth_Day = date('Y-m-d', strtotime('last day of'.$lastMonths));
$lastMonth_Date = substr($lastMonth_Day, 8,9);
//先月の月末まで
// for($i=16; $i<=$lastMonth_Date; $i++){
//   echo '<tr><td>'.$lastMonth.'/'.$i.'</td></tr>';
// }
// //今月の15まで
// for($j=1; $j<=15; $j++){
//   echo '<tr><td>'.$now_Month.'/'.$j.'</td></tr>';
// }

//DB接続
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

// $i = 16;
$lastMonth_ = str_replace('-','',$lastMonths);
$lastMonth_str = date('Y-m-d', strtotime($lastMonth_.'16'));
$nowMonth_str = date('Y-m-d', strtotime('first day of'.$now_Months.'-01'));//2018-02-01
$nowMonth_end = date('Y-m-d', strtotime($now_Months.'-15'));
$arr = array();
$arrs = array();
$arr_str = array();
$arr_end = array();

if($format == '/' || $format == ',' || $format == '<br>'){
  //先月16~末
  while($lastMonth_str <= $lastMonth_Day){
    try{
      $sss = $pdo->prepare('SELECT * FROM sample WHERE Userid = ? AND day = ? ORDER BY start ASC');
      // $sss -> bindValue(':day', $lastMonth_str, PDO::PARAM_STR);
      // $sss -> execute();
      $sss -> execute(array($row['Uid'], $lastMonth_str));
      while($sel = $sss -> fetch(PDO::FETCH_ASSOC)){
        if($sel['del'] == 0){
          $arr_str[] = $sel['start'];
          $arr_end[] = $sel['ends'];
          if(array_key_exists($sel['obj'], $arrs)){
            $arrs[$sel['obj']] = addclock($arrs[$sel['obj']],$sel['sumtime']);
          }else{
            // $arrs[$sel['obj']] = $sel['sumtime'];
            $arrs = array_merge($arrs,array($sel['obj'] => $sel['sumtime']));
          }
        }
      }
      $arrs_keys = array_keys($arrs);
      $arres = implode($format, $arrs_keys);
      //時間も取得する場合
      // $arr[] = array('day' => $lastMonth_str, 'obj' => $arres, 'format' => $format, 'str' => reset($arr_str), 'end' => end($arr_end));
      $arr[] = array('day' => $lastMonth_str, 'obj' => $arres, 'format' => $format);

    }catch(PDOException $e){
      print "エラー:". $e->getMessage()."<br/>";
    }

    $lastMonth_str = date('Y-m-d', strtotime($lastMonth_str.'+1 day'));
    $arrs = array();
    $arr_str = array();
    $arr_end = array();
  }

  //今月1~15
  while($nowMonth_str <= $nowMonth_end){
   try{
     $sss = $pdo->prepare('SELECT * FROM sample WHERE Userid = ? AND day = ? ORDER BY start ASC');
     // $sss -> bindValue(':day', $nowMonth_str, PDO::PARAM_STR);
     // $sss -> execute();
     $sss -> execute(array($row['Uid'], $nowMonth_str));
     while($sel = $sss -> fetch(PDO::FETCH_ASSOC)){
       if($sel['del'] == 0){
         if(array_key_exists($sel['obj'], $arrs)){
           $arrs[$sel['obj']] = addclock($arrs[$sel['obj']],$sel['sumtime']);
         }else{
           // $arrs[$sel['obj']] = $sel['sumtime'];
           $arrs = array_merge($arrs,array($sel['obj'] => $sel['sumtime']));
         }
       }
     }
     $arrs_keys = array_keys($arrs);
     $arres = implode($format, $arrs_keys);
     $arr[] = array('day' => $nowMonth_str, 'obj' => $arres, 'format' => $format);

   }catch(PDOException $e){
     print "エラー:". $e->getMessage()."<br/>";
   }

   $nowMonth_str = date('Y-m-d', strtotime($nowMonth_str.'+1 day'));
   $arrs = array();
  }

  header('Content-type:application/json; charset=utf8');
  echo json_encode($arr);

}else{ //main
  //先月16~末
  while($lastMonth_str <= $lastMonth_Day){
    try{
      $sss = $pdo->prepare('SELECT * FROM sample WHERE Userid = ? AND day = ? ORDER BY start ASC');
      $sss -> execute(array($row['Uid'], $lastMonth_str));
      // $sss -> bindValue(':day', $lastMonth_str, PDO::PARAM_STR);
      // $sss -> execute();

      while($sel = $sss -> fetch(PDO::FETCH_ASSOC)){
        $sel_time = change_s($sel['sumtime']);
        if($sel['del'] == 0){
          if(array_key_exists($sel['obj'], $arrs)){
            $arrs[$sel['obj']] += $sel_time;
          }else{
            // $arrs[$sel['obj']] = $sel['sumtime'];
            $arrs = array_merge($arrs,array($sel['obj'] => $sel_time));
          }
        }
      }
      // $arrs_keys = array_keys($arrs);
      // $arres = implode($format, $arrs_keys);
      if(!empty($arrs)){
        $max = max($arrs);
        $code_max = array_search($max, $arrs);
        $arr[] = array('day' => $lastMonth_str, 'obj' => $code_max, 'format' => $format);
      }else{
        $arr[] = array('day' => $lastMonth_str, 'obj' => '', 'format' => $format);
      }


    }catch(PDOException $e){
      print "エラー:". $e->getMessage()."<br/>";
    }

    $lastMonth_str = date('Y-m-d', strtotime($lastMonth_str.'+1 day'));
    $arrs = array();
  }

  //今月1~15
  while($nowMonth_str <= $nowMonth_end){
   try{
     $sss = $pdo->prepare('SELECT * FROM sample WHERE Userid = ? AND day = ? ORDER BY start ASC');
     $sss -> execute(array($row['Uid'], $nowMonth_str));
     // $sss -> bindValue(':day', $nowMonth_str, PDO::PARAM_STR);
     // $sss -> execute();

     while($sel = $sss -> fetch(PDO::FETCH_ASSOC)){
       $sel_time = change_s($sel['sumtime']);
       if($sel['del'] == 0){
         if(array_key_exists($sel['obj'], $arrs)){
           $arrs[$sel['obj']] += $sel_time;
         }else{
           // $arrs[$sel['obj']] = $sel['sumtime'];
           $arrs = array_merge($arrs,array($sel['obj'] => $sel_time));
         }
       }
     }

     if(!empty($arrs)){
       $max = max($arrs);
       $code_max = array_search($max, $arrs);
       $arr[] = array('day' => $nowMonth_str, 'obj' => $code_max, 'format' => $format);
     }else{
       $arr[] = array('day' => $nowMonth_str, 'obj' => '', 'format' => $format);
     }

   }catch(PDOException $e){
     print "エラー:". $e->getMessage()."<br/>";
   }

   $nowMonth_str = date('Y-m-d', strtotime($nowMonth_str.'+1 day'));
   $arrs = array();
  }

  header('Content-type:application/json; charset=utf8');
  echo json_encode($arr);
}

function addclock($a, $b){
  $aArray = explode(':',$a);
  $a_s = $aArray[0]*60*60 + $aArray[1]*60 + $aArray[2];
  $bArray = explode(':',$b);
  $b_s = $bArray[0]*60*60 + $bArray[1]*60 + $bArray[2];

  $c_s = $a_s + $b_s;
  // return $c_s;
  $h = 0;
  $m = 0;
  while ($c_s >= 60) {
      if ($c_s >= 3600) {
          $c_s -= 3600;
          $h++;
      } else {
          $c_s -= 60;
          $m++;
      }
  }
  return date('H:i:s',mktime($h,$m,$c_s));
}

function change_s($time){
  $timeArray = explode(':',$time);
  $time_s = $timeArray[0]*60*60 + $timeArray[1]*60 + $timeArray[2];
  return $time_s;
}
?>
