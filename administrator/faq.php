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

	require ("classes/html/HTML_faq.php");
	$faqhtml = new HTML_faq();

	require("classes/faq.php");
	$faq = new faq();

	switch ($task){
		case "edit":
			$faqid = $cid[0];
			if ($faqid==""){
				$faqid=$artid;
			}
			$faq->editFaq($faqhtml, $database, $option, $faqid, $myname, $categories, $text_editor, $mpre);
			break;
		case "saveedit":
			$faq->saveeditfaq($faqhtml, $database, $option, $mytitle, $category, $content, $artid, $myname, $ordering, $porder, $categories, $pcategory, $mpre);
			break;
		case "remove":
			if ($cid==""){
				$cid[0]=$artid;
			}
			$faq->removefaq($database, $option, $cid, $categories, $mpre);
			break;
		case "new":
			$faq->addFaq($faqhtml, $database, $option, $text_editor, $categories, $mpre);
			break;
		case "savenew":
			$faq->savefaq($database, $option, $mytitle, $category, $content, $ordering, $categories, $mpre);
			break;
		case "publish":
			$faq->publishfaq($database, $option, $cid, $artid, $myname, $categories, $mpre);
			break;
		case "unpublish":
			$faq->unpublishfaq($database, $option, $cid, $artid, $myname, $categories, $mpre);
			break;
		case "archive":
			$faq->archivefaq($database, $option, $cid, $categories, $mpre);
			break;
		case "unarchive":
			$faq->unarchivefaq($database, $option, $cid, $categories, $mpre);
			break;
		case "approve":
			$faq->approveFaq($database, $option, $artid, $categories, $category, $content, $mytitle, $mpre);
			break;
		default:
			$faq->showFaq($database, $option, $faqhtml, $categories, $mpre);
		}
?>