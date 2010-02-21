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
  *	Comments: The function listing retrieves all news categories and titles from the database.
 ***/

require ("classes/html/news.php");
$news = new news();

switch($task)
{
    case "viewarticle":
        show($news, $database, $sid, $mpre);
        break;
    default:
        listing($news, $database, $topid, $mpre);
        break;
}

function listing($news, $database, $topid, $mpre)
{
    $qry = "SELECT categoryname, categoryid
    		FROM {$mpre}categories
		    WHERE section='News' AND published=1
            ORDER BY categoryname";
    $result = $database->openConnectionWithReturn($qry);

    $j = 0;
    while ( list($catname, $catid) = mysql_fetch_array($result) )
    {
        $topictext[$j] = $catname;
        $topicid[$j] = $catid;
        $i = 0;
        if ($topid <> "")
        {
            $qry2 = "SELECT sid, title, time, counter
            		FROM {$mpre}stories
                    WHERE topic=$catid AND published=1 AND archived=0
                    ORDER BY time DESC";
            $result2 = $database->openConnectionWithReturn($qry2);
            if (mysql_num_rows($result2) <> 0)
                while ( list($artid, $arttitle, $arttime, $artcounter)=mysql_fetch_array($result2) )
                {
                    $title[$catname][$i] = $arttitle;
                    $sid[$catname][$i] = $artid;
                    $time[$catname][$i] = $arttime;
                    $counter[$catname][$i] = $artcounter;
                    $i++;
                }
        }
        $j++;
	}
    $news->newsmaker($topicid, $title, $sid, $topictext, $topid, $time, $counter);
}

function show($news, $database, $sid, $mpre)
{
    $qry = "SELECT time, title, introtext, fultext, newsimage, image_position, counter, topic
    		FROM {$mpre}stories WHERE sid=$sid";
    $result = $database->openConnectionWithReturn($qry);
    list ($dbtime, $title, $introtext, $fultext, $image, $imageposition, $count, $tid) = mysql_fetch_array($result);

    $dates = explode("-", $dbtime);
    $time = date ("j-M-Y", mktime (0,0,0,$dates[1],$dates[2],$dates[0]));
    $introtext = stripslashes($introtext);
    $fultext = stripslashes($fultext);

    $qry2 = "UPDATE {$mpre}stories SET counter=counter+1 WHERE sid=$sid";
    $database->openConnectionNoReturn($qry2);

    $qry2 = "SELECT categoryname FROM {$mpre}categories WHERE categoryid='$tid'";
    $result2 = $database->openConnectionWithReturn($qry2);
    list ($topic) = mysql_fetch_array($result2);

    $news->shownewsmaker($time, $title, $introtext, $fultext, $topic, $image, $sid, $imageposition, $count, $topic);
}
?>