<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
if(!isset($_SESSION)){
session_start();
}

require_once dirname(__FILE__).'/../../vendor/autoload.php';

require_once('../database.php');

$errorMessage='';

$photoinfo=$_SESSION['account']['password'].'.jpg';
$info=$_SESSION['account']['email'];

try{
$dbh=dbConnect();
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}


// ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
if( !empty($_FILES['proimg']['tmp_name']) ) {
  $filename=$_FILES['proimg']['name'];
  $ffname=$_FILES['proimg']['tmp_name'];
  $size_set_file='size_set'.$filename;

  list($w, $h) = getimagesize($ffname);

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
  $baseImage = imagecreatefromjpeg($ffname);

  //サムネイルになる土台の画像に合わせて元の画像を縮小しコピーペーストする
  imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $diffW, $diffH);

  //圧縮率60で保存する

  //ob_start();
  imagejpeg($thumbnail, $size_set_file, 60);
  //$imageData = ob_get_contents();
  //ob_end_clean();


  $fname = base64_encode(file_get_contents($size_set_file));

  $sql="UPDATE user_profile SET proimg = :proimg WHERE email = :email;";
  $stt=$dbh->prepare($sql);
  $stt->bindValue(':proimg',$fname);
  $stt->bindValue(':email',$info);
  $stt->execute();

  header("Location:kon_mypage.php");

	} else {
		$errorMessage='画像データの保存に失敗しました';
	}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録２</title>
</head>
<body>
  <div style="font-size: 30px; font-family: 'Bookman Old Style'; font-weight: bold; margin-left: 60px; margin-top: 60px; margin-bottom: 70px;">
    <p>Set profile image</p>
  </div>
  <div>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="file" name="proimg">
      <input type="submit" name="pro" value="Confirm">
    </form>
  </div>
</body>
</html>
