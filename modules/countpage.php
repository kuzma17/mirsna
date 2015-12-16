<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");} ?>
<script type="text/javascript">
function url(page){
document.forms['select'].action="<?php echo $_SERVER['PHP_SELF']; ?>?id=select_item&page="+page;
document.forms['select'].submit();
}
</script>
<?
echo "<hr>";
echo 'Count page - '.$body->count_page.'<br>';
$num_pages=ceil($body->count_page/$per_page);
if($num_pages > 1){
echo '<div id="countpage">
Страницы: ';
if($page!=1){
$dellpage=$page-1;
//echo '<a href="'.$_SERVER['PHP_SELF'].'?page=1"><<</a> ';
echo '<a onclick="url(1)" href="#"><<</a> ';
//echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$dellpage.'"><</a> ';
echo '<a onclick="url('.$dellpage.')" href="#"><</a> ';
//echo ' 1';
//if($num_pages > 2){
//echo '...';}
}

for($i=1;$i<=$num_pages;$i++) {
  if ($i == $page) {
    echo '<b>'.$i.'</b> ';
  } else {
    echo '<a onclick="url('.$i.')" href="#">'.$i."</a> ";
  }
}
if($page < $num_pages){
$addpage=$page+1;
//if($num_pages > 2){
//echo '...';}
//echo $num_pages.' ';
//echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$addpage.'">></a> ';
echo '<a onclick="url('.$addpage.')" href="#">></a> ';
//echo '<a href="'.$_SERVER['PHP_SELF'].'?page='.$num_pages.'">>></a>';
echo '<a onclick="url('.$num_pages.')" href="#">>></a> ';
}
echo '</div>';
}
?>
