<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");} ?>
<h2>Подбор матраса</h2>
<?php
$brend=$_POST["brend"];
$size=$_POST["size"];
$height=$_POST["height"];
$pr_block=$_POST["pr_block"];
$hard=$_POST["hard"];
$weight=$_POST["weight"];
$price=$_POST["price"];
$sort=1; // Order by
//---------------------------------
$per_page=$body->per_page;
if (isset($_GET['page'])) $page=($_GET['page']); else $page=1;
$start=abs(($page-1)*$per_page);
//-----------------------------------
$body->select_item($brend, $size, $height, $pr_block, $hard, $weight, $price, $start, $per_page, $sort);

if(mysql_num_rows($body->sql_res) == 1){
echo "1 matrass";}
while ($row=mysql_fetch_array($body->sql_res)){
echo '<a href="index.php?id='.$row["url"].'">'.$row["brend"].' '.$row["name"].'</a><br>';
}
?>