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
	 *	File Name: articles.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("classes/html/HTML_articles.php");
	$articleshtml = new HTML_articles();

	require("classes/articles.php");
	$articles = new articles();

	switch($task){
		case "edit":
			if ($artid==""){
				$artid = $cid[0];
			}
			$articles->editarticle($articleshtml, $database, $option, $artid, $myname, $categories, $text_editor, $mpre);
			break;
		case "saveedit":
			$articles->saveeditarticle($database, $option, $mytitle, $artid, $content, $category, $task, $original, $ordering, $porder, $myname, $secsecid, $pcategory, $categories, $author, $mpre);
			break;
		case "savenew":
			$articles->savenewarticle($database, $option, $mytitle, $content, $category, $ordering, $uid, $author, $categories, $mpre);
			break;
		case "remove":
			if ($artid <> "")
				$cid[0] = $artid;

			$articles->removearticle($database, $option, $cid, $categories, $myname, $mpre);
			break;
		case "new":
			$articles->addArticle($database, $option, $articleshtml, $categories, $text_editor, $mpre);
			break;
		case "approvearticle":
			$articles->editarticle($articleshtml, $database, $option, $artid, $myname, $categories, $mpre);
			break;
		case "approve":
			$articles->approvearticle($database, $option, $artid, $categories, $category, $author, $content, $mytitle, $mpre);
			break;
		case "publish":
			$articles->publisharticle($database, $option, $cid, $artid, $myname, $categories, $mpre);
			break;
		case "unpublish":
			$articles->unpublisharticle($database, $option, $cid, $artid, $myname, $categories, $mpre);
			break;
		case "archive":
			if ($cid[0]==""){
				print "<SCRIPT> alert('Select an article to archive'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
			}
			$articles->archivearticle($database, $option, $cid, $categories, $mpre);
			break;
		case "unarchive":
			if ($cid[0]==""){
				print "<SCRIPT> alert('Select an article to unarchive'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
			}
			$articles->unarchivearticle($database, $option, $cid, $categories, $mpre);
			break;
		default:
			$articles->showArticles($option, $articleshtml, $database, $categories, $mpre);
		}
?>