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
  * Date:	1/27/04
  * Comments: Submits & files monthly report
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	$qry = "SELECT name, co FROM {$spre}taskforces WHERE tf='$tfid' AND tg='0'";
    $result = $database->openConnectionWithReturn($qry);
    list ($tfname, $tfcoid) = mysql_fetch_array($result);

    $qry = "SELECT c.name, r.rankdesc, u.email
    		FROM {$mpre}users u, {$spre}characters c, {$spre}rank r
			WHERE c.id='$tfcoid' AND c.player=u.id AND r.rankid=c.rank";
    $result = $database->openConnectionWithReturn($qry);
    list ($tfco, $tfrank, $tfcoemail) = mysql_fetch_array($result);
    $tfco = $tfrank . " " . $tfco;

	// total ships
	$qry = "SELECT COUNT(*) FROM {$spre}ships WHERE tf='$tfid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($ships) = mysql_fetch_array($result);

	// active ships
	$qry = "SELECT count(*) FROM {$spre}ships WHERE tf='$tfid' AND (status='Operational' OR status='Docked at Starbase')";
    $result = $database->openConnectionWithReturn($qry);
    list ($actships) = mysql_fetch_array($result);

	// open ships
	$qry = "SELECT count(co) FROM {$spre}ships WHERE tf='$tfid' AND co='0'";
    $result = $database->openConnectionWithReturn($qry);
    list ($openships) = mysql_fetch_array($result);

	$inships = $ships - $actships - $openships;
	$coships = $ships - $openships;

  	// Total characters
	$qry = "SELECT COUNT(*) FROM {$spre}characters c, {$spre}ships s WHERE s.tf='$tfid' AND c.ship = s.id";
    $result = $database->openConnectionWithReturn($qry);
	list ($totalchar) = mysql_fetch_array($result);

    $avchar = $totalchar / $coships;
	$date = time();

    // Find recipients - anyone in the user database with the FCOps & Triad flags
    $qry = "SELECT email FROM {$mpre}users WHERE flags LIKE '%o%' OR flags LIKE '%a%'";
    $result = $database->openConnectionWithReturn($qry);
    $recip = "";
    while (list ($email) = mysql_fetch_array($result))
    	$recip .= $email . ", ";

	$mailersubject = "Monthly Report for Task Force " . $tfid;
	$mailerbody = "Task Force: $tfid - $tfname\n";
    $mailerbody .= "CO: $tfco\n";
	$mailerbody .= "\n";
	$mailerbody .= "Total Ships: $ships\n";
	$mailerbody .= "    CO'ed Ships: $coships\n";
	$mailerbody .= "        Active Ships: $actships\n";
	$mailerbody .= "        Inactive Ships: $inships\n";
	$mailerbody .= "    Open Ships: $openships\n";
	$mailerbody .= "\n";
	$mailerbody .= "Total Characters: $totalchar\n";
	$mailerbody .= "Average Characters per COed ship: $avchar\n";
	$mailerbody .= "\n";
	$mailerbody .= "Promotions:\n";
	$mailerbody .= "$promotions\n\n";
	$mailerbody .= "New COs:\n";
	$mailerbody .= "$newco\n\n";
	$mailerbody .= "Resigned COs:\n";
	$mailerbody .= "$resigned\n\n";
	$mailerbody .= "Website Updates:\n";
	$mailerbody .= "$webupdates\n\n";
	$mailerbody .= "Other Notes:\n";
	$mailerbody .= "$other\n\n";
	$mailerbody .= "Submitted " . date("F j, Y") . "\n";


	$header = "From: " . $tfco . " <" . $tfcoemail . ">";
    $recip .= $tfcoemail;
	mail ($recip, $mailersubject, $mailerbody, $header);

	$tfco = addslashes($tfco);
	$qry = "INSERT INTO {$spre}tfreports SET date='$date', tf='$tfid', co='$tfco',
	    		ships='$ships', cos='$coships', active='$actships', inactive='$inships',
	            open='$openships', characters='$totalchar', avgchar='$avchar',
	            promotions='$promotions', newco='$newco', resigned='$resigned',
				webupdates='$webupdates', notes='$other'";
	$database->openConnectionNoReturn($qry);

	echo "<h1>You report has been submitted.</h1>\n";
}
?>