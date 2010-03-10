<?
	/**
	 *	Mambo Site Server Open Source Edition Version 4.0
	 *	Dynamic portal server and Content managment engine
	 *	17-11-2002
 	 *
	 *	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 4.0
	 *	File Name: users.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *				Emir Sakic - saka@hotmail.com
	 *	Date: 17/11/2002
	 * 	Version #: 4.0
	 *	Comments:
	**/

	require ("classes/html/HTML_users.php");
	$usershtml = new HTML_users();

	require("classes/users.php");
	$users = new users();

	switch ($task){
		case "edit":
			$uid = $cid[0];
			$users->edituser($usershtml, $database, $option, $uid, $mpre);
			break;
		case "saveedit":
			$users->saveedituser($usershtml, $database, $option, $pname, $pemail, $puname, $uid, $block, $mpre);
			break;
		case "remove":
			$users->removeuser($database, $option, $cid, $mpre);
			break;
		case "new":
			$usershtml->newuser($option);
			break;
		case "savenew":
			$users->savenewuser($option, $database, $realname, $username, $email, $live_site, $mpre);
			break;
		default:
			$users->showUsers($database, $option, $usershtml, $offset, $mpre);
		}
?>