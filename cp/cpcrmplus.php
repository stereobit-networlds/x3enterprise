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
#ifdef CONF_CRM_PLUS
public crm.crmgantti;
public crm.crmacal;
public crm.reservations;
public crm.rccrm;
public crm.rccrmplus;
#endif
#ifdef SES_LOGIN
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcrmprun'      : $p = 'cp-crmplus-subdetail'; break; 
		case 'cpcrmpdetails'  : $p = 'cp-crmplus-subdetail'; break;
		case 'cpcrmgant'      : $p = 'cp-crmplus-detail'; break;
		case 'cpcrmpdashboard': $p = 'cp-crmplus-dashboard'; break;
		default               : $p = $_GET['iframe'] ? 'cp-crmplus-detail' : 'cp-crmplus';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>