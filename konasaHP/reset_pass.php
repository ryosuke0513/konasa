<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once('database.php'); // データベースアクセスファイル読み込み
require_once('auth.php'); // ログイン認証ファイル読み込み

require '/vendor/autoload.php';

//session_start();

$errorMessage = ""; // エラーメッセージ初期化

if (isset($_POST['reset'])) {
  if(!empty($_POST['email']) && !empty($_POST['password'])){
    try{
    $dbh=new PDO('mysql:dbname=heroku_52db3e9eb6b3150;host=us-cdbr-iron-east-04.cleardb.net;charset=utf8','bb3752587a7146','183858ec',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }catch(PDOException $e){
    echo "DBerror:".$e->getMessage();
    }
    $email=$_POST['email'];
    $password=$_POST['password'];

    $email=htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $password=htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

    $sql = "UPDATE user_id SET password = :password WHERE email = :email";
    $stt=$dbh->prepare($sql);
    $stt->bindValue(':email',$email);
    $stt->bindValue(':password',$password);
    $stt->execute();

    if($account=login($_POST['email'], $_POST['password'])){
      $_SESSION['account'] = $account;
      header("Location: main/kon_mypage.php");
    }else{
      $errorMessage="登録に失敗しました。別のアドレス、もしくはパスワードをお試しください。";
    }
    // ログイン失敗時の表示
  } elseif(empty($_POST['email']) && empty($_POST['password'])) {
    $errorMessage = "メールアドレスとパスワードを入力してください。";
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>reset pass</title>
</head>
<body>
  <div>password Reset</div>
  <p>メールアドレスと新しいパスワードを入れてください</p>
  <div>
    <form action="" method="post">
      <p><?php if(!empty($errorMessage)){echo $errorMessage;}?></p>
      <input type="text" name="email" placeholder="e-mail"><br>
      <input type="password" name="password" placeholder="password"><br>
      <input type="submit" name="reset" value="Reset pass">
    </form>
  </div>
