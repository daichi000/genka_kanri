<?php
$name = $_POST['username'];
$pw = $_POST['pass'];

//セッション開始
session_start();
$status = "none";
// $namejs = array($name);
  try{
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
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
              echo "PWNG"."<br>";
              exit();
            }
        }else{
          echo "not account";
          exit();
        }
      }catch(PDOException $e){
        print("error:". $e->getMessage());
      }
  }else{
    // echo "入力していない箇所あり";
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
  <!-- <link rel="stylesheet" href="./bootstrap-datepicker-master/js/bootstrap-datepicker.js" /> -->
  <link rel="stylesheet" href="./jquery-ui-1.12.1.custom/jquery.timepicker.css" />
  <link rel="stylesheet" href="users.css" />
  <script src="./jquery-ui-1.12.1.custom/jquery.timepicker.min.js"></script>
  <script src="./usersss.js"></script>

</head>
<body>
  <div class="tabs">
    <input type="radio" id='in' name="tab_item" checked>
    <label class="tab_item" for="in">作業入力</label>
    <input type="radio" id='day_out' name="tab_item">
    <label class="tab_item" for="day_out">作業表示（日）</label>
    <input type="radio" id='month_out' name="tab_item">
    <label class="tab_item" for="month_out">作業表示（月）</label>
    <div class="tab_content" id="in_content">
      <p class='login'>ログイン: <?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></p><br/>
      <table>
      <tr><td>作業日</td><td><input type="text" id="date"></td></tr>
      <tr><td>開始時刻</td><td><input type='text' id='str'></td></tr>
      <tr><td>終了時刻</td><td><input type='text' id='end'></td></tr>
      <tr><td>休憩</td><td><input type='text' id='bre'></td></tr>
      <tr><td>作業時間</td><td><input type="text" id="work_time" name="" value=""></td></tr>

      <!-- <span>主コード</span>
      <select class="code_mst" value="">
        <option value='0'>選択してください</option>
        <?php
        // foreach($cdmst_list as $key => $cdmst_name){
        //   echo '<option value="'.$key.'">'.$cdmst_name.'</option>';
        // }
        ?>
      </select>

      <span id='id_code'>コード</span>
      <select class="" value="" id='idData'>
        <option>選択してください</option>

      </select>

      <span class="" id='task_write'>
        作業内容<input type="text" id="task" value="">
        <input type="button" id="add_task" value="作業追加">
      </span></br></br> -->

      <tr><td>主コード</td>
      <td><select class="code_mst" value="">
        <option value='0'>選択してください</option>
        <?php
        foreach($cdmst_list as $key => $cdmst_name){
          echo '<option value="'.$key.'">'.$cdmst_name.'</option>';
        }
        ?>
      </select></td>

      <td id='id_code'>コード</td>
      <td><select class="" value="" id='idData'>
        <option>選択してください</option>

      </select></td>

      <td class="" id='task_write'>
        作業内容<input type="text" id="task" value="">
        <input type="button" id="add_task" value="作業追加">
      </td></br></br></tr></table>

      <div id='view'>
        <table id='view_tb'>

        </table>
      </div>
      <div id='overlay'>
      </div>

      </div>
      <!-- day-selectタブ -->
      <div class="tab_content" id="day_out_content">
        <p class='login'>ログイン: <?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></p><br/>
        <input type="text" id="select_dates" value="">
        <input type="button" id="select_day_button" value="select">
        <div id="select_day_view">
        </div>
      </div>

      <!-- month-selectタブ -->
      <div class="tab_content" id="month_out_content">
        <div class="top_month_select">
          <p class='login'>ログイン: <?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></p><br/>
          <input type="text" id="select_month">

          <!-- ラジオセレクト -->
          <div class="sample">
            <input type="radio" name="s3" id="select1" value="/" checked="">
            <label for="select1">/</label>
            <input type="radio" name="s3" id="select2" value=",">
            <label for="select2">,</label>
            <input type="radio" name="s3" id="select3" value="<br>">
            <label for="select3">改行</label>
            <input type="radio" name="s3" id="select4" value="main">
            <label for="select4">メイン作業</label>
          </div>

          <input type="button" id="select_month_button" value="select">
          <input type="button" id="day_open" value="day_open">
          <input type="button" id="day_hidden" value="day_hidden">
        </div>
        <div id='select_month_view'>
          <table id='select_month_view_tb' border='1' bordercolor='#4ec4d3'></table>
        </div>
      </div>
    </div>

    <!-- 編集ダイアログ -->
    <div id="modalWindow">
      <p id='test'>date: <input type='text' id='date_edit' value=''></p>
      <p>start: <input type='text' id='str_edit'></p>~
      <p>end: <input type='text' id='end_edit'></p>
      <p>break: <input type='text' id='bre_edit'></p>
      <p>time: <input type="text" id="work_time_edit" name="" value=""></p>
      <p>master_code:
      <select class="code_mst_edit" value="">
        <option value='0'>選択してください</option>
        <?php
        foreach($cdmst_list as $key => $cdmst_name){
          echo '<option value="'.$key.'">'.$cdmst_name.'</option>';
        }
        ?>
      </select>
      </p>
      <p id='id_code'>id_code:
      <select class="idData_edit" value="" id=''>
        <option value='0'>選択してください</option>
      </select>
      </p>
      <p class="" id='task_edit'>
        task: <input type="text" class="task_edit" value="">
      </p>
      <input type="button" class="close" value="close">
      <input type="button" class="update" value="update">

    </div>
</body>
</html>
