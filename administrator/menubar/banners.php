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
	 *	File Name: banners.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("menubar/html/menudefault.php");

	if ($option=="Current"){
		require ("menubar/html/menubanners_current.php");
		$menu = new menubanners();

		switch ($task){
			case "edit":
				$comcid = $cid[0];
				$menu->EDIT_MENU_Banners($comcid, $option, $database, $mpre);
				break;
			case "new":
				$menu->NEW_MENU_Banners();
				break;
			default:
				$default = new MENU_Default($act, $option);
		}
	}else if ($option=="Finished"){
		require ("menubar/html/menubanners_finished.php");
		$menu = new menubanners();

		switch ($task){
			case "edit":
				$comcid = $cid[0];
				$menu->EDIT_MENU_Banners($comcid, $option);
				break;
			case "new":
				$menu= new MENU_Default($act, $option);
				break;
			default:
				$default = new MENU_Default($act, $option);
		}
	}
?>

