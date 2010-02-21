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
	 *	File Name: menusections.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_menusections.php");
	$menusectionshtml = new HTML_menusections();

	require("classes/menusections.php");
	$menusections = new menusections();

	switch ($task){
		case "new":
			$menusections->addMenusection($database, $menusectionshtml, $option, $mpre);
			break;
		case "AddStep2":
			$menusections->addStep2($database, $menusectionshtml, $option, $ItemName, $ItemType, $mpre);
			break;
		case "AddStep3":
			$menusections->addStep3($database, $menusectionshtml, $option, $ItemName, $PageSource, $text_editor, $mpre);
			break;
		case "savenew":
			$menusections->saveMenusection($database, $ItemName, $pagecontent, $Weblink, $moduleID, $option, $heading, $browserNav, $mpre);
			break;
		case "edit":
			$Itemid = $cid[0];
			$menusections->editMenusection($database, $menusectionshtml, $option, $Itemid, $myname, $text_editor, $mpre);
			break;
		case "saveedit":
			$menusections->saveEditMenusection($database, $menusectionshtml, $option, $ItemName, $pagecontent, $filecontent, $Itemid, $order, $origOrder, $myname, $Weblink, $link2, $heading, $browserNav, $mpre);
			break;
		case "Upload":
			$menusections->saveFileUpload($database, $option,  $userfile, $userfile_name, $Itemid, $mpre);
			break;
		case "remove":
			$menusections->removeMenusection($database, $option, $cid, $mpre);
			break;
		case "publish":
			$menusections->publishMenusection($database, $option, $Itemid, $cid, $mpre);
			break;
		case "unpublish":
			$menusections->unpublishMenusection($database, $option, $Itemid, $cid, $mpre);
			break;
		case "saveUploadImage":
			$menusections->saveUploadImage($option, $userfile1, $userfile1_name, $userfile2, $userfile2_name, $userfile3, $userfile3_name, $userfile4, $userfile4_name, $userfile5, $userfile5_name, $sectionid);
			break;
		default:
			$menusections->viewMenuItems($database, $menusectionshtml, $option, $mpre);
		}
?>
