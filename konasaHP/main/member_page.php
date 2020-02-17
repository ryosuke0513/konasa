<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

//session_save_path("/Applications/MAMP/tmp/php");
//session_start();

require '/vendor/autoload.php';

$errorMessage='';
$i=$_POST["member_profile"];
try{
$dbh=new PDO('mysql:dbname=heroku_52db3e9eb6b3150;host=us-cdbr-iron-east-04.cleardb.net;charset=utf8','bb3752587a7146','183858ec',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}

$sql = "SELECT * FROM user_profile WHERE name = :email;";
$stt = $dbh->prepare($sql);
$stt->bindValue(':email', $i);
$stt->execute();
while($row=$stt->fetch()){
  $result['name'] = $row['name'];
  $result['work'] = $row['work'];
  $result['skill'] = $row['skill'];
  $result['assist'] = $row['assist'];
  $result['support'] = $row['support'];
}if(empty($result)){
  $errorMessage="";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
</head>
<body>
  <div>
    <p>My page</p>
    <div>
      <p>Name</p>
      <p><?php if(!empty($result)){echo $result['name'];}else{echo "登録ページで名前を".$errorMessage;}?></p>
    </div>
    <div>
      <p>Work</p>
      <p><?php if(!empty($result)){echo $result['work'];}else{echo "登録ページでお仕事を".$errorMessage;}?></p>
    </div>
    <div>
      <p>Skill</p>
      <p><?php if(!empty($result)){echo $result['skill'];}else{echo "登録ページでスキルを".$errorMessage;}?></p>
    </div>
    <div>
      <p>Assist</p>
      <p><?php if(!empty($result)){echo $result['assist'];}else{echo "登録ページで支援できることを".$errorMessage;}?></p>
    </div>
    <div>
      <p>Support</p>
      <p><?php if(!empty($result)){echo $result['support'];}else{echo "登録ページで支援してほしいことを".$errorMessage;}?></p>
    </div>
    <div>
      <form action="" method="post">
        <input type="button" onclick="location.href='all_member.php'" value="メンバーリスト">
      </form>
  </div>
</body>
</html>
