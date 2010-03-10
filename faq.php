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
  * Date: 12/9/03
  *	Comments: The function listing retrieves all faq categories and titles from the database.
 ***/

require ("classes/html/faq.php");
$faq = new faq();

switch($task)
{
    case "show":
        show($faq, $database, $artid, $mpre);
        break;
    default:
        listfaq($faq, $database, $topid, $mpre);
        break;
}

function listfaq($faq, $database, $topid, $mpre)
{
    $qry = "SELECT categoryid, categoryname
            FROM {$mpre}categories
            WHERE section='Faq' AND published=1
            ORDER BY categoryname";
    $result = $database->openConnectionWithReturn($qry);
    $j = 0;

    while ( list($catid, $catname) = mysql_fetch_array($result))
    {
        $topicid[$j] = $catid;
        $topictext[$j] = $catname;

        $qry2 = "SELECT artid, title, counter
                 FROM {$mpre}faqcont
                 WHERE faqid='$catid' AND published=1 AND archived=0
                 ORDER BY ordering";
        $result2 = $database->openConnectionWithReturn($qry2);
        $num[$j] = mysql_num_rows($result2);

        if ($topid <> "")
        {
            $i=0;
            if (mysql_num_rows($result2)<> 0)
                while ( list($artid, $arttitle, $artcounter) = mysql_fetch_array($result2))
                {
                    $sid[$catname][$i] = $artid;
                    $title[$catname][$i] = $arttitle;
                    $counter[$catname][$i] = $artcounter;
                    $i++;
                }
        }
        $j++;
    }
    $faq->faqlist($topictext, $topicid, $title, $sid, $topid, $counter);
}

function show($faq, $database, $id, $mpre)
{
    $qry = "SELECT title, content FROM {$mpre}faqcont WHERE artid='$id' AND published=1";
    $result = $database->openConnectionWithReturn($qry);
    list($title, $content) = mysql_fetch_array($result);

    $qry = "UPDATE {$mpre}faqcont SET counter=counter+1 WHERE artid=$id";
    $database->openConnectionNoReturn($qry);

    $pat= "SRC=images";
    $replace= "SRC=../images";

    $pat2= "SRC=\"images";
    $replace2= "SRC=\"../images";

    $content=eregi_replace($pat, $replace, $content);
    $content=eregi_replace($pat2, $replace2, $content);

    $faq->showfaq($title, $id, $content);
}

?>