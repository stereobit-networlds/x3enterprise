<?php
require('phpdac7.php'); 
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;
/---------------------------------load and create libs
use i18n.i18n;

/---------------------------------load not create dpc (internal use)
/include networlds.clientdpc;

/---------------------------------load all and create after dpc objects
public cms.cmsrt;

#ifdef SES_LOGIN
public cp.cpcharts;
#endif

public i18n.i18nL;

',1);

/*
	$cptemplate = _m('cms.paramload use FRONTHTMLPAGE+cptemplate');  
	echo $page->render(null, getlocal(), null, $cptemplate.'/index.php');
*/	
	$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;
	echo "<!-- remote chart $time -->";
	
?>