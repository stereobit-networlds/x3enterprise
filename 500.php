<?php
require_once('phpdac7.php');
$htmlpage = new pcntl('
super javascript;load_extension adodb refby _ADODB_; super database;use i18n.i18n;include mail.smtpmail;	public cms.cmsrt;public cms.cmsvstats;public cms.cmslogin;public cms.cmsmenu;public bshop.shkategories; public bshop.shkatalogmedia;public bshop.shnsearch;public bshop.shwishcmp;public bshop.shtags;public bshop.shusers;public bshop.shcustomers;public bshop.shcart;public jsdialog.jsdialogStream;public i18n.i18nL;
',1);
$mc_page = '500';
$TEMPLATE = _m("cms.paramload use FRONTHTMLPAGE+template");

if (($TEMPLATE=='media-center') || ($TEMPLATE=='media-mixed')) {
	$headerStyle = 1;
}
elseif ($TEMPLATE=='electro') {
	
	$bodyClass = 'page home page-template-default';
	$headerclass = 'v1';
	$headerfile = 'header-v1';

    switch($mc_page){

        case '401':
		case '400':
		case '403':
		case '404':
		case '500':
					$bodyClass = 'page home page-template-default';
					$headerfile = 'header-v2';
					break;
	}
}
else {}	

echo $htmlpage->render(null,getlocal());
?>