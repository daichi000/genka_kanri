<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
  height:5vh;
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
  width:460px;
  margin:auto;
  font-size:16px;
  /* box-sizing: border-box; */
  height:95vh;
  padding-top:300px;
}

/* body > .login{
  height:auto;
} */

.login_header {
  background: #28d;
  padding: 20px;
  font-size: 1.4em;
  font-weight: normal;
  text-align: center;
  text-transform: uppercase;
  color: #fff;
  margin:0;
}

.login_container{
  background: #ebebeb;
  padding: 12px;
  text-aligh: center;
}

.login input[type="submit"] {
  background: #28d;
  border-color: transparent;
  color: #fff;
  cursor: pointer;
  padding:20px 100px;
}

.login input[type="submit"]:hover {
  background: #17c;
}

/* Buttons' focus effect */
.login input[type="submit"]:focus {
  border-color: #05a;
}

table{
  margin-left:20px;
  margin-bottom:20px;
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
      <h2 class="login_header">アカウント登録</h2>
      <form class="login_container" action="petadb_account.php" method="post" onsubmit="return registration_check();">
      <table>
        <tr>
          <td height='50px' width="90px">UserName</td><td><input type="text" name="un" id="un" value="" autocomplete="off"></td>
        </tr>
        <tr>
          <td height="50px">Password</td><td><input type="password" name="pw" id="pw" value=""></td>
        </tr>
        <tr>
          <td height="50px">Password Check</td><td><input type="password" name="pwconf" id="pwconf" value="" onkeyup="setConfirmPW(this.value);"></td><td><div id="pass_confirm_message"></div></td>
        </tr>
      </table>

      <center><input type="submit" name="registration" value="登録する"></center>
      </form>
      <a href="./petadb_login.php">ログイン画面へ</a>
    </div>
  </main>



</body>
</html>
