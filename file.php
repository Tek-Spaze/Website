<?php
$GLOBALS['q']	= array();
$init_query	= array();
$error_404		= false;
$inc_build		= null;
$uri_exp		=explode('/', substr($_SERVER['REQUEST_URI'],1));

if ($uri_exp[0] !== "file"){
	header('location: /404');exit();
}else if(file_exists('code/'.$uri_exp[1].'/'.$uri_exp[2].'.'.$uri_exp[1])){
	switch($uri_exp[1]){
		case 'css':
			header("Content-Type: text/css");require('code/'.$uri_exp[1].'/'.$uri_exp[2].'.'.$uri_exp[1]);
			break;
		case 'js': 
			header('Content-Type: text/javascript');require('code/'.$uri_exp[1].'/'.$uri_exp[2].'.'.$uri_exp[1]);
			break;	
		case 'png':case 'svg':
			header('location: /code/'.$uri_exp[1].'/'.$uri_exp[2].'.'.$uri_exp[1]);
			break;
		default:
			header('location: /404');exit();
	}
	
}else{
	header('location: /404');exit();
}

?>