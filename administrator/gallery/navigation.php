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
	 *	File Name: navigation.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	session_start();
if (!session_is_registered("session_id"))
{
	print "<script> document.location.href='../index.php'</script>";
	exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Navigation</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
</head>

<body bgcolor="#FFFFFF">
<BR><BR><BR>
<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0">
<TR>
    <TD><A HREF="index.php?gal=0&image=jpg&directory=<?echo $directory;?>&Itemid=<?echo $Itemid;?>" TARGET="images">View Jpegs</A></TD>
</TR>
<TR>
    <TD><A HREF="index.php?gal=0&image=gif&directory=<?echo $directory;?>&Itemid=<?echo $Itemid;?>" TARGET="images">View Gifs</A></TD>
</TR>	
<TR>
    <TD><A HREF="index.php?gal=0&image=png&directory=<?echo $directory;?>&Itemid=<?echo $Itemid;?>" TARGET="images">View PNGs</A></TD>
</TR>
<TR>
    <TD><A HREF="index.php?gal=0&image=swf&directory=<?echo $directory;?>&Itemid=<?echo $Itemid;?>" TARGET="images">View swf</A></TD>
</TR>
<TR>
    <TD><A HREF="pdf.php" TARGET="images">List documents</A></TD>
</TR>
<TR>
	<TD><A HREF="uploadimage.php?directory=<?echo $directory;?>&Itemid=<?echo $Itemid;?>" TARGET="images">Upload</A></TD>
</TR>
</TABLE>


</body>
</html>
