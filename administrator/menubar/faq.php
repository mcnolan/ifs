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
	 *	File Name: faq.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("menubar/html/menufaq.php");
	$menu = new menufaq();

	$comcid = $cid[0];

	if ($comcid <> ""){
		$query = "SELECT published, approved FROM " . $mpre . "faqcont WHERE artid=$comcid";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$publish = $row->published;
			$approved= $row->approved;
		}
	}

	switch ($task){
		case "edit":
			if ($comcid==""){
				$comcid=$artid;
			}
			$menu->EDIT_MENU_Faq($comcid, $option, $categories, $publish, $approved);
			break;
		case "new":
			$menu->NEW_MENU_Faq($categories);
			break;

		default:
			$menu->DEFAULT_MENU_Faq($act, $option);
		}
?>