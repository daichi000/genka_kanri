
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
      /* font-family:Arial,'ＭＳ Ｐゴシック',sans-serif ; */
      /* margin-top:15px; */
      /* padding-top:9px; */
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

    .login{
      width:40vh;
      margin:auto;
      font-size:1.5vh;
      /* box-sizing: border-box; */
      height:95vh;
      padding-top:30vh;
    }

    /* body > .login{
      height:auto;
    } */

    .login_header {
      background: #28d;
      padding: 2vh;
      font-size: 1.4em;
      font-weight: normal;
      text-align: center;
      text-transform: uppercase;
      color: #fff;
      margin:0;
    }

    .login_container{
      background: #ebebeb;
      padding: 2vh;
      text-aligh: center;
    }

    .login input[type="submit"] {
      background: #28d;
      border-color: transparent;
      color: #fff;
      cursor: pointer;
      padding:2vh 10vh;
    }

    .login input[type="submit"]:hover {
      background: #17c;
    }

    /* Buttons' focus effect */
    .login input[type="submit"]:focus {
      border-color: #05a;
    }

    table{
      margin-left:2vh;
      margin-bottom:2vh;
      font-size:1.5vh;
    }

    a{
      color:white;
      float:right;
    }
    </style>
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
