<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form class="" action="petadb_login.php" method="post">
      UserName<input type="text" name="username" value=""><br>
      Password<input type="text" name="pass" value=""><br>
      <input type="submit" name="login" value="Login">
    </form>
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


    //name検索
    if(isset($_POST['username'])){
      if($_POST['username']!=''){
        try{
          $stt = $pdo->prepare('SELECT * FROM dbtest WHERE username LIKE :name');//名前付きパラメータ
          $stt -> bindValue(':name',$_POST['username']);//postを代入
          $stt -> execute();
          if(!$row = $stt -> fetch(PDO::FETCH_ASSOC)){
            echo "not account";
          }
          while($row = $stt -> fetch(PDO::FETCH_ASSOC)){

            if($_POST['pass'] == $row['password']){
              echo "OK"."<br>";
              header("Location:http://localhost/petadb/petadb_main.php");
            }else{
              echo "PWNG"."<br>";
              break;
            }
          }
        }catch(PDOException $e){
          print("error:". $e->getMessage());
        }
      }
    }



 ?>
  </body>
</html>
