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
	 *	File Name: componentwindow.php
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
	
	$query = "SELECT components.module AS module, components.title AS title, component_module.content AS content FROM components, component_module WHERE components.id='$id' AND components.id = component_module.componentid";
	$result = openConnectionWithReturn($query);
	while ($row = mysql_fetch_object($result)){
		$title = $row->title;
		$content = $row->content;
		$module = $row->module;
		}
	$pat= "SRC=images";
	$replace= "SRC=../../images";
	$pat2="\\\\'";
	$replace2="'";
	$content=eregi_replace($pat, $replace, $content);
	$content=eregi_replace($pat2, $replace2, $content);
	$title=eregi_replace($pat2, $replace2, $title);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Components</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
	<!--
		 Mambo Site Server Open Source Edition
		 Dynamic portal server and Content managment engine
		 27-11-2002
 
		 Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
	
	<SCRIPT>
		var content = window.opener.document.adminForm.content.value;  
		var title = window.opener.document.adminForm.mytitle.value;
		
		content = content.replace('#', '');
		title = title.replace('#', '');
		content = content.replace('SRC=images', 'SRC=../../images');
		content = content.replace('SRC=images', 'SRC=../../images');
		title = title.replace('src=images', 'src=../../images');
		content = content.replace('src=images', 'src=../../images');
		title = title.replace('SRC=\"images', 'SRC=\"../../images');
		content = content.replace('SRC=\"images', 'SRC=\"../../images');
		title = title.replace('src=\"images', 'src=\"../../images');
		content = content.replace('src=\"images', 'src=\"../../images');
		
	</SCRIPT>
</head>

<body>
	<TABLE ALIGN="center" WIDTH="160" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
	<TR>
	    <TD CLASS="componentHeading"><SCRIPT>document.write(title);</SCRIPT></TD>
	</TR>
	<TR>
	    <TD VALIGN='top' HEIGHT='90%'><SCRIPT>document.write(content);</SCRIPT></TD>
	</TR>
	<TR>
	    <TD ALIGN='center'><A HREF="#" onClick="window.close()">Close</A></TD>
	</TR>
	</TABLE>


</body>
</html>
