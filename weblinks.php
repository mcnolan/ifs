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
  *	Comments: The function listing retrieves all web links categories and titles from the database.
 ***/

require ("classes/html/weblinks.php");
$weblinks = new weblinks();
listweblinks($weblinks, $database, $topid, $mpre);

function listweblinks($weblinks, $database, $topid, $mpre)
{
    $qry = "SELECT categoryid, categoryname
            FROM {$mpre}categories
            WHERE published=1 AND section='Weblinks'
            ORDER BY categoryname";
    $result = $database->openConnectionWithReturn($qry);
    $j = 0;
    while ( list($catid, $catname) = mysql_fetch_array($result) )
    {
    	$topicid[$j] = $catid;
        $topictext[$j] = $catname;
        $qry2 = "SELECT url, title, date
                 FROM {$mpre}links
                 WHERE cid={$catid} AND published=1 AND archived=0
                 ORDER BY ordering";
        $result2 = $database->openConnectionWithReturn($qry2);
        $i=0;
        while ( list($caturl, $cattitle, $catdate) = mysql_fetch_array($result2) )
        {
            $sid[$catname][$i] = $caturl;
            $title[$catname][$i] = $cattitle;
            $date[$catname][$i] = $catdate;
            $url[$catname][$i] = $caturl;
            $i++;
        }
        $j++;
    }
    $weblinks->displaylist($topictext, $topicid, $title, $sid, $topid, $date, $url);
}
?>