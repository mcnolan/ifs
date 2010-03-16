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
  * Date:	12/22/03
  * Comments: Submits & files monthly report
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
elseif ($sid == "0" || !$sid)
	echo "Error!  Ship ID not specified!";
else
{
	$qry = "SELECT * FROM {$spre}ships WHERE id='$sid'";
	$result=$database->openConnectionWithReturn($qry);
	list($sid,$sname,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,,,$desc)=mysql_fetch_array($result);

	$qry = "SELECT id, name, rank, pos, player FROM {$spre}characters WHERE ship='$sid'";
	$result=$database->openConnectionWithReturn($qry);

	$qry2 = "SELECT name, rank, player FROM {$spre}characters WHERE id='$co'";
	$result2 = $database->openConnectionWithReturn($qry2);
	list($coname, $corank, $uid) = mysql_fetch_array($result2);

	$qry2 = "SELECT email FROM " . $mpre . "users WHERE id='$uid'";
	$result2=$database->openConnectionWithReturn($qry2);
	list($coemail)=mysql_fetch_array($result2);
	$recip = $coemail;

	$qry3 = "SELECT co, tg FROM {$spre}taskforces WHERE tf='$tf'";
	$result3=$database->openConnectionWithReturn($qry3);
	while ( list($tgco,$tgid)=mysql_fetch_array($result3) )
    {
		if ($tgid == $tg || $tgid == 0)
        {
			$qry4 = "SELECT player FROM {$spre}characters WHERE id='$tgco'";
			$result4=$database->openConnectionWithReturn($qry4);
			list($pid)=mysql_fetch_array($result4);

			$qry4 = "SELECT email FROM " . $mpre . "users WHERE id='$pid'";
			$result4=$database->openConnectionWithReturn($qry4);
			list($tfemail)=mysql_fetch_array($result4);
			$recip .= ", " . $tfemail;
		}
	}

	$qry4 = "SELECT rankdesc FROM {$spre}rank WHERE rankid='$corank'";
	$result4=$database->openConnectionWithReturn($qry4);
	list($rank) = mysql_fetch_array($result4);
    $commoff = $rank . " " . $coname . " (" . $coemail . ")";

	$crewcount = 0;
	while ( list($cid,$cname,$crank,$pos,$player)=mysql_fetch_array($result) )
    {
		++$crewcount;

		$qry4 = "SELECT rankdesc FROM {$spre}rank WHERE rankid='$crank'";
		$result4=$database->openConnectionWithReturn($qry4);
		list($rank) = mysql_fetch_array($result4);

		$qry4 = "SELECT email FROM " . $mpre . "users WHERE id='$player'";
		$result4=$database->openConnectionWithReturn($qry4);
		list($email) = mysql_fetch_array($result4);

		$crewlisting .= $rank . " " . $cname . "\n" . $pos . "\n" . $email . "\n\n";
	}
	require_once "includes/mail/report_ship.mail.php";

	$header = "From: " . $coemail;
	mail ($recip, $mailersubject, $mailerbody, $header);

	$qry = "UPDATE {$spre}ships SET report=now() WHERE id=" . $sid;
	$result=$database->openConnectionWithReturn($qry);

	$date = time();
	$crewlisting = addslashes($crewlisting);
	$commoff = addslashes($commoff);
	$qry = "INSERT INTO {$spre}reports SET date='$date', ship='$sid', co='$commoff', url='$site',
    		status='$status', crew='$crewcount', crewlist='$crewlisting', mission='$mission',
            missdesc='$missdesc', improvement='$improvement', comments='$comments'";
	$database->openConnectionNoReturn($qry);

	echo "<h2>You report has been submitted.</h2><br />\n";
}
?>
