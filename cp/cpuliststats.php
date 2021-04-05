<?php
require('phpdac7.php'); 
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;
use bmail.bmailcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
		
/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public crm.crmforms;
public bmail.rcbmailclick;
public bmail.rculiststats;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');
   
    $t = $_POST['FormAction'] ? $_POST['FormAction'] : $_GET['t'];
	switch ($t) { 	
	
		case 'bmaillist'     	   :
		case 'bmailrepl'     	   :
		case 'bmailfail'     	   :
		case 'bmailview'     	   :	
		case 'bmailcamp'		   :
		case 'bmailqueue'		   :
		case 'bmailrecs'		   :	
	    case 'bmailreg'			   :
		case 'bmaildel'			   :
		case 'bmailsent'		   : $p = 'cp-iframe-jqgrid'; 
									 break;	
	
		case 'cpuliststats'		   : 
		default           		   : $p = 'cp-bmail-uliststats'; 
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>