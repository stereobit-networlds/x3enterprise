<?php
require('phpdac7.php'); 
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 		
super database;

public cms.cmsrt;
public jsdialog.jsdialogStreamSrv;

',1);	 

//echo "&nbsp;"; //null
echo $page->render(null,getlocal(),null,'empty.html');
?>
