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
	 *	File Name: bannerClient.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	require ("menubar/html/menudefault.php");
	
	require ("menubar/html/menubannerClient.php");
	$menu = new menubannerClient();
	
	switch ($task){
		case "edit":
			$comcid = $cid[0];
			$menu->EDIT_MENU_Banners($comcid, $option);
			break;
		case "new":
			$menu->NEW_MENU_Banners();
			break;
		default:
			$menu->DEFAULT_MENU_Banners($act, $option);
	}
?>

