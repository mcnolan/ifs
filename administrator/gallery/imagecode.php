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
	 *	File Name: imagecode.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Mambo Site Server - Image Gallery</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">

<SCRIPT LANGUAGE="javascript">
<!--
	function changePosition(positionimage){
		
		var original = new String(document.codeimage.imagecode.value);
		if (positionimage == "left"){
			var express = /ALIGN=right/g;
			var newString = original.replace(express, "ALIGN=left");
			}
		else {
			var express = /ALIGN=left/g;
			var newString = original.replace(express, "ALIGN=right");
			}
		document.codeimage.imagecode.value = newString;
		}
	function windowclose(){
		parent.window.close();
		}
//-->
</SCRIPT>

</head>

<body bgcolor="#FFFFFF">
<FORM NAME="codeimage">
<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0" ALIGN="center">
<TR>
    <TD>Image Code:</TD>
    <TD><INPUT TYPE="text" NAME="imagecode" SIZE="75"></TD>
	<TD><INPUT TYPE="radio" NAME="position" VALUE="left" CHECKED onClick="changePosition('left')";>Left</TD>
    <TD><INPUT TYPE="radio" NAME="position" VALUE="right" onClick="changePosition('right')";>Right</TD>
</TR>
<TR>
	<TD ALIGN="center" COLSPAN="3"><A HREF="#" onClick="windowclose()">Close</A></TD>
</TR>
</TABLE>
</FORM>

</body>
</html>

