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
	 *	File Name: forums.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	require ("classes/html/HTML_forum.php");
	$forumhtml = new HTML_forum;

	require("classes/forum.php");
	$forum = new forum();

	switch ($task){
		case "edit":
			$uid = $cid[0];
			if ($uid==""){
				print "<SCRIPT> alert('Select a forum to edit'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
			}
			$forum->editforum($forumhtml, $database, $option, $uid, $act, $myname, $mpre);
			break;
		case "saveedit":
			$forum->saveforum($forumhtml, $database, $option, $forumName, $description, $moderate, $language, $uid, $moderatorID, $emailModerator, $mpre);
			break;
		case "remove":
			$forum->removeforum($database, $option, $cid, $mpre);
			break;
		case "new":
			$forum->newforum($database, $option, $act, $forumhtml, $mpre);
			break;
		case "savenew":
			$forum->savenewforum($option, $database, $forumName, $description, $moderate, $language, $moderatorID, $emailModerator, $numMessDisp, $mpre);
			break;
		case "publish":
			$forum->publishforum($option, $database, $uid, $cid, $image, $categoryname, $position, $mpre);
			break;
		case "unpublish":
			$forum->unpublishforum($option, $database, $uid, $cid, $mpre);
			break;
		case "archive":
			$forum->archiveForum($database, $option, $cid, $mpre);
			break;
		case "unarchive":
			$forum->unarchiveForum($database, $option, $cid, $mpre);
			break;
		default:
			$forum->showforum($database, $option, $forumhtml, $act, $mpre);
		}
?>