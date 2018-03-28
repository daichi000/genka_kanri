<?php
$edit_works_id = $_POST['works'];

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','13qe!#QE');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

//sample検索
try{
  $ser = $pdo->prepare('SELECT * FROM sample WHERE work_id LIKE :work_id');
  $ser -> bindValue(':work_id', $edit_works_id, PDO::PARAM_STR);
  $ser -> execute();
  $res = $ser -> fetch(PDO::FETCH_ASSOC);
}catch(PDOException $e){
  print 'エラー:'. $e->getMessage().'<br/>';
}

//master_code検索
// try{
//   $mas = $pdo->prepare('SELECT * FROM code_master WHERE cdmst_id LIKE :cdmst_id');
//   $mas -> bindValue(':cdmst_id', $res['master_code'], PDO::PARAM_STR);
//   $mas -> execute();
//   $rsl = $mas -> fetch(PDO::FETCH_ASSOC);
// }catch(PDOException $e){
//   print 'エラー:'. $e->getMessage().'<br/>';
// }

$send_edit_res = array('date_' => $res['day'], 'str_' => $res['start'], 'end_' => $res['ends'], 'bre_' => $res['break'], 'time_' => $res['sumtime'], 'mst_' => $res['master_code'], 'sub_' => $res['sub_code'], 'task_' => $res['obj']);
header('Content-type:application/json; charset=utf8');
echo json_encode($send_edit_res);
 ?>
