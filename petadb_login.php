<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>楽楽勤怠</title>
  </head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="petadb_login.css?<?php echo date("YmdHis"); ?>">

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
        <h2 class="login_header">ログイン</h2>
        <form class="login_container" action="user.php" method="post" onsubmit="return unpwerror();">
          <table>
          <tr><td height="1vh" width="90px">UserName</td><td><input type="text" name="username" id="username" value="" autocomplete="off"></td></tr>
          <tr><td height="1vh">Password</td><td><input type="password" name="pass" id="pass" value=""></td></tr>
        </table>
          <center><input type="submit" name="login" value="Login"></center>
        </form>
        <a href="./petadb_makeaccount.php">アカウントをお持ちでない方はこちら</a>
      </div>
    </main>
  </body>
</html>
