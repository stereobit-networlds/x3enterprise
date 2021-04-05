<?php
require('phpdac7.php'); 
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
		
/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public bmail.rculists;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');
   
    $t = $_POST['FormAction'] ? $_POST['FormAction'] : $_GET['t'];
	switch ($t) {
		
		case 'cpcleanbounce'       : $p = 'cp-bmail-ulists-clean'; break;
		
		case 'cpsubscribe'    	   :
		case 'cpunsubscribe'   	   :
		case 'cpadvsubscribe' 	   : $p = 'cp-bmail-ulists-subscribe'; break;		
		
		case 'cpactivatequeuerec'  :
		case 'cpdeactivatequeuerec': $p = 'cp-bmail-ulists-queue';  break;
		case 'cpulframe' 		   : $p = 'cp-iframe-jqgrid'; break;
		case 'cpviewtrace'         : $p = 'cp-iframe-jqgrid'; break;		
		case 'cpviewclicks'        :		
		case 'cpviewsubsqueue'     : 	
		case 'cpulists'   		   : 
		default           		   : $p = 'cp-bmail-ulists-queue'; 
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>