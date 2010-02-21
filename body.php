<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Updated By: Nolan
  *		john.pbem@gmail.com
  *
  * Version:	1.13n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	12/9/03
  * Comments: Display front page news stories
  *
  * See CHANGELOG for patch details
  *
 ***/

require ("classes/html/body.php");
$body = new body();

// Get news headlines
$qry = "SELECT sid, introtext, fultext, title, time, newsimage,
            image_position, topic, counter
        FROM {$mpre}stories
        WHERE archived=0 AND published=1 AND frontpage=1
        ORDER BY time DESC, ordering";
$result = $database->openConnectionWithReturn($qry);
$count = mysql_num_rows($result);

$title = array();

if ($count <> 0)
{
    $i = 0;
    while ($row = mysql_fetch_object($result))
    {
        $sid[$i] = $row->sid;
        $introtext[$i] = $row->introtext;
        $exttext[$i] = $row->fultext;
        $title[$i] = $row->title;
        $dbtime = $row->time;
        $dates = explode("-", $dbtime);
        $time[$i] = date ("j-M-Y", mktime (0,0,0,$dates[1],$dates[2],$dates[0]));

        $newsimage[$i] = $row->newsimage;
        $imageposition[$i] = $row->image_position;
        $tid = $row->topic;
        $counter[$i] = $row->counter;

        $qry2 = "SELECT categoryname FROM {$mpre}categories WHERE categoryid='$tid'";
        $result2 = $database->openConnectionWithReturn($qry2);
        list ($category[$i]) = mysql_fetch_array($result2);
        $i++;
    }
}

// Get ship & character counts
$qry = "SELECT id FROM {$spre}ships WHERE tf<>'99'";
$result = $database->openConnectionWithReturn($qry);
$shipnum = mysql_num_rows($result);

$qry = "SELECT id FROM {$spre}characters WHERE ship<>'".DELETED_SHIP."'";
$result = $database->openConnectionWithReturn($qry);
$charnum = mysql_num_rows($result);

echo "<img src=images/news.jpg>";

$body->indexbody($sid, $introtext, $exttext, $title, $time, $newsimage, $imageposition, $category, $counter, $charnum, $shipnum, $newstop);
?>
