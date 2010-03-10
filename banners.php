<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Version:	1.11
  * Release Date: June 3, 2004
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file based on code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	12/9/03
  * Comments: Views banners; redirects to proper URL
 ***/

include ("configuration.php");

switch($op)
{
    case "click":
		clickbanner($bid, $database, $mpre);
		break;

    default:
		viewbanner($database, $mpre);
}

function viewbanner($database, $mpre)
{
	$qry="SELECT * FROM {$mpre}banner WHERE showBanner=1";
	$result=$database->openConnectionWithReturn($qry);
    $numrows = mysql_num_rows($result);

	// Get a random banner (if any exist)
    if ($numrows>1)
    {
		$numrows = $numrows-1;
		mt_srand((double)microtime()*1000000);
		$bannum = mt_rand(0, $numrows);
    }
    else
		$bannum = 0;

	$qry="SELECT bid, imageurl FROM {$mpre}banner WHERE showBanner=1 LIMIT $bannum,1";
	$result=$database->openConnectionWithReturn($qry);

	if (mysql_num_rows($result)!=0)
    {
		list($bid, $imageurl) = mysql_fetch_row($result);

		$qry="UPDATE {$mpre}banner SET impmade=impmade+1 WHERE bid=$bid";
		$database->openConnectionNoReturn($qry);

		if($numrows>0)
        {
			$qry="SELECT cid, imptotal, impmade, clicks, date, name, imageurl
            	  FROM {$mpre}banner WHERE bid=$bid";
			$result=$database->openConnectionWithReturn($qry);
			list($cid, $imptotal, $impmade, $clicks, $date, $name, $imageurl)
            	= mysql_fetch_row($result);

			// Check if this impression is the last one and print the banner
			if($imptotal==$impmade)
            {
		   		$qry="INSERT INTO {$mpre}bannerfinish
                	  (cid, name, impressions, clicks, imageurl, datestart, dateend)
                      VALUES ('$cid', '$name', '$impmade', '$clicks', '$imageurl', '$date', now())";
				$database->openConnectionNoReturn($qry);

				$qry="DELETE FROM {$mpre}banner WHERE bid=$bid";
				$database->openConnectionNoReturn($qry);
			}

			if ((eregi(".gif", $imageurl)) || (eregi(".jpg", $imageurl)))
            {
				$imageurl="images/banners/$imageurl";
    			echo"<a href=\"banners.php?op=click&bid=$bid\">" .
                	"<img src=\"$imageurl\" border=\"0\" vspace=\"5\" alt=\"Partner Site Banner\" /></a>\n";
			}
            elseif (eregi(".swf", $imageurl))
            {
				$imageurl="images/banners/$imageurl";
				echo "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" " .
                	 "codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\" " .
                     "height=\"50\" border=\"5\" VSPACE=\"5\">\n" .
					 "<param name=\"SRC\" value=\"$imageurl\" />\n" .
                     "<embed src=\"$imageurl\" loop=\"false\" " .
                     "pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" " .
                     "type=\"application/x-shockwave-flash\" height=\"50\" />\n" .
 					 "</object></a>\n";
			}
		}
	}
    else
		echo "&nbsp;";
}


/********************************************/
/* Function to redirect the clicks to the   */
/* correct url and add 1 click              */
/********************************************/
function clickbanner($bid, $database, $mpre)
{
	if ($database=="")
    {
		require("classes/database.php");
		$database = new database();
	}
	$qry="SELECT clickurl FROM {$mpre}banner WHERE bid=$bid";
	$result=$database->openConnectionWithReturn($qry);
    list($clickurl) = mysql_fetch_row($result);

	$qry="UPDATE {$mpre}banner SET clicks=clicks+1 WHERE bid=$bid";
	$database->openConnectionNoReturn($qry);

	$pat="http://";
	if (!eregi($pat, $clickurl))
		$clickurl="http://".$clickurl;

	header("Location: {$clickurl}");

}
?>