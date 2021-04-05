<?php
$localscript=1;
$pushTokens=0;
define('SMTP_PHPMAILER','true');
//define('SENDMAIL_PHPMAILER','true');

require_once('phpdac7.php');

$processMethod = 'balanced'; 
$processDebug = false;

$htmlpage = new pcntl('
super javascript;
load_extension adodb refby _ADODB_; 
super database;
use i18n.i18n;
include mail.smtpmail;
/include process;

public twig.twigengine;
public cms.cmsrt;
public cms.cmsvstats;
/public cms.cmslogin;
public bshop.shlogin;
public cms.cmsmenu;
public cms.cmssubscribe;
public bshop.shkategories; 
public bshop.shkatalogmedia;
public bshop.shnsearch;
public bshop.shwishcmp;
public bshop.shtags;
public bshop.shusers;
public bshop.shcustomers;
/public bshop.shcart->processcart_bcstep0->processcart_bcstep1->processcart_bcstep2->processcart_bcstep3;
public bshop.shcart;
public bshop.shtransactions;
public jsdialog.jsdialogStream;
public i18n.i18nL;

/phpcode if ($x==1) { $x=2: } else $x=3: echo $x:;
/phpcode echo $x . \' x\':;

/phpcode echo \'status \' . GetSessionParam(\'cartstatus\'):;
/nvl bshop.a bshop.b return (GetSessionParam(\'cartstatus\')):;

',1);
function milliseconds() {
    $mt = explode(' ', microtime());
    //return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000)); //x64
	return round(microtime(true) * 1000);
}
$ms = milliseconds();
$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;
echo "<!-- $ms local $time -->";

//$mc_page = isset($_GET['page']) ? $_GET['page'] : _m("cms.paramload use FRONTHTMLPAGE+home");
//$mc_page = isset($_GET['page']) ? $_GET['page'] : _m('cmsrt.mcSelectPage use +klist');
$mc_page = _m('cmsrt.mcSelectPage use +klist'); //$_GET['page'] = pager in katalog
$TEMPLATE = _m("cms.paramload use FRONTHTMLPAGE+template");

if (($TEMPLATE=='media-center') || ($TEMPLATE=='media-mixed')) {
    /*when in cart procedure disable common subscribe form in every page -footer-*/	
    $nosubform = ((GetParam('t')=='viewcart') || ((GetReq('t')=='calc')) ||
	              (GetReq('t')=='cart-order') || ((GetReq('t')=='cart-submit')) || 
		          (GetReq('t')=='cart-cancel') || ((GetReq('t')=='cart-checkout')) ||
				  (GetReq('t')=='addtocart') || ((GetReq('t')=='removefromcart')) ||
				  (GetParam('FormAction')==_v('shcart.checkout')) ||
				  (GetParam('FormAction')==_v('shcart.order')) ||
				  (GetParam('FormAction')==_V('shcart.submit'))) ? 1 : 0;
	  
    //$mc_page = _m('cmsrt.mcSelectPage use +klist');	
    $headerStyle = ($mc_page=='home') ? 1 : 2;
    //echo $htmlpage->render(null,getlocal());	
}
elseif ($TEMPLATE=='electro') {
	
	$bodyClass = 'page home page-template-default';
	$headerclass = 'v1';
	$headerfile = 'header-v2';	

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
        case 'shop'		:
		case 'klist'	:
		case 'search'   :
		case 'kfilter'  :	
					$bodyClass = 'left-sidebar';
					break;
		case 'kshow'    :		
					$bodyClass = 'single-product';
					break;					
    }
}
else {}

echo $htmlpage->render(null,getlocal());

$ms = milliseconds();	
$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;
echo "<!-- $ms local $time -->";
