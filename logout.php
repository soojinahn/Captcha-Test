<?php
include ("config.php");
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
init_set('display_errors', 1);

$sidvalue = session_id(); 
echo "<br>Your session id: " . $sidvalue . "<br>";

$_SESSION = array();		//Make $_SESSION  empty
session_destroy();			//Terminate session on server
setcookie("PHPSESSID", "", time()-3600);

echo "Your session is terminated."; 

?>
