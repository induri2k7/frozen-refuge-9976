<?php
require 'lib/facebook.php';
require 'lib/fbconfig.php';

echo 'ram';
$user = $facebook->getUser();
if ($user)
{
$logoutUrl = $facebook->getLogoutUrl();
try
{
$userdata = $facebook->api('/me');
}
catch (FacebookApiException $e) {
error_log($e);
$user = null;
}
$_SESSION['facebook']=$_SESSION;
$_SESSION['userdata'] = $userdata;
$_SESSION['logout'] = $logoutUrl;
//Redirecting to home.php
header("Location: home.php");
}
else
{
$loginUrl = $facebook->getLoginUrl(array(
 'scope' => 'email,user_birthday'
));
echo '<a href="'.$loginUrl.'">Login with Facebook</a>';
}
?>
