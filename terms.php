<?php
require('phpdac7.php'); 
$htmlpage = new pcntl('
super javascript;
load_extension adodb refby _ADODB_; 
super database;
use i18n.i18n;
include mail.smtpmail;
public cms.cmsrt;
public cms.cmsvstats;
public cms.cmslogin;
public cms.cmsmenu;
public bshop.shkategories; 
public bshop.shkatalogmedia;
public bshop.shnsearch;
public bshop.shwishcmp;
public bshop.shtags;
public bshop.shusers;
public bshop.shcustomers;
public bshop.shcart;
public jsdialog.jsdialogStream;
public i18n.i18nL;

',1);
 
$mc_page = isset($_GET['page']) ? $_GET['page'] : _m('cmsrt.mcSelectPage use +terms');
$user = GetGlobal('UserName') ? decode(GetGlobal('UserName')) : '';
_m("cmsvstats.update_page_statistics use fp+$mc_page+".$user);

$TEMPLATE = _m("cms.paramload use FRONTHTMLPAGE+template");

if (($TEMPLATE=='media-center') || ($TEMPLATE=='media-mixed')) {

	$headerStyle = ($mc_page=='home') ? 1 : 2;
}
elseif ($TEMPLATE=='electro') {
	
	$bodyClass = 'page home page-template-default';
	$headerclass = 'v1';
	$headerfile = 'header-v1';

    switch($mc_page){

        case 'about':
					$bodyClass = 'about full-width page page-template-default';
					break;
		case 'home':
					$bodyClass = 'page home page-template-default';
					$headerfile = 'header-v1';
					break;		
        case 'home-v2':
					$bodyClass = 'home-v2';
					$headerfile = 'header-v2';
					break;
		case 'home-v3':
					$bodyClass = 'page home page-template-default';
					$headerfile = 'header-v3';
					break;
        case 'home-v3-full-color':
					$bodyClass = 'home page-template page-template-template-homepage-v3 full-color-background';
					$headerfile = 'header-v3-full-color';
					break;
        case 'single-product':
					$bodyClass = 'single-product full-width';
					break;
        case 'single-product-sidebar':
        case 'single-product-sidebar-accessories':
        case 'single-product-sidebar-specification':
        case 'single-product-sidebar-reviews':
					$bodyClass = 'single-product';
					break;
         case 'single-product-extended':
					$bodyClass = 'single-product full-width extended';
					break;
        case 'blog':
					$bodyClass = 'blog';
					break;
        case 'blog-fw':
					$bodyClass = 'blog full-width';
					break;
        case 'blog-v3':
					$bodyClass = 'blog blog-list right-sidebar';
					break;
        case 'contact-v2':
        case 'terms-and-conditions':
		case 'cookies' :
		case 'terms' :		
					$bodyClass = 'page full-width';
					$headerfile = 'header-v2';
					break;
        case 'blog-single':
					$bodyClass = 'single-post right-sidebar';
					break;
        case 'blog-v1':
        case 'shop-right-side-bar':
					$bodyClass = 'right-sidebar';
					break;
        case 'blog-v2':
					$bodyClass = 'right-sidebar blog-grid';
					break;
        case 'contact-v1':
					$bodyClass = 'page-template-default contact-v1';
					break;
        case 'cat-3-col':
        case 'cat-4-col':
        case 'shop':
					$bodyClass = 'left-sidebar';
					break;
    }
}
else {}
	  
echo $htmlpage->render(null,getlocal());  
$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;
echo "<!-- local $time -->";
?>