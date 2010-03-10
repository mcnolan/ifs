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
	 *	File Name: surveywindow.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	
	function database(){
		include ("../../configuration.php");
		mysql_connect($host, $user, $password);
		}
			
	function openConnectionWithReturn($query){
		include ("../../configuration.php");
        $result = mysql_db_query($db, $query) or die("Did not execute query");
        return $result;
        }

    function openConnectionNoReturn($query){
		include ("../../configuration.php");
        mysql_db_query($db, $query) or die("Did not execute query");
        }
	
	database();
	

	$query = "SELECT pollTitle FROM poll_desc WHERE pollID='$id'";
	$result=openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$title = $row->pollTitle;
		}
	mysql_free_result($result);
	
	$query = "SELECT optionText FROM poll_data WHERE pollid='$id' order by voteid";
	$result = openConnectionWithReturn($query);
	$i = 0;
	while ($row = mysql_fetch_object($result)){
		$optionText[$i] = $row->optionText;
		$i++;
		}
	mysql_free_result($result);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Survey Preview</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
	<!--
		 Mambo Site Server Open Source Edition
		 Dynamic portal server and Content managment engine
		 27-11-2002
 
		 Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
</head>

<body bgcolor="#FFFFFF">
	<FORM>
	<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" >
	<TR>
	    <TD CLASS="componentHeading" COLSPAN='2'><? echo $title; ?></TD>
	</TR>
	<? for ($i = 0; $i < count($optionText); $i++){ 
		if ($optionText[$i] <> ""){
	?>
	<TR>
	    <TD VALIGN='top' HEIGHT='30'><INPUT TYPE="radio" NAME="survey" VALUE="<? echo $optionText[$i]; ?>"></TD><TD WIDTH="100%" VALIGN="top"><? echo $optionText[$i]; ?></TD>
	</TR>
	<? } ?>
	<? } ?>
	<TR>
	    <TD VALIGN='middle' HEIGHT='50' COLSPAN='2' ALIGN='center'><INPUT TYPE="button" NAME="submit" VALUE="Vote">&nbsp;&nbsp;<INPUT TYPE="button" NAME="result" VALUE="Results"></TD>
	</TR>
	<TR>
	    <TD ALIGN='center' COLSPAN='2'><A HREF="#" onClick="window.close()">Close</A></TD>
	</TR>
	</TABLE>
	</FORM>



</body>
</html>
