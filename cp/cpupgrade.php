<?php
require('phpdac7.php');
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

use i18n.i18n;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

/---------------------------------load all and create after dpc objects
public cms.cmsrt;
#ifdef SES_LOGIN
public cms.rcupgrade;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;
',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

    switch ($_GET['t']) {
		case 'cpupgrade'     : $p = 'cp-upgrade'; break;
		default              : $p = 'cp-upgrade-go';		
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>