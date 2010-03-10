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
	 *	File Name: view.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<HTML>
<HEAD>
<?
include "conf.php";
print "<TITLE>$title[$gal]</TITLE></HEAD>";
print "<BODY BACKGROUND=\"\" BGCOLOR=\"#ffffff\" TEXT=\"#000000\" LINK=\"#0000ff\" VLINK=\"#800080\" ALINK=\"#ff0000\">";
include "banner.php";
print "<h1 align=\"center\"><a href=\"index.php?gal=$gal&pg=$pg\">$title[$gal]</a></h1>";
$path=$picurl[$gal]."/".$id;
print "<center><img src=\"$path\" ></center>";
include "bannerbot.php";
?>
</BODY>
</HTML>
