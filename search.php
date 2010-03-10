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
  * Date:	12/13/03
  *	Comments: Search stories, articles, faqs and content for user input.
 ***/

require ("classes/html/search.php");
$search = new search();

$search->openhtml();
if ($searchword==""||$searchword==" ")
	$search->nokeyword();
else
{
	$searchword = str_replace ('<', '&lt;', $searchword);
	$searchword = str_replace ('>', '&gt;', $searchword);

	$search->searchintro($searchword);

	$totalRows = 0;

	$qry = "SELECT sid, title, time, introtext
    		FROM {$mpre}stories
            WHERE ((title LIKE '%$searchword%' OR introtext LIKE '%$searchword%'
            	OR fultext LIKE '%$searchword%') AND published=1) ORDER BY time DESC";
    $result = $database->openConnectionWithReturn($qry);
    $totalRows = mysql_num_rows($result);
    if (mysql_num_rows($result) > 0)
	    for ($i = 0;
	    	 list ($id1[$i], $title1[$i], $time1[$i], $text1[$i]) = mysql_fetch_array($result);
	         $i++);
	if (is_array($id1))
	    array_pop($id1);
	$search->stories($id1, $title1, $time1, $text1, $searchword, $popup);

	$qry = "SELECT artid, title, content, date
    		FROM {$mpre}articles
            WHERE ((title LIKE '%$searchword%' OR content LIKE '%$searchword%')
            	AND published=1) ORDER BY date DESC";
    $result = $database->openConnectionWithReturn($qry);
    $totalRows += mysql_num_rows($result);
    if (mysql_num_rows($result) > 0)
	    for ($i = 0;
	    	 list ($id2[$i], $title2[$i], $text2[$i], $date2[$i]) = mysql_fetch_array($result);
	         $i++);
	if (is_array($id2))
	    array_pop($id2);
	$search->articles($id2, $title2, $time2, $text2, $searchword, $popup);

	$qry = "SELECT artid, title, content
    		FROM {$mpre}faqcont
            WHERE ((title LIKE '%$searchword%' OR content LIKE '%$searchword%') AND published=1)";
    $result = $database->openConnectionWithReturn($qry);
    $totalRows += mysql_num_rows($result);
    if (mysql_num_rows($result) > 0)
	    for ($i = 0;
	    	 list ($id3[$i], $title3[$i], $text3[$i]) = mysql_fetch_array($result);
	         $i++);
	if (is_array($id3))
	    array_pop($id3);
	$search->faqs($id3, $title3, $text3, $searchword, $popup);

	$qry = "SELECT mcid, menuid, content, heading
    		FROM {$mpre}menucontent
            WHERE (content LIKE '%$searchword%' OR heading LIKE '%$searchword%')";
    $result = $database->openConnectionWithReturn($qry);
    $totalRows += mysql_num_rows($result);
    if (mysql_num_rows($result) > 0)
	    for ($i = 0;
    		 list ($id4[$i], $mid4[$i], $content4[$i], $heading4[$i]) = mysql_fetch_array($result2);)
	    {
	    	$qry2 = "SELECT inuse, sublevel FROM {$mpre}menu WHERE id='{$mid[$i]}'";
	        $result2 = $database->openConnectionWithReturn($qry2);
	        list ($inuse, $sublevel[$i]) = mysql_fetch_array($result2);
			if ($inuse != 0)
	        	$i++;
		}
	if (is_array($id4))
	    array_pop($id4);
	$search->content($id4, $mid4, $heading4, $content4, $sublevel, $searchword);

	$search->conclusion($totalRows, $searchword);

}
$search->closehtml();
?>