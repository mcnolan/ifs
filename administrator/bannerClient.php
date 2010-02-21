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
	 *	File Name: bannerClient.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_bannerClient.php");
	$bannerClienthtml = new HTML_bannerClient();

	require("classes/bannerClient.php");
	$bannerClient = new bannerClient();


	switch ($task){
		case "new":
			$bannerClient->addBannerClient($database, $bannerClienthtml, $option, $mpre);
			break;
		case "saveNew":
			$bannerClient->saveBannerClient($database, $cname, $contact, $email, $extrainfo, $mpre);
			break;
		case "edit":
			$clientid = $cid[0];
			$bannerClient->editBannerClient($bannerClienthtml, $database, $option, $clientid, $myname, $mpre);
			break;
		case "save":
			$bannerClient->saveEditBannerClient($bannerClienthtml, $database, $clientid, $cname, $contact, $email, $extrainfo, $myname, $mpre);
			break;
		case "remove":
			$bannerClient->removeBannerClient($database, $option, $cid, $mpre);
			break;
		default:
			$bannerClient->viewBannerClients($database, $bannerClienthtml, $option, $mpre);
	}
?>