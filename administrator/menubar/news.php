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
	 *	File Name: news.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("menubar/html/menunews.php");
	$menu = new menunews();

	$comcid = $cid[0];

	switch ($task){
		case "edit":
			$comcid = $cid[0];
			if ($comcid==""){
				$comcid=$id;
			}
			$menu->EDIT_MENU_News($database, $comcid, $option, $categories, $mpre);
			break;
		case "new":
			$menu->NEW_MENU_News($categories);
			break;
		default:
			$menu->DEFAULT_MENU_News($act, $option);
		}
?>