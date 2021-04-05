<?php
$localscript=1;
//define('SMTP_PHPMAILER','true');
//define('SENDMAIL_PHPMAILER','true');
require_once('phpdac7.php');

$htmlpage = new pcntl('
/super javascript;
load_extension adodb refby _ADODB_; 
super database;
/use i18n.i18n;
/include mail.smtpmail;

/public twig.twigengine;
public cms.cmsrt;
/public cms.cmsvstats;
/public cms.cmslogin;
/public bshop.shlogin;
public cms.cmsmenu;
/public cms.cmssubscribe;
public bshop.shkategories; 
public bshop.shkatalog;
/public bshop.shnsearch;
/public bshop.shwishcmp;
public bshop.shtags;
/public bshop.shusers;
/public bshop.shcustomers;
public bshop.shcart;
/public bshop.shtransactions;
/public jsdialog.jsdialogStream;
/public i18n.i18nL;

/phpcode if ($x==1) { $x=2: } else $x=3: echo $x:;
/phpcode echo $x . \' x\':;

/phpcode echo \'status \' . GetSessionParam(\'cartstatus\'):;
/nvl bshop.a bshop.b return (GetSessionParam(\'cartstatus\')):;

',1);
/*
echo $htmlpage->render(null,getlocal(),true);//,'media-center/index.php');	

$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;
echo "<!-- local $time -->";
*/

