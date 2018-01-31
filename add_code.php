<?php
header('Content-Type: application/json; charset=utf-8');

try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'root','');
  // echo "OK";


}catch(PDOException $e){
  print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

$code_msts = $_POSR['code_mst'];
$add_code = $_POST['add_code'];
echo $code_msts;
echo $add_code;
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
//       $stmo -> bindValue(':id', $code_mst);
//       $stmo -> bindValue(':addcode', $add_code);
//       $stmo -> execute();
//       echo 'コードを追加しました';
//     }
//   }catch(PDOException $e){
//     print("error:". $e->getMessage());
//   }
// }
