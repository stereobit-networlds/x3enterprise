<?php
/**
 * This file is part of phpdac7.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    balexiou<balexiou@stereobit.com>
 * @copyright balexiou<balexiou@stereobit.com>
 * @link      http://www.stereobit.com/php-dac7.php
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace phpdac7;

error_reporting(E_ALL & ~E_NOTICE); //prod 0 /dev E_ALL ~E_NOTICE
ini_set('log_errors', true); //prod true / dev false
ini_set('display_errors', 1); //prod 1 / dev false
ini_set('error_log', false);//'errors.log'); //prod 'errors.log' /dev false

define ("_DS_", DIRECTORY_SEPARATOR);	
define ("_OS_",(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'WINMS' : 'LINMS');
define ("_MODE_", 2); //1=phpdac5 or 2=agndac5
define ("_MACHINENAME", _OS_);
define ("_DUMPFILE", 'dumpagn-'. _MACHINENAME . '.log');
define ("_UMONFILE", '/tier/umon-'. _MACHINENAME . '-');

if (isset($timezone)) //global timezone var
	date_default_timezone_set($timezone);
else	
	date_default_timezone_set('Europe/Athens');

if (isset($nosession)) //global nosession var	
{;} else session_start(); 	

$start=microtime(true);
$env = array(
'appname' => 'phpdac7',
'apppath' => '',
'dpctype' => 'local',
'dpcpath' => '/home/stereobi/public_html/bit77/phpdac7',
'prjpath' => '/',
'dachost' => '127.0.0.1',
'dacport' => '19123',
'app' => '',/*'/var/stereobit/phpdac7/vendor/stereobit/cpdac7.phar',*/
'cppath' =>'/home/stereobi/public_html/bit77/www1.bit77.gr/cp',
'key' => 'd41d8cd98f00b204e9800998ecf8427e', 
);
$dac = false; //when shm.id exists turns to true
$pharApp = false; //when phar is enabled turns to true
//$_cleanOB = 0; //0 level if not a phpdac call
$dh = $env['dachost'];
$dp = $env['dacport'];

//$u = file_put_contents($env['dpcpath'] . '/key.md', md5(getenv('COMPUTERNAME') . getenv('LOGONSERVER')));
if ($env['key']!==md5(getenv('COMPUTERNAME') . getenv('LOGONSERVER'))) die('phpdac7 valid key required');

$dac = @is_file($env['dpcpath'] . "/shm.id");
$stream = $env['app'] ? "phar://" . $env['app'] : "phpdac5://$dh:$dp";
$st = $dac ? $stream : $env['dpcpath'];
		
define('_DPCPATH_', $env['dpcpath']);

define('_DACSTREAMCVIEW_', 3); //verbose level
define('_DACSTREAMCREP1_', "<!-- ");
define('_DACSTREAMCREP2_', "$st/");
define('_DACSTREAMCREP3_', ' -->');
define('_DACSTREAMCREP0_', 'D'); //trail txt err		
			
//REGISTER PHPDAC			
//ms-windows can load the class below
//stream_wrapper_register("phpdac5","phpdac7\c7_dacstream");
//linux must set
require($env['dpcpath'] ."/system/dacstreamc7.lib.php");  
stream_wrapper_register("phpdac5","c_dacstream");

//if st is stream (dacport at last 5 chars) and mode = 1/2
if ((_MODE_ == 2) && (substr($st,-5) == $dp))
{
	//REGISTER PHPRES (client side,resources) protocol.		
	require("$st/kernel/sresc.lib.php"); 
	//require_once("$st/tier/sresct.lib.php"); 
	stream_wrapper_register("phpres5","c_resstream");
	
	$__id = getSesId(true);
	if ($agnport = trim(get('netport-' . $__id)))
	{
		//echo $_SESSION['uuid'];
		//echo '-'. $agnport .'-';
		
		//set heartbeat
		getT('heartbrst');
		
		//change protocol for the rest of request
		$st = "phpres5://$dh:" . $agnport; //19125
	}
	else
	{
		//create uuid;
		if (isset($nosession)) {}
			else $_SESSION['uuid'] =  _uuid();
	
		//kernel open a uuid tier
		get($__id); //$uuid);		
	}
}//MODE
//else 1=default
require("$st/system/pcntlst.lib.php");


//namespace\funcs
function __log($data=null,$mode=null,$filename=null) 
{
	$f = $filename ? $filename : '/phpdac7-'. _MACHINENAME .'.log';	
	$fsize = 4 * 1024 * 1024; //4mb

	if (@filesize(getcwd() . $f) > $fsize) {
		//rename old
		if (@rename(getcwd() . $f, getcwd() . str_replace('.log', '.log-'.date('yz'), $f)))
			//create new
			$m = 'w';
	}	
	else //append	
		$m = $mode ? $mode : 'a+';

	if ($fp = @fopen (getcwd() . $f , $m)) 
    {
		fwrite ($fp, date('c') .':'. $data . PHP_EOL);
		fclose ($fp);
		return true;
	}
    return false;
}
   
//call phpdac7 srv to get a variable 
function get($call=null) {
    global $dh, $dp;		
    if (!$call) return false;   
	   
    return @file_get_contents("phpdac5://$dh:$dp/" . $call);
}
			
function jdecode($dmsg=null) {			
	preg_match( '/\[(.*)\]/', $dmsg, $res);
	//echo $res[0];	
	return @json_decode($res[0]);					
}

//generate a uuid
function _uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

//call phpagn7 tier to get a variable 
function getT($call=null, $port=null) {   
	global $dh, $dp, $agnport;
    if (!$call) return false;	   
	   
	$dpt = trim($agnport); //$port ? $port : '19125';   
    return @file_get_contents("phpres5://$dh:$dpt/" . $call);
}

//get client ip
function getIP($encode=false) {
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
		$ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	}
	return ($encode==true) ? md5($ip) : $ip;
}

//select between global sesID (REMOTE_ADDR or fixed id) and session
function getSesId($encode=false) {
	global $sesID, $nosession;
	
	if (!isset($sesID)) 
	{
		//$id = ((!$nosession) ? session_id() : getIP(true));
		if (!isset($nosession))
		{	
			$username = $_SESSION['UserName']; 
			$userid = $_SESSION['UserID'];
			$usersecid = $_SESSION['UserSecID']; 
			$admin = $_SESSION['ADMIN'];
			$adminsecid = $_SESSION['ADMINSecID'];
	
			$id = isset($username) ? $username : session_id();
		}
		else
			$id = getIP();
	}
	else
		$id = $sesID;	
	
	__log('ID:'.$id);
	return ($encode==true) ? md5($id) : $id;
}


//namespace\c7_dacstream
class c7_dacstream {

   var $position;
   var $data;
   
   var $DPCEOF;
   var $size;
   
   var $path, $dpcmem;

   public function stream_open($_url,$mode,$options,&$opened_path) {
   
		$url = parse_url($_url);   
		$timeout = 5;//30;
   
        $server = $url['host'];
		$port = $url['port'];
		$this->path = $url['path'];
		//print_r($url);
		
        //$socket = fsockopen($server, $port, $errno, $errstr, $timeout); 
		//PERSISTENT CONNECTION
		$socket = @pfsockopen($server, $port, $errno, $errstr, $timeout); 
		
		if (!$socket) {
		  echo $errstr,"(",$errno,")\n";
		  return false;
		}
		//exclude '/' from the begining of str
        $this->dpcmem = (substr($this->path,0,1)=='/') ? substr($this->path,1) : $this->path;
		//client version of getdpcmem
		$request = "getdpcmemc " . $this->dpcmem . "\r\n";
        fputs($socket, $request); 
        $ret = ''; 
        while (!feof($socket)) { 
          $ret .= fgets($socket, 4096);
        }  
        fclose($socket);  
				
		$this->DPCEOF = strlen($ret);
		$this->size = strlen($ret);
	    $this->data = $ret;
		    
		$this->position = 0;
		
		return true;   
   }
   
   public function stream_read($count) {
   
        $ret = substr($this->data,$this->position,$count);
		$this->position += strlen($ret);
		
        //return ($this->gc($ret,_DACSTREAMCVIEW_)); 
		return $ret;
   }
   
   public function stream_write($data) {
   
       /* $left = substr($this->data, 0, $this->position);
		$right = substr($this->data, $this->position + strlen($data));
		
		$this->data = $left . $data . $right;
		
		$this->position += strlen($data); */
		
		return (strlen($data));
   }
   
   public function stream_tell() {
   
     return ($this->position);
   }
   
   public function stream_eof() {
     //return ($this->DPCEOF);
	 return $this->position >= strlen($this->data);
   }
   
   public function stream_seek($offset,$whence) {
   
     switch($whence){
     	case SEEK_SET: 
     		if (($offset < strlen($this->data)) && ($offset >=0)) {
     		    $this->position = $offset;
				return true;
     		}
			else
			    return false;
     		break;
     	case SEEK_CUR: 
     		if ($offset >=0) {
     		    $this->position += $offset;
				return true;
     		}
			else
			    return false;
     		break;
		case SEEK_END: 
     		if (strlen($this->data) + $offset >= 0) {
     		    $this->position = strlen($this->data) + $offset;
				return true;
     		}
			else
			    return false;
     		break;	
     	default:
     		return false;
     } // switch
   }
   
   public function stream_stat() {
   
     return (array('size'=>strlen($this->data)));
   }
   
    //https://api.drupal.org/api/drupal/includes%21stream_wrappers.inc/function/DrupalLocalStreamWrapper%3A%3Aurl_stat/7.x
	//Parameters
	//$uri: A string containing the URI to get information about.
	//$flags: A bit mask of STREAM_URL_STAT_LINK and STREAM_URL_STAT_QUIET.
	public function url_stat($uri, $flags) {
		// Suppress warnings if requested or if the file or directory does not
		// exist. This is consistent with PHP's plain filesystem stream wrapper.
		if ($flags & STREAM_URL_STAT_QUIET || !file_exists($path)) {
			return @stat($this->path);
		}
		else {
			return stat($this->path);
		}
	}  
	
	public function gc($g, $l=false) {
		global $dh, $dp;
		$b = defined('_DACSTREAMCREP2_') ? _DACSTREAMCREP2_ : $this->dpcmem;
		$d = defined('_DACSTREAMCREP0_') ? _DACSTREAMCREP0_ : '';
		
		//echo "PHPDAC5 Kernel v2, $dh:$dp\r\nphpdac5> getdpcmemc";
		switch ($l) {
			case 3  : $g = str_replace($this->dpcmem, _DACSTREAMCREP3_, $g);
			case 2  : $g = str_replace("phpdac5> getdpcmemc ", $b, $g);
			case 1  : $g = str_replace("PHPDAC5 Kernel v2, $dh:$dp\n", _DACSTREAMCREP1_, $g);		
			default : //do nothing	
		}		
		return ($g);// . $d); //error when trail text
	}	
}


//namespace\process
class dacProcess {
    static public function test($name) {
        //print '[['. $name .']]';
    }
	
    static public function autoload($class)  {
		global $st;	
        if (0 !== strpos($class, 'process')) //check is process dir
            return;
				
		require($st . '/process/'.str_replace(array('_', "\0"), array('/', ''), $class).'.php');
    }
}

ini_set('unserialize_callback_func', 'spl_autoload_call');
spl_autoload_register(__NAMESPACE__ .'\dacProcess::autoload');

/* remote script */
if (($dac) && (!$localscript)) { 

	require("$st/www7" . $_SERVER['PHP_SELF']);
		
	__log('fetch remote:'.$_SERVER['PHP_SELF']);	
	die();
} //else continue
__log('fetch local:'.$_SERVER['PHP_SELF']);
?>
