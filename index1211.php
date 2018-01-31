<?php
try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  // echo "OK";
}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}
$id = $_POST['name'];
$arr = array();
try{
    $stmh = $pdo -> prepare("SELECT * FROM dbcode WHERE master_id LIKE :id");
    $stmh -> bindValue(':id', $id, PDO::PARAM_INT);
    $stmh -> execute();
		// $arr = array();
		// while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
		//    $arr = array("id" => $row['ID']);
		//
		//  }
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
      $arr[] = $row['code']."<br>";
      // echo $row['code'];
    }
}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}


// while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
	// $arr = array(
	// 	"message" => $row['ID'],
	// 	"name" => $row['name']
	// )};
	// echo $row['ID'];}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($arr,JSON_PRETTY_PRINT);

// echo $_POST['name'];
 ?>
