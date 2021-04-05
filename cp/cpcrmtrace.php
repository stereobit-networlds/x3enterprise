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
public piwik.siteanalytics;
public cms.rccollections;
public crm.crmforms;
public crm.crmtimeline;
public crm.rccrmtrace;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcrmdataprofile': $p = 'cp-crm-profile-data'; break;
		case 'cpcrmtimeline'  : $p = 'cp-crm-timeline'; break;
		case 'cpcrmcontact'   : $p = 'cp-crm-profile-contact'; break;
		case 'cpcrmsaveactivity':
		case 'cpcrmactivities': $p = 'cp-crm-profile-activities'; break;
		case 'cpcrmaddactivity': $p = 'cp-crm-activities-add'; break;		
		case 'cpcrmeditprofile': $p = 'cp-crm-profile-edit'; break;
		case 'cpcrmuser'      :
		case 'cpcrmcust'      :
		case 'cpcrmcont'      :
		case 'cpcrmsaveprofile':		
		case 'cpcrmprofile'   : $p = 'cp-crm-profile'; break;
		default               : $p = 'cp-crm-trace';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>