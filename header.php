<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';
// die;
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { 
    $protocol = 'https';
    define("STRIPE_MODE", 'LIVE');
} else {
	define("STRIPE_MODE", 'TEST');
    $protocol = 'https';
}

$cur_dirname = basename(__DIR__);
 
if($cur_dirname=='public_html'){
	$cur_dirname = '';
	$cur_dir = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], chr($cur_dirname))).$cur_dirname."/booking/";
} else {
	$cur_dir = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], $cur_dirname)).$cur_dirname."/";
}


$dots = explode(".",$_SERVER['HTTP_HOST']);
if(sizeof((array)$dots)>2 && $dots[0]!='www' && strlen($dots[1])>3){
 /*define("ROOT_PATH", substr($_SERVER["DOCUMENT_ROOT"],0,-1).'/');*/
 define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"].'/');
 define("BASE_URL", $protocol.'://'.$_SERVER['HTTP_HOST'].'/');
 define("SITE_URL",$protocol.'://'.$_SERVER['HTTP_HOST'].'/');
 define("AJAX_URL",$protocol.'://'.$_SERVER['HTTP_HOST'].'/assets/lib/');
 define("FRONT_URL",$protocol.'://'.$_SERVER['HTTP_HOST']."/front/");
}else{
 /*define("ROOT_PATH", substr($_SERVER["DOCUMENT_ROOT"],0,-1) .$cur_dir);*/
 define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] .$cur_dir);
 define("BASE_URL", substr($cur_dir,0,-1));
 define("SITE_URL",$protocol.'://'.$_SERVER['HTTP_HOST'].$cur_dir);
 define("AJAX_URL",$protocol.'://'.$_SERVER['HTTP_HOST'].$cur_dir.'assets/lib/');
 define("FRONT_URL",$protocol.'://'.$_SERVER['HTTP_HOST'].$cur_dir.'front/');
}

define("STRIPE_LIB_PATH", (dirname(__FILE__).'/assets/stripe/init.php'));

?>