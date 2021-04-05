<?php
require('phpdac7.php'); 
$page = new pcntl('

#define ESHOP CONF_ESHOP_ENABLE

super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

#if ESHOP > 0			
	security CART_DPC 1 1:1:1:1:1:1:1:1;
	security SHCART_DPC 1 1:1:1:1:1:1:1:1;
	security TRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
	security SHTRANSACTIONS_DPC 1 1:1:1:1:1:1:1:1;
#endif				

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public bshop.rckategories;
public bshop.shkatalogmedia;
public bshop.rcitems;
public bshop.shcustomers;
public bshop.shcart;
public bshop.rctransactions;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

    $mc_page = (GetSessionParam('LOGIN')) ? 'cp-transactions' : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>