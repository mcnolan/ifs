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
  * Comments: Functions to list and display articles
 ***/

require("classes/html/articles.php");
$articles = new articles();

switch($task)
{
    case "show":
        show($articles, $database, $artid, $mpre);
        break;
    default:
        listsections($articles, $database, $topid, $mpre);
        break;
}

function listsections($articles, $database, $topid, $mpre)
{
    $qry = "SELECT categoryid, categoryname
            FROM {$mpre}categories
            WHERE section='Articles' AND published=1
            ORDER BY categoryname";
    $result = $database->openConnectionWithReturn($qry);
    $numresult = mysql_num_rows($result);
    $j = 0;
    while (list($catid, $catname) = mysql_fetch_array($result))
    {
        $topictext[$j] = $catname;
        $topicid[$j] = $catid;
        $qry2 = "SELECT artid, title, indent
                    FROM {$mpre}articles
                    WHERE secid=$catid AND approved=1 AND published=1
                        AND archived=0
                    ORDER BY ordering";
        $result2 = $database->openConnectionWithReturn($qry2);
        if ($topid <> "")
        {
            $i = 0;
            if (mysql_num_rows($result2)<> 0)
                while (list($artid, $arttitle, $artindent) = mysql_fetch_array($result2))
                {
                    $title[$catname][$i] = $arttitle;
                    $sid[$catname][$i] = $artid;
                    $indent[$catname][$i] = $artindent;
                    $i++;
                }
        }
        $j++;
    }
    $articles->listarticles($topictext, $topicid, $title, $sid, $topid, $indent);
}

function show($articles, $database, $artid, $mpre)
{
    $qry = "SELECT title, content, author FROM {$mpre}articles WHERE artid=$artid";
    $result = $database->openConnectionWithReturn($qry);
    list($title,$content,$author)=mysql_fetch_array($result);

    $qry = "UPDATE {$mpre}articles SET counter=counter+1 WHERE artid=$artid";
    $database->openConnectionNoReturn($qry);

    $pat= "SRC=images";
    $replace= "SRC=../images";
    $content=eregi_replace($pat, $replace, $content);

    $pat3="SRC=\"images";
    $replace3= "SRC=\"../images";
    $content=eregi_replace($pat3, $replace3, $content);

    $articles->showarticle($title, $artid, $author, $content);
}
?>