<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net
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
  * Date:	5/11/04
  * Comments: Functions for Fleet Awards
  *
 ***/

// Get award description page
function awards_detail ($database, $mpre, $spre, $award)
{
	$qry = "SELECT id, name, level, active, image, intro, descrip
    		FROM {$spre}awards WHERE id='$award'";
    $result = $database->openConnectionWithReturn($qry);
    list ($id, $name, $level, $active, $image, $intro, $descrip) = mysql_fetch_array($result);

    $qry = "SELECT a.id, a.date, a.rank, r.rankdesc, c.name, s.name
    	 	FROM {$spre}rank r, {$spre}characters c, {$spre}ships s, {$spre}awardees a
            WHERE a.award='$id' AND a.recipient=c.id AND (a.rank=r.rankid OR (a.rank='0'
            	AND r.rankid='1')) AND a.ship=s.id AND a.approved='2'
            ORDER BY a.date DESC LIMIT 0,10";
    $result = $database->openConnectionWithReturn($qry);

    echo "<h1>$name</h1>\n";
    echo "Level $level Award<br />\n";
    if ($active < '1')
    	echo "<i>DISCONTINUED</i><br />\n";
    if ($image)
    	echo "<img src=\"awards/{$image}\" alt=\"{$name}\" /><br />\n";

    echo "<p>$intro</p>\n";
    echo "<p>$descrip</p>\n";
    echo "<br />\n";

	if (mysql_num_rows($result))
    {
	    echo "<h2>Recent Recipients</h2>\n";
	    while (list ($rid, $rdate, $rankid, $rrank, $rname, $sname) = mysql_fetch_array($result)) {
        	if ($rdate != '0')
	        	$rdate = date("F j, Y", $rdate) . ": ";
            else
            	$rdate = "";

            if ($rankid == '0')
            	$rrank = "";
            else
            	$rrank .= " ";

	    	echo "${rdate}<a href=\"index.php?option=" . option . "&action=" . action .
            	 "&task=common&lib=areason&rid=$rid\">{$rrank}$rname, $sname</a><br />\n";
		}
        echo "<br />";
	    echo "<a href=\"index.php?option=" . option . "&action=" . action .
        	 "&task=common&lib=arecip&award=$id\">View All Recipients</a><br />\n";
	}
}

// General page listing all awards plus short intro
function awards_list ($database, $mpre, $spre)
{
   	echo "<h1>Awards</h1>\n";

    $qry = "SELECT level FROM {$spre}awards GROUP BY level ORDER BY level ASC";
    $result = $database->openConnectionWithReturn($qry);
    while (list($level) = mysql_fetch_array($result))
    {
		echo "<h2>Level {$level} Awards</h2>\n";
		$qry2 = "SELECT id, name, intro FROM {$spre}awards
        		 WHERE active='1' AND level='$level' ORDER BY name";
	    $result2 = $database->openConnectionWithReturn($qry2);
	    while (list($id, $award, $intro) = mysql_fetch_array($result2))
	        echo "<p><a href=\"index.php?option=" . option . "&task=" . task .
            	 "&action=common&lib=adet&award={$id}\">$award</a><br \>\n" .
				 "<blockquote>$intro</blockquote></p>\n";
	    echo "<br /><br />";
    }
    echo "<br /><br />";

	$qry = "SELECT id, name, intro, level FROM {$spre}awards WHERE active<'1' ORDER BY level, name";
    $result = $database->openConnectionWithReturn($qry);
    while (list($id, $award, $intro, $level) = mysql_fetch_array($result))
        echo "<p><a href=\"index.php?option=" . option . "&task=" . task .
        	 "&action=common&lib=adet&award={$id}\">$award</a> <i>(discontinued)</i> " .
             "- Level $level<br />\n" .
			 "<blockquote>$intro</blockquote></p>\n";
    echo "<br /><br />";
}

// Award page for recipients
function awards_reason ($database, $mpre, $spre, $rid)
{
    $qry = "SELECT a.date, a.reason, a.rank, b.name, b.image, r.rankdesc, r.level, c.id, c.name, s.name
    	 	FROM {$spre}rank r, {$spre}characters c, {$spre}ships s, {$spre}awardees a, {$spre}awards b
            WHERE a.id='$rid' AND a.recipient=c.id
            	AND (a.rank=r.rankid OR(a.rank='0' AND r.rankid='1'))
                AND a.ship=s.id AND a.award=b.id
            ORDER BY a.date DESC";
    $result = $database->openConnectionWithReturn($qry);
    list ($rdate, $reason, $rankid, $aname, $image, $rrank, $ranklev, $cid, $rname, $sname)
    	= mysql_fetch_array($result);

    $qry = "SELECT r.level, r.rankdesc, s.name
    		FROM {$spre}rank r, {$spre}ships s, {$spre}characters c
            WHERE c.id='$cid' AND c.rank=r.rankid AND c.ship=s.id";
    $result = $database->openConnectionWithReturn($qry);
    list ($nowranklev, $nowrank, $nowship) = mysql_fetch_array($result);

    if ($rankid == '0')
    {
    	$rrank = "";
        $ranklev = $nowranklev;
        $nowrank = "";
    }
    if ($rdate == '0')
    	$rdate = "";
    else
		$rdate = "On " . date("F j, Y", $rdate) . "<br />\n";

    echo $rdate;
    echo "<h2>$rrank $rname <font size=\"-2\"><i>($sname)</i></font></h2>\n";
    echo "received the<br />";
    echo "<h1>$aname</h1>\n";
    echo "<img src=\"awards/{$image}\" alt=\"{$aname}\" /><br /><br />\n";

    if ($reason)
    {
	    echo "with the following reason:";
	    echo "<blockquote>$reason</blockquote>\n";
	    echo "<br /><br />";
    }

    if ($ranklev < $nowranklev)
    	echo "Since receiving this award, $rname has been promoted to $nowrank.<br />\n";
    elseif ($ranklev > $nowranklev)
    	echo "Since receiving this award, $rname has been demoted to $nowrank.<br />\n";
    elseif ($rrank != $nowrank)
    	echo "Since receiving this award, {$rname}'s rank changed to $nowrank.<br />\n";

    if ($sname != $nowship)
    	echo "Since receiving this award, $rname transferred to $nowship.<br />\n";
}

// List recipients of award
function awards_recipients($database, $mpre, $spre, $award)
{
	$qry = "SELECT name, level, active FROM {$spre}awards WHERE id='$award'";
    $result = $database->openConnectionWithReturn($qry);
    list ($name, $level, $active) = mysql_fetch_array($result);

    $qry = "SELECT a.id, a.date, a.rank, r.rankdesc, c.name, s.name
    	 	FROM {$spre}rank r, {$spre}characters c, {$spre}ships s, {$spre}awardees a
            WHERE a.award='$award' AND a.recipient=c.id
            	AND (a.rank=r.rankid OR (a.rank='0' AND r.rankid='1'))
                AND c.ship=s.id AND a.approved='2'
            ORDER BY a.date DESC";
    $result = $database->openConnectionWithReturn($qry);

    echo "<h1>$name</h1>\n";
    echo "Level $level Award<br />\n";
    if ($active < '1')
    	echo "<i>DISCONTINUED</i><br />\n";

	echo "<h2>Recipients</h2>\n";
    while (list ($rid, $rdate, $rankid, $rrank, $rname, $sname) = mysql_fetch_array($result))
    {
       	if ($rdate != '0')
        	$rdate = date("F j, Y", $rdate) . ": ";
        else
           	$rdate = "";

        if ($rankid == '0')
           	$rrank = "";
        else
           	$rrank .= " ";

    	echo "${rdate}<a href=\"index.php?option=" . option . "&action=" . action .
        	 "&task=common&lib=areason&rid=$rid\">{$rrank}$rname, $sname</a><br />\n";
	}
}

?>