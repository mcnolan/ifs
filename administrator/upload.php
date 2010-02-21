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
	 *	File Name: upload.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments: 
	**/
?>
<html>
<head>
	<title>File Upload</title>
	<link rel="stylesheet" href="../css/admin.css" type="text/css">
	<!--
		 Mambo Site Server Open Source Edition
		 Dynamic portal server and Content managment engine
		 27-11-2002
 
		 Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
</head>
<body>
<?if (($bannerid!="") || ($newbanner==1)){
		$choice="saveUploadNew"?>
	<FORM ENCTYPE="multipart/form-data" ACTION="banners_current.php" METHOD=POST NAME="filename">
		<table border=0 bgcolor=FFFFFF cellpadding=4 cellspacing=0 width=99%>
			<TR>
				<TD align="left"><span class='componentHeading'>Upload An Image</span></TD>
			</TR>
			<TR>
				<TD ALIGN="Left">Upload file:  <INPUT NAME="userfile" TYPE="file"></TD>
			</TR>
			<TR>
				<TD>
					<input type=hidden name=task value="<? echo $choice;?>">
					<input type=hidden name=bannerid value="<?echo $bannerid;?>">
					<INPUT TYPE="submit" VALUE="Send File">
				</TD>
			</TR>
		</TABLE>
	</FORM>
	<a href="javascript: window.opener.focus; window.close();">Close</a>
			
<?}else if ($sectionid!=""){
	if ($option=="MenuSections"){?>
		<FORM ENCTYPE="multipart/form-data" ACTION="menusections.php" METHOD=POST NAME="filename">
	<?}else if ($option=="SubSections"){?>
		<FORM ENCTYPE="multipart/form-data" ACTION="subsections.php" METHOD=POST NAME="filename">
	<?}?>
		<TABLE WIDTH="99%" CELLPADDING="0" CELLSPACING="3" BORDER="0" bgcolor=ffffff>
		<TR><TD class='componentHeading'>Upload Images</TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile1" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile2" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile3" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile4" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD ALIGN="LEFT" WIDTH="360"><INPUT NAME="userfile5" TYPE="file"></TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR><TD><input type=hidden name=task value="saveUploadImage">
				<input type=hidden name=sectionid value="<?echo $sectionid;?>">
				<INPUT TYPE="submit" VALUE="Send File(s)"></TD></TR>
	</TABLE></CENTER>
	</FORM>
	<a href="javascript:window.opener.focus; window.close();">Close</a>
 <?}?>
 </body>
 </html>
