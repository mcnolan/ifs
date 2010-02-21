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

	$mailersubject = "Monthly Report for the " . $sname;
	$mailerbody = "Ship Name: " . $sname . " ({$sid})\n";
	$mailerbody .= "Commanding Officer: " . $commoff . ".\n";
	$mailerbody .= "Ship's Website: " . $site . "\n";
	$mailerbody .= "Ship's Status: " . $status . "\n";
	$mailerbody .= "\n\nCrew List:\n";

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
	$mailerbody .= $crewlisting;

	$mailerbody .= "Simm Information:\n";
	$mailerbody .= "~~~~~~~~~~~~~~~~~\n";
	$mailerbody .= "Current Mission Title: " . $mission . "\n\n";
	$mailerbody .= "Mission Description:\n";
	$mailerbody .= "$missdesc\n\n";
	$mailerbody .= "What have you done this month to improve the quality of your sim?\n";
	$mailerbody .= "$improvement\n\n\n";

	$mailerbody .= "Misc Information:\n";
	$mailerbody .= "~~~~~~~~~~~~~~~~~\n";
	$mailerbody .= "Additional Comments:\n";
	$mailerbody .= "$comments\n\n";

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