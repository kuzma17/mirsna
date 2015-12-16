<?php if($id_page != 'trexnh54bvfs32'){Header("Location: index.php");} ?>
<style>
.list_item{
margin-bottom:25px;
cursor:pointer;
}
.list_item img{
float:left;
border:0;
margin-right:10px;
width:140px;
height:92px;
border: 1px #CCCCCC solid; /* стили рамки */
 -moz-border-radius: 7px; /* закругление для старых Mozilla Firefox */
 -webkit-border-radius: 7px; /* закругление для старых Chrome и Safari */
 -khtml-border-radius:7px; /* закругл. для браузера Konquerer системы Linux */
 border-radius: 7px; /* закругление углов для всех, кто понимает */
}
.list_item a{
float:left;
margin-right:10px;
margin-top: -10px;
font-family:sans-serif;
font-size:12px;
color:#838383;
text-decoration:underline;
}
.list_item a:hover{
text-decoration:none;
}
.sale_box{
float:right;
height:26px;
margin-top: -10px;
font-family:Arial;
font-size:12px;
color:#848484;
background:url(images/sale_bg3.png);
font-weight:bolder;
}
.font_sale{
font-size:10px;
}
.sort{
width:210px; float:right; margin-top:0;font-family:sans-serif;
font-size:10px;
color:#5B5B5B;
}
.sort a{
font-size:12px;
color:#FF8000;
text-decoration:underline;
font-weight:bolder;
}
.sort a:hover{
color:#FF8000;
text-decoration:none;
}
.video_box{
width:560px;margin-left:70px;background:#5C5C5C;border: 1px #777777 solid;
}
.video_panel{
height:15px;font-family:sans-serif;margin-left:2px;padding:3px;
font-size:10px;
color:#FFFFFF;
}
.video_panel a{
color:#ECECEC;float:right; margin-right:10px;
}
.video_panel a:hover{
text-decoration:none;
}

iframe{
width:560px; height:315px;border-bottom: 1px #777777 solid;
}
</style>
<?php
$brend=$_GET['brend'];
$type=$_GET['type'];
$series=$_GET['series'];
$pr_block=$_GET['pr_block'];
$class=$_GET['class'];
$memory=$_GET['memory'];
$sort=$_GET['sort'];
$arr=$body->list_item($brend, $type, $series, $pr_block, $class, $memory, $sort);
// --- module SORT ----
$url_page=$_SERVER['PHP_SELF'].'?id=productions';
if($brend!=''){$url_page.='&brend='.$brend;}
if($type!=''){$url_page.='&type='.$type;}
if($series!=''){$url_page.='&series='.$series;}
if($pr_block!=''){$url_page.='&pr_block='.$pr_block;}
if($class!=''){$url_page.='&class='.$class;}
if($memory!=''){$url_page.='&memory='.$memory;}
?>
<div class="sort">
сортировать по цене: <A href="<?php echo $url_page; ?>&sort=1"> вниз</A> <A href="<?php echo $url_page; ?>">вверх</A>
</div>
<div id="clear"></div>
<!-- end module SORT -->
<?php
// --- Block VIDEO ----
if($_GET['v'] && $_GET['v']!=''){
?>
<script type="text/javascript" language="javascript">
$(document).ready(function(){

function playVideoAndPauseOthers(frame) {
        $('iframe[src*="http://www.youtube.com/embed/"]').each(function(i) {
            var func = this === frame ? 'playVideo' : 'pauseVideo';
            this.contentWindow.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
        });
    }

var key_video = 1;
$('#video_a').click(function() {
if(key_video==1){
 //var frameId = /#vid(\d+)/.exec($(this).attr('href'));
        //(frameId !== null) ;
            //frameId = frameId[1]; // Get frameId
var frameId = null; // Get frameId
playVideoAndPauseOthers($('#video' + frameId + ' iframe')[0]);
$('#video').animate({height: "hide"}, 700);
$('#video_a').text("показать видео");
key_video = 0;
}else{
$('#video').animate({height: "show"}, 700);
$('#video_a').text("скрыть видео");
key_video = 1;
}
});
 });
</script>
<div style="margin:5px;">
<div class="video_box">
<div class="video_panel">
<A id="video_a" href="#">скрыть видео</A></div>
<iframe id="video" src="<?php echo $body->video($_GET['v']); ?>&showinfo=0" frameborder="0" allowfullscreen></iframe>
</div>
</div>
<div id="clear"></div>
<?php
//--- End Block Video ---
}
?>

<?php
foreach ($arr as $row){
?>
<div class="list_item" onclick="location.href='index.php?<?php echo'id=productions&brend='.$row['id_brend'].'&type='.$row['id_type_item'].'&series='.$row['id_series'].'&item='.$row['id']; ?>'">
<h3><?php echo $row['name']; ?></h3>
<?php if($row['img_anons']!=''){
echo '<img src="images/'.$row["img_anons"].'">';
} 
echo '<div style="float:left; width:570px">'.$row['anons'];
?>
<div class="sale_box">
<div style="float:left;margin:5px;margin-left:10px;">
<?php
//$min_max_price = $body->min_max_price($row['id']);
if($row['min_price'] == $row['max_price']){
echo '<span class="font_sale">цена</span> '.$row['min_price'].' <span class="font_sale">грн.</span>';
}else{
echo '<span class="font_sale">цена</span> '.str_replace(".00","",$row['min_price']).' - '.str_replace(".00","",$row['max_price']).' <span class="font_sale">грн.</span>';
}
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