<?php
ini_set('display_errors','On'); 
date_default_timezone_set("Europe/Copenhagen");
session_start();
error_reporting(E_ALL);
include "./classes/User.php";
include "./classes/Event.php";
include "./classes/Page.php";
include "./classes/Navigation.php";
include "./classes/pages/LoginPage.php";
include "./classes/pages/CreateEventPage.php";
include "./classes/pages/EventOverviewPage.php";
include "./classes/pages/EditEventPage.php";
include "./classes/pages/ErrorPage.php";
include "./classes/pages/EventPage.php";
include "./classes/pages/SettingsPage.php";
include "./classes/pages/LogoutPage.php";
include "./classes/pages/ViewEventPage.php";
include "config.php";
include "pages.php";



///////////////////////////////////////////////////////
//Command logic
$requestURI = explode('/',$_SERVER['REQUEST_URI']);
$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
$commandArr = array_values(array_diff_assoc($requestURI, $scriptName));
$command = isset($commandArr[0]) ? $commandArr[0] : '';
$params = array_slice($commandArr,1);


$currentuser = User::Current();

///////////////////////////////////////////////////////
//Page logic
foreach ($pages as $page)
{
    if ($page['command'] == $command || $page['command'] == '_ANY_')
    {
        if (preg_match('/'.$currentuser->type.'/',$page['usertype']))
            $currentpage = $page['page'];
    }
}
if (!isset($currentpage))
	$currentpage = new ErrorPage();


$reload = $currentpage->consumePost($command, $params,$currentuser);
if ($reload !== false)
{
    header("Location: $reload");
	die();
}
$basefolder = explode('index.php',$_SERVER['PHP_SELF']);
$basefolder = $basefolder[0];
$baseurl = 'http://'.$_SERVER['SERVER_NAME'].$basefolder;
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="ISO-8859-1">
    <title>FMK <?php echo "$command - [" . implode(',',$params)."]";?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FMK.NU - FYNS MUSIK KONTOR - ARTISTS' BOOKING">
    <meta name="author" content="GreveIT / E-nygaard">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="apple-touch-icon" sizes="72x72" href="img/touch-icon-ipad.png" />
    <!--<link rel="shortcut icon" href="img/favicon.ico">-->
    <!--<link rel="apple-touch-icon" href="touch-icon-iphone.png" />-->
    <!--<link rel="apple-touch-icon" sizes="114x114" href="touch-icon-iphone4.png" />-->

    <base href="<?php echo $baseurl; ?>"/>
    
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
	
    <?php 
    $nav = new Navigation();
    $nav->show($command,$params,$currentuser); 
    //echo "Type:".User::Current()->type;
    ?>

    <?php $currentpage->show($command, $params,$currentuser);?>

  </body>
</html>


