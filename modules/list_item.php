<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");} ?>
<?php
$brend=$_GET['brend'];
$type=$_GET['type'];
$series=$_GET['series'];
$pr_block=$_GET['pr_block'];
$class=$_GET['class'];
$memory=$_GET['memory'];
$sort=$_GET['sort'];
$sort=$_GET['sort'];
$v=$_GET['v'];
$arr=$body->list_item($brend, $type, $series, $pr_block, $class, $memory, $sort);
// --- module SORT ----
$url_page=$_SERVER['PHP_SELF'].'?id=productions';
if($brend!=''){$url_page.='&brend='.$brend;}
if($type!=''){$url_page.='&type='.$type;}
if($series!=''){$url_page.='&series='.$series;}
if($pr_block!=''){$url_page.='&pr_block='.$pr_block;}
if($class!=''){$url_page.='&class='.$class;}
if($memory!=''){$url_page.='&memory='.$memory;}
if($v!=''){$url_page.='&v='.$v;}
?>
<div class="sort">
сортировать по цене: <A href="<?php echo $url_page; ?>&sort=1"> вниз</A> <A href="<?php echo $url_page; ?>">вверх</A>
</div>

<!-- end module SORT -->
<?php
// --- Block VIDEO ----
if($_GET['v'] && $_GET['v']!=''){
?>

<div style="margin:2px;">
<div class="video_box">
<div class="video_panel">
<A id="video_a" href="#" style="color:#FFFFFF">скрыть видео</A></div>
<div id="fr"><iframe id="video" src="<?php echo $body->video($_GET['v']); ?>&showinfo=0&wmode=opaque&wmode=transparent" frameborder="0" allowfullscreen></iframe></div>
</div>
</div>
<?php
//--- End Block Video ---
}
?>
<div id="clear"></div>
<?php
foreach ($arr as $row){
?>

<div class="list_item" urlpage="index.php?<?php echo'id=productions&brend='.$row['id_brend'].'&type='.$row['id_type_item'].'&series='.$row['id_series'].'&item='.$row['id']; ?>">
<h3><?php echo $row['name']; ?></h3>
<div style="width:145px;float:left;margin-right:10px">
<?php if($row['img_anons']!=''){
echo '<img src="images/'.$row["img_anons"].'">';
//--discount---
if($row['discount']!=0){
echo '<div class="discount_list">-'.$row['discount'].'%</div>';
}
//-------------
} 
?>
</div>
<?php
echo '<div style="float:left; width:570px">'.$row['anons'];
?>
<div class="sale_box">
<div style="float:left;margin:5px;margin-left:10px;">
<?php
//$min_max_price = $body->min_max_price($row['id']);
if($row['discount']!=0){
echo '<span class="font_sale" style="color:red">акционная ';
}else{
echo '<span class="font_sale">';
}
echo 'цена '.$row['min_price'];
if($row['min_price'] != $row['max_price']){
echo ' - '.$row['max_price'];
}
echo ' грн.</span>';
?>
</div>
<div style="float:left;height:26px;width:14px;background:url(images/sale3.png) no-repeat;"></div>
</div>
<A href="index.php?<?php echo'id=productions&brend='.$row['id_brend'].'&type='.$row['id_type_item'].'&series='.$row['id_series'].'&item='.$row['id']; ?>">подробнее >></A>
</div>
<div id="clear"></div>
</div>
<?php
}
?>