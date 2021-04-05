<?php
require('phpdac7.php');
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 
super database;

use xwindow.window;
use jqgrid.jqgrid;
use gui.swfcharts;

/---------------------------------load not create dpc (internal use)
include networlds.clientdpc;

public jqgrid.mygrid;
public cms.cmsrt;
#ifdef SES_LOGIN
public cp.rctranssql2;
public cp.rcpmenu;
#endif
public cp.rccontrolpanel;

',1);	 

//load standart sync sql
_m('rctranssql2.sync_sql use 1+ISO-8859-7+UTF-8');

//load syncmysqlpos.txt
_m('rctranssql2.remote_execute_sql use /cp/syncsql/syncmysqlpos.txt++ISO-8859-7+UTF-8+1+1');

//run sql
_m('rctranssql2.run_sql use +1');//execute sql

//run xml
$data = @file_get_contents(getcwd() .'/syncsql/skroutz.xml');//'http://dl.dropbox.com/u/106627024/skroutz.xml');
$utfdata = mb_convert_encoding($data, 'UTF-8', 'ISO-8859-7');
//echo $utfdata;
$to = getcwd() . '/../skroutz.xml';
$to2 = getcwd() . '/../totos.xml';
file_put_contents($to, trim($utfdata, "\t\n\r\0\x0B"));
file_put_contents($to2, trim($utfdata, "\t\n\r\0\x0B"));
//echo $to,'>home/stereobi/public_html/basis/skroutz.xml';

$data = @file_get_contents(getcwd() .'/syncsql/bestprice.xml');//'http://dl.dropbox.com/u/106627024/bestprice.xml');
//$ndata = str_replace(array("\r","\n"),array('',''),$data);
$utfdata = mb_convert_encoding($data, 'UTF-8', 'ISO-8859-7');
$to3 = getcwd() . '/../bestprice.xml';
file_put_contents($to3, trim($utfdata, "\t\n\r\0\x0B"));
//echo $to,'>home/stereobi/public_html/basis/bestprice.xml';

$cptemplate = _m('cmsrt.paramload use FRONTHTMLPAGE+cptemplate');

$mc_page = (GetSessionParam('LOGIN')) ? 'cp-tags' : 'cp-login';
echo $page->render(null,getlocal(), null, $cptemplate.'/index.php');
?>
