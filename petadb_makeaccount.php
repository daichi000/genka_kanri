<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>楽楽勤怠</title>
  </head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="petadb_login.css?<?php echo date("YmdHis"); ?>">

<script type="text/javascript">
  function setConfirmPW(pwconfs){
    var pw = document.getElementById("pw").value;

    var message = "";
    if(pw == pwconfs){
      message = "";
    }else{
      message = "パスワードが一致しません";
    }
    var div = document.getElementById("pass_confirm_message");
    if (!div.hasFistChild) {div.appendChild(document.createTextNode(""));}
    div.firstChild.data = message;
  }

  function registration_check(){
    var un = document.getElementById("un").value;
    var pw = document.getElementById("pw").value;
    var pwconf = document.getElementById("pwconf").value;

    //入力なしエラー
    if((un == "") || (pw == "") || (pwconf == "")){
      alert("入力していない項目があります");
      return false;
    }

    //パスワード不一致
    if(pw != pwconf){
      alert("パスワードが一致していません");
      return false;
    }
  }
</script>

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
  <main>
    <div class="login">
      <h2 class="login_header">アカウント登録</h2>
      <form class="login_container" action="petadb_account.php" method="post" onsubmit="return registration_check();">
      <table>
        <tr>
          <td height='1vh' width="50px">UserName</td><td><input type="text" name="un" id="un" value="" autocomplete="off"></td>
        </tr>
        <tr>
          <td height="1vh">Password</td><td><input type="password" name="pw" id="pw" value=""></td>
        </tr>
        <tr>
          <td height="1vh">Password Check</td><td><input type="password" name="pwconf" id="pwconf" value="" onkeyup="setConfirmPW(this.value);"></td><td><div id="pass_confirm_message"></div></td>
        </tr>
      </table>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <!-- <input type="checkbox" value="kanri">管理者権限で登録</br></br> -->

      <!-- 管理者チェックなくす -->
      <!-- <label>
        <input type="checkbox" name="admin" value="admin">
        <span>管理者権限で登録</span>
      </label></br></br> -->
      <center><input type="submit" name="registration" value="登録する"></center>
      </form>
      <a href="./petadb_login.php">ログイン画面へ</a>
    </div>
  </main>

</body>
</html>
