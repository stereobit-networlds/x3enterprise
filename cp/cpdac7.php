<?php
$localscript=1;

require('phpdac7.php'); 
$page = new pcntl('
/super javascript;

/load_extension adodb refby _ADODB_; 
/super database;

/---------------------------------load and create libs
/use i18n.i18n;
/use jqgrid.jqgrid;
/use filesystem.downloadfile;

/---------------------------------load not create dpc (internal use)
/include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
/public jqgrid.mygrid;
public cms.cmsrt;
public cp.rcdac7;
/#ifdef SES_LOGIN
/public cp.rcpmenu;
/#endif
/public cp.rccontrolpanel;
/public i18n.i18nL;

',1);
/*
$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpdac7'        :		
		default              : $p = $_GET['iframe'] ? 'cp-replica-detail' : 'cp-replica';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
*/
die($_GET['dac7cmd']);	
?>