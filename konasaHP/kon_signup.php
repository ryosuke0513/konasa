<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
session_start();
require_once('database.php'); // データベースアクセスファイル読み込み
require_once('auth.php'); // ログイン認証ファイル読み込み

require_once dirname(__FILE__).'/../vendor/autoload.php';

$errorMessage='';
$email='';
$password='';

if (isset($_POST['signup'])) {
  if(!empty($_POST['email']) && !empty($_POST['password'])){
    try{
    $dbh=dbConnect();
    }catch(PDOException $e){
    echo "DBerror:".$e->getMessage();
    }
    $email=$_POST['email'];
    $password=$_POST['password'];

    $email=htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $password=htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

    $sql = "INSERT INTO user_id(email,password) VALUES (:email,:password)";
    $stt=$dbh->prepare($sql);
    $stt->bindValue(':email',$email);
    $stt->bindValue(':password',$password);
    $stt->execute();

    if($account=login($_POST['email'], $_POST['password'])){
      $_SESSION['account'] = $account;
      header("Location: kon_toroku.php");
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
  <title>sign up</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/log_sig_sp.css">
</head>
<body>
  <div class="log_sig_top">
    <p>sign up</p>
  </div>
  <div class="form">
    <form class="form_put" action="" method="post">
      <p><?php if(!empty($errorMessage)){echo $errorMessage;}?></p>
      <input class="sou" type="text" name="email" placeholder="e-mail"><br>
      <input class="sou" type="password" name="password" placeholder="password"><br>
      <input class="button" type="submit" name="signup" value="SIGN UP">
      <input class="button" type="button" onclick="location.href='kon_login.php'" value="LOG IN" style="background-color:black; color:white;">
    </form>
  </div>
</body>
</html>
