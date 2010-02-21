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
	 *	File Name: components.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_components.php");
	$componentshtml = new HTML_components();

	require("classes/components.php");
	$components = new components();

	switch ($task){
		case "new":
			$components->addComponent($database, $componentshtml, $option, $text_editor, $mpre);
			break;
		case "savenew":
			$components->saveComponent($database, $mytitle, $content, $position, $order, $mpre);
			break;
		case "edit":
			$componentid = $cid[0];
			$components->editComponent($componentshtml, $database, $option, $componentid, $myname, $text_editor, $mpre);
			break;
		case "saveedit":
			$components->saveeditcomponent($html, $database, $mytitle, $content, $position, $show, $componentid, $order, $original, $myname, $module, $mpre);
			break;
		case "remove":
			$components->removecomponent($database, $option, $cid, $mpre);
			break;
		case "publish":
			$components->publishComponent($database, $option, $cid, $componentid, $mytitle, $content, $position, $order, $original, $mpre);
			break;
		case "unpublish":
			$components->unpublishComponent($database, $option, $componentid, $cid, $mpre);
			break;
		default:
			$components->viewcomponents($database, $componentshtml, $option, $mpre);
		}
?>