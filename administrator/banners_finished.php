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
	 *	File Name: banners_finished.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_banners.php");
	$bannershtml = new HTML_banners();

	require("classes/banners.php");
	$banners = new banners();

	switch ($task){
		case "edit":
			$bannerid = $cid[0];
			$banners->editBanner_finished($bannershtml, $database, $option, $show, $bannerid, $mpre);
			break;
		case "remove":
			$banners->removeBanner_finished($database, $option, $cid, $mpre);
			break;
		default:
			$banners->viewBanners_finished($database, $bannershtml, $option, $mpre);
	}
?>
