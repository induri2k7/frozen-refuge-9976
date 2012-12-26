<?php
require 'lib/facebook.php';
require 'lib/fbconfig.php';
session_start();
$facebook=$_SESSION['facebook'];
$userdata=$_SESSION['userdata'];
$logoutUrl=$_SESSION['logout'];
echo $userdata['id'];
//Facebook Access Token
$access_token_title='fb_'.$facebook_appid.'_access_token';
$access_token=$facebook[$access_token_title];
if(!empty($userdata))
{
$facebook_id=$userdata['id'];
$name=$userdata['name'];
$first_name=$userdata['first_name'];
$last_name=$userdata['last_name'];
$email=$userdata['email'];
$gender=$userdata['gender'];
$birthday=$userdata['birthday'];
$location=mysql_real_escape_string($userdata['location']['name']);
$hometown=mysql_real_escape_string($userdata['hometown']['name']);
$bio=mysql_real_escape_string($userdata['bio']);
$relationship=$userdata['relationship_status'];
$timezone=$userdata['timezone'];

echo $facebook_id;
echo $name;
echo $first_name;
echo $last_name;
echo $email;

// Update or Post Facebook wall. 
include('status_update.php');
}
else
{
header("Location: fblogin.php");
}
?>
