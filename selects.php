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

    $send = array('key' => $sel['work_id'], 'mst_id' => $mst_ex['cdmst'], 'sub_id' => $sub_ex['code'], 'obj' => $sel['obj'], 'start' => $sel['start'], 'ends' => $sel['ends'], 'break' => $sel['break'], 'sumtime' => $sel['sumtime'], 'del' => $sel['del']);
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

?>
