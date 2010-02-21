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
	 *	File Name: logout.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	$relpath = "../";
	require ("../classes/database.php");
	$database = new database();

	session_start();
    session_register("userid");

	$query = "DELETE FROM " . $mpre . "session WHERE userid='$userid'";
	$database->openConnectionNoReturn($query);

	$myname="";
	$fullname="";
	$userid="";
	$session_id = "";

	session_unregister("myname");
	session_unregister("fullname");
	session_unregister("userid");
	session_unregister("session_id");

	if (session_register("myname")){session_destroy();}
	if (session_register("fullname")){session_destroy();}
	if (session_register("userid")){session_destroy();}
	if (session_register("sessionid")){session_destroy();}

	print "<SCRIPT>document.location.href='../index.php';</SCRIPT>\n";
?>