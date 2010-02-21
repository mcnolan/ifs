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
  * Date:   1/1/04
  *	Comments: Displays today's birthdays
 ***/

// Display details on who's birthday it is today
if ($bdetails == "1")
{
    $bdaydate = date("F j");
    echo "<h1>Birthdays on {$bdaydate}</h1>\n";

	$bdaydate = date("md");
	$qry = "SELECT id, username FROM {$mpre}users WHERE bday='$bdaydate' ORDER BY username";
    $result = $database->openConnectionWithReturn($qry);

    if (!mysql_num_rows($result))
    	echo "No birthdays today.\n";
    else
    {
	    while (list($uid, $bdayname) = mysql_fetch_array($result))
        {
	    	echo "<u>" . stripslashes($bdayname) . "</u><br />\n";

            $qry2 = "SELECT r.rankdesc, c.name, s.name FROM {$spre}rank r, {$spre}characters c, {$spre}ships s WHERE c.player='$uid' AND c.ship=s.id AND c.rank=r.rankid AND c.ship!='74' ORDER BY r.level DESC";
			$result2 = $database->openConnectionWithReturn($qry2);
            if (!mysql_num_rows($result2))
            	echo "No characters.<br /><br />\n";
            else
            	while (list($rank, $cname, $sname) = mysql_fetch_array($result2))
                {
                	$rank = stripslashes($rank);
                    $cname = stripslashes($cname);
                    $sname = stripslashes($sname);
                	echo "$rank $cname, $sname<br />\n";
                }
	    }
    }

}

// Just show the summary (in the column)
else
{
	$bdaydate = date("md");
	$qry2 = "SELECT username FROM {$mpre}users WHERE bday='$bdaydate'";
    $result2 = $database->openConnectionWithReturn($qry2);

    if (!mysql_num_rows($result2))
    	$content = "No birthdays today.\n";
    else
    {
    	$content = "";
	    while (list($bdayname) = mysql_fetch_array($result2))
	    	$content .= $bdayname . "<BR>";
        $content .= "&nbsp;&nbsp;<a HREF=\"index.php?option=birthdays\">Details</a>\n";
    }

    $bdaydate = date("F j");
    $title = "Birthdays on<br />{$bdaydate}\n";
}
?>