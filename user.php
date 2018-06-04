<?php
if($_POST['username'] == '' || $_POST['pass'] == ''){
  header("Location:./petadb_login.php");
}else{
  $name = $_POST['username'];
  $pw_org = $_POST['pass'];
  $pw = hash("sha256", $pw_org);

  //セッション開始
  session_start();
  $status = "none";
    try{
      $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','13qe!#QE');
    }catch(PDOException $e){
      print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
    $sql = "SELECT * FROM code_master";
    $stmt = $pdo->query($sql);
    $cdmst_list = array();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
      $cdmst_list[$row['cdmst_id']] = $row['cdmst'];
    }
    $sql_name = "SELECT * FROM petauser";
    $name_select = $pdo->query($sql_name);
    $name_list = array();
    while($row_name = $name_select -> fetch(PDO::FETCH_ASSOC)){
      //管理者も表示する
      // if($row_name['admin'] == 0){
        $name_list[$row_name['Uid']] = $row_name['Name'];
      // }
    }

    if($name != ''){
      try{
        //ログイン情報で名前検索
          $stt = $pdo->prepare('SELECT * FROM petauser WHERE Name LIKE :name');//名前付きパラメータ
          $stt -> bindValue(':name',$name);//postを代入
          $stt -> execute();
          if($row = $stt -> fetch(PDO::FETCH_ASSOC)){
            // パスワードが正しい
            if($pw == $row['password']){
                //セッションに格納
                $_SESSION['NAME'] = $name;
                $admin = $row['admin'];
              }else{
                ?>
                <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
                <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
                <link rel="stylesheet" href="petadb_check.css?<?php echo date("YmdHis"); ?>">

                <body>
                  <header>
                    <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
                    <h1>開発課原価管理</h1>
                    <div class="top_login">
                      <i class="material-icons">person</i>
                      <!-- <span class='login'><?php //echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></span> -->
                      <span class='login'><?php echo 'no user'; ?></span>
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
          }else{// not account
            ?>
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <link rel="stylesheet" href="petadb_check.css?<?php echo date("YmdHis"); ?>">

            <body>
              <header>
                <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
                <h1>開発課原価管理</h1>
                <div class="top_login">
                  <i class="material-icons">person</i>
                  <!-- <span class='login'><?php //echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></span> -->
                  <span class='login'><?php echo 'no user'; ?></span>
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

//一般ユーザ
if($admin == 0){
  ?>
  <!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>楽楽原価</title>

    <script src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous">></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="./jquery-ui-1.12.1.custom/jquery.timepicker.css" />
    <link rel="stylesheet" href="./user_user.css?<?php echo date("YmdHis"); ?>" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="./jquery-ui-1.12.1.custom/jquery.timepicker.min.js"></script>
    <script src="user_user.js?<?php echo date("YmdHis"); ?>"></script>
  </head>

  <body>
    <header>
      <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
      <h1>開発課原価管理</h1>
      <div class="logout">
        <a href="./petadb_login.php"><img src="./logout.png" alt=""></a>
      </div>
      <div class="top_login">
        <i class="material-icons">person</i>
        <span class='login'><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></span>
      </div>
    </header>
      <!-- サイドメニュー -->
    <div class="tabs">
      <input type="radio" id='in' name="tab_item" checked>
      <label class="tab_item" for="in">作業入力</label>
      <input type="radio" id='day_out' name="tab_item">
      <label class="tab_item" for="day_out">作業表示（日）</label>
      <input type="radio" id='month_out' name="tab_item">
      <label class="tab_item" for="month_out">作業表示（月）</label>
      <div class="tab_bottom">
      </div>

      <!-- 作業入力タブ -->
      <div class="tab_content" id="in_content">
        <!-- 作業入力欄   -->
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
            <td width="70px"><input type="button" id="add_task" value="追加">
          </td></br></br></tr></table>

        <!-- 出力欄 -->
        <div id='view'>
          <table id='view_tb'>
            <tr><th width='150px'>日にち</th><th width='200px'>時間</th><th width='220px'>主コード</th><th width='200px'>コード</th><th width='200px'>内容</th><th width='150px'></th></tr>
          </table>
        </div>
        <div id='overlay'>
        </div>
        </div>

      <!-- 作業表示（日）タブ -->
      <div class="tab_content" id="day_out_content">
        <input type="text" id="select_dates" value="">
        <input type="button" id="select_day_button" value="表示">
        <div id="select_day_view">
          <table id='day_view'>
            <tr><th width='200px'>時間</th><th width='200px'>主コード</th><th width='250px'>コード</th><th width='220px'>内容<th width='100px'></th></tr>
          </table>
        </div>
      </div>

      <!-- 作業表示（月）タブ -->
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

      <input type="button" class="update" value="更新">
      <input type="button" class="close" value="キャンセル">
    </div>

  </body>
  </html>

<?php
}else{
//管理者画面
?>
  <!DOCTYPE html>
  <html lang="ja">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>楽楽原価</title>

    <script src="https://code.jquery.com/jquery-3.2.1.js"
    integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
    crossorigin="anonymous">></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="./jquery-ui-1.12.1.custom/jquery.timepicker.css" />
    <link rel="stylesheet" href="user_kanri_.css?<?php echo date("YmdHis"); ?>" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="./jquery-ui-1.12.1.custom/jquery.timepicker.min.js"></script>
    <script src="user_kanri.js?<?php echo date("YmdHis"); ?>"></script>
  </head>

  <body>
    <header>
      <img src="./jmc_icon.jpg" alt="" class='jmc_icon'>
      <h1>開発課原価管理　≪管理者≫</h1>
      <div class="logout">
        <a href="./petadb_login.php"><img src="./logout.png" alt=""></a>
      </div>
      <div class="top_login">
        <i class="material-icons">person</i>
        <span class='login'><?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></span>
      </div>
    </header>

    <!-- サイドメニュー -->
    <div class="tabs">
      <input type="radio" id='in' name="tab_item" checked>
      <label class="tab_item" for="in">作業入力</label>
      <input type="radio" id='day_out' name="tab_item">
      <label class="tab_item" for="day_out">作業表示（日）</label>
      <input type="radio" id='month_out' name="tab_item">
      <label class="tab_item" for="month_out">作業表示（月）</label>
      <input type="radio" id='kanri' name="tab_item">
      <label class="tab_item" for="kanri">管理画面</label>
      <input type="radio" id='genka' name="tab_item">
      <label class="tab_item" for="genka">原価コード</label>
      <div class="tab_bottom">
      </div>
      <!-- メニューバー取り消し -->
      <!-- <div class="menu">
      <i class="material-icons" id="menu">menu</i>
      </div> -->

      <!-- 作業入力タブ -->
      <div class="tab_content" id="in_content">
        <!-- 作業入力欄 -->
        <table id='write_tb'>
        <caption>作業入力</caption>
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
          <td width="70px"><input type="button" id="add_task" value="追加">
        </td></br></br></tr></table>

        <div id='view'>
          <table id='view_tb'>
            <tr><th width='150px'>日にち</th><th width='200px'>時間</th><th width='220px'>主コード</th><th width='200px'>コード</th><th width='200px'>内容</th><th width='150px'></th></tr>
          </table>
        </div>
        <div id='overlay'>
        </div>

      </div>

      <!-- 作業表示（日）タブ -->
      <div class="tab_content" id="day_out_content">
        <input type="text" id="select_dates" value="">
        <input type="button" id="select_day_button" value="表示">
        <div id="select_day_view">
          <table id='day_view'>
            <tr><th width='200px'>時間</th><th width='200px'>主コード</th><th width='250px'>コード</th><th width='220px'>内容<th width='100px'></th></tr>
          </table>
        </div>
      </div>

      <!-- 作業表示（月）タブ -->
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

      <!-- kanriタブ -->
      <div class="tab_content" id="kanri_content">
        <div class="kanri_month_select">
          <span>月選択</span>&nbsp&nbsp
          <input type="text" id="select_kanri_month"><br/><br/>
          <span>ユーザ</span>&nbsp&nbsp
          <select class="user_select" value="">
            <option value='0'>選択してください</option>
            <?php
            foreach($name_list as $uid => $uname){
              echo '<option value="'.$uid.'">'.$uname.'</option>';
            }
            ?>
          </select>
          <input type="button" id="select_kanri_button" value="表示">
        </div>
        <div id='select_kanri_view'>
          <table id='select_kanri_view_tb' border='1.2' border-color:'#4ec4d3'></table>
        </div>
        <div id="kanri_month_come">
        </div>
        <div id="kanri_month_time_cp">
          <table id='select_kanri_view_cp' border='1.2' border-color:'#4ec4d3'>
          </table>
        </div>
      </div>

      <!-- 原価コードタブ -->
      <div class="tab_content" id="genka_content">
        <p><font color="red">※使用不可</font></p>
        <table border="1"><?php foreach($cdmst_list as $key => $val){
          echo '<tr><td>'. $cdmst_list[$key] . '</td><td><table>';

          $sub_code = $pdo -> prepare('SELECT * FROM dbcode WHERE master_id LIKE :master_id');
          $sub_code -> bindValue(':master_id', $key, PDO::PARAM_STR);
          $sub_code -> execute();
          while($sub_code_name = $sub_code -> fetch(PDO::FETCH_ASSOC)){
            echo '<tr><td width="500px">'. $sub_code_name['code']. '</td><td width="50px"><button type="submit" id="'.$sub_code_name['code_id']. '"name="minus" value="minus">削除</button></td></tr>';
          }
          echo '<tr><td><button type="submit" name="plus" value="plus" id="'. $key. '">追加</button></td>';
          echo '</table></td></tr>';
        }?><tr><td><button type="submit" name="plus" value="plus">追加</button></td></tr></table>
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

        <input type="button" class="update" value="更新">
        <input type="button" class="close" value="キャンセル">

      </div>
  </body>
  </html>
<?php
}
