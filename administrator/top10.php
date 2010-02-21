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
	 *	File Name: top10.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require("classes/html/HTML_top10.php");
	$top10html = new HTML_top10();

	if ($task == "news"){
		$query = "SELECT counter, title FROM " . $mpre . "stories ORDER BY counter DESC LIMIT 10";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$storytitle[$i] = $row->title;
			$storycounter[$i] = $row->counter;
			$i++;
			}
		}
	else if ($task == "articles"){
		$query = "SELECT counter, title FROM " . $mpre . "articles ORDER BY counter DESC LIMIT 10";
		$result = $database->openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$sectitle[$i] = $row->title;
			$seccounter[$i] = $row->counter;
			$i++;
			}
		}

	$top10html->showtop10($storytitle, $storycounter, $sectitle, $seccounter, $task)
?>