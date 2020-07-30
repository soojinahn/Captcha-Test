<?php
include ("config.php");
include ("myfunctions.php") ;
session_start();


$db = connection();

if(!isset($_SESSION["captcha"])){
  
  echo "Please do captcha test.";
  header("refresh: 2 ; url = authForm.php");
  exit();

}

if(isset($_GET["ucid"])){
  
  $flag = true;
  
  $ucid = safe("ucid");
  $pass = safe("pass");
  $amount = safe("amount");
  $delay = $_GET["delay"];
  
  if(!$flag){
    header("refresh: $delay ; url=auth.php");   
    echo "<br> Redirecting.";
    exit();
  }
  
  if (! authenticate($ucid, $pass)){ 
  
      echo "Not authenticated. Please login again.";
      header("refresh: $delay ; url=auth.php");
      exit();
    }
    
  else 
    { 
    
      $_SESSION["logged"] = true;
      $_SESSION["ucid"] = $ucid;
      
      echo "Authenticated. Please wait.";
      header("refresh: $delay ; url=pin1.php");
     
      exit();
    }

}

?>

<form action =  "auth.php">

<input type=  text name=  "ucid" autocomplete = "off">  ucid <br><br>
<input type=  text name=  "pass" autocomplete = "off">  pass <br><br>
<input type = test name = "amount" autocomplete = "off"> amount <br><br>
<input type=  text name=  "delay" autocomplete = "off">  delay <br><br>

<input type=  submit>

</form>

