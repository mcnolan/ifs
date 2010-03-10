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

	require ("classes/html/HTML_news.php");
	$newshtml = new HTML_news();

	require("classes/news.php");
	$news = new news();

	switch ($task){
		case "new":
			$news->newNews($database, $newshtml, $option, $text_editor, $categories, $mpre);
			break;
		case "edit":
			$storyid = $cid[0];
			if ($storyid==""){
				$storyid=$id;
			}
			$news->editNews($database, $newshtml, $option, $storyid, $myname, $categories, $text_editor, $mpre);
			break;
		case "savenew":
			$news->saveNewNews($database, $option, $introtext, $fultext, $newstopic, $image, $mytitle, $ordering, $position, $frontpage, $categories, $mpre);
			break;
		case "remove":
			if ($cid==""){
				$cid[0]=$sid;
			}
			$news->removenews($database, $option, $cid, $categories, $mpre);
			break;
		case "saveedit":
			$news->saveeditnews($database, $option, $image, $introtext, $fultext, $mytitle, $newstopic, $sid, $task, $position, $ordering, $myname, $porder, $frontpage, $categories, $mpre);
			break;
		case "publish":
			$news->publishnews($database, $option, $sid, $cid, $categories, $mpre);
			break;
		case "unpublish":
			$news->unpublishnews($database, $option, $sid, $cid, $categories, $mpre);
			break;
		case "archive":
			$news->archivenews($database, $option, $sid, $cid, $categories, $mpre);
			break;
		case "unarchive":
			$news->unarchivenews($database, $option, $sid, $cid, $categories, $mpre);
			break;
		case "approve":
			//echo "option:$option, intro:$introtext, ful:$fultext, topic:$newstopic, image:$image, mytitle:$mytitle, ordering:$ordering, position:$position, frontpage:$frontpage, sid:$sid, porder:$porder, categories:$categories";
			//break;
			$news->approvenews($database, $option, $introtext, $fultext, $newstopic, $image, $mytitle, $ordering, $position, $frontpage, $sid, $porder, $categories, $mpre);
			//echo "option:$option, intro:$introtext, ful:$fultext, topic:$newstopic, image:$image, mytitle:$mytitle, ordering:$ordering, position:$position, frontpage:$frontpage, sid:$sid, porder:$porder, categories:$categories";
			break;
		default:
			$news->viewNews($database, $newshtml, $option, $categories, $mpre);
		}
?>