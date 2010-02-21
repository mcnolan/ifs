<?PHP

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
	 *	File Name: newsflash.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_newsflash.php");
	$newsflashhtml = new HTML_newsflash();

	require("classes/newsflash.php");
	$newsflash = new newsflash();

	switch ($task){
		case "new":
			$newsflash->addNewsflash($database, $newsflashhtml, $option, $text_editor, $mpre);
			break;
		case "savenew":
			$newsflash->saveNewsflash($database, $flashtitle, $content, $option, $mpre);
			break;
		case "edit":
			$newsflashid = $cid[0];
			$newsflash->editNewsflash($newsflashhtml, $database, $option, $newsflashid, $myname, $text_editor, $mpre);
			break;
		case "saveedit":
			$newsflash->saveEditNewsflash($newsflashhtml, $database, $flashtitle, $content, $newsflashid, $option, $myname, $mpre);
			break;
		case "remove":
			$newsflash->removeNewsflash($database, $option, $cid, $mpre);
			break;
		case "publish":
			$newsflash->publishNewsflash($database, $option, $newsflashid, $cid, $mpre);
			break;
		case "unpublish":
			$newsflash->unpublishNewsflash($database, $option, $newsflashid, $cid, $mpre);
			break;
		default:
			$newsflash->viewNewsflash($database, $newsflashhtml, $option, $mpre);
		}
?>