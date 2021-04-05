<?php
//define ('SENDMAIL_PHPMAILER',null);
define ('SMTP_PHPMAILER','true');

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
use bmail.bmailcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;
include mail.smtpmail;

/---------------------------------load all and create after dpc objects
public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public twig.twigengine;
public cp.rcfs;
public cms.rccollections;
public bmail.rcbulkmail;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');
//print_r($_POST);
//echo $_SESSION['cryptoPost_key'] . '>' . $_POST['cryptoPost_key'];
//echo $_POST['cryptoPost'];
	$t = $_POST['FormAction'] ? $_POST['FormAction'] : $_GET['t'];
	switch ($t) {
		case 'cptemplatesav'   :
		case 'cptemplatenew'   : $p = 'cp-bmail-new'; break;
		case 'cppreviewcamp'   : $p = 'cp-bmail-preview'; break;
		case 'cpsavemailadv'   : $p = 'cp-bmail-post'; break;
		case 'cpdeletecamp'    :
		case 'cpcontinuecamp'  :
		case 'cppausecamp'     :
		case 'cpstopcamp'      :		
		case 'cpviewcamp'      : $p = 'cp-bmail-campaigns'; break;	
		
		case 'cpsubsend'       : $p = 'cp-bmail-campaigns'; break; 

		default                : $p = 'cp-bmail-edit';
	}	
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');

?>