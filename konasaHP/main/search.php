<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
//session_start();

require_once dirname(__FILE__).'/../../vendor/autoload.php';

if(isset($_POST['search'])){
  header("Location: search_member.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>search</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/search_sp.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
  <div class="main">
    <form action="search_member.php" method="post">
      <div class="mainname">search by job</div>
      <div class="select">
        <select class="selectname" name="work">
          <option>IT</option>
          <option>メーカー</option>
          <option>流通・小売</option>
          <option>金融</option>
          <option>広告・出版・印刷</option>
          <option>公社</option>
          <option>その他</option>
        </select>
      </div>
      <div class="button">
        <input class="fas" type="submit" name="search" value="&#xf002;" style="background-image: linear-gradient(45deg, #709dff 0%, #91fdb7 100%);">
      </div>
    </form>
  </div>
</body>
</html>
