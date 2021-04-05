<?php
require('phpdac7.php');
$page = new pcntl('

super javascript;
/super rcserver.rcssystem;

load_extension adodb refby _ADODB_; 
super database;

/---------------------------------load and create libs
use crypt.cryptopost;
use i18n.i18n;
use jqgrid.jqgrid;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;	

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public crm.rccrmforms;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('rcserver.paramload use FRONTHTMLPAGE+cptemplate');

	switch ($_GET['t']) {
		case 'cpcrmformsubdetail': 
								switch (GetReq('module')) {
									case 'formcode' : $p = 'cp-crmforms-code'; break;
									case 'formhtml' : $p = 'cp-crmforms-html'; break;
									default         : $p = 'cp-crmforms-detail';
								}	
								break;		
		case 'cpcrmformdata'  : $p = 'cp-crmforms-detail'; break;
		case 'cpcrmformdetail': 
								switch (GetReq('module')) {
									case 'formcode' : $p = 'cp-crmforms-code'; break;
									case 'formhtml' : $p = 'cp-crmforms-html'; break;
									default         : $p = 'cp-crmforms-detail';
								}	
								break;
		case 'cpcrmformshow'  : $p = 'cp-crmforms-edit'; break;
		case 'cpcrmfshow'     : $p = 'cp-crmforms-edit'; break;
		default               : $p = $_GET['iframe'] ? 'cp-crmforms-edit' : 'cp-crmforms';
	}
	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>