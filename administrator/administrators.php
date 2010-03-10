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
	 *	File Name: administrators.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("classes/html/HTML_administrators.php");
	$administratorshtml = new HTML_administrators();

	require("classes/administrators.php");
	$administrators = new administrators();

	switch ($task){
		case "edit":
			$uid = $cid[0];
			$administrators->editadministrator($administratorshtml, $database, $option, $uid, $mpre);
			break;
		case "saveedit":
			$administrators->saveeditadministrator($administratorshtml, $database, $option, $realname, $email, $username, $uid, $new_password, $pname, $pemail, $puname, $live_site, $npassword, $vpassword, $ppassword, $emailAdmin, $mpre);
			break;
		case "remove":
			$administrators->removeadministrator($database, $option, $cid, $userid, $mpre);
			break;
		case "new":
			$administratorshtml->newadministrator($option);
			break;
		case "savenew":
			$administrators->savenewadministrator($option, $database, $realname, $username, $email, $live_site, $mpre);
			break;
		default:
			$administrators->showadministrators($database, $option, $administratorshtml, $userid, $mpre);
		}
?>