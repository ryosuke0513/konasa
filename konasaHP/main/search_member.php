<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once dirname(__FILE__).'/../../vendor/autoload.php';
require_once('../database.php');

//session_start();

$info=$_POST['work'];

try{
$dbh=dbConnect();
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}

$sth = $dbh->prepare("SELECT * FROM user_profile WHERE work=:work");
$sth->bindValue(':work', $info);
$sth->execute();
$res = $sth->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メンバー一覧</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/search_member.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
 <div class="main">
  <div class="mainname"><?php echo $info.'業界のメンバー'; ?></div>
  <div class="list">
    <?php foreach($res as $value): ?>
      <form class="listform" action="member_page.php" method="post">
        <input type="hidden" name="member_profile" value="<?=$value['name']?>">
        <?php if(!empty($value['proimg'])){echo '<p><img src="data:image/jpeg;base64,'.$value['proimg'].'"></p>';}else{echo '<p><img src="S__45850670.jpg"></p>';}?>
        <input class="name" type="submit" value="<?=$value['name']?>"><br>
      </form>
    <?php endforeach; ?>
  </div>
  <div class="return">
    <input class="fas" type="button" onclick="history.back()" value="&#xf2ea;">
  </div>
</div>

</body>
</html>
