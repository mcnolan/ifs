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
	 *	File Name: newsfeeds.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_newsfeeds.php");
	$newsfeedshtml = new HTML_newsfeeds();

	require("classes/newsfeeds.php");
	$newsfeeds = new newsfeeds();

	$selection = split("&", $REQUEST_URI);
	$selections = array();
	$k = 0;
	for ($i = 0; $i < count($selection); $i++){
		if (eregi("selections", $selection[$i])){
			$selected = split("=", $selection[$i]);
			$selections[$k] = $selected[1];
			$k++;
			}
		}

	for ($i = 0; $i < count($selections); $i++){
		$selections[$i] = ereg_replace( "[+]", " ", $selections[$i]);
		}

	switch ($task){
		default:
			$newsfeeds->viewnewsfeeds($database, $newsfeedshtml, $option, $mpre);
			break;
		case "save":
			$newsfeeds->savenewsfeeds($database, $option, $selections, $num, $mpre);
			break;
		}
?>