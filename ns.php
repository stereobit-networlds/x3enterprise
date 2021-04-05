<?php
require('phpdac7.php'); 
$htmlpage = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

public cms.cmsrt;
public cp.rcnewsletter;
',1);

$ns_page = $_GET['a'] ? urldecode($_GET['a']) .'.html' :'media-center/blank.php'; //as default event the page is copied and ready 
//echo $ns_page; //redir to subscribe when no tag ???
echo $htmlpage->render(null,getlocal(),null,$ns_page);//'media-center/index.php');
?>