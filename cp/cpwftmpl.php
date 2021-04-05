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
include mail.smtpmail;

security ACCOUNTMNG_ 1 1:1:1:1:1:1:1:1;
security USERMNG_ 1 1:1:1:1:1:1:1:1;
security USERSMNG_ 1 1:1:1:1:1:1:1:1;
security SIGNUP_ 1 1:1:1:1:1:1:1:1;
security DELETEUSR_ 1 1:1:1:1:1:1:1:1;
security UPDATEUSR_ 1 1:1:1:1:1:1:1:1;
			
/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public cms.rcwftmpl;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cms.paramload use FRONTHTMLPAGE+cptemplate');

$mc_page = (GetSessionParam('LOGIN')) ? 'cp-wftmpl' : 'cp-login'; 
echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>