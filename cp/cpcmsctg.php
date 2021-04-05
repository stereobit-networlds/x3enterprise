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
public cms.rccmsctg;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpsortsave'  :
		case 'cpsortpage'  : $p = 'cp-cmsctg-sort'; break;		
		case 'cpcatalog'   : 
		case 'cpsavectg'   : 
		case 'cpctgitems'  : $p = 'cp-cmsctg-items'; break;
		case 'cpcmsctg'    :
		default            : $p = 'cp-cmsctg';
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>