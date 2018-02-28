<?php
session_start();
// $name = $_POST['username'];
$idData = $_POST['idData'];
$task = $_POST['task'];
$code_mst = $_POST['code_mst'];
$date = $_POST['date'];
$str = $_POST['str'];
$end = $_POST['end'];
$bre = $_POST['bre'];
$work_time = $_POST['work_time'];

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

//id検索
try{
  $stz = $pdo->prepare('SELECT * FROM petauser WHERE Name LIKE :name');
  $stz -> bindValue(':name',htmlspecialchars($_SESSION['NAME'], ENT_QUOTES), PDO::PARAM_STR);
  $stz -> execute();
  $row = $stz -> fetch(PDO::FETCH_ASSOC);
  // echo $row[Uid]
}catch(PDOException $e){
  print "エラー:". $e->getMessage()."<br/>";
}

//master_codeの検索
try{
  $stk = $pdo->prepare('SELECT * FROM code_master WHERE cdmst_id LIKE :cdmst_id');
  $stk -> bindValue(':cdmst_id',$code_mst, PDO::PARAM_STR);
  $stk -> execute();
  $cmd = $stk -> fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
  print 'エラー:'. $e->getMessage().'<br/>';
}

//dbcodeの検索
try{
  $stc = $pdo->prepare('SELECT * FROM dbcode WHERE code_id LIKE :code_id');
  $stc -> bindValue(':code_id', $idData, PDO::PARAM_STR);
  $stc -> execute();
  $cod = $stc -> fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
  print 'エラー:'. $e->getMessage().'<br/>';
}

//data格納
try{
  $stu = $pdo->prepare('INSERT INTO sample (Userid, obj, master_code, sub_code, day, start, ends, break, sumtime, del ) VALUES (:Userid, :obj, :master_code, :sub_code, :day, :start, :ends, :break, :sumtime, :del)');
  $stu -> bindValue(':Userid',$row['Uid']);
  $stu -> bindValue(':obj', $task, PDO::PARAM_STR);
  $stu -> bindValue(':master_code', $code_mst, PDO::PARAM_STR);
  $stu -> bindValue(':sub_code', $idData, PDO::PARAM_STR);
  $stu -> bindValue(':day', $date, PDO::PARAM_STR);
  $stu -> bindValue(':start', $str, PDO::PARAM_STR);
  $stu -> bindValue(':ends', $end, PDO::PARAM_STR);
  $stu -> bindValue(':break', $bre, PDO::PARAM_STR);
  $stu -> bindValue(':sumtime', $work_time, PDO::PARAM_STR);
  $stu -> bindValue(':del', 0, PDO::PARAM_STR);
  $stu -> execute();
  // echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES).' '.$task.' '.$cmd['cdmst'].' '$cod['code'].' '.$date.' '.$str.' '.$end.' '.$bre.' '.$work_time;

  // $stq = $pdo->prepare('SELECT LAST_INSERT_ID()');
  // $stq -> execute();
  // $key = $stq -> fetch(PDO::FETCH_ASSOC);

  //最後にinsertしたidを取得
  $key = $pdo->lastInsertId('work_id');
}catch(PDOException $e){
  print('error:'. $e->getMessage());
}

// $key = mysql_insert_id();

// $value = $date.' '.$str.'~'.$end.' '.$bre.' '.$work_time.' '.$cmd['cdmst'].' '.$cod['code'].' '.$task;
$send_value = array('key' => $key, 'date' => $date, 'str' => $str, 'end' => $end, 'bre' => $bre, 'work_time' => $work_time, 'mst' => $cmd['cdmst'], 'sub' => $cod['code'], 'task' => $task);
// $send_value[] = array($key => $value);
header('Content-type:application/json; charset=utf8');

echo json_encode($send_value);

// echo $key;
// echo $date.' '.$str.'~'.$end.' '.$bre.' '.$work_time.' '.$cmd['cdmst'].' '.$cod['code'].' '.$task;
 ?>
