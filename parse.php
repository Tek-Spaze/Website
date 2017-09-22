<?php
$GLOBALS['q']	= array();
$init_query	= array();
$error_404		= false;
$inc_build		= null;
$uri_exp		=explode('/', substr($_SERVER['REQUEST_URI'],1));

foreach($uri_exp as $part){
	if(is_dir($inc_build.$part)){
		$inc_build .= $part.'/';
	}else if(file_exists($inc_build.$part.'.php')){
		$inc_build .= $part.'.php';
	}else{
		$init_query[] = $part;
	}
}
if (!empty($init_query)){
	foreach($init_query as $key => $bit){
		$GLOBALS['q'][$bit]	= ($key !== (count($init_query)-1)) ? $init_query[$key + 1] : null;
	}
}
$inc_build .= (substr($inc_build, - 4) !== '.php' && file_exists($inc_build.'index.php'))?'index.php':null;
$error_404 = (!empty($init_query[0]) && $inc_build === 'index.php')? true:false;
if (!empty($uri_exp)){
	switch($uri_exp[0]){
		case 'parse': 
			$error_404=true;
		case 'template': 
			$error_404=true;
	}
}
require ($error_404) ? '404/index.php': $inc_build;
?>