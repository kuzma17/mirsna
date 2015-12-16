<?php
//error_reporting (E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);
$id_page='trexnh54bvfs32';
//phpinfo();
require_once 'templates/config.php';
require_once 'templates/function.php';
$body = new site();
$title = $body->title();
include 'templates/template.php';
?>
