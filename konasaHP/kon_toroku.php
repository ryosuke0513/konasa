<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once('database.php');

if(!isset($_SESSION)){
session_start();
}

require_once dirname(__FILE__).'/../vendor/autoload.php';

$errorMessage="";

$profileimg="";
$name="";
$email="";
$work="";
$skill="";
$assist="";
$support="";

try{
$dbh=dbConnect();
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}

//$path='photo/';
//$photoname='';
//$photomessage='';


if(isset($_POST['confirm'])){
   if(!empty($_POST['name'])&&!empty($_POST['email'])&&!empty($_POST['work'])&&!empty($_POST['skill'])&&!empty($_POST['assist'])&&!empty($_POST['support'])){

        $sql="INSERT INTO user_profile(name,work,skill,assist,support,email) VALUES(:name,:work,:skill,:assist,:support,:email)";

        $name=$_POST['name'];
        $email=$_POST['email'];
        $work=$_POST['work'];
        $skill=$_POST['skill'];
        $assist=$_POST['assist'];
        $support=$_POST['support'];

        $stt=$dbh->prepare($sql);
        $stt->bindValue(':name',$name);
        $stt->bindValue(':email',$email);
        $stt->bindValue(':work',$work);
        $stt->bindValue(':skill',$skill);
        $stt->bindValue(':assist',$assist);
        $stt->bindValue(':support',$support);
        $stt->execute();
        header("Location: main/myimg.php");
      }else{
    $errorMessage="全て入力してください";
      }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録画面</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/toroku.css">
</head>
<body>
  <div><?php echo $errorMessage; ?></div>
  <div class="main">
    <p>Set up a profile</p>
  </div>
  <div class="setup">
    <form action="" method="post">
      <div class="setup_name">name</div>
      <div class="setup_in">
        <input type="text" name="name">
      </div>
      <div class="setup_name">mail</div>
      <div class="setup_in">
        <input type="email" name="email" placeholder="登録したアドレスを入力">
      </div>
      <div class="setup_name">Work</div>
      <div class="setup_in">
       <select name="work">
         <option>IT</option>
         <option>メーカー</option>
         <option>流通・小売</option>
         <option>金融</option>
         <option>広告・出版・印刷</option>
         <option>公社</option>
         <option>その他</option>
       </select>
     </div>
     <div class="setup_name">skill</div>
     <div class="setup_in">
       <select name="skill">
         <option>言語[資格]</option>
         <option>金融[資格]</option>
         <option>法務・総務[資格]</option>
         <option>教育[資格]</option>
         <option>食品・販売・サービス</option>
         <option>不動産</option>
         <option>IT・システム開発</option>
         <option>マーケティング</option>
         <option>営業</option>
         <option>デザイン</option>
         <option>その他</option>
      </select>
    </div>
    <div class="setup_name">assist</div>
    <div class="setup_in">
      <textarea name="assist" placeholder="支援できることを記入してください"></textarea>
    </div>
    <div class="setup_name">support</div>
    <div class="setup_in">
      <textarea name="support" placeholder="支援してほしいことを記入してください"></textarea>
    </div>
    <div class="button">
      <input type="submit" name="confirm" value="確定">
    </div>
   </form>
 </div>
</body>
</html>
