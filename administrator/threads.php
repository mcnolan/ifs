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

	require ("classes/html/HTML_threads.php");
	$threadshtml = new HTML_threads();

	require("classes/threads.php");
	$threads = new threads();

	switch($task){
		case "edit":
			if ($tid==""){
				$tid = $cid[0];
			}
			$threads->editThread($threadshtml, $database, $option, $tid, $myname, $forum, $act, $text_editor, $mpre);
			break;
		case "saveedit":
			$threads->saveEditThread($database, $option, $subject, $tid, $content, $author, $act, $forum, $myname, $replytoid, $forumid, $origforumid, $authorid, $replyauthorid, $mpre);
			break;
		case "savenew":
			$threads->savenewThread($database, $option, $act, $forum, $subject, $content, $forumID, $author, $authorid, $mpre);
			break;
		case "remove":
			if ($tid <> ""){
				$cid[0] = $tid;
			}
			$threads->removeThread($database, $option, $cid, $forum, $act, $mpre);
			break;
		case "new":
			$adminid=$userid;
			$threads->addThread($database, $option, $act, $threadshtml, $forum, $myname, $text_editor, $adminid, $mpre);
			break;
		case "reply":
			$threads->newReply($database, $option, $act, $threadshtml, $forum, $myname, $cid, $text_editor, $mpre);
			break;
		case "savenewreply":
			$threads->savenewReply($database, $option, $act, $forum, $subject, $content, $forumID, $author, $authorid, $published, $archive, $repLevel, $repID, $topMessageID, $mpre);
			break;
		case "publish":
			$threads->publishThread($database, $option, $cid, $tid, $myname, $forum, $act, $live_site, $mpre);
			break;
		case "unpublish":
			$threads->unpublishThread($database, $option, $cid, $tid, $myname, $forum, $act, $mpre);
			break;
		case "archive":
			$threads->archiveThread($database, $option, $cid, $forum, $act, $mpre);
			break;
		case "unarchive":
			$threads->unarchiveThread($database, $option, $cid, $forum, $act, $mpre);
			break;
		default:
			$threads->showThreads($option, $threadshtml, $database, $forum, $act, $mpre);
		}
?>