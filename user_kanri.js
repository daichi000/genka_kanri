
// <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js">
//

  // var _name = JSON.prase($script.attr('name'));
  // console.log(array);
  // alert(array[0]);
  $(function(){
    // $('.add_code').hide();
    // $('#idData').hide();
    // $('#id_code').hide();
    // $('#task_write').hide();
    // $('#add_task').hide();
    //画面サイズ
    var screenWidth = screen.width;
    // if(screenWidth >= 2000){
    //   $('body').css('zoom','80%');
    // }else{
    //   $('body').css('zoom','90%');
    // }
    $('body').css('zoom', '80%');

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
        // $('#id_code').show();
        // $('#idData').show();
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
      // $('#task_write').show();
      // $('#add_task').show();
      // var idData = $('#idData').val();
    });

    //追加がクリックされた場合
    $('#add_task').click(function(){
      $('#date_err').empty();
      $('#str_err').empty();
      $('#end_err').empty();
      $('#task_err').empty();
      $('#time_err').empty();
      $('#cdmst_err').empty();
      $('#idData_err').empty();

      var check = true;
      if($('#date').val() == ''){
        $('#date_err').append('※必須項目');
        check = false;
      }else{
        var date = $('#date').val();
      }

      // if($('#str').val() == ''){
      //   $('#str_err').append('※必須項目');
      //   check = false;
      // }else{
      //   var str = $('#str').val();
      // }

      // if($('#end').val() == ''){
      //   $('#end_err').append('※必須項目');
      //   check = false;
      // }else{
      //   var end = $('#end').val();
      // }

      if($('#task').val() == ''){
        $('#task_err').append('※必須項目');
        check = false;
      }else{
        var task = $('#task').val();
      }

      if($('#work_time').val().slice(0,1) == '-' || $('#work_time').val() == '' || $('#work_time').val().slice(0,4) == '0:00'){
        $('#time_err').append('※不適切');
        check = false;
      }else{
        var work_time = $('#work_time').val();
      }

      if($('.code_mst').val() == 0){
        $('#cdmst_err').append('※必須項目');
        check = false;
      }else{
        var code_mst = $('.code_mst').val();
      }

      if($('#idData').val() == 0){
        $('#idData_err').append('※必須項目');
        check = false;
      }else{
        var idData = $('#idData').val();
      }

      if(check == false){
        return;
      }


      var str = $('#str').val();
      var end = $('#end').val();
      var bre = $('#bre').val();
      $.post('task_write.php',{
        idData: idData,
        task: task,
        code_mst: code_mst,
        date: date,
        str: str,
        end: end,
        bre: bre,
        work_time: work_time

      }, function(display){
        var works = display.key;
        //変数を動的に指定
        $('#view_tb').append("<tr id=" + works + "><td>" + display.date + "</td><td>"+ display.str +"~"+ display.end +"("+ display.work_time +")</td><td>"+ display.mst +"</td><td>"+ display.sub +"</td><td>"+ display.task +"</td><td><input type='button' class='edit' id=" + works + "><input type='button' class='del' id=" + works + "></td></tr>");

        $('#task').val('');//textボックス初期化
        $('#str').val(end);
        $('#end').val(end);
        $('#bre').val('');
        $('#work_time').val('');
        $('#idData').children().remove();
        $('#idData').append('<option>選択してください</option>');
        $('.code_mst').val('0');

      // //編集ダイアログクローズ
      // $('#close').on('click', function(){
      //   $('#overlay, #modalWindow').fadeOut();
      // });
      //
      // //編集ダイアログ中央設置
      // locateCenter();
      // $(window).resize(locateCenter);
      //
      // function locateCenter() {
      //   let w = $(window).width();
      //   let h = $(window).height();
      //
      //   let cw = $('#modalWindow').outerWidth();
      //   let ch = $('#modalWindow').outerHeight();
      //
      //   $('#modalWindow').css({
      //     'left': ((w - cw) / 1.5) + 'px',
      //     'top': ((h - ch) / 1.5) + 'px'
      //   });
      // }

      });
    });

    //編集ダイアログ中央設置
    locateCenter();
    $(window).resize(locateCenter);

    function locateCenter() {
      let w = $(window).width();
      let h = $(window).height();

      let cw = $('.modalWindow').outerWidth();
      let ch = $('.modalWindow').outerHeight();

      $('.modalWindow').css({
        'left': ((w - cw) / 1.5) + 'px',
        'top': ((h - ch) / 1.5) + 'px'
      });
    }

    //削除ボタン
    $(document).on('click','.del',function(){
      $(this).parent().parent().fadeOut(1000);
      var works = $(this).attr('id');
      $.post('del_works.php',{
        works: works
      });
    });

    //削除ボタン_select画面
    // $(document).on('click','.del_select',function(){
    //   $(this).parent().parent().fadeOut(1000);
    //   var works = $(this).attr('id');
    //   $.post('del_works.php',{
    //     works: works
    //   });
    // });

    //編集ボタン
    $(document).on('click','.edit',function(){
      $('#date_edit_err').empty();
      $('#str_edit_err').empty();
      $('#end_edit_err').empty();
      $('#task_edit_err').empty();
      $('#time_edit_err').empty();
      $('#code_mst_edit_err').empty();
      $('#idData_edit_err').empty();

      var works = $(this).attr('id');
      $('#overlay, #modalWindow_input').fadeIn();
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

      //編集ボタン_作業表示（日）
      $(document).on('click','.edit_day',function(){
        $('#date_edit_d_err').empty();
        $('#str_edit_d_err').empty();
        $('#end_edit_d_err').empty();
        $('#task_edit_d_err').empty();
        $('#time_edit_d_err').empty();
        $('#code_mst_edit_d_err').empty();
        $('#idData_edit_d_err').empty();

        var works = $(this).attr('id');
        $('#overlay_day, #modalWindow_day').fadeIn();
        $.post('data_edit.php',{
          works: works
        }, function(data){
          $('#date_edit_d').datepicker({
            dateFormat: dateFormat, //yy-mm-dd
            showOtherMonths: true, //他の月を表示
            selectOtherMonths: true //他の月を選択可能
          }).datepicker('setDate',data.date_); //編集データ

          $('#str_edit_d').val(data.str_.slice(0,-3));
          $('#end_edit_d').val(data.end_.slice(0,-3));
          $('#bre_edit_d').val(data.bre_.slice(0,-3));
          $('#work_time_edit_d').val(data.time_.slice(0,-3));
          $('.code_mst_edit_d').val(data.mst_);
          $('.task_edit_d').val(data.task_);
          var code_mst = $('.code_mst_edit_d').val();
          $.post('user_select.php',{
            code_mst: code_mst
            // cashe: false
          }, function(data_edit){
            //code_mst_editに属するsub_codeを表示
            $('.idData_edit_d').children().remove();
            for(var i in data_edit){
              $('.idData_edit_d').append('<option value=' + i + '>' + data_edit[i] + '</option>');//value:id
            }
            $('.idData_edit_d').val(data.sub_);
          });
          $('.update_day').attr('id', works);
        });
      });

      //編集画面の主コード変更
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

      //編集画面の主コード変更_作業表示（日）
      $('.code_mst_edit_d').change(function(){
        $('.idData_edit_d').children().remove();
        $('.idData_edit_d').append('<option value="0" >選択してください</option>');
        var code_mst = $('.code_mst_edit_d').val();
        $.post('user_select.php',{
          code_mst: code_mst
          // cashe: false
        }, function(data_edit){
          //code_mst_editに属するsub_codeを表示
          for(var i in data_edit){
            $('.idData_edit_d').append('<option value=' + i + '>' + data_edit[i] + '</option>');//value:id
          }
          // $('.idData_edit').children().remove();
          // $('.idData_edit').val(data.sub_);
        });
      });

      //更新ボタン
      $(document).on('click','.update',function(){
        $('#date_edit_err').empty();
        $('#str_edit_err').empty();
        $('#end_edit_err').empty();
        $('#task_edit_err').empty();
        $('#time_edit_err').empty();
        $('#code_mst_edit_err').empty();
        $('#idData_edit_err').empty();

        var check = true;

        if($('#date_edit').val() == ''){
          $('#date_edit_err').append('※必須項目');
          check = false;
        }else{
          var date_af = $('#date_edit').val();
        }

        if($('#str_edit').val() == ''){
          $('#str_edit_err').append('※必須項目');
          check = false;
        }else{
          var str_af = $('#str_edit').val();
        }

        if($('#end_edit').val() == ''){
          $('#end_edit_err').append('※必須項目');
          check = false;
        }else{
          var end_af = $('#end_edit').val();
        }

        if($('.task_edit').val() == ''){
          $('#task_edit_err').append('※必須項目');
          check = false;
        }else{
          var task_af = $('.task_edit').val();
        }

        if($('#work_time_edit').val().slice(0,1) == '-' || $('#work_time_edit').val() == '' || $('#work_time_edit').val().slice(0,4) == '0:00'){
          $('#time_edit_err').append('※不適切');
        }else{
          var work_time_af = $('#work_time_edit').val();
        }

        if($('.code_mst_edit').val() == 0){
          $('#code_mst_edit_err').append('※必須項目');
          check = false;
        }else{
          var code_mst_af = $('.code_mst_edit').val();
        }

        if($('.idData_edit').val() == 0){
          $('#idData_edit_err').append('※必須項目');
          check = false;
        }else{
          var idData_af = $('.idData_edit').val();
        }

        var works = $(this).attr('id');
        // var task_af = $('.task_edit').val();
        // var idData_af = $('.idData_edit').val();

        // var date_af = $('#date_edit').val();
        // var str_af = $('#str_edit').val();
        // var end_af = $('#end_edit').val();
        var bre_af = $('#bre_edit').val();
        // var work_time_af = $('#work_time_edit').val();
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
          $('#overlay, #modalWindow_input').fadeOut();
          $('#'+ works).empty();
          $('#'+ works).append("<td>" + update.date + "</td><td>" + update.str + "~"+ update.end + "(" + update.work_time + ")</td><td>"+ update.mst + "</td><td>" + update.sub + "</td><td>"+ update.task + "</td><td><input type='button' class='edit' id=" + works + "><input type='button' class='del' id=" + works + "></td>");
        });
      });

      //更新ボタン_作業表示（日）
      $(document).on('click','.update_day',function(){
        $('#date_edit_d_err').empty();
        $('#str_edit_d_err').empty();
        $('#end_edit_d_err').empty();
        $('#task_edit_d_err').empty();
        $('#time_edit_d_err').empty();
        $('#code_mst_edit_d_err').empty();
        $('#idData_edit_d_err').empty();

        var check = true;

        if($('#date_edit_d').val() == ''){
          $('#date_edit_d_err').append('※必須項目');
          check = false;
        }else{
          var date_af = $('#date_edit_d').val();
        }

        if($('#str_edit_d').val() == ''){
          $('#str_edit_d_err').append('※必須項目');
          check = false;
        }else{
          var str_af = $('#str_edit_d').val();
        }

        if($('#end_edit_d').val() == ''){
          $('#end_edit_d_err').append('※必須項目');
          check = false;
        }else{
          var end_af = $('#end_edit_d').val();
        }

        if($('.task_edit_d').val() == ''){
          $('#task_edit_d_err').append('※必須項目');
          check = false;
        }else{
          var task_af = $('.task_edit_d').val();
        }

        if($('#work_time_edit_d').val().slice(0,1) == '-' || $('#work_time_edit_d').val() == '' || $('#work_time_edit_d').val().slice(0,4) == '0:00'){
          $('#time_edit_d_err').append('※不適切');
        }else{
          var work_time_af = $('#work_time_edit_d').val();
        }

        if($('.code_mst_edit_d').val() == 0){
          $('#code_mst_edit_d_err').append('※必須項目');
          check = false;
        }else{
          var code_mst_af = $('.code_mst_edit_d').val();
        }

        if($('.idData_edit_d').val() == 0){
          $('#idData_edit_d_err').append('※必須項目');
          check = false;
        }else{
          var idData_af = $('.idData_edit_d').val();
        }

        var works = $(this).attr('id');
        var bre_af = $('#bre_edit_d').val();

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
          // $('#overlay, #modalWindow_day').fadeOut();
          $('#overlay_day, #modalWindow_day').fadeOut();
          $('#d'+ works).empty();
          $('#d'+ works).append("<td>" + update.str + "~"+ update.end + "(" + update.work_time + ")</td><td>"+ update.mst + "</td><td>" + update.sub + "</td><td>"+ update.task + "</td><td><input type='button' class='edit_day' id=" + works + "><input type='button' class='del' id=" + works + "></td>");
          //$('#select_day_button').trigger('click');
          $('#'+ works).empty();
          $('#'+ works).append("<td>" + update.date + "</td><td>" + update.str + "~"+ update.end + "(" + update.work_time + ")</td><td>"+ update.mst + "</td><td>" + update.sub + "</td><td>"+ update.task + "</td><td><input type='button' class='edit_day' id=" + works + "><input type='button' class='del' id=" + works + "></td>");
          $('#select_day_button').trigger('click');
        });
      });

      //キャンセルボタン
      $(document).on('click','.close',function(){
        $('#overlay, .modalWindow').fadeOut();
        $('#overlay_day, .modalWindow').fadeOut();
      })

    //カレンダー
    $.datepicker.setDefaults($.datepicker.regional["ja"]);
    var dateFormat = 'yy-mm-dd';
    $('#date').datepicker({
      dateFormat: dateFormat, //yy-mm-dd
      showOtherMonths: true, //他の月を表示
      selectOtherMonths: true //他の月を選択可能
    }).datepicker('setDate','today') //今日の日付

    $('#select_dates').datepicker({
      dateFormat: dateFormat, //yy-mm-dd
      showOtherMonths: true, //他の月を表示
      selectOtherMonths: true //他の月を選択可能
    }).datepicker('setDate','today') //今日の日付

    $('#select_month').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm",
      showButtonPanel: true,
      currentText: "This Month",
      onChangeMonthYear: function (year, month, inst) {
          $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month - 1, 1)));
      },
      onClose: function(dateText, inst) {
          var month = $(".ui-datepicker-month :selected").val();
          var year = $(".ui-datepicker-year :selected").val();
          $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
      }
  }).focus(function () {
      $(".ui-datepicker-calendar").hide();
  // }).after(
  //     $("<a href='javascript: void(0);'>clear</a>").click(function() {
  //         $(this).prev().val('');
  //     })
}).datepicker('setDate','today')
    // $('#select_month').datepicker({
    //   changeMonth: true,
    //   changeYear: true,
    //   showButtonPanel: true,
    //   dateFormat: 'yy-mm',
    //   onClose: function(dateText, inst) {
    //       $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    //   }
    // });
    $('#select_kanri_month').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm",
      showButtonPanel: true,
      currentText: "This Month",
      onChangeMonthYear: function (year, month, inst) {
          $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month - 1, 1)));
      },
      onClose: function(dateText, inst) {
          var month = $(".ui-datepicker-month :selected").val();
          var year = $(".ui-datepicker-year :selected").val();
          $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
      }
  }).focus(function () {
      $(".ui-datepicker-calendar").hide();
  // }).after(
  //     $("<a href='javascript: void(0);'>clear</a>").click(function() {
  //         $(this).prev().val('');
  //     })
}).datepicker('setDate','today')

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
    $('#str_edit_d').timepicker({
      'timeFormat': 'H:i',
      'step' : '10'
    });
    $('#end_edit_d').timepicker({
      'timeFormat': 'H:i',
      'step' : '10'
    });
    $('#bre_edit_d').timepicker({
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

    $('#str_edit_d, #end_edit_d, #bre_edit_d').change(function(){
      var str_edit_input = $('#str_edit_d').val();
      var end_edit_input = $('#end_edit_d').val();
      var bre_edit_input = $('#bre_edit_d').val();
      if(str_edit_input && end_edit_input){
        var result2 = timeMath.sub(end_edit_input + ':00', str_edit_input + ':00', bre_edit_input + ':00');
        // console.log(result1);
        $('#work_time_edit_d').val(result2.slice(0,-3));//秒を非表示
      }
    });

    //作業表示（日）表示クリック
    $('#select_day_button').click(function(){
      $('#day_view td').remove();
      $('#day_sumtime').children().remove();
      var select_date = $('#select_dates').val();
      $.post('selects.php',{
        select_date: select_date
      },function(result){
        for(n in result){
          if(result[n].del == 0){
            $('#day_view').append('<tr id=d' + result[n].key + '><td>'+ result[n].start.slice(0,-3) +'~'+ result[n].ends.slice(0,-3) +'('+ result[n].sumtime.slice(0,-3)+')</td><td>'+ result[n].mst_id + '</td><td>' + result[n].sub_id + '</td><td>'+ result[n].obj + '</td><td><input type="button" class="edit_day" id=' + result[n].key + '><input type="button" class="del" id=' + result[n].key + '></td></tr><br>');
          }
        }
        //一日の合計作業時間
        if(n == result.length -1){
          $('#day_sumtime').append('<table id="day_sumtime_view"><tr><th>本日の作業時間</th></tr><tr><td>' + result[n].d_time + '</td></tr></table>');
        }
      });
    });

    $('#select_month_button').click(function(){
      $('#select_month_view').children().children().remove();
      var select_month = $('#select_month').val();
      var format = $("input[name='s3']:checked").val();
      $.post('select_month.php',{
        select_month: select_month,
        format: format
      },function(result){
        for(n in result){
          if(result[n].obj == ""){
            $('#select_month_view_tb').append('<tr><td class="day" width="60px">' + result[n].day.slice(5,10) + '</td><td>&nbsp;</td></tr>');
          }else if(result[n].format == '<br>'){
            $('#select_month_view_tb').append('<tr><td class="day" width="60px">' + result[n].day.slice(5,10) + '</td><td>"' + result[n].obj + '"</td></tr>');
          }else{
            $('#select_month_view_tb').append('<tr><td class="day" width="60px">' + result[n].day.slice(5,10) + '</td><td>' + result[n].obj + '</td></tr>');
          }
        }
        // alert(result);
      });
    });

    //管理画面表示
    $('#select_kanri_button').click(function(){
      $('#select_kanri_view').children().children().remove();
      $('#kanri_month_time').children().remove();
      $('#kanri_month_come').children().remove();
      $('#kanri_month_time_cp').children().children().remove();
      var select_kanri_month = $('#select_kanri_month').val();
      var select_user = $('.user_select').val();
      $.post('kanri_selectssss.php',{
        select_kanri_month: select_kanri_month,
        select_user: select_user
      },function(kanri_result){
        // for(n in kanri_result){
        //   $('#select_kanri_view_tb').append('<tr><td>' + kanri_result[n].master + '</td><td>' + kanri_result[n].sub
        //   + '</td><td>'+ kanri_result[n].key + '</tr>'
        // )};
      for(n in kanri_result){
        $('#select_kanri_view_tb').append('<tr class=' + n + '><td>' + kanri_result[n].master + '</td><td>' + kanri_result[n].time + '</td></tr>');
          for(keys in kanri_result[n].sub){
            $('.' + n).append('<tr><td width="500px">'
           + keys + '</td><td>' + kanri_result[n].sub[keys]
          + '</td></tr>');
          }

        $('#select_kanri_view_cp').append('<tr><td>' + kanri_result[n].time + '</td></tr>');

        if(n == kanri_result.length - 1){
          // $('#kanri_month_time').append(
          //   '<span>合計時間</span><span>' + kanri_result[n].m_time.slice(0,-3) + '</span>'
          // );
          $('#select_kanri_view_cp').append('<tr><td><font color="red">' + kanri_result[n].m_time + '</font></td></tr>');
          $('#kanri_month_come').append('<p><font color="red">※Excelに貼り付けを行う際は「セルの書式設定」にて"ユーザ定義"を選択して、種類を"[h]:mm"にしてください</font></p>');
        }
      }


        // $('#select_kanri_view_tb').append('<tr><td>' + kanri_result + '</td></tr>');
      });
    });

    //日付の表示非表示
    $('#day_hidden').click(function(){
      var $element = document.getElementsByClassName("day");
      for(var $i = 0; $i <$element.length; $i++){
        $element[$i].style.display="none";
      }
    });

    $('#day_open').click(function(){
      var $element = document.getElementsByClassName("day");
      for(var $i = 0; $i <$element.length; $i++){
        $element[$i].style.display="block";
      }
    });

    //サイドメニュー非表示
    $.fn.clickToggle = function(a, b) {
      return this.each(function() {
        var clicked = false;
　       $(this).on('click', function() {
  　 clicked = !clicked;
　　　if (clicked) {
　　　　return a.apply(this, arguments);
　　　}
　　　return b.apply(this, arguments);
　　  });
    });
    };
    $( '#menu' ).clickToggle(
    function() {
      $('#in, #day_out, #month_out, .tab_item, .tab_bottom').css('width','0');
      $('#in, #day_out, #month_out, .tab_item, .tab_bottom').css('overflow','hidden');
      $('.menu').css('margin-left','10px');
      $('.tab_content').css('margin-left','30px');
    },
    function() {
      $('#in, #day_out, #month_out, .tab_item, .tab_bottom').css('width','280px');
      $('label, .tab_bottom').css('display','block');
      $('.menu').css('margin-left','290px');
      $('.tab_content').css('margin-left','320px');
    });
  });
