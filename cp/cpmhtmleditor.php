<?php
require('phpdac7.php');
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

use i18n.i18n;

include networlds.clientdpc;

public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public cp.cpmhtmleditor;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;
public i18n.i18nL;

',1);
	
$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');
$postok = defined('CPMHTMLEDITOR_DPC') ? _v('cpmhtmleditor.postok') : false;

	switch ($_GET['t']) {
		case 'cpmdelitem'    : $p = 'cp-htmleditor-newitem'; break;
		case 'cpmnewitem'    : $p = ($_POST['insert'] && $postok) ? 'cp-uploadimage' : 'cp-htmleditor-newitem'; break;
		case 'cpmedititem'   : $p = 'cp-htmleditor-edititem'; break;
		case 'cpmvphotoadddb':
		case 'cpmvphotodeldb':
		case 'cpmvphoto'     : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mvphoto'; break;
		case 'cpmvdel'       : $p = $_GET['ajax'] ? 'cp-ajax-mvphoto' : 'cp-mvphoto'; break;
		
		case 'cpmhtmleditor' :		
		default              : $p = GetParam('ajax') ? 'cp-ajax-ckeditor' : (GetParam('iframe') ? 'cp-iframe-ckeditor' : 'cp-ckeditor'); 
	}
    $mc_page = (GetSessionParam('LOGIN')) ? $p : 'cp-login';
	echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>