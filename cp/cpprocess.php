<?php
require('phpdac7.php');
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public process.rcprocess;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		
		case 'cpstackshowf'	  : $p = 'cp-process-list'; break;
		case 'cpstackrunshowf': $p = 'cp-process-list'; break;
		
		case 'cpproformsubdetail': 
								switch (GetReq('module')) {
									case 'formcode' : $p = 'cp-process-code'; break;
									case 'formhtml' : $p = 'cp-process-html'; break;
									default         : $p = 'cp-process-detail';
								}	
								break;		
		case 'cpproformdata'  : $p = 'cp-process-detail'; break;
		case 'cpproformdetail': 
								switch (GetReq('module')) {
									case 'formcode' : $p = 'cp-process-code'; break;
									case 'formhtml' : $p = 'cp-process-html'; break;
									default         : $p = 'cp-process-detail';
								}	
								break;
		case 'cpproformshow'  : $p = 'cp-process-edit'; break;
		case 'cpproshow'      : $p = 'cp-process-edit'; break;
		default               : $p = $_GET['iframe'] ? 'cp-process-edit' : 'cp-process';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>