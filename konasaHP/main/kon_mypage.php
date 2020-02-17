<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require '/vendor/autoload.php';

//session_save_path("/Applications/MAMP/tmp/php");
if(!isset($_SESSION)){
session_start();
}

$imgname='';
$errorMessage='';
$info=$_SESSION['account']['email'];

try{
$dbh=new PDO('mysql:dbname=heroku_52db3e9eb6b3150;host=us-cdbr-iron-east-04.cleardb.net;charset=utf8','bb3752587a7146','183858ec',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
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

$imgname=$result['proimg'];
$img_dir='../photo/'.$imgname;

$file = $img_dir;
$size_set_file='size_set'.$imgname;
//元の画像のサイズを取得する
list($w, $h) = getimagesize($file);

//元画像の縦横の大きさを比べてどちらかにあわせる
if($w > $h){
    $diffW = $h;
    $diffH = $h;
}elseif($w < $h){
    $diffW = $w;
    $diffH = $w;
}elseif($w === $h){
    $diffW = $w;
    $diffH = $h;
}

//サムネイルのサイズ
$thumbW = 120;
$thumbH = 120;

//サムネイルになる土台の画像を作る
$thumbnail = imagecreatetruecolor($thumbW, $thumbH);

//元の画像を読み込む
$baseImage = imagecreatefromjpeg($file);

//サムネイルになる土台の画像に合わせて元の画像を縮小しコピーペーストする
imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $diffW, $diffH);

//圧縮率60で保存する
imagejpeg($thumbnail, $size_set_file, 60);

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
