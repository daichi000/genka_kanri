<?php
$after_works_id = 242;//work_id
$task_af = 'gggg';//obj
$code_mst_af = 6;//master_code
$date_af = '2020-12-12';//day
$str_af = '11:11:11';//start
$end_af = '11:11:11';//ends
$bre_af = '11:11:11';//break
$work_time_af = '11:11:11';//sumtime
$idData_af = 9;//sub_code

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

try{
  $upd = $pdo->prepare('UPDATE sample SET obj = :obj, master_code = :master_code, sub_code = :sub_code WHERE work_id = :work_id');
  $params = array(':obj' => $task_af, ':master_code' => $code_mst_af,':sub_code' => $idData_af, ':work_id' => $after_works_id);
  $upd -> execute($params);
}catch(PDOException $e){
  print "エラー:". $e->getMessage()."<br/>";
}

echo($after_works_id.$task_af.$code_mst_af.$date_af.$str_af.$end_af.$bre_af.$work_time_af.$idData_af);
 ?>
