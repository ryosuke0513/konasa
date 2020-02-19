<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require '/vendor/autoload.php';

//DB接続チェック
try{
$dbh=new PDO('mysql:dbname=heroku_52db3e9eb6b3150;host=us-cdbr-iron-east-04.cleardb.net;charset=utf8','bb3752587a7146','183858ec',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}
// ログイン処理
function login($email, $password){
  $dbh = new PDO('mysql:dbname=heroku_52db3e9eb6b3150;host=us-cdbr-iron-east-04.cleardb.net;charset=utf8','bb3752587a7146','183858ec',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  $sql = "SELECT *  FROM user_id  WHERE email = :email AND  password = :password";
  $stt = $dbh->prepare($sql);
  $stt->bindValue(':email', $email);
  $stt->bindValue(':password', $password);
  $stt->execute();
  while($row=$stt->fetch()){
    $result['id'] = $row['id'];
    $result['email'] = $row['email'];
    $result['password'] = $row['password'];
  }
  if(isset($result)){
    return $result;
  }
}
// ログイン認証
function authCheck($email, $password){
  $dbh = new PDO('mysql:dbname=heroku_52db3e9eb6b3150;host=us-cdbr-iron-east-04.cleardb.net;charset=utf8','bb3752587a7146','183858ec',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  $sql = "SELECT * FROM user_id WHERE email = :email AND password = :password ";
  $stt = $dbh->prepare($sql);
  $stt->bindValue(':email', $email);
  $stt->bindValue(':password', $password);
  $stt->execute();
  while($row=$stt->fetch()){
    $result['id'] = $row['id'];
    $result['email'] = $row['email'];
    $result['password'] = $row['password'];
  }
  if(isset($result)){
    return $result;
  }
}
?>
