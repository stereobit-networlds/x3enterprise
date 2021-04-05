<?php
require('phpdac7.php');
$page = new pcntl('
super javascript;
/super rcserver.rcssystem;
load_extension adodb refby _ADODB_; 
super database;
/---------------------------------load and create libs
use i18n.i18n;
use gui.swfcharts;
use jqgrid.jqgrid;
use cms.cmscharts;

/---------------------------------load not create dpc (internal use)
/include networlds.clientdpc;
include mail.smtpmail;

/load_extension recaptcha refby _RECAPTCHA_;	

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;

#ifdef SES_LOGIN
public crm.crmforms;
public crm.rccrmtrace;
#endif

public piwik.siteanalytics;
public bmail.rculiststats;
public cp.rcmessages;
public cp.rccpclick;
public cp.rcpmenu;
public cp.cplogin;
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cms.paramload use FRONTHTMLPAGE+cptemplate');


	switch ($_GET['t']) {
		
		case 'cpctgvisits'  :
		case 'cpitmvisits'  :
		case 'cptransact'   :
		case 'cpitemsactiv' :	
		case 'cpitemsinact'	:
		case 'cpmailqueue'	: 
		case 'cpmailrecs'	:	
	    case 'cpusersin'	:
		case 'cpcustin'		:
		case 'cpmailsent'	: $mc_page = 'cp-iframe-jqgrid'; 
							  break;		
		
		case 'captchaimage' : die(_m('cmsrt.captchaImage'));
		
	    case 'chpass'   : 	$mc_page = (GetReq('sectoken')) ? 'cp-chpass' : 'cp-lock';
							break;
						
		case 'shremember':	$mc_page = 'cp-lock';
                            break;  
        case 'lang'     :   $mc_page = 'cp-lang';
                            break;  						
        default       	:	
							if (($user = $_POST['cpuser']) && ($pass = $_POST['cppass'])) 
								$login = _m("shlogin.do_login use ".$user.'+'.$pass.'+1');	//editmode
						
							if ((GetSessionParam('LOGIN'))||($login)) { 
								$cpGet = _v('rcpmenu.cpGet');
								$id = $cpGet['id'];
								$cat = $cpGet['cat'];
								$dashboard = (isset($id)) ? 'cp-itemstats' : ( (isset($cat)) ? 'cp-catstats' : 'cp-dashboard' );
						
								$seclevid = $GLOBALS['ADMINSecID'] ? $GLOBALS['ADMINSecID'] : GetSessionParam('ADMINSecID');
								$default_page = ($seclevid<6) ? 'cp-mailstats' : $dashboard; 
								$mc_page = (($p=GetReq('t')) && ($p!='cp'))  ? str_replace('cp', 'cp-', GetReq('t')) : $default_page;
							}
							else
								$mc_page = 'cp-login';
						
    }
  
	echo $page->render(null, getlocal(), null, $cptemplate.'/index.php');
	$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;
	echo "<!-- local $time -->";
?>