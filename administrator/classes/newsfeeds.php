<?
	/**
	 *	Mambo Site Server Open Source Edition Version 3.0.5
	 *	Dynamic portal server and Content managment engine
	 *	27-11-2002
 	 *
	 *	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 3.0.5
	 *	File Name: newsfeeds.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/

	class newsfeeds {
		function viewnewsfeeds($database, $newsfeedshtml, $option, $mpre){
			$query = "SELECT * FROM " . $mpre . "newsfeedscategory";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$newsfeedscategory[$i] = $row->category;

				$query = "SELECT * FROM " . $mpre . "newsfeedslinks WHERE categoryid=$row->id";
				$result2 = $database->openConnectionWithReturn($query);
				$k = 0;
				while ($row2 = mysql_fetch_object($result2)){
					$newsfeedsid["$row->category"][$k] = "$row2->id";
					$newsfeedsname["$row->category"][$k] = "$row2->name";
					$k++;
					}
				$i++;
				}
			mysql_free_result($result);

			$query = "SELECT * FROM " . $mpre . "newsfeedslinks WHERE inuse=1";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$name[$i] = $row->name;
				$id[$i] = $row->id;
				$i++;
				}

			$query = "SELECT numnews FROM " . $mpre . "components WHERE module='newsfeeds'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$num = $row->numnews;
				}

			$newsfeedshtml->viewnewsfeeds($option, $newsfeedsname, $newsfeedsid, $newsfeedscategory, $name, $id, $num);
			}

		function savenewsfeeds($database, $option, $selections, $num, $mpre){
			$query = "UPDATE " . $mpre . "newsfeedslinks SET inuse=0 WHERE inuse=1";
			$database->openConnectionNoReturn($query);

			for ($i = 0; $i < count($selections); $i++){
				$query = "UPDATE " . $mpre . "newsfeedslinks SET inuse=1 WHERE id='$selections[$i]'";
				$database->openConnectionNoReturn($query);
				}

			$query = "UPDATE " . $mpre . "components SET numnews=$num WHERE module='newsfeeds'";
			$database->openConnectionNoReturn($query);

			exec('/usr/home/work/mambov3/newsfeeds/newsfeeds.sh');
			print "<SCRIPT>document.location.href='index2.php?option=newsfeeds'</SCRIPT>\n";
			}
		}
?>