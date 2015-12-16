<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");} ?>
<?php
$brend=$_POST["brend"];
$size=$_POST["size"];
if($_POST["height"]!=''){$height=$body->height_select($_POST["height"]);}
//$height=$_POST["height"];
$pr_block=$_POST["pr_block"];
if($_POST["hard"]!=''){$hard=$body->hard_select($_POST["hard"]);}
//$hard=$_POST["hard"];
if($_POST["weight"]!=''){$weight=$body->weight_select($_POST["weight"]);}
//$weight=$_POST["weight"];
$price_from=$_POST["price_from"];
$price_to=$_POST["price_to"];
$sort=$_POST["sort"]; // Order by
//---------------------------------
$per_page=$body->per_page;
if (isset($_GET['page'])) $page=($_GET['page']); else $page=1;
$start=abs(($page-1)*$per_page);
//-----------------------------------

// --- module SORT ----
$url_page=$_SERVER['PHP_SELF'].'?id=select';
if($brend!=''){$url_page.='&brend='.$brend;}
if($size!=''){$url_page.='&size='.$size;}
if($height!=''){$url_page.='&height='.$_POST["height"];}
if($pr_block!=''){$url_page.='&pr_block='.$pr_block;}
if($hard!=''){$url_page.='&hard='.$_POST["hard"];}
if($weight!=''){$url_page.='&weight='.$_POST["hard"];}
if($price_from!=''){$url_page.='&price_from='.$price_from;}
if($$price_to!=''){$url_page.='&$price_tot='.$$price_to;}
?>
<div class="sortseach">
сортировать по цене: <A href="#" sort="1"> вниз</A> <A href="#" sort="0">вверх</A>
</div>
<div id="both"></div>
<!-- end module SORT -->
<div style="margin-top:10px;margin-left:10px"><strong style="color:#FF8000">По Вашему запрсу:</strong><br>
<?php
if($brend!=''){echo 'Бренд: '.$body->valuesm("brend", "name", $brend).'<br>';}
if($size!=''){echo 'Размер: '.$body->valuesm("size", "name", $size).'<br>';}
if($height!=''){echo 'Высота: '.$body->valuesm("height", "name", $_POST["height"]).'.<br>';}
if($pr_block!=''){echo 'Пружинный блок: '.$body->valuesm("pr_block", "name", $pr_block).'<br>';}
if($_POST["hard"]!=''){echo 'Жосткость: '.$body->valuesm("select_hard", "name", $_POST["hard"]).'<br>';}
if($weight!=''){echo 'Макс.вес на место: '.$body->valuesm("weight", "name", $_POST["weight"]).'.<br>';}
if($price_from!='' || $price_to!=''){echo 'Цена:';
if($price_from!=''){echo ' от '.$_POST["price_from"];}
if($price_to!=''){echo ' до '.$_POST["price_to"];}
echo ' грн.';}
?>
</div>
<?php
if($arr_item=$body->select_item($brend, $size, $_POST["height"], $pr_block, $_POST["hard"], $_POST["weight"], $price_from, $price_to, $sort, $start, $per_page)){
?>
<br>
<table class="select_item" cellspacing="1" cellpadding="1">
<tbody>
<tr class="head_table"><TD>бренд</TD><TD>модель</TD><TD>размер</TD><TD>высота</TD><TD>пружинный блок</TD><TD>жесткость</TD><TD>макс.вес<br>
на место</TD><TD>цена</TD></tr>
<?php
foreach($arr_item as $row){
// -- hard --
$arr_hard_item=$body->hard($row['id']);
$hard_item='';
foreach($arr_hard_item as $hard_value){$hard_item.=$hard_value.', ';}
$hard_item=chop($hard_item, ', ');
// -----
echo '<tr onclick="location.href=\'index.php?id=productions&brend='.$row['id_brend'].'&type=1&item='.$row['id'].'\'" class="row_select">
<td>'.$row['brend'].'</td><td>'.$row['name'].'</td><td>'.$row['size'].'</td><td>'.$row['height'].'</td><td>'.$row['pr_block'].'</td><td>'.$hard_item.'</td><td>'.$row['weight'].'</td><td>'.$row['price'].'</td></tr>';
}
?>
</tbody>
</table>
<?php
}else{
echo '<p style="text-align:center">По Вашему запросу в базе нет матрасов. Попробуйте задать другие параметры.</p>';
}
?>