<?php
require_once dirname(__FILE__).'/../vendor/autoload.php';

use Aws\S3\S3Client;

use Aws\Exception\AwsException;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>こん朝</title>
  <link rel="stylesheet" href="stylesheet/top_sp.css">
</head>
<body>
  <div class="top_back">
   <div class="top">
     <p>Is there such a <br> good morning</p>
   </div>
   <div class="form">
     <form action="kon_login.php" method="post">
       <input type="submit" value="log in" style="background-color:silver ; color:black; font-size:15px; font-family:Bookman Old Style;">
     </form>
     <form action="kon_signup.php" method="post">
       <input type="submit" value="sign up" style="background-color:black ; color:white; font-size:15px; font-family:Bookman Old Style;">
     </form>
   </div>
  </div>
</body>
</html>
