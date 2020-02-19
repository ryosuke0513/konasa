<?php
//session_save_path("/Applications/MAMP/tmp/php");
require_once dirname(__FILE__).'/../vendor/autoload.php';
session_start();
require_once('database.php'); // データベースアクセスファイル読み込み
require_once('auth.php'); // ログイン認証ファイル読み込み
$errorMessage = ""; // エラーメッセージ初期化

// ログイン処理
if (isset($_POST['login'])) {
  if(!empty($_POST['email']) && !empty($_POST['password'])){
    if ($account=login($_POST['email'], $_POST['password'])){
      $_SESSION['account'] = $account;
      header("Location: main/kon_mypage.php");
    // ログイン失敗時の表示
    } else {
      $errorMessage = "ログインに失敗しました。";
    }
  } else {
    $errorMessage = "メールアドレスとパスワードを入力してください。";
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>log in</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/log_sig_sp.css">
</head>
<body>
  <div class="log_sig_top">
    <p>log in</p>
  </div>
  <div class="form">
    <form class="form_put" action="" method="post">
      <p><?php if(!empty($errorMessage)){echo $errorMessage;}?></p>
      <input class="sou" type="text" name="email" value="" placeholder="e-mail"><br>
      <input class="sou" type="password" name="password" value="" placeholder="password"><br><br>
      <input class="button" type="submit" name="login" value="LOG IN" style="background-color:white;">
      <input class="button" type="button" onclick="location.href='kon_signup.php'" value="SIGN UP" style="background-color:black; color:white;">
      <input class="button" type="button" onclick="location.href='reset_pass.php'" value="RESET PASS">
    </form>
  </div>
</body>
</html>
