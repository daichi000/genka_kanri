<?php
$after_works_id = $_POST['works'];
$task_af = $_POST['task_af'];
$code_mst_af = $_POST['code_mst_af'];
$date_af = $_POST['date_af'];
$str_af = $_POST['str_af'];
$end_af = $_POST['end_af'];
$bre_af = $_POST['bre_af'];
$work_time_af = $_POST['work_time_af'];
$idData_af = $_POST['idData_af'];

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

try{
  $upd = $pdo->prepare('UPDATE sample SET obj = :obj, master_code = :master_code, sub_code = :sub_code, day = :day, start = :start, ends = :ends, break = :break, sumtime = :sumtime WHERE work_id = :work_id');
  $params = array(':obj' => $task_af, ':master_code' => $code_mst_af, ':sub_code' => $idData_af, ':day' => $date_af, ':start' => $str_af, ':ends' => $end_af, ':break' => $bre_af, ':sumtime' => $work_time_af, ':work_id' => $after_works_id);
  $upd -> execute($params);
}catch(PDOException $e){
  print "エラー:". $e->getMessage()."<br/>";
}

//master_codeの検索
try{
  $stk = $pdo->prepare('SELECT * FROM code_master WHERE cdmst_id LIKE :cdmst_id');
  $stk -> bindValue(':cdmst_id',$code_mst_af, PDO::PARAM_STR);
  $stk -> execute();
  $cmd = $stk -> fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
  print 'エラー:'. $e->getMessage().'<br/>';
}

//dbcodeの検索
try{
  $stc = $pdo->prepare('SELECT * FROM dbcode WHERE code_id LIKE :code_id');
  $stc -> bindValue(':code_id', $idData_af, PDO::PARAM_STR);
  $stc -> execute();
  $cod = $stc -> fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
  print 'エラー:'. $e->getMessage().'<br/>';
}

$value = $date_af.' '.$str_af.'~'.$end_af.' '.$bre_af.' '.$work_time_af.' '.$cmd['cdmst'].' '.$cod['code'].' '.$task_af;
// $send_value = array('key' => $key, 'value' => $value);
// $send_value[] = array($key => $value);
// header('Content-type:application/json; charset=utf8');

// echo json_encode($send_value);
echo $value;
 ?>
