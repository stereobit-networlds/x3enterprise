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
public backup.rcbackup;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

$insDownload = _v('rcbackup.instDownload');

	switch ($_GET['t']) {
		case 'cpbackupdn'   : $p = 'cp-backup-detail'; break;
		case 'cpbackupget'   : $p = 'cp-backup-detail'; break;
		case 'cpbackupsave'  : $p = $insDownload ? 'cp-backup-detail' : 'cp-backup'; break;
		case 'cpbackupdtl'   : $p = $_GET['iframe'] ? 'cp-backup-detail' : 'cp-backup'; break;
		default              : $p = $_GET['iframe'] ? 'cp-backup-detail' : 'cp-backup';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>