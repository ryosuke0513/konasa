<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

require_once('../database.php');

require_once dirname(__FILE__).'/../../vendor/autoload.php';

//session_save_path("/Applications/MAMP/tmp/php");
//session_start();


try{
$dbh=dbConnect();
}catch(PDOException $e){
echo "DBerror:".$e->getMessage();
}

$sth = $dbh->prepare("SELECT * FROM user_profile");
$sth->execute();
$res = $sth->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>メンバー一覧</title>
  <link rel="stylesheet" type="text/css" href="stylesheet/member_list_sp.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
  <div class="main">
   <div class="mainname">Member list</div>
   <div class="list">
     <?php foreach($res as $value): ?>
       <form class="listform" action="member_page.php" method="post">
         <?php if(!empty($value['proimg'])){echo '<p><img src="data:image/jpeg;base64,<?php echo $result['proimg'];?>"></p>';}else{echo '<p><img src="S__45850670.jpg"></p>';}?>
         <input type="hidden" name="member_profile" value="<?=$value['name']?>">
         <input class="name" type="submit" value="<?=$value['name']?>"><br>
       </form>
     <?php endforeach; ?>
   </div>
  </div>
 <div class="return">
   <input class="fas" type="button" onclick="history.back()" value="&#xf2ea;" style="background-image: linear-gradient(45deg, #FF9999 0%, #91fdb7 100%);">
 </div>
</body>
</html>
