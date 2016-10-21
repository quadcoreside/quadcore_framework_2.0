<?php
	$debut = microtime(true);

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	date_default_timezone_set('Europe/Paris');

	define('WEBROOT', dirname(__FILE__));
	define('ROOT', dirname(WEBROOT));
	define('DS', DIRECTORY_SEPARATOR);
	define('CORE', ROOT.DS.'core');
	define('HELPER', ROOT.DS.'helpers');
	define('LIBRARIES', ROOT.DS.'libraries');
	define('DATAS', ROOT.DS.'datas');
	define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));

	require CORE.DS.'Includer.php';
	new Dispatcher();

	if(Conf::$debug > 1){
	    echo '<br style="padding:10 100 10 100;"><div style="position:fixed; bottom:0; background:#900; color:#FFF; line-heght:30px; height:30px; left:0; right:0; padding-left:10px;">
			Page genere: ' . round(microtime(true) - $debut, 6) . ' ms  ';
		echo (Session::isLogged()) ? '<b style="color:green;"> Session User true </b> |' : ' Session User false  |';
		echo (Session::isLoggedAdm()) ? '<b style="color:green;"> Session Admin true </b>|' : ' Session Admin false |';
		echo (isset($_SESSION['csrf'])) ? '<b style="color:green;"> CSRF: '.$_SESSION['csrf'].' </b>|' : ' No CSRF TOKEN';
		echo '</div>';
	}

?>
