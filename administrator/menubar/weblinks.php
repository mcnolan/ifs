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
	 *	File Name: weblinks.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("menubar/html/menuweblinks.php");
	$menu = new menusweblinks();

	require ("menubar/html/menudefault.php");

	$comcid = $cid[0];

	if ($comcid <> ""){
		$query = "SELECT published, approved FROM " . $mpre . "links WHERE lid=$comcid";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$publish = $row->published;
			$approved = $row->approved;
			}
		}

	switch ($task){
		case "edit":
			if ($comcid==""){
				$comcid=$lid;
			}
			$menu->EDIT_MENU_Weblinks($comcid, $option, $categories, $publish, $approved);
			break;
		case "new":
			$menu->NEW_MENU_Weblinks($categories);
			break;
		default:
			$default = new MENU_Default($act, $option);
		}
?>