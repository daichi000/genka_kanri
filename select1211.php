<?php

 ?>
 <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script>
        $(function() {

            // Ajax
            // Asynchronous JavaScript + XML
            // サーバーと通信 + ページの書き換え
            // 非同期: 処理が終わる前に次の処理に移る
            // $.post
            // $.get

            $('#select').click(function() {
                $.post('index1211.php', {
                    name: $('#name').val()
                }, function(data) {
                    $('#result').html(data);
                });

            });

        });
    </script>
 <p>
   <input type="text" id="name" value="">
   <input type="button" name="" value="select" id="select">
 </p>
 <div id="result">
 </div>
