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

//同一のアカウントが存在するかどうか
try{
  $stt = $pdo->prepare('SELECT * FROM petauser WHERE Name LIKE :name');//名前付きパラメータ
  $stt -> bindValue(':name',$name);//postを代入
  $stt -> execute();
  if($row = $stt -> fetch(PDO::FETCH_ASSOC)){
    echo "同一アカウントあり";
  }else{
  //登録
  $stmt = $pdo -> prepare("INSERT INTO petauser (Name, password) VALUES (:username, :password)");
  // $name = $_POST["un"];
  $stmt->bindValue(':username', $name, PDO::PARAM_STR);
  $stmt->bindValue(':password', $pass, PDO::PARAM_STR);
  $stmt->execute();
  echo "登録完了"."<br>"."以下からログインしてください";
  ?>
  <input type="button" name="" value="ログイン画面へ" onClick="location.href='http://localhost/petadb/petadb_login.php'">
  <?php
  }
}catch(PDOException $e){
    print("error:". $e->getMessage());
}


// if($_POST["un"]=="daichi" && $_POST["pw"]=="123"){
//   echo "Login OK";
// }else{
//   echo "Not Login";
// }
// // echo $a;
 ?>
