<?php
$works_id = $_POST['works'];

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','13qe!#QE');
}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

//delete
try{
  $std = $pdo->prepare('UPDATE sample SET del = :del WHERE work_id = :id');
  $std -> bindValue(':del', 1, PDO::PARAM_INT);
  $std -> bindValue(':id', $works_id, PDO::PARAM_STR);
  $std -> execute();
}catch(PDOException $e){
  print('error:'. $e->getMessage());
}

echo $works_id;
 ?>
