<?php
/**
* Copyright 2011 Facebook, Inc.
*
* Licensed under the Apache License, Version 2.0 (the "License"); you may
* not use this file except in compliance with the License. You may obtain
* a copy of the License at
*
* http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
* WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
* License for the specific language governing permissions and limitations
* under the License.
*/

require 'lib/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId' => '242494765877295',
  'secret' => '60445fb3c27ab2f43211537d3ff0200f',
));

// Get User ID
$facebook->setAccessToken($initMe["accessToken"]);

$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl( array('scope' => 'email,read_stream'));
  
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Fb App</title>
<style>
body {
font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
}
h1 a {
text-decoration: none;
color: #3b5998;
}
h1 a:hover {
text-decoration: underline;
}
</style>
</head>
<body>
<img src="../Pennant.gif"/>

<?php if ($user): ?>
<a href="<?php echo $logoutUrl; ?>">Logout</a>
<?php else: ?>
<div>
Login using OAuth 2.0:
<a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
</div>
<?php endif ?>



<?php if ($user): ?>
<pre><img src="https://graph.facebook.com/<?php echo $user; ?>/picture"></pre>

<pre><?php print_r($user_profile['username']); ?></pre>
<pre><?php print_r($user_profile['email']); ?></pre>
<pre><?php print_r($user_profile['link']); ?></pre>



<?php
$file = 'data.txt';

$searchfor = $user_profile['username'];

// the following line prevents the browser from parsing this as HTML.
header('Content-Type: text/plain');

// get the file contents, assuming the file to be readable (and exist)
$contents = file_get_contents($file);
// escape special characters in the query
$pattern = preg_quote($searchfor, '/');
// finalise the regular expression, matching the whole line
$pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
if(preg_match_all($pattern, $contents, $matches)){
   echo "Already Registered:\n";
   echo implode("\n", $matches[0]);
}
else{

$fp = fopen('data.txt', 'a');
fwrite($fp,"\n");
fwrite($fp, $user_profile['username']);
fwrite($fp,",");
fwrite($fp, $user_profile['email']);
fwrite($fp,",");
fwrite($fp, $user_profile['link']);
fclose($fp);
$message = "Dear Sir/Madem,\n \n Now your successfully Registered with Pennant technologies in Facebook.\n Now you are going to get Banking alerts to Your Facebook account as a notification.\n Enjoy Banking on Facebook.\n\n Thanks,\n Pennant Technologies";//""Dear" +$user_profile['userid']+", We Received your details from Facebook""; //\n User Name:' $user_profile['username'] '\n Email:' $user_profile['email']' . Kindly Let us know if you find any issues /n Thanks,/n Pennant Technologies";

// In case any of our lines are larger than 120 characters, we should use wordwrap()
$message = wordwrap($message, 120);

// Send
mail($user_profile['email'], 'Details of Facebook Account', $message);
   }



?>



<pre> <src="https://graph.facebook.com/<?php echo $user_profile['userid']; ?>?fields=id,name,address"> </pre>



<?php else: ?>
<strong><em>You are not Connected.</em></strong>
<?php endif ?>


</body>
</html>
