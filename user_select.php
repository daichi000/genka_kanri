<?php
$request = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : '';
if($request !== 'xmlhttprequest') exit;

header('Content-Type: application/json; charset=utf-8');

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}


$mst = $_POST['code_mst'];//master_id
$arr = array();
if(!empty($mst)){
  try{
    $stt = $pdo->prepare('SELECT * FROM dbcode WHERE master_id LIKE :name');
    $stt -> bindValue(':name',$mst);
    $stt -> execute();

    while($row = $stt->fetch(PDO::FETCH_ASSOC)){
      // $arr[] = $row['code']."<br>";
      $arr += array(
        $row['code_id'] => $row['code']
      );
      // $arr[$row['code_id']] = $row['code'];
      // $arr += array( $row['code_id']; )
      // $arr[] = [$row['code_id']],[$row['code']];
    }
    //
  }catch(PDOException $e){
    print("error:". $e->getMessage());
  }
}
echo json_encode($arr,JSON_PRETTY_PRINT);


// if(isset($_POST['add_code'])){
//   $add_code = $_POST['add_code'];
//   echo $add_code;
  // if(!empty($add_code)){
  //   try{
  //     $stmp = $pdo->prepare('SELECT * FROM dbcode WHERE code LIKE :code');
  //     $stmp -> bindValue(':code',$add_code);
  //     $stmp -> execute();
  //
  //     if($co = $stmp->fetch(PDO::FETCH_ASSOC)){
  //       echo '同一コードが存在します';
  //     }else{
  //       $stmo = $pdo->prepare('INSERT INTO dbcode ("master_id", "code") VALUES(:id, :addcode)');
  //       $stmo -> bindValue(':id', $mst);
  //       $stmo -> bindValue(':addcode', $add_code);
  //       $stmo -> execute();
  //       echo 'コードを追加しました';
  //     }
  //   }catch(PDOException $e){
  //     print("error:". $e->getMessage());
  //   }
  // }
// }

// if(isset($_POST['idData'])){
//   $idData = $_POST['idData'];
//   $task = $_POST['task'];
//   echo $idData.$task;
//
// }


 ?>
