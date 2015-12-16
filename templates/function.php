<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");}
class site {
  var $sql_host="127.0.0.1";
  //var $sql_database="uyyaqxkt_mirsna";
  //var $sql_login="uyyaqxkt_mirsna";
  //var $sql_passwd="170270Kuzma";
  
  var $sql_database="uyyaqxkt_mirsna";
  var $sql_login="root";
  var $sql_passwd="170270";

  var $conn_id;
  var $sql_query;
  var $sql_err;
  var $sql_res;

  var $config;
  var $menu;
  var $id='home';
  var $per_page=2; //num select item
  var $count_page;

function site(){
//$this->sql_connect();
//$this->sql_query="SELECT * FROM `ms_menu` ORDER BY `sort`";
//$this->sql_execute();
 //while ($row=mysql_fetch_array($this->sql_res)) { 
//$fp[$row[id]]=$row;
//}
//$this->settings();
//$this->sql_close();
//$this->menu=$fp;
if($_GET['id']){
$this->id=$_GET['id'];}
}

function sql_connect()
 {
  $this->conn_id=mysql_connect($this->sql_host,$this->sql_login,$this->sql_passwd);
  mysql_select_db($this->sql_database);
  mysql_query('SET NAMES utf8');
 }

 function sql_execute()
 {
  $this->sql_res=mysql_query($this->sql_query,$this->conn_id);
  $this->sql_err=mysql_error();
 }

 function sql_close()
 {
  mysql_close($this->conn_id);
 }

function menu($menu,$parent){
$this->sql_connect();
$this->sql_query="SELECT * FROM `ms_menu` WHERE `on` = 1 AND `menu` = $menu AND `parent_id` = $parent ORDER BY `num`";
$this->sql_execute();
$num=mysql_num_rows($this->sql_res);
if($num > 0){
//$i=0;
//while ($row=mysql_fetch_array($this->sql_res)){
for($i=0;$i<$num;$i++){
$row=mysql_fetch_array($this->sql_res);
$arr_menu[$i]['name']=$row['name'];
$arr_menu[$i]['url']=$row['url'];
$arr_menu[$i]['parent_id']=$row['parent_id'];
$arr_menu[$i]['id']=$row['id'];
//$i++;
}
return $arr_menu;
}
$this->sql_close();
}

function title(){
if($_GET['id']=='select'){
$title='Подбор матраса';
return $title;
exit;}
if($_GET['id']=='actions'){
$title='Акции';
return $title;
exit;}
if($_GET['item']){
$item=$_GET['item'];
$this->sql_connect();
$this->sql_query="SELECT 
ms_type_item.name AS type,
ms_brend.name AS brend, 
ms_item.name 
FROM `ms_item` 
LEFT JOIN `ms_type_item` ON ms_item.id_type_item = ms_type_item.id 
LEFT JOIN `ms_brend` ON ms_item.id_brend = ms_brend.id 
WHERE ms_item.id = '$item'";
$this->sql_execute();
$this->sql_execute();
$row=mysql_fetch_array($this->sql_res);
$title=$row['type'].' '.$row['brend'].' '.$row['name'];
return $title;
exit;
}
else{
if($_SERVER["REQUEST_URI"]=='/'){
$url = '/index.php?id=home';
}else{
$url = $_SERVER["REQUEST_URI"];
}

$url = str_replace("&sort=1", "", $url);
$url = str_replace("&sort=0", "", $url);
if($_GET['id']=='productions'){
$query="SELECT `title` FROM `ms_menu` WHERE `url` = '$url'";
}else{
$query="SELECT `title` FROM `ms_page` WHERE `url` = '$url'";}
$this->sql_connect();
$this->sql_query=$query;
$this->sql_execute();
//$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
$title=$row['title'];
}
return $title;
}

function content(){
$url = $_SERVER["REQUEST_URI"];
if($url=='/'){
$url='/index.php?id=home';}
$this->sql_connect();
$this->sql_query="SELECT `text` FROM `ms_page` WHERE `url` = '$url'";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row['text'];
}

function list_item($brend, $type, $series, $pr_block, $class, $memory, $sort){
$this->sql_connect();
$query="SELECT 
ms_item.id, 
ms_item.id_brend, 
ms_item.id_type_item, 
ms_item.id_series, 
ms_item.name, 
ms_item.anons, 
ms_item.img_anons,
COALESCE(ms_discount.discount,0) AS discount,
MIN(ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0)) AS min_price,
MAX(ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0)) AS max_price
FROM `ms_item` 
INNER JOIN `ms_price` ON ms_item.id = ms_price.id_item 
LEFT JOIN `ms_actions` ON ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE()  
LEFT JOIN `ms_discount` ON ms_price.id_item = ms_discount.id_item AND ms_discount.id_actions = ms_actions.id 
WHERE ms_item.id_type_item = $type AND ms_item.on = 1";
if($brend!=''){
$query.=" AND ms_item.id_brend = $brend";
}
if($series!= ''){
	//$series = 0;
$query.=" AND ms_item.id_series = $series";
}
if($pr_block!=''){
$query.=" AND ms_item.id_pr_block = $pr_block";
}
if($class!=''){
$query.=" AND ms_item.class = $class";
}
if($memory!=''){
$query.=" AND ms_item.memory = $memory";
}
$query.=" GROUP BY ms_item.id ORDER BY ms_item.id_brend, min_price";
if($sort==1){
$query.= " ASC";
}else{
$query.= " DESC";}
$this->sql_query=$query;
$this->sql_execute();
$this->sql_close();
while ($row=mysql_fetch_array($this->sql_res)){
$arr[]=$row;
}
return $arr;
}

function min_max_price($item){
$this->sql_connect();
$this->sql_query="SELECT MIN(`price`) AS min_price, MAX(`price`) AS max_price FROM `ms_price` WHERE `id_item` = $item";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row;
}

function item($id){
$this->sql_connect();
$this->sql_query="SELECT 
ms_pr_block.name AS pr_block,
ms_item.height,
ms_item.weight,
ms_item.text,
ms_item.img_zoom_big,
ms_item.img_zoom,
ms_item.img,
ms_item.img_set,
ms_item.img_bottom
FROM `ms_item` 
LEFT JOIN `ms_pr_block` ON ms_item.id_pr_block = ms_pr_block.id
WHERE 
ms_item.id = $id";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row;
}

function brend($id){
$this->sql_connect();
$this->sql_query="SELECT `name` FROM `ms_brend` WHERE `id` = $id";
$this->sql_execute();
$row=mysql_fetch_array($this->sql_res);
$this->sql_close();
return $row['name'];
}

function options($table){
$this->sql_connect();
$this->sql_query="SELECT `id`, `name` FROM `ms_$table` WHERE `select_on` = 1 ORDER BY `num`";
$this->sql_execute();
$this->sql_close();
}

function height_select($id){
$this->sql_connect();
$this->sql_query="SELECT `height_select` FROM `ms_height` WHERE `id` = $id";
$this->sql_execute();
$row=mysql_fetch_array($this->sql_res);
$this->sql_close();
return $row['height_select'];
}

function weight_select($id){
$this->sql_connect();
$this->sql_query="SELECT `weight_select` FROM `ms_weight` WHERE `id` = $id";
$this->sql_execute();
$row=mysql_fetch_array($this->sql_res);
$this->sql_close();
return $row['weight_select'];
}

function hard_select($hard){
$this->sql_connect();
$this->sql_query="SELECT `id` FROM `ms_hard` WHERE `id_select_hard` = $hard";
$this->sql_execute();
while ($row=mysql_fetch_array($this->sql_res)){
$arr[]=$row['id'];
}
$this->sql_close();
return $arr;
}

function select_item($brend, $size, $height, $pr_block, $hard, $weight, $price_from, $price_to, $sort, $start, $per_page){
$query="SELECT
ms_item.id,
ms_item.id_brend,
ms_brend.name AS brend,
ms_item.name,
ms_size.name AS size,
ms_item.height,
ms_pr_block.name AS pr_block,
ms_item.weight,
ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0) AS price
FROM `ms_price`
INNER JOIN `ms_item` ON ms_price.id_item = ms_item.id   
INNER JOIN `ms_brend` ON ms_item.id_brend = ms_brend.id
INNER JOIN `ms_size` ON ms_price.id_size = ms_size.id  
INNER JOIN `ms_pr_block` ON ms_item.id_pr_block = ms_pr_block.id 
LEFT JOIN `ms_actions` ON ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE() 
LEFT JOIN `ms_discount` ON ms_price.id_item = ms_discount.id_item AND ms_discount.id_actions = ms_actions.id 
WHERE (ms_item.id_type_item = 1 OR ms_item.id_type_item = 6) AND ms_item.on = 1";
if($brend!=''){
$where.=" AND ms_item.id_brend = $brend";
}
if($size!=''){
$where.=" AND ms_price.id_size = $size";
}
if($height!=''){
$height=$this->height_select($height);
$where.=" AND ms_item.height $height";
}
if($pr_block!=''){
$where.=" AND ms_item.id_pr_block = $pr_block";
}
if($hard!=''){
$hard=$this->hard_select($hard);
$where.=" AND EXISTS(
SELECT * 
FROM `ms_hard_item`
WHERE 
ms_hard_item.id_item = ms_item.id AND ";
if($hard[1]!=''){
$where.="((ms_hard_item.id_hard = ".$hard[0].") OR (ms_hard_item.id_hard = ".$hard[1].")))";
}else{
$where.="ms_hard_item.id_hard = ".$hard[0].")";
 }
}
if($weight!=''){
$weight=$this->weight_select($weight);
$where.= " AND ms_item.weight $weight";
}

if($price_from!=''){
$where.= " AND ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0) >= $price_from";
}
if($price_to!=''){
$where.= " AND ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0) <= $price_to";
}

$where.=" ORDER BY ms_item.id_brend, ms_item.name, `price`";
if($sort==1){
$where.= " ASC";
}else{
$where.= " DESC";}
$this->sql_connect();
$this->sql_query=$query.$where;
$this->sql_execute();
$this->sql_close();
while ($row=mysql_fetch_array($this->sql_res)){
$arr[]=$row;
}
return $arr;
}

function countpage($where){
$this->sql_query="SELECT count(*) FROM `ms_item`".$where;
$this->sql_execute();
$row=mysql_fetch_array($this->sql_res);
$total_rows=$row[0];
$this->count_page=$total_rows;
}

function hard($id){
$this->sql_connect();
$this->sql_query="SELECT 
ms_hard.name
FROM `ms_hard_item` 
INNER JOIN `ms_hard` ON ms_hard_item.id_hard = ms_hard.id 
WHERE ms_hard_item.id_item = $id";
$this->sql_execute();
$this->sql_close();
while ($row=mysql_fetch_array($this->sql_res)){
$arr[]=$row['name'];
}
return $arr;
}

function valuesm($table, $option, $id){
$this->sql_connect();
$this->sql_query="SELECT $option FROM `ms_$table` WHERE `id` = $id";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row["$option"];
}

function size($type_size,$item,$distinct){
$this->sql_connect();
$query="SELECT ";
if($distinct==1){
$query .= "DISTINCT ";}
$query .= "ms_size.$type_size 
FROM `ms_price` 
LEFT JOIN `ms_size` ON ms_price.id_size = ms_size.id 
WHERE ms_price.id_item = $item 
ORDER BY `$type_size`";
$this->sql_query=$query;
$this->sql_execute();
while ($row=mysql_fetch_array($this->sql_res)){
$arr_size[]=$row["$type_size"];
}
return $arr_size;
$this->sql_close();
}

function price($item){
$this->sql_connect();
$this->sql_query="SELECT 
ms_size.size_x, 
ms_size.size_y, 
ROUND(ms_price.price, 0) AS price,
COALESCE(ms_discount.discount,0) AS discount,
ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0) AS price_action
FROM `ms_price` 
LEFT JOIN `ms_size` ON ms_price.id_size = ms_size.id 
LEFT JOIN `ms_actions` ON ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE() 
LEFT JOIN `ms_discount` ON ms_price.id_item = ms_discount.id_item AND ms_discount.id_actions = ms_actions.id 
WHERE 
ms_price.id_item = $item";
$this->sql_execute();
while ($row=mysql_fetch_array($this->sql_res)){
$arr_size[$row["size_x"]][$row["size_y"]]=$row;
}
return $arr_size;
$this->sql_close();
}

function price3($item){
$this->sql_connect();
$this->sql_query="SELECT 
ms_price.size, 
ROUND(ms_price.price, 0) AS price,
COALESCE(ms_discount.discount,0) AS discount,
ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0) AS price_actions  
FROM 
`ms_price`
LEFT JOIN `ms_actions` ON ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE()  
LEFT JOIN `ms_discount` ON ms_price.id_item = ms_discount.id_item AND ms_discount.id_actions = ms_actions.id 
WHERE 
ms_price.id_item = $item";
$this->sql_execute();
$row=mysql_fetch_array($this->sql_res);
$this->sql_close();
return $row;
}

function price_m2($item){
$this->sql_connect();
$this->sql_query="SELECT 
ROUND(ms_price.price_m2, 0) AS price_m2, 
ROUND((ms_price.price_m2 - ((ms_price.price_m2 / 100) * COALESCE(ms_discount.discount,0))), 0) AS price_m2_actions  
FROM `ms_price` 
INNER JOIN `ms_actions` ON ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE()  
LEFT JOIN `ms_discount` ON ms_price.id_item = ms_discount.id_item AND ms_discount.id_actions = ms_actions.id 
WHERE 
ms_price.id_item = $item AND 
ms_price.price_m2 != 0";
$this->sql_execute();
$row=mysql_fetch_array($this->sql_res);
return $row;
$this->sql_close();
}

function num_size($x, $y){
$this->sql_connect();
$this->sql_query="SELECT `id` FROM `ms_size` WHERE `size_x` = $x AND `size_y` = $y";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row["id"];
}

function video($id){
$this->sql_connect();
$this->sql_query="SELECT `url` FROM `ms_video` WHERE `id` = $id";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row["url"];
}

function insert_price($query_value){
$this->sql_connect();
$this->sql_query="INSERT INTO `ms_price` (`id_item`, `id_size`, `price`, `price_m2`) VALUES $query_value";
$this->sql_execute();
$this->sql_close();
}

function info($id){
$this->sql_connect();
$this->sql_query="SELECT `name`,`img`,`text`,`manufacturer` FROM `ms_info` WHERE `id` = $id";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row;
}

function discount($item){
$this->sql_connect();
$this->sql_query="SELECT 
ms_discount.discount 
FROM `ms_discount`
INNER JOIN `ms_actions` ON ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE() 
WHERE 
ms_discount.id_item = $item";
$this->sql_execute();
$this->sql_close();
$row=mysql_fetch_array($this->sql_res);
return $row['discount'];
}

function actions(){
$this->sql_connect();
$this->sql_query="SELECT 
`id`, 
`name`, 
DATE_FORMAT(`date_from`,'%d.%m.%Y') AS date_from, 
DATE_FORMAT(`date_to`,'%d.%m.%Y') AS date_to, 
`text` 
FROM `ms_actions` 
WHERE ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE()";
$this->sql_execute();
$this->sql_close();
while ($row=mysql_fetch_array($this->sql_res)){
$arr[]=$row;
}
return $arr;
}

function list_actions($id_actions){
$this->sql_connect();
$this->sql_query="SELECT 
ms_item.id, 
ms_item.id_brend, 
ms_item.id_type_item, 
ms_item.id_series, 
ms_item.name, 
ms_item.anons, 
ms_item.img_anons,
COALESCE(ms_discount.discount,0) AS discount,
MIN(ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0)) AS min_price,
MAX(ROUND((ms_price.price - ((ms_price.price / 100) * COALESCE(ms_discount.discount,0))), 0)) AS max_price
FROM `ms_item` 
INNER JOIN `ms_price` ON ms_item.id = ms_price.id_item 
INNER JOIN `ms_actions` ON ms_actions.on = 1 AND ms_actions.date_from <= CURDATE() AND ms_actions.date_to >= CURDATE()  
INNER JOIN `ms_discount` ON ms_price.id_item = ms_discount.id_item AND ms_discount.id_actions = ms_actions.id 
WHERE 
ms_discount.id_actions = $id_actions 
GROUP BY ms_item.id ORDER BY ms_item.id_brend, min_price";
$this->sql_execute();
$this->sql_close();
while ($row=mysql_fetch_array($this->sql_res)){
$arr[]=$row;
}
return $arr;
}

}
?>
