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
  <link rel="stylesheet" href="user.css">
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
          var works = display.key;
          //変数を動的に指定
          $('#view').append("<div id=" + works + "><br>" + display.value + "<input type='button' value='edit' class='edit' id=" + works + "><input type='button' value='delete' class='del' id=" + works + "></div>");

          // $('#view').apppend('<div id=' + works + '>');
          // var nest = $('<>').append('<div>')
          // $('#'+ works).append()

          $('#task').val('');//textボックス初期化
          $('#str').val(end);
          $('#end').val(end);
          $('#bre').val('');
          $('#work_time').val('');
          $('.add_code').hide();
          $('#idData').hide();
          $('#id_code').hide();
          $('#task_write').hide();
          $('.code_mst').val('0');

        //編集ダイアログクローズ
        $('#close').on('click', function(){
          $('#overlay, #modalWindow').fadeOut();
        });

        //編集ダイアログ中央設置
        locateCenter();
        $(window).resize(locateCenter);

        function locateCenter() {
          let w = $(window).width();
          let h = $(window).height();

          let cw = $('#modalWindow').outerWidth();
          let ch = $('#modalWindow').outerHeight();

          $('#modalWindow').css({
            'left': ((w - cw) / 2) + 'px',
            'top': ((h - ch) / 2) + 'px'
          });
        }

        });
      });

      //削除ボタン
      $(document).on('click','.del',function(){
        $(this).parent().fadeOut(1000);
        var works = $(this).attr('id');
        $.post('del_works.php',{
          works: works
        });
      });

      //編集ボタン
      $(document).on('click','.edit',function(){
        var works = $(this).attr('id');
        $('#overlay, #modalWindow').fadeIn();
        $.post('data_edit.php',{
          works: works
        }, function(data){
          // $('#date_edit').val(data);
          $('#date_edit').datepicker({
            dateFormat: dateFormat, //yy-mm-dd
            showOtherMonths: true, //他の月を表示
            selectOtherMonths: true //他の月を選択可能
          }).datepicker('setDate',data.date_); //編集データ

          $('#str_edit').val(data.str_.slice(0,-3));
          $('#end_edit').val(data.end_.slice(0,-3));
          $('#bre_edit').val(data.bre_.slice(0,-3));
          $('#work_time_edit').val(data.time_.slice(0,-3));
          $('.code_mst_edit').val(data.mst_);
          $('.task_edit').val(data.task_);
          // $('.idData_edit').val(data.sub_);
          // $('.idData_edit').children().remove();
          var code_mst = $('.code_mst_edit').val();
          $.post('user_select.php',{
            code_mst: code_mst
            // cashe: false
          }, function(data_edit){
            //code_mst_editに属するsub_codeを表示
            $('.idData_edit').children().remove();
            for(var i in data_edit){
              $('.idData_edit').append('<option value=' + i + '>' + data_edit[i] + '</option>');//value:id
            }
            $('.idData_edit').val(data.sub_);
          });
          $('.update').attr('id', works);
        });
        });

        $('.code_mst_edit').change(function(){
          $('.idData_edit').children().remove();
          $('.idData_edit').append('<option value="0" >選択してください</option>');
          var code_mst = $('.code_mst_edit').val();
          $.post('user_select.php',{
            code_mst: code_mst
            // cashe: false
          }, function(data_edit){
            //code_mst_editに属するsub_codeを表示
            for(var i in data_edit){
              $('.idData_edit').append('<option value=' + i + '>' + data_edit[i] + '</option>');//value:id
            }
            // $('.idData_edit').children().remove();
            // $('.idData_edit').val(data.sub_);
          });
        });

        //UPDATEボタン
        $(document).on('click','.update',function(){
          var works = $(this).attr('id');
          var task_af = $('.task_edit').val();
          var idData_af = $('.idData_edit').val();
          var code_mst_af = $('.code_mst_edit').val();
          var date_af = $('#date_edit').val();
          var str_af = $('#str_edit').val();
          var end_af = $('#end_edit').val();
          var bre_af = $('#bre_edit').val();
          var work_time_af = $('#work_time_edit').val();
          $.post('data_after.php', {
            works : works,
            task_af : task_af,
            idData_af : idData_af,
            code_mst_af : code_mst_af,
            date_af : date_af,
            str_af : str_af,
            end_af : end_af,
            bre_af : bre_af,
            work_time_af : work_time_af
          },function(update){
            // alert(update);
            $('#overlay, #modalWindow').fadeOut();
            $('#'+ works).empty();
            $('#'+ works).append("<br>" + update + "<input type='button' value='edit' class='edit' id=" + works + "><input type='button' value='delete' class='del' id=" + works + ">");
          });
        });

        //CLOSEボタン
        $(document).on('click','.close',function(){
          $('#overlay, #modalWindow').fadeOut();
        })

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
      $('#str_edit').timepicker({
        'timeFormat': 'H:i',
        'step' : '10'
      });
      $('#end_edit').timepicker({
        'timeFormat': 'H:i',
        'step' : '10'
      });
      $('#bre_edit').timepicker({
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

      $('#str_edit, #end_edit, #bre_edit').change(function(){
  			var str_edit_input = $('#str_edit').val();
  			var end_edit_input = $('#end_edit').val();
        var bre_edit_input = $('#bre_edit').val();
        if(str_edit_input && end_edit_input){
  				var result2 = timeMath.sub(end_edit_input + ':00', str_edit_input + ':00', bre_edit_input + ':00');
  				// console.log(result1);
  				$('#work_time_edit').val(result2.slice(0,-3));//秒を非表示
  			}
  		});
    });

  </script>
</head>
<body>
  <p>Login now: <?php echo htmlspecialchars($_SESSION['NAME'], ENT_QUOTES); ?></p><br/>

  <p>date: <input type="text" id="date"></p>
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
    task: <input type="text" id="task" value="">
    <input type="button" id="add_task" value="add">
  </span></br></br>

  <div id='view'>
  </div>
  <div id='overlay'>
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
  </div>

</body>

</html>
