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

	require ("classes/html/HTML_weblink.php");
	$weblinkshtml = new HTML_weblinks();

	require("classes/weblinks.php");
	$weblinks = new weblinks();

	switch($task){
		case "edit":
			$id = $cid[0];
			if ($id==""){
				$id=$lid;
			}
			$weblinks->editweblinks($weblinkshtml, $database, $option, $id, $myname, $categories, $mpre);
			break;
		case "saveedit":
			$weblinks->saveeditweblinks($database, $option, $lid, $mytitle, $url, $category, $myname, $ordering, $porder, $cid, $categories, $mpre);
			break;
		case "savenew":
			$weblinks->savenewweblink($database, $option, $mytitle, $url, $category, $ordering, $categories, $mpre);
			break;
		case "remove":
			if ($cid==""){
				$cid[0]=$lid;
			}
			$weblinks->removeweblink($database, $option, $cid, $categories, $mpre);
			break;
		case "new":
			$weblinks->addweblink($database, $weblinkshtml, $option, $categories, $mpre);
			break;
		case "publish":
			$weblinks->publishweblink($database, $option, $cid, $lid, $categories, $mpre);
			break;
		case "unpublish":
			$weblinks->unpublishweblink($database, $option, $cid, $lid, $categories, $mpre);
			break;
		case "approve":
			$weblinks->approvelink($database, $option, $lid, $categories, $category, $url, $mytitle, $mpre);
			break;
		default:
			$weblinks->showWeblinks($option, $weblinkshtml, $database, $categories, $mpre);
		}
?>