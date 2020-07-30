<?php
include ("config.php");
session_start();


$font = 'LaBelleAurore.ttf';
$font1 = 'Xenotron.ttf';
$font2 = 'XeroxSans.ttf';

header('Content-Type: image/png');

$im = imagecreatetruecolor(400, 200);



$black = imagecolorallocate($im, 0, 0, 0);
$blue = imagecolorallocate($im,26,35,126);
$gray = imagecolorallocate($im,224,224,224);
$red = imagecolorallocate($im,255,0,0);
$green = imagecolorallocate($im, 0,128,0);

imagefill($im, 0,0, $blue);

imagefilledrectangle($im, 10, 10, 390, 190, $gray);

$length = 4;

$random = substr(str_shuffle(md5(time())), 0, $length);

$text = substr($random, 0, 2);
$text1 = substr($random, 2, 4);

$_SESSION["captcha"] = $random;

$sidvalue = session_id(); 
$text2 =  "session id: $sidvalue";
$text3 = "captcha: $random";


imagettftext($im, 25, -30, 50, 50, $red, $font, $text);
imagettftext($im, 25, 0, 200, 100, $green, $font1, $text1);
imagettftext($im, 15, 0, 20, 165, $black, $font2, $text2);
imagettftext($im, 15, 0, 20, 183, $black, $font2, $text3);

imagepng($im);

imagedestroy($im);


?>
