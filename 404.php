﻿<?php
require_once('phpdac7.php');
$htmlpage = new pcntl('
super javascript;
',1);
$mc_page = '404';
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