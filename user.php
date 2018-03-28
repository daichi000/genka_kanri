<?php
if($_POST['username'] == '' || $_POST['pass'] == ''){
  header("Location:./petadb_login.php");
}else{
  $name = $_POST['username'];
  $pw = $_POST['pass'];

  //セッション開始
  session_start();
  $status = "none";
  // $namejs = array($name);
    try{
      $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','13qe!#QE');
      // echo "OK";


    }catch(PDOException $e){
      print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
    $sql = "SELECT * FROM code_master";
    $stmt = $pdo->query($sql);
    $cdmst_list = array();
    //cdmst_list[1]= E (製品製造)
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
      $cdmst_list[$row['cdmst_id']] = $row['cdmst'];
    }

    if($name != ''){
      try{
        //ログイン情報で名前検索
          $stt = $pdo->prepare('SELECT * FROM petauser WHERE Name LIKE :name');//名前付きパラメータ
          $stt -> bindValue(':name',$name);//postを代入
          $stt -> execute();
          if($row = $stt -> fetch(PDO::FETCH_ASSOC)){
            // echo "ok";
            if($pw == $row['password']){
                // echo "OK"."<br>";
                // header("Location:http://localhost/petadb/user.php");
                //セッションに格納
                $_SESSION['NAME'] = $name;
                // echo $name.'<br>';
              }else{
                // echo "PWNG"."<br>";
                ?>
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
                  padding-top:300px;
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

                .ng, .ok{
                  width:500px;
                  margin:auto;
                  font-size:16px;
                  /* box-sizing: border-box; */
                  /* margin-top:300px; */
                  padding-top:300px;
                  background: #ebebeb;
                  padding: 12px;
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

                input.font-awesome{
                  font-family: Font-Awesome;
                  font-style: normal;
                  font-weight: normal;
                  text-decoration: inherit;
                }
                </style>
                <body>
                  <header>
                    <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
                    <h1>開発課原価管理</h1>
                    <div class="top_login">
                      <i class="material-icons">person</i>
                      <span class='login'><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></span>
                    </div>
                    <div class="logout">

                    </div>
                  </header>
                  <script type="text/javascript" src="info.js">
                  </script>
                  <main>
                    <div class="ng">
                      <p>パスワードが違います</p>
                      <center><input type="button" value="戻る" onClick="location.href='./petadb_login.php'"></center>
                    </div>
                  </main>
                  <?php
                exit();
              }
          }else{
            // echo "not account";
            ?>
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
              padding-top:300px;
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

            .ng, .ok{
              width:500px;
              margin:auto;
              font-size:16px;
              /* box-sizing: border-box; */
              /* margin-top:300px; */
              padding-top:300px;
              background: #ebebeb;
              padding: 12px;
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

            input.font-awesome{
              font-family: Font-Awesome;
              font-style: normal;
              font-weight: normal;
              text-decoration: inherit;
            }
            </style>
            <body>
              <header>
                <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
                <h1>開発課原価管理</h1>
                <div class="top_login">
                  <i class="material-icons">person</i>
                  <span class='login'><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></span>
                </div>
                <div class="logout">

                </div>
              </header>
              <script type="text/javascript" src="info.js">
              </script>
              <main>
                <div class="ng">
                  <p>アカウントが存在しません</p>
                  <center><input type="button" value="戻る" onClick="location.href='./petadb_login.php'"></center>
                </div>
              </main>
            <?php
            exit();
          }
        }catch(PDOException $e){
          print("error:". $e->getMessage());
        }
    }else{
      // echo "入力していない箇所あり";
    }
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザ入力画面</title>

  <script src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="./jquery-ui-1.12.1.custom/jquery.timepicker.css" />
  <link rel="stylesheet" href="user.css" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <script src="./jquery-ui-1.12.1.custom/jquery.timepicker.min.js"></script>
  <script src="./user.js"></script>

</head>

<body>
  <header>
    <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
    <h1>開発課原価管理</h1>
    <div class="logout">
      <!-- <i class="material-icons w3-xxxlarge" onClick="location.href='./petadb_login.php'">arrow_forward</i> -->
      <a href="./petadb_login.php"><img src="./logout.png" alt=""></a>
    </div>
    <div class="top_login">
      <i class="material-icons">person</i>
      <span class='login'><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></span>
    </div>


  </header>
    <!-- 旧サイドメニュー -->
    <div class="tabs">
      <!-- <div class="side_tabs"> -->
        <input type="radio" id='in' name="tab_item" checked>
        <label class="tab_item" for="in">作業入力</label>
        <input type="radio" id='day_out' name="tab_item">
        <label class="tab_item" for="day_out">作業表示（日）</label>
        <input type="radio" id='month_out' name="tab_item">
        <label class="tab_item" for="month_out">作業表示（月）</label>
        <div class="tab_bottom">
        </div>
        <div class="menu">
        <i class="material-icons" id="menu">menu</i>
        </div>

      <!-- </div> -->

    <div class="tab_content" id="in_content">
      <table id='write_tb'>
      <caption>作業入力欄</caption>
      <tr><td>作業日</td><td id="date_err" width="90px"></td><td width="500px"><input type="text" id="date"></td></tr>
      <tr><td>開始時刻</td><td id="str_err"></td><td><input type='text' id='str'></td></tr>
      <tr><td>終了時刻</td><td id="end_err"></td><td><input type='text' id='end'></td></tr>
      <tr><td>休憩</td><td></td><td><input type='text' id='bre'></td></tr>
      <tr><td>作業時間</td><td id="time_err"></td><td><input type="text" id="work_time" name="" value=""></td></tr>

      <tr><td>主コード</td><td id="cdmst_err"></td>
      <td><select class="code_mst" value="">
        <option value='0'>選択してください</option>
        <?php
        foreach($cdmst_list as $key => $cdmst_name){
          echo '<option value="'.$key.'">'.$cdmst_name.'</option>';
        }
        ?>
      </select></td></tr>

      <tr><td id='id_code' width="90px">コード</td><td id="idData_err" width="60px"></td>
      <td><select class="" value="" id='idData'>
        <option>選択してください</option>

      </select></td></tr>

      <tr><td class="" id='task_write' width="40px">
        作業内容</td><td id="task_err"></td><td><input type="text" id="task" value=""></td>
        <td width="70px"><input type="button" id="add_task" value="⊕ 追加">
      </td></br></br></tr></table>

      <div id='view'>
        <table id='view_tb'>
          <tr><th width='150px'>日にち</th><th width='200px'>時間</th><th width='220px'>主コード</th><th width='200px'>コード</th><th width='200px'>内容</th><th width='150px'></th></tr>
        </table>
      </div>
      <div id='overlay'>
      </div>

      </div>
      <!-- day-selectタブ -->
      <div class="tab_content" id="day_out_content">
        <input type="text" id="select_dates" value="">
        <input type="button" id="select_day_button" value="表示">
        <div id="select_day_view">
          <table id='day_view'>
            <tr><th width='200px'>時間</th><th width='200px'>主コード</th><th width='250px'>コード</th><th width='220px'>内容<th width='100px'></th></tr>
          </table>
        </div>
      </div>

      <!-- month-selectタブ -->
      <div class="tab_content" id="month_out_content">
        <div class="top_month_select">
          <input type="text" id="select_month">

          <!-- ラジオセレクト -->
          <div class="month_display">
            <input type="radio" name="s3" id="select1" value="/" checked="">
            <label for="select1">/</label>
            <input type="radio" name="s3" id="select2" value=",">
            <label for="select2">,</label>
            <input type="radio" name="s3" id="select3" value="<br>">
            <label for="select3">改行</label>
            <input type="radio" name="s3" id="select4" value="main">
            <label for="select4">メイン作業</label>
          </div>

          </div>
          <input type="button" id="select_month_button" value="表示">
          <input type="button" id="day_hidden" value="非表示">
          <input type="button" id="day_open" value="日付表示">
          <div id='select_month_view'>
            <table id='select_month_view_tb' border='1' bordercolor='#4ec4d3'></table>
          </div>
        </div>

      </div>
    </div>

    <!-- 編集ダイアログ -->
    <div id="modalWindow">
      <table id="edit_dialog">
        <tr><td>作業日</td><td><input type='text' id='date_edit' value=''></td><td id='date_edit_err'></td></tr>
        <tr><td>開始時刻</td><td><input type='text' id='str_edit'></td><td id='str_edit_err'></td></tr>
        <tr><td>終了時刻</td><td><input type='text' id='end_edit'></td><td id='end_edit_err'></td></tr>
        <tr><td>休憩</td><td><input type='text' id='bre_edit'></td></tr>
        <tr><td>作業時間</td><td><input type="text" id="work_time_edit" name="" value=""></td><td id='time_edit_err'></td></tr>
        <tr><td>主コード</td><td>
        <select class="code_mst_edit" value="">
          <option value='0'>選択してください</option>
          <?php
          foreach($cdmst_list as $key => $cdmst_name){
            echo '<option value="'.$key.'">'.$cdmst_name.'</option>';
          }
          ?>
        </select>
        </td><td id='code_mst_edit_err'>
        </td></tr>
          <tr><td id='id_code'>コード</td><td>
          <select class="idData_edit" value="" id=''>
            <option value='0'>選択してください</option>
          </select>
        </td><td id='idData_edit_err'></td></tr>
        <tr><td class="" id='task_edit'>
          作業内容</td><td><input type="text" class="task_edit" value="">
        </td><td id='task_edit_err'></td></tr>
      </table>

      <input type="button" class="update" value="⟳ 更新">
      <input type="button" class="close" value="キャンセル">


    </div>
</body>
</html>
