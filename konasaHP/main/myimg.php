<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require '/vendor/autoload.php';

$photoinfo=$_SESSION['account']['password'].'.jpg';
$info=$_SESSION['account']['email'];

try{
$dbh=new PDO('mysql:dbname=heroku_52db3e9eb6b3150;host=us-cdbr-iron-east-04.cleardb.net;charset=utf8','bb3752587a7146','183858ec',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}

// ファイルへのパス
$path = '../photo/';

// ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
if( !empty($_FILES['proimg']['tmp_name']) && is_uploaded_file($_FILES['proimg']['tmp_name']) ) {
  $photoname=$_FILES['proimg']['name'].$photoinfo;

  $sql="UPDATE user_profile SET proimg = :proimg WHERE email = :email;";
  $stt=$dbh->prepare($sql);
  $stt->bindValue(':proimg',$photoname);
  $stt->bindValue(':email',$info);
  $stt->execute();

	// ファイルを指定したパスへ保存する
	if( move_uploaded_file( $_FILES['proimg']['tmp_name'], $path.$photoname) ) {
		header("Location:kon_mypage.php");
	} else {
		echo 'アップロードされたファイルの保存に失敗しました。';
	}
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
