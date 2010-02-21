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
	 *	File Name: blank.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	if (phpversion() <= "4.2.1") {	
		$browse = getenv("HTTP_USER_AGENT");
	} else {
		$browse = $_SERVER['HTTP_USER_AGENT'];
	}
	if ((preg_match("/MSIE/i", "$browse")) && (preg_match("/mac/i", "$browse")))
		$width = "100%";
	else
		$width = "45%";
?>

<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
<TR>
	<TD WIDTH="47%" VALIGN="top"><? include ("menubar/mainmenu.php"); ?></TD>
	<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
	<TD VALIGN="top" BGCOLOR="#999999" WIDTH="100%">
		<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="100%" BGCOLOR="#999999">
		<TR>
			<TD WIDTH="100%">&nbsp;</TD>
		</TR>
		</TABLE>
	</TD>
</TR>
<TR>
	<TD WIDTH="370">&nbsp;</TD>
	<TD VALIGN="bottom" ALIGN="left" BGCOLOR="#999999"><img name="shadow" src="../images/admin/shadow.gif" width="100%" height="10" border="0" VSPACE="0" HSPACE="0"></TD>
</TR>
</TABLE>
