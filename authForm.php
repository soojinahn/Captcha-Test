<?php
include("myfunctions.php");
include("config.php");
session_start();


if(isset($_GET["guess"])){
  
  $guess = $_GET["guess"];
  $delay = $_GET["delay"];
  $text = $_SESSION["captcha"];
  
  if($guess == $text){
    $_SESSION["captcha"] = true;
    echo "Your captcha guess was right. <br>";
    header("refresh: $delay ; url = auth.php");
    exit();
  }
  else{
    echo "Your captcha guess was wrong. <br>";
    exit();
  }
  
}

?>

<img src = "captcha.php" width = 275> <br><br>

<form action = "authForm.php">

<input type = "text" size = 10 name = "guess" autocomplete = off>
  what is the captcha text?<br>

<input type = "text" size = 10 name = "delay" autocomplete = off>
    delay<br>  

<input type = "submit" value = "Submit">

</form>

