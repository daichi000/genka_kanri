<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous">
  </script>
  <script>
    $(function(){
      $('.task').hide();
      $('#display').click(function(){
        $('.task').show();
      });

    });


  </script>
  <?php
  try{
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
    // echo "OK";


  }catch(PDOException $e){
    print "エラー!: " . $e->getMessage() . "<br/>";
      die();
  }

  try{
      $sql = "SELECT * FROM dbcode";
      $stmh = $pdo->prepare($sql);
      $stmh->execute();
  }catch(PDOException $Exception){
      die('接続エラー：' .$Exception->getMessage());
  }




// while($row = $result->fetch_array(MYSQLI_ASSOC)){
// 	$rows[] = $row;
// }


 ?>
 <table border='0'>
 <form action="kanri_make.php" method="post">
   <tr><td>
     code:
      </td><td>
       <select id="code" name="code">

      <?php
      while($row = $stmh->fetch(PDO::FETCH_ASSOC)){?>
        <option value="<?php echo $row['code'];?>"><?php echo $row['code'];?>
        </option>
     <?php } ?>
        </select>
      </td><td>
        <input type="submit" name="display" id="display" value="表示">
  </td>



   <td>
     <!-- <div id='task'></div> -->
   </td>
    </tr><tr>&nbsp;</tr><tr>&nbsp;</tr><tr>&nbsp;</tr>
     <tr><td>
       addcode:
     </td><td>
       <input type="text" name="addcode">
     </td><td>
       <input type="submit" name="button_addcode" value="コード追加">
     </td></tr><tr>&nbsp;</tr><tr>&nbsp;</tr><tr>&nbsp;</tr>
     <tr class='task'>
       <td>
         addtask:
       </td><td>
         <input type="text" name="addtask">
       </td><td>
         <input type="submit" name="button_addtask" value="タスク追加">
       </td>
     </tr>
  </form>
  </table>


  <!-- <p id='task'>aaa</p> -->
 <?php
 //  $code = null;
 //  $task = null;
 // if(!empty($_POST['code'])){
 //   $code = $_POST['code'];
 //   // echo $id;
 // }
 // if(!empty($_POST['task'])){
 //   $task = $_POST['task'];
 // }
 // //code,taskをDBに追加
 // $stmt = $pdo -> prepare("INSERT INTO dbwork (code, task) VALUES (:code, :task)");
 // $stmt->bindValue(':code', $code, PDO::PARAM_INT);
 // $stmt->bindValue(':task', $task, PDO::PARAM_STR);
 //
 // $stmt->execute();
 //
 // //DBの値を表示
 // while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
 //   echo 'code:'.$row['code'];
 //   echo ' task:'.$row['task'];
 //   echo '<br/>';
 // }



 //選択したcodeのtaskを表示
 if(isset($_POST['display'])){
   if($_POST['code']!=''){
     try{
       $stt = $pdo->prepare('SELECT * FROM dbcode WHERE code LIKE :name');
       $stt -> bindValue(':name',$_POST['code']);
       $stt -> execute();

       if($exsist = $stt->fetch(PDO::FETCH_ASSOC)){
         // echo $exsist['code_id'];//1
         $stts = $pdo->prepare('SELECT * FROM dbwork WHERE code_id LIKE :name');
         $stts -> bindValue(':name',$exsist['code_id']);
         $stts -> execute();

         while($exs = $stts->fetch(PDO::FETCH_ASSOC)){
           echo $exs['task'];
           echo "/";
         }
       }else{
         echo "no";
       }

   }catch(PDOException $e){
     print("error:". $e->getMessage());
   }
  }

  // session_start();
  // $_SESSION['code_id'] = $exsist['code_id'];
  // echo $_SESSION['code_id'];
 }

 //code追加
 if(isset($_POST["button_addcode"])){
   if($_POST['addcode']!=''){
     try{
       $sttz = $pdo->prepare('SELECT * FROM dbcode WHERE code LIKE :name');
       $sttz -> bindValue(':name',$_POST['addcode']);
       $sttz -> execute();

       if($addcode = $sttz ->fetch(PDO::FETCH_ASSOC)){
         echo "同一のコードがあります";
       }else{
         $stmq = $pdo -> prepare("INSERT INTO dbcode (code) VALUES (:code)");
         // $stmq->bindValue(':codeid', '', PDO::PARAM_INT);
         $stmq->bindValue(':code', $_POST['addcode'], PDO::PARAM_STR);
         $stmq->execute();
         echo "[". $_POST['addcode']."]"."を追加しました";
       }

     }catch(PDOException $e){
       print("error:". $e->getMessage());
     }
   }
 }


 //task追加
 // if(isset($_POST['button_addtask'])){
 //   echo $_SESSION['code_id'];
 //   if($_POST['addtask']!=''){
 //     try{
 //       //同じtaskが存在するかどうか
 //       $sttz = $pdo->prepare('SELECT * FROM dbwork WHERE task LIKE :task');
 //       $sttz -> bindValue(':task',$_POST['addtask']);
 //       $sttz -> execute();
 //       //task_idの最大値
 //       $stto = $pdo->prepare('SELECT MAX(task_id) as task_id FROM dbwork');
 //       $stto -> execute();
 //       $max_task_id = $stto -> fetch(PDO::FETCH_ASSOC);
 //       if($addcode = $sttz ->fetch(PDO::FETCH_ASSOC)){
 //         echo "同一のタスクがあります";
 //       }else{
 //         $stmr = $pdo -> prepare("INSERT INTO dbwork (task_id, task, code_id) VALUES (:task_id, :task, :code_id)");
 //         // $stmq->bindValue(':codeid', '1', PDO::PARAM_INT);
 //         $stmr->bindValue(':task_id',1, PDO::PARAM_INT);
 //         $stmr->bindValue(':task', $_POST['addtask'], PDO::PARAM_STR);
 //         $stmr->bindValue(':code_id', $_SESSION['code_id'], PDO::PARAM_INT);
 //         $stmr->execute();
 //         echo "[". $_POST['addtask']."]"."を追加しました";
 //       }
 //     }catch(PDOException $e){
 //       print("error:". $e->getMessage());
 //     }
 //   }
 // }

  ?>
