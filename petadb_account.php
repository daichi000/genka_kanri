<!DOCTYPE html>
<body>
  <header>
    <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
    <h1>開発課原価管理</h1>
    <div class="top_login">
      <i class="material-icons">person</i>
      <span class='login'><?php echo 'no user'; ?></span>
    </div>
    <div class="logout">

    </div>

  </header>
  <script type="text/javascript" src="info.js">
  </script>


<?php

//DB接続
try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','13qe!#QE');
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
  $pass_org = $_POST['pw'];
  $pass = hash("sha256", $pass_org);
  // echo $id;
}
// echo $name;

//同一のアカウントが存在するかどうか
try{
  $stt = $pdo->prepare('SELECT * FROM petauser WHERE Name LIKE :name');//名前付きパラメータ
  $stt -> bindValue(':name',$name);//postを代入
  $stt -> execute();
  if($row = $stt -> fetch(PDO::FETCH_ASSOC)){
    // echo "同一アカウントあり";
  ?>
  <main>
    <div class="ng">
      <p>同一アカウントが存在するため登録できませんでした。</p>
      <center><input type="button" value="戻る" onClick="location.href='./petadb_makeaccount.php'"></center>
    </div>
  </main>

  <?php
  }else{
  //登録
  $stmt = $pdo -> prepare("INSERT INTO petauser (Name, password, admin) VALUES (:username, :password, :admin)");
  // $name = $_POST["un"];
  $stmt->bindValue(':username', $name, PDO::PARAM_STR);
  $stmt->bindValue(':password', $pass, PDO::PARAM_STR);
  if(isset($_POST['admin'])){
    $stmt->bindValue(':admin', 1, PDO::PARAM_INT);
  }else{
    $stmt->bindValue(':admin', 0, PDO::PARAM_INT);
  }
  $stmt->execute();
  // echo "登録完了"."<br>"."以下からログインしてください";
  ?>
  <main>
    <div class="ok">
      <p>アカウント登録が完了しました！</p>
      <center><input type="button" value="ログイン画面へ" onClick="location.href='./petadb_login.php'"></center>
    </div>
  </main>
  <!-- <input type="button" name="" value="ログイン画面へ" onClick="location.href='http://localhost/petadb/petadb_login.php'"> -->
  <?php
  }
}catch(PDOException $e){
    print("error:". $e->getMessage());
}
 ?>
<html>
 <head>
   <meta charset="utf-8">
   <link rel="shortcut icon" href="favicon.ico">
   <title>楽楽勤怠</title>
 </head>
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

 <style type="text/css">
 html{
   height:100%;
 }

 body{
   height:100%;
 }

 main {
   background: #456;
   font-family: 'Open Sans', sans-serif;
   height:95%;
   padding-top:30vh;
 }

 header{
   background-color:#44DEDE;
   height:50px;
 }

 .jmc_icon{
   border:1.2px black solid;
   border-radius:5px;
   float:left;
   margin-right:30px;
   margin-top:3px;
   margin-left:5px;
 }

 header h1{
   font-size:25px;
   color:#F5F5F5;
   margin:6px 0 0 0;
   float:left;
 }

 .top_login{

   float:right;
   /* width:30px; */
   height:30px;
   margin-right:100px;
   padding-top:2px;
   margin-top:10px;
   border-left:1px #dcdcdc solid;
   border-right:1px #dcdcdc solid;
 }

 header i{
   float:left;
 }

 .ng, .ok{
   width:50vh;
   margin:auto;
   font-size:1.5vh;
   /* box-sizing: border-box; */
   margin-top:-5vh;
   padding-top:20vh;
   background: #ebebeb;
   padding: 2vh;
   /* text-aligh: center; */
 }

 .ng p, .ok p{
   text-align: center;
 }

 input[type="button"] {
   background: #28d;
   border-color: transparent;
   color: #fff;
   cursor: pointer;
   padding:20px 100px;
 }

 input[type="button"]:hover {
   background: #17c;
 }

 /* Buttons' focus effect */
 input[type="button"]:focus {
   border-color: #05a;
 }

 </style>
 </body>
</html>
