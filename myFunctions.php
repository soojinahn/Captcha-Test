<?php


function connection()  {

  include("account.php");

  error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);  
  ini_set('display_errors' , 1);

  $db = mysqli_connect($hostname, $username, $password, $project);

  if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
  }

  mysqli_select_db( $db, $project ); 

  return $db;


}


function authenticate($ucid, $pass)  {

  global $db;

  $s = "select * from users where ucid = '$ucid'";
  ($t = mysqli_query($db,$s)) or die (mysqli_error($db));
  $num = mysqli_num_rows($t);
  
  $r = mysqli_fetch_array($t, MYSQLI_ASSOC);
  $hash = $r['hash'];


  if ($num == 0 || !password_verify($pass, $hash))  {return false;}
  else  {return true;}
  
}
  
  
function safe($name)  {
  global $flag;
  global $db;
  
  $value = $_GET[$name];
  $value = trim($value);   
  
  if($value != ""){$value = mysqli_real_escape_string($db, $value);}
  else{ return $value; }
  
  if($name == "ucid"){
    $count = preg_match('/^[a-zA-Z]{2,4}[0-9]{0,4}$/', $value, $matches);
    
    if($count == 0){
      $flag = false;
      echo "Illegal ucid format. Please try again.";
      return;
    }
  }
  
  else if($name == "pass"){
    $count = preg_match('/^([a-zA-Z0-9\?\*]){3,5}$/', $value, $matches);
    
    if($count == 0){
      $flag = false;
      echo "Illegal password format. Please try again.";
      return;
    }
  
  }
  
  else if($name == "amount"){
    $count = preg_match('/^[+-]?[1-9]{0,5}0{0,2}\.\d{2}$/', $value, $matches);
    
    if($count == 0){
      $flag = false;
      echo "Illegal amount entered. Please try again.";
      return;
    }
  }
  
  return $value;
  
}
 
 
  
function transact($ucid, $account, $amount)  {

    global $db;
    
    $s = "update accounts set balance = balance + '$amount', recent = NOW() where ucid='$ucid' and account='$account' and balance + $amount >= 0.00";
    
    ($t =mysqli_query($db,$s) ) or die (mysqli_error($db));
    $num = mysqli_affected_rows($db);
    
    
    if($num == 0){
      echo "<br> Error: either overdraft or invalid account."; return;
    }
    
    
    $s = "insert into transactions values ('$ucid', '$account', '$amount', NOW(),'N')";
    ($t = mysqli_query($db,$s) ) or die (mysqli_error($db));
  
    

  }
  
  
  
function retrieve($ucid, $number)  {
    
    global $db;
      
   $s2 = "select * from accounts where ucid = '$ucid'";
   ($t2 = mysqli_query($db,$s2)) or die (mysqli_error($db));

  while($r2 = mysqli_fetch_array($t2, MYSQLI_ASSOC)){
    $id = $r2["ucid"];
    $acct = $r2["account"];
    $balance = $r2["balance"];

    echo "<hr><b> $id &nbsp; $acct &nbsp; \$$balance &nbsp; most recent </b><br>";
  
    $s1 = "select * from transactions where ucid = '$ucid'  and account = '$acct' LIMIT $number";
    ($t1 = mysqli_query($db,$s1)) or die (mysqli_error($db));


    while($r1 = mysqli_fetch_array($t1, MYSQLI_ASSOC)){
      $amount = $r1["amount"];
      $timestamp = $r1["timestamp"];
      $mail = $r1["mail"];

      echo "<br><i> \$$amount &nbsp $timestamp &nbsp mail copy: '$mail'</i>";
      
      
      }
    
    
    }
    
  }
  
  
  
function clear($ucid, $account)  {

    global $db;
    
    $s = "delete from transactions where ucid = '$ucid' and account = '$account'";
    ($t = mysqli_query($db,$s)) or die (mysqli_error($db));
    
    $s1 = "update accounts set balance = '0.00'  and recent = '0000-01-01 00:00:01' where ucid = '$ucid' and account = '$account'";
    
    ($t1 = mysqli_query($db,$s1)) or die (mysqli_error($db));
    
    
  }
  
  
?>



  
