<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");} ?>
<?php
// Module Table Price

$item = $_GET['item']; // id item 
$arr_x=$body->size("size_x", $item, 1);
$arr_y=$body->size("size_y", $item, 1);
$arr_price=$body->price($_GET['item']);

$num_x=count($arr_x) + 1;
$num_y=count($arr_y);
echo '<div id="clear"></div>';
echo '<p><strong>Прайс '.$body->brend($_GET["brend"]).' грн.';
if($discount){
echo ' с учетом <font style="color:red">акции - '.$discount.'%</font>';
}
echo '</strong></p>';
echo '<table class="price" cellspacing="1" cellpadding="1">
<tr><td width="96">Размеры</td>
<td colspan="'.$num_x.'">Ширина (мм)</td>
</tr>';
echo '<tr>
<td>Длина (мм)</td>';
	for($x=0; $x < $num_x - 1; $x++){
	echo '<td>'.$arr_x[$x].'</td>';
}
echo '</tr>';

for($y=0; $y < $num_y; $y++){
echo '<tr>
<td>'.$arr_y[$y].'</td>';
	for($x=0; $x < $num_x - 1; $x++){
		if($arr_price[$arr_x[$x]][$arr_y[$y]]['discount']==0){
			echo '<td>'.$arr_price[$arr_x[$x]][$arr_y[$y]]['price'].'</td>';
			}else{
			echo '<td><font style="text-decoration:line-through; color:#8E8E8E">'.$arr_price[$arr_x[$x]][$arr_y[$y]]['price'].'</font><br>
<font style="color:red">'.$arr_price[$arr_x[$x]][$arr_y[$y]]['price_action'].'</font></td>';
			}
	
}
echo '</tr>';
}
//$price_m2 = $body->price_m2($item);
if($price_m2 = $body->price_m2($item)){
$num_x1=$num_x + 1;
echo '<tr>
<td colspan="'.$num_x1.'">Нестандартный размер (стоимость за 1 кв. м.) - ';
if($body->discount($_GET['item'])){
echo '<font style="text-decoration:line-through; color:#8E8E8E">'.$price_m2['price_m2'].'</font> <font style="color:red">'.$price_m2['price_m2_actions'].'</font>';
}else{
echo $price_m2['price_m2'];
}
echo '</td>
</tr>';
}
echo '</table>';
?>