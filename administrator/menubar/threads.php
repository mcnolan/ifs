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
	 *	File Name: threads.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("menubar/html/menuthreads.php");
	$menu = new menuthreads();

	$comcid = $cid[0];

	if ($comcid <> ""){
		$query = "SELECT published FROM " . $mpre . "messages WHERE ID=$comcid";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$publish = $row->published;
		}
	}

	switch ($task){
		case "edit":
			$comcid = $cid[0];
			if ($comcid==""){
				$comcid=$tid;
			}
			$menu->EDIT_MENU_Threads($comcid, $option, $publish, $forum);
			break;
		case "new":
			if ($cat <> ""){
				$forum = $cat;
				}
			$menu->NEW_MENU_Threads($forum, $act, $option);
			break;
		case "reply":
			$menu->NEW_MENU_ThreadsReply($forum, $act, $option);
			break;
		default:
			$menu->DEFAULT_MENU_Threads($act, $option);
		}
?>