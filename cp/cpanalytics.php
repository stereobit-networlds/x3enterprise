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
public piwik.siteanalytics;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;
',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

    switch ($_GET['t']) {
		case 'siteanalytics'  : $p = 'cp-site-analytics'; break;		
		case 'siteactions'    : $p = 'cp-site-analytics-actions'; break;		
		case 'sitereferrers'  : $p = 'cp-site-analytics-referrers'; break;		
		case 'siteengagements': $p = 'cp-site-analytics-engagements'; break;		
		case 'sitelocations'  : $p = 'cp-site-analytics-locations'; break;		
		case 'sitedevices'    : $p = 'cp-site-analytics-devices'; break;		
		case 'sitevariables'  : $p = 'cp-site-analytics-variables'; break;		
		case 'sitevisitors'   : $p = 'cp-site-analytics-visitors'; break;		
		case 'sitelive'	      : $p = 'cp-site-analytics-live'; break;		
		case 'siteanalytics'  : 
		default               : $p = 'cp-site-analytics';		
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>