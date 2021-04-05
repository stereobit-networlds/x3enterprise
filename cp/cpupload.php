<?php
require('phpdac7.php');
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_;
super database;

/---------------------------------load and create libs
use i18n.i18n;
use xwindow.window;

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public bshop.rckategories;
public bshop.rcitems;
public cms.rcupload;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-upload' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>