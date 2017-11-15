<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <script type="text/javascript">
      function unpwerror(){
        var id = document.getElementById("id").value;
        var pass = document.getElementById("pass").value;

        if((id == "") || (pass == "")){
          alert("入力していない箇所があります");
          return false;
        }
      }
    </script>
    <form class="" action="petadb_main.php" method="post" onsubmit="return unpwerror();">
      UserName<input type="text" name="username" id="id" value=""><br>
      Password<input type="password" name="pass" id="pass" value=""><br>
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
    if(isset($_POST['username']) && isset($_POST['pass'])){

      if($_POST['username']!=''){
        try{
          $stt = $pdo->prepare('SELECT * FROM dbtest WHERE username LIKE :name');//名前付きパラメータ
          $stt -> bindValue(':name',$_POST['username']);//postを代入
          $stt -> execute();
          // while(!$row = $stt -> fetch(PDO::FETCH_ASSOC)){
          //   echo "not account";
          // }
          if($row = $stt -> fetch(PDO::FETCH_ASSOC)){
            // echo "ok";
            if($_POST['pass'] == $row['password']){
                echo "OK"."<br>";
                header("Location:http://localhost/petadb/petadb_main.php");
              }else{
                echo "PWNG"."<br>";
                // break;
              }
          }else{
            echo "not account";
          }

          // while($row = $stt -> fetch(PDO::FETCH_ASSOC)){
          //
          //
          //   $row += 1;
          // }
        }catch(PDOException $e){
          print("error:". $e->getMessage());
        }
      }
    }else{
      echo "入力していない箇所あり";
    }


 ?>
  </body>
</html>
