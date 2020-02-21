<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once('../database.php');

//session_save_path("/Applications/MAMP/tmp/php");
//session_start();

require_once dirname(__FILE__).'/../../vendor/autoload.php';

$errorMessage='';
$i=$_POST["member_profile"];
try{
$dbh=dbConnect();
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
  <title>メンバーリスト</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/mypage_sp.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
  <div class="top">
    <div class="proimg">
      <img src="data:image/jpeg;base64,<?php echo $result['proimg'];?>">
    </div>
    <p class="top_p" style="padding-bottom:20px;"></p>
    <div class="mymain">
      <p>Name</p>
      <p><?php if(!empty($result)){echo $result['name'];}else{echo "登録されていません".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Work</p>
      <p><?php if(!empty($result)){echo $result['work'];}else{echo "登録されていません".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Skill</p>
      <p><?php if(!empty($result)){echo $result['skill'];}else{echo "登録されていません".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Assist</p>
      <p><?php if(!empty($result)){echo $result['assist'];}else{echo "登録登録されていません".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Support</p>
      <p><?php if(!empty($result)){echo $result['support'];}else{echo "登録されていません".$errorMessage;}?></p>
    </div>
    <div>
      <form action="" method="post">
        <input class="fas" type="button" onclick="history.back()" value="&#xf2ea;" style="background-image: linear-gradient(45deg, #FF9999 0%, #91fdb7 100%);">
      </form>
  </div>
</body>
</html>
