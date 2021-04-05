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
public cms.rcxmlfeeds;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);


$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-xmlfeeds' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>