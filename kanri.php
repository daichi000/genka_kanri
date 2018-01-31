<?php
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
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理画面</title>
  <script src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">></script>
  <script type='text/javascript'>
    $(function(){
      $('.add_code').hide();

      //selectタグが変更された場合
      $('.code_mst').change(function(){
        var code_mst = $('.code_mst').val();
        $.post('select.php',{
          code_mst: code_mst
        }, function(data){
          $('#res').html(data);
          $('.add_code').show();

          //addボタンが押下された場合
          $('#add_code').click(function(){
            var add_code_name = $('#add_code_name').val();
            // $.post('select.php',{
            //   add_code: add_code_name
            //   // code_msts: code_mst
            // }, function(adddata){
            //   $('#res_add').html(adddata);//コードが追加されましたor同一コードが存在します
            // });
            var add_code_name = $('#add_code_name').val();
            $('#res_add').text(add_code_name);
          });
        });
        return false;

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
  <span>master_code:</span>
  <select class="code_mst" value="">
    <option>選択してください</option>
    <?php
    foreach($cdmst_list as $key => $cdmst_name){
      echo '<option value="'.$key.'">'.$cdmst_name.'</option>';
    }
    ?>

  </select>
  <div id='res'>
  </div>

  <div class="add_code">
      <input type="text" id="add_code_name" value="">
      <input type="button" id="add_code" value="add">
  </div>

  <div id='res_add'>
  </div>

</body>

</html>
