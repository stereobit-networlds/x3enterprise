<?php
require('phpdac7.php'); 
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;
use filesystem.downloadfile;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public backup.rcreplica;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpreplicate'   : $p = 'cp-replica-detail'; break;
		case 'cpreplicadtl'  : $p = $_GET['iframe'] ? 'cp-replica-detail' : 'cp-replica'; break;
		
		case 'cpdorepall'    :
		case 'cpreplica'     :		
		default              : $p = $_GET['iframe'] ? 'cp-replica-detail' : 'cp-replica';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>