<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");} ?>
<?php
// Module Table Price 3
$item = $_GET['item']; // id item 
$arr_price=$body->price3($item);
echo '<div id="clear"></div>';
echo '<p><strong>Прайс '.$body->brend($_GET["brend"]).' грн.';
if($discount){
echo ' с учетом <font style="color:red">акции - '.$discount.'%</font>';
}
echo '</strong></p>';
echo '<table class="price" cellspacing="1" cellpadding="1" style="width:70%">
<tr><td>Размер (мм)</td><td>Стоимость модели (грн.)</td></tr>';
echo '<tr><td>'.$arr_price["size"].'</td>';

if($arr_price['discount']==0){
			echo '<td>'.$arr_price['price'].'</td>';
			}else{
			echo '<td><font style="text-decoration:line-through; color:#8E8E8E">'.$arr_price['price'].'</font><br>
<font style="color:red">'.$arr_price['price_action'].'</font></td>';
			}	
echo '</tr>
</table>';
?>