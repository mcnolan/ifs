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
	 *	File Name: subsections.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("menubar/html/menusubsections.php");
	$menu = new menusubsections();

	require ("menubar/html/menudefault.php");

	switch ($task){
		case "edit":
			if (trim($checkedID)!=""){
				$comcid = $checkedID;
			}else{
				$comcid=$cid[0];
			}
			$menu->EDIT_MENU_subsections($comcid, $option, $database, $categories, $mpre);
			break;
		case "new":
			$menu->NEW_MENU_subsections($option, $sections);
			break;
		case "AddStep2":
			if (trim($ItemType)!="Own"){
				$menu->SAVE_MENU_subsections($option, $sections, $ItemType);
			}else{
				$menu->NEW_MENU_subsections($option, $sections);
			}
			break;
		case "AddStep3":
			$menu->SAVE_MENU_subsections($option, $sections, $PageSource);
			break;
		default:
			$default = new MENU_Default($act, $option);
		}
?>

