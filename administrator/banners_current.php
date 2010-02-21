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
	 *	File Name: banners_current.php
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
		case "new":
			//check if this is the first banner to be made, there must be a client existing first!
			$query="select cid from " . $mpre . "bannerclient";
			$result=$database->openConnectionWithReturn($query);
			if (mysql_num_rows($result)>0){
				$banners->addBanner_current($database, $bannershtml, $option, $mpre);
			}else{
				print "<SCRIPT> alert('You cannot add a new banner until a client has been added'); window.history.go(-1); </SCRIPT>\n";
			}
			break;
		case "saveNew":
			$banners->saveNewBanner_current($database, $bname, $clientid, $imptotal, $imageurl, $clickurl, $show, $unlimited, $mpre);
			break;
		case "edit":
			if (trim($bannerid)==""){
				$bannerid = $cid[0];
			}
			$banners->editBanner_current($bannershtml, $database, $option, $show, $bannerid, $myname, $mpre);
			break;
		case "saveEdit":
			$banners->saveEditBanner_current($bannershtml, $database, $bannerid, $bname, $cname, $clientid, $imptotal, $imageurl, $clickurl, $show, $option, $myname, $unlimited, $mpre);
			break;
		case "saveUploadNew":
			$banners->saveUploadNew_current($userfile, $userfile_name);
			break;
		case "remove":
			$banners->removeBanner_current($database, $option, $cid, $mpre);
			break;
		case "publish":
			$banners->publishBanner_current($database, $option, $bannerid, $cid, $mpre);
			break;
		case "unpublish":
			$banners->unpublishBanner_current($database, $option, $bannerid, $cid, $mpre);
			break;

		default:
			$banners->viewBanners_current($database, $bannershtml, $option, $mpre);
	}
?>