<?php
try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

try{
    $sql = "SELECT * FROM test";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
}catch(PDOException $Exception){
    die('接続エラー：' .$Exception->getMessage());
}

while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
  // echo $row['color'];
  // echo $row['name'];
}


 ?>
 <form action="dbtest.php" method="post">
   ID:<input type="text" name="id" ><br/>
   name:<input type="text" name="name" ><br/>
   color:<input type="text" name="color" ><br/>
   drink:<input type="text" name="drink" >
   <input type="submit" value="送信">
 </form>

<?php
$id = null;
$name = null;
$color = null;
$drink = null;
if(!empty($_POST['id']) && is_numeric($_POST['id'])){
  $id = $_POST['id'];
  // echo $id;
}
if(!empty($_POST['name'])){
  $name = $_POST['name'];
  // echo $name;
}
if(!empty($_POST['color'])){
  $color = $_POST['color'];
  // echo $color;
}
if(!empty($_POST['drink'])){
  $drink = $_POST['drink'];
  // echo $drink;
}

$stmt = $pdo -> prepare("INSERT INTO test (ID, name, color, drink) VALUES (:ID, :name, :color, :drink)");
$stmt->bindValue(':ID', $id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':color', $color, PDO::PARAM_STR);
$stmt->bindValue(':drink', $drink, PDO::PARAM_STR);

// $name = 'one';
$stmt->execute();

//アップデート
// $colors = 'PINK';
// $names = 'Kobayashi';
// $sql = 'update test set name =:name where id = :1';
// $stmts = $pdo -> prepare($sql);
// $stmts->bindValue(':name', $names, PDO::PARAM_STR);
// $stmts->bindValue(':color', $colors, PDO::PARAM_STR);
// $stmts->execute();

 ?>
