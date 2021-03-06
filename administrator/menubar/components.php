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
	 *	File Name: components.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("menubar/html/menucomponents.php");
	$menu = new menucomponents();

	require ("menubar/html/menudefault.php");
	print $module;

	switch ($task){
		case "edit":
			$comcid = $cid[0];
			$menu->EDIT_MENU_Components($database, $option, $comcid, $module, $mpre);
			break;
		case "new":
			$menu->NEW_MENU_Components();
			break;
		default:
			$default = new MENU_Default($act, $option);
		}
?>
