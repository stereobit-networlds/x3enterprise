<?php
require('phpdac7.php'); 
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;
use bshop.bshopcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public bshop.rcshop;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpshopformsubdetail': 
								switch (GetReq('module')) {
									case 'istats'     :
									case 'irelatives' : $p = 'cp-shop-items'; break;
									case 'iqpolicy'   : $p = 'cp-shop-qpolicy'; break;
									case 'ipurchases' : $p = 'cp-shop-transactions'; break;
									case 'dashboard'  : $p = 'cp-shop-dashboard'; break;
									default           : $p = 'cp-shop-detail';
								}	
								break;		
		case 'cpshopformdata'  : $p = 'cp-shop-detail'; break;
		case 'cpshopformdetail': 
								switch (GetReq('module')) {
									case 'istats'     :									
									case 'irelatives' : $p = 'cp-shop-items'; break;
									case 'iqpolicy'   : $p = 'cp-shop-qpolicy'; break;
									case 'ipurchases' : $p = 'cp-shop-transactions'; break;
									case 'dashboard'  : $p = 'cp-shop-dashboard'; break;
									default           : $p = 'cp-shop-detail';
								}	
								break;
		case 'cpcmsformshow'  : $p = 'cp-shop-edit'; break;
		case 'cpcmsfshow'     : $p = 'cp-shop-edit'; break;
		default               : $p = $_GET['iframe'] ? 'cp-shop-edit' : 'cp-shop';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>