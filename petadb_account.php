<?php
//DB接続
try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

try{
    $sql = "SELECT * FROM dbtest";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}

while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
  // echo $row['color'];
  // echo $row['name'];
}

$name = null;
$pass = null;
// echo $_POST['un'];
if(!empty($_POST['un'])){
  $name = $_POST['un'];
  // echo $id;
}
if(!empty($_POST['pw'])){
  $pass = $_POST['pw'];
  // echo $id;
}
// echo $name;
$stmt = $pdo -> prepare("INSERT INTO dbtest (username, password) VALUES (:username, :password)");
// $name = $_POST["un"];
$stmt->bindValue(':username', $name, PDO::PARAM_STR);
$stmt->bindValue(':password', $pass, PDO::PARAM_STR);
$stmt->execute();

if($_POST["un"]=="daichi" && $_POST["pw"]=="123"){
  echo "Login OK";
}else{
  echo "Not Login";
}
// echo $a;
 ?>
