<?php

?>
<script type="text/javascript">
  // function passwordid(){
  //   var pw = document.getElementById("pw").value;
  //   var pwconf = document.getElementById("pwconf").value;
  //
  //   if(pw != pwconf){
  //   alert("パスワードが一致していません");
  //   return false;
  //   }
  // }

  // var pwconf = document.getElementById("pwconf").value;
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
Regstration<br/><br/>
<form class="" action="petadb_account.php" method="post" onsubmit="return registration_check();">
<table>
  <tr>
    <td>UserName</td><td><input type="text" name="un" id="un" value=""></td>
  </tr>
  <tr>
    <td>Password</td><td><input type="password" name="pw" id="pw" value=""></td>
  </tr>
  <tr>
    <td>Password Check</td><td><input type="password" name="pwconf" id="pwconf" value="" onkeyup="setConfirmPW(this.value);"></td><td><div id="pass_confirm_message"></div></td>
  </tr>
</table>

<input type="submit" name="registration" value="go">
</form>

<?php
