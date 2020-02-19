<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require '../vendor/autoload.php';

//DB接続処理
function dbConnect(){
  $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $server = $url["host"];
  $username = $url["user"];
  $password = $url["pass"];
  $db = substr($url["path"], 1);

  $dbh = new PDO(
    'mysql:host=' . $server . ';dbname=' . $db . ';charset=utf8mb4',
    $username,
    $password,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]);
  return $dbh;
}

// ログイン処理
function login($email, $password){
  $dbh = dbConnect();
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
  $dbh = dbConnect();
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
