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
  *	Comments: Search for past articles.
 ***/

require("classes/html/pastarticles.php");
$pastarticles = new pastarticles();

switch($task)
{
	case "search":
		returnSearch($option, $search, $days, $pastarticles, $type, $database, $mpre);
		break;
	default:
		viewArchivePage($option, $pastarticles, $type);
		break;
}


function viewArchivePage($option, $pastarticles, $type)
{
	$pastarticles->searchArchiveForm($option, $search, $days, $type);
}

function returnSearch($option, $search, $days, $pastarticles, $type, $database, $mpre)
{
	if ($type=="News")
		if ($days!=0 && (isset($search)))
			$qry = "SELECT sid, title, time
            		FROM {$mpre}stories
                    WHERE archived='1' AND TO_DAYS(NOW()) - TO_DAYS(time) <= $days
                    	AND title LIKE '%$search%'";
		elseif ((isset($search)) && ($days == 0))
			$qry= "SELECT sid, title, time
            	   FROM {$mpre}stories
                   WHERE archived='1' AND title LIKE '%$search%'";
		elseif (($search == "") && ($days > 0))
			$qry = "SELECT sid, title, time
            		FROM {$mpre}stories
                    WHERE archived='1' AND TO_DAYS(NOW()) - TO_DAYS(time) <= $days";
    else if ($type=="Articles")
		if ($days!=0 && (trim($search)!=""))
			$qry = "SELECT artid, title, date
            		FROM {$mpre}articles
                    WHERE archived='1' AND TO_DAYS(NOW()) - TO_DAYS(date) <= $days
                    	AND title LIKE '%$search%'";
		elseif ((isset($search)) && ($days == 0))
			$qry= "SELECT artid, title, date
            	   FROM {$mpre}articles
                   WHERE archived='1' AND title LIKE '%$search%'";
		elseif (($search == "") && ($days > 0))
			$qry = "SELECT artid, title, date
            		FROM {$mpre}articles
                    WHERE archived='1' AND TO_DAYS(NOW()) - TO_DAYS(date) <= $days";

	$result=$database->openConnectionWithReturn($qry);
	$length = mysql_num_rows($result);
	display_query($length, $result, $pastarticles, $option, $search, $days, $type);
}

function display_query($length, $result, $pastarticles, $option, $search, $days, $type)
{
	$pastarticles->searchArchiveForm($option, $search, $days, $type);

	for ($i=0;
	     list ($sid[$i], $title[$i], $date[$i]) = mysql_fetch_array($result);
	     $i++)
	{
	    if ($type == "News")
	    {
	        $articledate = split(" ", $date[$i]);
	        $date3 = $articledate[0];
	    }
	    else
	        $date3 = $date[$i];
	    list ($year,$month, $day) = split ('[/.-]', $date3);
	    $date3 = date ("M d Y", mktime (0,0,0,$month,$day,$year));
	    $date2[$i]=$date3;
	}

	$pastarticles->displaySearchResults($sid, $title, $date2, $option, $length, $type);
}


?>