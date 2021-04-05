<?php
require('phpdac7.php'); 
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use i18n.i18n;
use jqgrid.jqgrid;
use crm.crmcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef CONF_CRM_PLUS
public crm.crmplus;
public crm.crmevents;
public crm.crmactions;
#endif
#ifdef SES_LOGIN
public crm.crmreports;
public crm.crmreturns;
public crm.crmpurchases;
public crm.crmitemstats;
public crm.crmwishlist;
public crm.crmwishcmp;
public crm.crmwishfav;
public crm.crmforms;
public crm.crmtransactions;
public crm.crmtasks;
public crm.crminbox;
public crm.crmoutbox;
public crm.crmdocs;
public crm.crmdocsitem;
public crm.crmstats;
public crm.crmcustomer;
public crm.crmdashboard;
public crm.rccrm;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcrmrun'       : $p = 'cp-crm-subdetail'; break; 
		case 'cpcrmdetails'   : $p = $_GET['iframe'] ? 'cp-crm-subdetail' : 'cp-tags'; break;
		case 'cpcrmshowcus'   : $p = 'cp-crm-detail'; break;
		case 'cpcrmshowusr'   : $p = 'cp-crm-detail'; break;
		case 'cpcrmdashboard' : $p = 'cp-crm-dashboard'; break;
		case 'crmstats'       : $p = 'cp-crm-stats'; break;
		case 'crmtree'        : $p = 'cp-crm'; break;
		default               : $p = $_GET['iframe'] ? 'cp-crm-detail' : 'cp-crm';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>