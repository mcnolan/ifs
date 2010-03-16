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
  * Version:	1.14n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This program contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
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

	require_once "includes/mail/report_tfco.mail.php";


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
