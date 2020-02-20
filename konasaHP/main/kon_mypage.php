<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once('../database.php');

require_once dirname(__FILE__).'/../../vendor/autoload.php';

//session_save_path("/Applications/MAMP/tmp/php");
if(!isset($_SESSION)){
session_start();
}

$imgname='';
$errorMessage='';
$info=$_SESSION['account']['email'];

echo $info;

try{
$dbh=dbConnect();
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}


$sql = "SELECT * FROM user_profile WHERE email = :email;";
$stt = $dbh->prepare($sql);
$stt->bindValue(':email', $info);
$stt->execute();
while($row=$stt->fetch()){
  $result['name'] = $row['name'];
  $result['work'] = $row['work'];
  $result['skill'] = $row['skill'];
  $result['assist'] = $row['assist'];
  $result['support'] = $row['support'];
  $result['proimg'] = $row['proimg'];
}if(empty($result)){
  $errorMessage="登録してください";
}

$size_set_file='data:image/jpeg;base64,'.$result['proimg'];

//$imgname=$result['proimg'];
//$finfo    = finfo_open(FILEINFO_MIME_TYPE);
//$mimeType = finfo_buffer($finfo, $imgname);
//finfo_close($finfo);

//header('Content-Type: ' . $mimeType);
//echo $mimeType;
//$img_dir='../photo/'.$imgname;

//$file = $img_dir;
//$size_set_file='size_set'.$imgname;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/mypage_sp.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

</head>
<body>
  <div class="top">
    <div class="proimg">
      <p><?php echo"<img src='$size_set_file')>";?></p>
    </div>
    <p class="top_p" style="padding-bottom:20px;"></p>
    <div class="mymain">
      <p>Name : <?php if(!empty($result)){echo $result['name'];}else{echo "登録ページで名前を".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Work : <?php if(!empty($result)){echo $result['work'];}else{echo "登録ページでお仕事を".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Skill : <?php if(!empty($result)){echo $result['skill'];}else{echo "登録ページでスキルを".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Assist</p>
      <p>&nbsp;&nbsp;<?php if(!empty($result)){echo $result['assist'];}else{echo "登録ページで支援できることを".$errorMessage;}?></p>
    </div>
    <div class="mymain">
      <p>Support</p>
      <p>&nbsp;&nbsp;<?php if(!empty($result)){echo $result['support'];}else{echo "登録ページで支援してほしいことを".$errorMessage;}?></p>
    </div>
    <div class="form">
      <form action="" method="post">
        <input class="fas" type="button" onclick="location.href='profile_update.php'" value="&#xf2c2;" style="background-image: linear-gradient(45deg, #709dff 0%, #91fdb7 100%);">
        <input class="fas" type="button" onclick="location.href='all_member.php'" value="&#xf007;" style="background-image: linear-gradient(45deg, #709dff 0%, #FFFFCC 100%);">
        <input class="fas" type="button" onclick="location.href='search.php'" value="&#xf002;" style="background-image: linear-gradient(45deg, #709dff 0%, #FF99FF 100%);">
      </form>
    </div>
  </div>
</body>
</html>
