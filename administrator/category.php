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
	 *	File Name: category.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("classes/html/HTML_category.php");
	$categoryhtml = new HTML_category;

	require("classes/category.php");
	$category = new category();

	switch ($task){
		case "edit":
			$uid = $cid[0];
			if ($uid==""){
				print "<SCRIPT> alert('Select a category to edit'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
			}
				$category->editcategory($categoryhtml, $database, $option, $uid, $act, $myname, $mpre);
			break;
		case "saveedit":
			$category->savecategory($categoryhtml, $database, $option, $categoryname, $image, $act, $uid, $pname, $position, $mpre);
			break;
		case "remove":
			$category->removecategory($database, $option, $cid, $act, $mpre);
			break;
		case "new":
			$category->newcategory($database, $option, $act, $categoryhtml, $mpre);
			break;
		case "savenew":
			$category->savenewcategory($option, $database, $categoryname, $act, $mpre);
			break;
		case "publish":
			$category->publishcategory($option, $database, $uid, $cid, $image, $categoryname, $position, $mpre);
			break;
		case "unpublish":
			$category->unpublishcategory($option, $database, $uid, $cid, $mpre);
			break;
		default:
			$category->showcategory($database, $option, $categoryhtml, $act, $mpre);
		}
?>