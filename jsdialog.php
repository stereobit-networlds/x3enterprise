<?php
//$localscript=1;
require('phpdac7.php');
$page = new pcntl('
super javascript;

load_extension adodb refby _ADODB_; 		
super database;

public cms.cmsrt;
public jsdialog.jsdialogStream;
public bshop.shkategories; 
public bshop.shkatalogmedia;
public bshop.shcart;
public bshop.shagent;
',1);	 

	if ($respond = _m("shagent.respond"))
		die($respond); 
	
	//else
	die();

///----------------------------------------------- 	
/*
if (GetReq('t')=='jsdecode') {
	print_r(GetSessionParam('_PASTMSG'));
	die();
}	
*/
if (GetReq('t')=='jsdcode') {
	
	//silent
	die(); //<<<<<<<<<<<<<<<<<< TEST
	
	//scope vars
	$db = GetGlobal('db'); 
	
	$ip = $_SERVER['REMOTE_ADDR'];
	$ipx = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$agent = $_SERVER['HTTP_USER_AGENT'];
	if ((stristr($agent, 'bingbot')) ||
	    (stristr($agent, 'hrefsbot')) ||
	    (stristr($agent, 'googlebot')) ||
		(stristr($agent, 'skroutzbot')) ||
	    (stristr($agent, 'facebookexternalhit/')) ||
		(stristr($agent, 'bot'))
	    ) die();
		
	$currentDiv = GetReq('div'); //as came from url call
	$currentPage = GetReq('cmd'); //as came from url call
	$currentItem = GetReq('id'); //as came from url call
	$currentCat = GetReq('cat'); //as came from url call

	$msgId = $currentItem ? $currentItem : ($currentCat ? $currentCat : $currentPage);	
	
	//load shown messages to not replay
	$pastMsg = GetSessionParam('_PASTMSG');	
	foreach ($pastMsg as $mid=>$divid)
		if (($mid==$msgId) && ($divid==$currentDiv)) 
			die();
			//die(_m("jsdialogStream.say use $msgId+$currentDiv++2000"));
		
		
	//as saved at rcvstats
	$referer = $_SESSION['http_referer'] ? $_SESSION['http_referer'] : $_SERVER['HTTP_REFERER'];
	//items viewed in session (array)
	$sesViewItems = unserialize(GetSessionParam('lastvieweditems'));
	
    $UserName = GetGlobal('UserName');	
	$finduser = $UserName ? 
				"attr2=" . $db->qstr(decode($UserName)) . ' OR attr3=' . $db->qstr(decode($UserName)) : 
				"attr2=" . $db->qstr(session_id());	
		
    //can be based on ip and date before today		
	$sSQL = "SELECT tid,attr1,REMOTE_ADDR,HTTP_USER_AGENT,REFERER from stats ";
	$sSQL.= "where $finduser ORDER BY DATE DESC LIMIT 100";
	$res = $db->Execute($sSQL);
	
	if (!empty($res->fields)) {
		//fetch items, categories...
		foreach	($res as $i=>$rec) {
			if ($tid = $rec[0]) { 
				switch ($tid) {
					case 'menu'    : $menus[] = $rec[1]; break;
					case 'search'  : $searches[] = $rec[1]; break;
					case 'filter'  : $filters[] = $rec[1]; break;
					case 'action'  : $actions[] = $rec[1]; break;
					case 'event'   : $events[] = $rec[1]; break;					
					case 'fp'      : $pages[] = $rec[1]; break;
					case 'template': break;					
					default        : if (!$rec[1]) 
										$items[] = $tid; 
				}		
			}	
			if ($attr1 = $rec[1]) {
				switch ($attr1) {
					case 'cartin'  : $cartin[] = $rec[0]; break;
					case 'cartout' : $cartout[] = $rec[0]; break;
					case 'checkout': $checkout[] = $rec[0];break;			
					default        : if (!$rec[0]) 
										$categories[] = $attr1;
				}		
			}	
		}
	}	
	
	//if currentDiv =, currentPage=, currentCat=, currentItem=
	if ($currentItem) { //search for item agent
		$aSQL = "SELECT script from pagents ";
		$aSQL.= "where code=" . $db->qstr($currentItem);
		//$res = $db->Execute($aSQL);
		//if ($res->fields[0]) {
			//load agent
			//..
			//switch ($currentDiv)
		//}	
		$d =  date('Y-m-d H:i:s');
	}
	elseif ($currentCategory) { //category instructions
		//switch ($currentDiv)
		$d =  date('H:i:s');
	}
	elseif ($currentPage) { //page instructions
		//switch ($currentDiv)
		$d =  date('Y-m-d');
	}
	else { //default instructions
		//switch ($currentDiv)
	
		if (stristr($referer, 'skroutz'))
			$d = date('d-m-Y H:i:s'); 
		elseif (stristr($referer, 'bestprice'))
			$d = date('d-m-Y H:i:s'); 
		else
			$d = /*$referer ? urldecode($referer) :*/ date('H:i:s');
		
		//$d =  date('Y-m-d H:i:s');
	}	
	
	//save showed messages to not replay	
	$pastMsg[$msgId] = $currentDiv;
	SetSessionParam('_PASTMSG', $pastMsg);
	
	//from newer to older (to do crm data sales,wishlists etc..)
	$agentSession = array('_MENUS'=>$menus, '_SEARCHES'=>$searches, '_FILTERS'=>$filters,
						'_ACTIONS'=>$actions, '_EVENTS'=>$events, '_PAGES'=>$pages,
						'_ITEMS'=>$items, '_CARTIN'=>$cartin, '_CARTOUT'=>$cartout,
						'_CATEGORIES'=>$categories,
						'_PASTMSG'=>$pastMsg, '_CRM'=>null,
						);	
	//$a = new agent($script, $agentSession);  				
	//$respond = $a->respond();
	
	$respond = $d ? _m("jsdialogStream.say use $d+++2000") : null;
	die($respond);
}
//else
echo $page->render(null,getlocal(),null,'empty.html');
?>
