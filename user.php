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
  <link rel="stylesheet" href="./jquery-ui-1.12.1.custom/jquery.timepicker.css" />
  <script src="./jquery-ui-1.12.1.custom/jquery.timepicker.min.js"></script>
  <script type='text/javascript'>
  // <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js">
  //

    // var _name = JSON.prase($script.attr('name'));
    // console.log(array);
    // alert(array[0]);
    $(function(){
      $('.add_code').hide();
      $('#idData').hide();
      $('#id_code').hide();
      $('#task_write').hide();

      //selectタグが変更された場合
      $('.code_mst').change(function(){
        $('#idData').children().remove();//子タグのoption値をいったん削除
        $('#idData').append('<option value="0">選択してください</option>');
        // var code_mst = "";
        var code_mst = $('.code_mst').val();
        $.post('user_select.php',{
          code_mst: code_mst
          // cashe: false
        }, function(data){
          // $('#res').html(data);
          // $('#id_code').reset();
          $('#id_code').show();
          $('#idData').show();
          for(var i in data){
            $('#idData').append('<option value=' + i + '>' + data[i] + '</option>');//value:id
          }



        });
          // return false;
      });

      //idタグが変更された場合
      $('#idData').change(function(){
        // $('#task_write').children().remove();

        // var task = $('#task').val();
        // $.post('')
        $('#task_write').show();
        // var idData = $('#idData').val();
      });

      //addがクリックされた場合
      $('#add_task').click(function(){
        var task = $('#task').val();
        var idData = $('#idData').val();
        var code_mst = $('.code_mst').val();
        var date = $('#date').val();
        var str = $('#str').val();
  			var end = $('#end').val();
        var bre = $('#bre').val();
        var work_time = $('#work_time').val();
        // $('#view').html(task);
        $.post('task_write.php',{
          idData: idData,
          task: task,
          code_mst: code_mst,
          date: date,
          str: str,
          end: end,
          bre: bre,
          work_time: work_time
          // cashe: false

        }, function(display){
          // alert (aaa);
          $('#view').append("<br>", display);
          //リセット
          // $('.code_mst')[0].reset();
          // $('#idData')[0].reset();
          // $('task_write')[0].reset();

          $('#task').val('');//textボックス初期化
          $('#str').val(end);
          $('#end').val('');
          $('#bre').val('');
          $('#work_time').val('');
          $('.add_code').hide();
          $('#idData').hide();
          $('#id_code').hide();
          $('#task_write').hide();
          $('.code_mst').val('0');
        });

      });

      $.datepicker.setDefaults($.datepicker.regional["ja"]);
      var dateFormat = 'yy-mm-dd';
      $('#date').datepicker({
        dateFormat: dateFormat, //yy-mm-dd
        showOtherMonths: true, //他の月を表示
        selectOtherMonths: true //他の月を選択可能
      }).datepicker('setDate','today') //今日の日付

      $('#str').timepicker({
  			'scrollDefault':'9:00',
  			'timeFormat': 'H:i',
  			'step' : '10'
  		});
  		$('#end').timepicker({
  			'scrollDefault':'9:00',
  			'timeFormat': 'H:i',
  			'step' : '10'
  		});
      $('#bre').timepicker({
        'scrollDefault':'1:00',
        'timeFormat': 'H:i',
        'step' : '10'
      });

      //時間計算
  		var timeMath = {
  	    sub : function(){
  	      var result,times,second,i,
  	        len = arguments.length;
  	      if(len === 0)return;
  	      for (i = 0; i < len; i++) {
  	              if (!arguments[i] || !arguments[i].match(/^[0-9]+:[0-9]{2}:[0-9]{2}$/)) continue;
  	              times = arguments[i].split(':');
  	              second = this.toSecond(times[0], times[1], times[2]);
  	              if (!second) continue;
  	              if (i === 0) {
  	                  result = second;
  	              } else {
  	                  result -= second;
  	              }
  	          }
  	          return this.toTimeFormat(result);
  	    },
  	    toSecond : function(hour, minute, second) {
  	       if ((!hour && hour !== 0) || (!minute && minute !== 0) || (!second && second !== 0) ||
  	           hour === null || minute === null || second === null ||
  	           typeof hour === 'boolean' ||
  	           typeof minute === 'boolean' ||
  	           typeof second === 'boolean' ||
  	           typeof Number(hour) === 'NaN' ||
  	           typeof Number(minute) === 'NaN' ||
  	           typeof Number(second) === 'NaN') return;

  	       return (Number(hour) * 60 * 60) + (Number(minute) * 60) + Number(second);
  	    },
  	    toTimeFormat : function(fullSecond) {
  	        var hour, minute, second;

  	        if ((!fullSecond && fullSecond !== 0) || !String(fullSecond).match(/^[\-0-9][0-9]*?$/)) return;

  	        var paddingZero = function(n) {
  	            return (n < 10)  ? '0' + n : n;
  	        };

  	        hour   = Math.floor(Math.abs(fullSecond) / 3600);
  	        minute = Math.floor(Math.abs(fullSecond) % 3600 / 60);
  	        second = Math.floor(Math.abs(fullSecond) % 60);

  	        minute = paddingZero(minute);
  	        second = paddingZero(second);

  	        return ((fullSecond < 0) ? '-' : '') + hour + ':' + minute + ':' + second;
  	    }

  	  };

  		$('#str, #end, #bre').change(function(){
  			var str_input = $('#str').val();
  			var end_input = $('#end').val();
        var bre_input = $('#bre').val();
        if(str_input && end_input){
  				var result1 = timeMath.sub(end_input + ':00', str_input + ':00', bre_input + ':00');
  				// console.log(result1);
  				$('#work_time').val(result1.slice(0,-3));//秒を非表示
  			}
  		});
    });

  </script>
</head>
<body>
  <!-- <form id="search" method="post">
    code_master:<input type="text" id="request">
    <input type="submit" value="検索" id='button'>
  </form>
  <br>
  <div id="res"></div>
  <form id="plus" method="post">
    <input type="text" id="task">
    <input type="submit" value="追加" id='button_plus'>
  </form> -->
  <p>Login now: <?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></p><br/>

  <span>date: <input type="text" id="date"></span>
  <p>start: <input type='text' id='str'></p>~
  <p>end: <input type='text' id='end'></p>
  <p>break: <input type='text' id='bre'></p>
  <p>time: <input type="text" id="work_time" name="" value=""></p>

  <span>master_code:</span>
  <select class="code_mst" value="">
    <option value='0'>選択してください</option>
    <?php
    foreach($cdmst_list as $key => $cdmst_name){
      echo '<option value="'.$key.'">'.$cdmst_name.'</option>';
    }
    ?>
  </select>

  <span id='id_code'>id_code:</span>
  <select class="" value="" id='idData'>
    <option>選択してください</option>

  </select>
  <!-- <div id='res'>
  </div> -->

  <!-- <div class="add_code">
      <input type="text" id="add_code_name" value="">
      <input type="button" id="add_code" value="add">
  </div> -->

  <!-- <div id='res_add'>
  </div> -->
  <span class="" id='task_write'>
    <input type="text" id="task" value="">
    <input type="button" id="add_task" value="add">
  </span></br></br>

  <div id='view'>

  </div>

</body>

</html>
