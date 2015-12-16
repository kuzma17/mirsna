<?php
$id_page='trexnh54bvfs32';
//phpinfo();
require_once '../templates/config.php';
require_once '../templates/function.php';
$body = new site();
$title = $body->title();
$id_info=$_POST['id_info'];
$info=$body->info($id_info);
?>
<h2><?php echo $info['name']; ?></h2>
<div class="line"></div>
<?php if($info['img']!=''){ ?>
<img src="../images/<?php echo $info['img']; ?>">
<?php } ?>
<?php echo $info['text']; 
if($info['manufacturer']!=''){
echo '<p><strong>Производитель: '.$info['manufacturer'].'</strong></p>';}
?>
