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
	 *	File Name: subsections.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_subsections.php");
	$subsectionshtml = new HTML_subsections();

	require("classes/subsections.php");
	$subsections = new subsections();

	switch ($task){
		case "new":
			$subsections->addSubsection($database, $subsectionshtml, $option, $sections, $mpre);
			break;
		case "AddStep2":
			$subsections->addStep2($database, $subsectionshtml, $option, $ItemName, $ItemType, $SectionID, $sections, $mpre);
			break;
		case "AddStep3":
			$subsections->addStep3($database, $subsectionshtml, $option, $ItemName, $PageSource, $SectionID, $sections, $mpre);
			break;
		case "savenew":
			$subsections->saveSubsection($database, $ItemName, $pagecontent, $Weblink, $moduleID, $option, $SectionID, $heading, $sections, $browserNav, $mpre);
			break;
		case "edit":
			$Itemid = $cid[0];
			if (trim($categories)!=""){
				$sections=$categories;
			}
			$subsections->editSubsection($database, $subsectionshtml, $option, $Itemid, $checkedID, $myname, $sections, $mpre);
			break;
		case "saveedit":
			$subsections->saveEditSubsection($database, $menusectionshtml, $option, $ItemName, $link2, $pagecontent, $filecontent, $Itemid, $SectionID, $order, $origOrder, $myname, $origSecID, $Weblink, $heading, $browserNav, $mpre);
			break;
		case "Upload":
			$subsections->saveFileUpload($database, $option,  $userfile, $userfile_name, $Itemid, $mpre);
			break;
		case "remove":
			$subsections->removeSubsection($database, $option, $cid, $sections, $mpre);
			break;
		case "publish":
			$subsections->publishSubsection($database, $option, $Itemid, $cid, $sections, $mpre);
			break;
		case "unpublish":
			$subsections->unpublishSubsection($database, $option, $Itemid, $cid, $sections, $mpre);
			break;
		case "saveUploadImage":
			$subsections->saveUploadImage($database, $option, $userfile1, $userfile1_name, $userfile2, $userfile2_name, $userfile3, $userfile3_name, $userfile4, $userfile4_name, $userfile5, $userfile5_name, $sectionid, $mpre);
			break;
		default:
			if (trim($categories)!=""){
				$sections=$categories;
			}
			$subsections->viewSubItems($database, $subsectionshtml, $option, $sections, $mpre);
		}
?>
