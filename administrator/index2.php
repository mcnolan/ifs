<?
/**
*	Mambo Site Server Open Source Edition Version 4.0.11
*	Dynamic portal server and Content managment engine
*	27-11-2002
*
*	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
*	Distributed under the terms of the GNU General Public License
*	This software may be used without warrany provided these statements are left
*	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
*	This code is Available at http://sourceforge.net/projects/mambo
*
*	Site Name: Mambo Site Server Open Source Edition Version 4.0.11
*	File Name: index2.php
*	Developers: Danny Younes - danny@miro.com.au
*				Nicole Anderson - nicole@miro.com.au
*	Date: 27-11-2002
* 	Version #: 4.0.11
*	Comments:
*
* Modified December 2009 by Nolan (john.pbem@gmail.com) to work with register_globals off
**/


$relpath = "../";
require ("../classes/database.php");
$database = new database();

session_start();
session_register("session_id");
require("../includes/addslash.php");
$current_time = time();
$query = "UPDATE " . $mpre . "session SET time='$current_time' WHERE session_id='$session_id'";
$database->openConnectionNoReturn($query);


$past = time()-1800;
$query = "DELETE FROM " . $mpre . "session WHERE time < $past";
$database->openConnectionNoReturn($query);

if ($session_id){
	$query = "SELECT * FROM " . $mpre . "session WHERE session_id='$session_id'";
	$result2 = $database->openConnectionWithReturn($query);
	if (mysql_num_rows($result2) <> 1){
		print "<SCRIPT>document.location.href='index.php?moo'</SCRIPT>\n";
		exit();
	}
}
else {
	print "<SCRIPT>document.location.href='index.php?error=bleh'</SCRIPT>\n";
	exit();
}
?>
<html>
<head>
	<title>Mambo Site Server - Administration</title>
	<link rel="stylesheet" href="../themes/admin.css" type="text/css">
	<!--
		 Mambo Site Server Open Source Edition
		 Dynamic portal server and Content managment engine
		 27-11-2002

		 Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
<style type="text/css">

</style>
<script language="JavaScript1.2" src="js/rollover.js"></SCRIPT>
<script language="javascript" src="js/adminjavascript.js"></script>
</head>

<BODY bgcolor="#fffff5" leftmargin="0" rightmargin="0" topmargin="0">

<? if (($task != "edit") && ($task != "new") && ($task != "AddStep2") && ($task != "AddStep3") && ($task !="reply")) { ?>

<script type='text/javascript'>

//HV Menu v5- by Ger Versluis (http://www.burmees.nl/)
//Submitted to Dynamic Drive (http://www.dynamicdrive.com)
//Visit http://www.dynamicdrive.com for this script and more

function Go(){return}

</script>
<script type='text/javascript' src='js/mambomenu_var.js'></script>
<script type='text/javascript' src='js/menu_com.js'></script>
<noscript>Your browser does not support script</noscript>

<?}

include("menubar.php");
include ("../configuration.php");

if (phpversion() <= "4.2.1") {
	$browse = getenv("HTTP_USER_AGENT");
} else {
	$browse = $_SERVER['HTTP_USER_AGENT'];
}

if (preg_match("/MSIE/i", "$browse")){
	if (preg_match("/Mac/i", $browse)){
		$text_editor = false;
	}
	elseif (preg_match("/Windows/i", $browse)){
		$text_editor = true;
	}
}
elseif (preg_match("/Mozilla/i", "$browse")){
	if (preg_match("/Mac/i", $browse)){
		$text_editor = false;
	}
	elseif (preg_match("/Windows/i", $browse)){
		$text_editor = false;
	}
}
?>

<TABLE CELLSPACING="0" CELLPADDING="4" BORDER="1" BGCOLOR=#e2e2e2 bordercolor=#000000 WIDTH="98%" ALIGN=CENTER>
<TR>
    <TD bgcolor=#fffff5>
	<?

/* Show list of items to edit or delete or create new */
switch ($option){
	case "Components":
	include("components.php");
	break;
	case "News":
	if ($act == "categories"){
		include("category.php");
	}
	else {
		include("news.php");
	}
	break;
	case "Articles":
	if ($act == "categories"){
		include("category.php");
	}
	else {
		include("articles.php");
	}
	break;
	case "Faq":
	if ($act == "categories"){
		include("category.php");
	}
	else {
		include("faq.php");
	}
	break;
	case "Newsflash":
	include("newsflash.php");
	break;
	case "Survey":
	include("survey.php");
	break;
	case "Weblinks":
	if ($act == "categories"){
		include("category.php");
	}
	else {
		include("weblinks.php");
	}
	break;
	case "top10":
	include("top10.php");
	break;
	case "Current":
	$section="Current";
	include("banners_current.php");
	break;
	case "Finished":
	$section="Finished";
	include("banners_finished.php");
	break;
	case "Clients":
	include("bannerClient.php");
	break;
	case "Users":
	include("users.php");
	break;
	case "Administrators":
	include("../configuration.php");
	include("administrators.php");
	break;
	case "MenuSections":
	include("menusections.php");
	break;
	case "SubSections":
	include("subsections.php");
	break;
	case "newsfeeds":
	include("newsfeeds.php");
	break;
	case "logout";
	include("logout.php");
	break;
	case "statistics":
	include("statistics.php");
	break;
	case "contact":
	include ("contact.php");
	break;
	case "systemInfo":
	include ("systemInfo.php");
	break;
	case "phpMyAdmin":
	include ("phpMyAdmin.php");
	break;
	case "module_installer":
	include ("module_installer.php");
	break;
	case "Forums":
	if ($act == "threads"){
		include("threads.php");
	}else {
		include("forums.php");
	}
	break;
	default:
}
	?>
	</TD>
</TR>
</table>
</BODY>
</HTML>
