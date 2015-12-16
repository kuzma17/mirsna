<?php

$id_page='trexnh54bvfs32';
require_once '../templates/function.php';
$body = new site();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang="ru">
<head>
<meta http-equiv='content-type' content='text/html; charset=utf-8' />
<meta http-equiv='content-style-type' content='text/css' />
<meta http-equiv='content-language' content='ru' />
<title>Мир сна, mirsna.od.ua</title>
<link rel='stylesheet' href='../css/style.css' type='text/css' />
<style>
.block_upload{
width:350px;margin: 0 auto;margin-top:50px; background:#E3E3E3;padding:10px;
border: 1px #CCCCCC solid;
border-radius: 7px;
}
.block_upload input{
margin:1px;
width:280px;
}
</style>
</head>
<body>
<h2>Загрузка прайсов</h2>
<hr>
<table cellpadding="5" cellspacing="1" bgcolor="Silver" width="550" style="margin-left:10px;font-size:12px">
<TR bgcolor="white">
<TD>имя(не важно что,<br />не используется</TD><TD>id в таблице ms_item</TD><TD>ширина X</TD><TD>высота Y</TD><TD><strong>Стоимость</strong></TD><TD>Стоимость 1 кв.м.</TD>
</TR>
</table>
<p>Пример таблицы</p>
<div class="block_upload">
<form name="upload" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
Бренд: 
<select name="brend">
<OPTION value="">Не важно</OPTION>
<?php
$body->options("brend");
while ($row=mysql_fetch_array($body->sql_res)){
echo '<OPTION value="'.$row["id"].'"';
if($_POST["brend"] && $_POST["brend"]==$row["id"]){
echo ' selected';}
echo '>'.$row["name"].'</OPTION>';
}
?>
</select>
<input type="hidden" name="MAX_FILE_SIZE" value="30000">
<input type="file" name="file_csv" style="width:350px">
<input type="submit" value="загрузить">
</form>
</div>
<hr>
<?php
$file_csv = $_FILES['file_csv']['tmp_name'];

echo $file_csv.'<br>';
$max_row=100;
$row_start=0;
$row_end=10;
$znak=';';
$query='';
$f = fopen($file_csv, "rt") or die("Ошибка!");

for ($i=0; $data=fgetcsv($f,$max_row,$znak); $i++) {
  $num = count($data);
$id_size=$body->num_size($data[2], $data[3]); // nun size, field "name" on table ms_size
$query.='('.$data[1].', '.$id_size.', "'.$data[4].'", "'.$data[5].'"),';
if($id_size!=''){
  for ($c=0; $c<$num; $c++)
    print "[$c]: $data[$c] ";
}else{echo "NNNN";}
}
fclose($f);
$query=chop($query, ',');
echo "<br>============query===========<br>";
echo $query;
echo "<br>============query===========<br>";
$body->insert_price($query);
echo 'Прайс удачно загружен!';
echo $body->sql_err;
?>




</body>
</html>