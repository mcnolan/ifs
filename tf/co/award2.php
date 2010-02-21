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
  * Date:	6/03/04
  * Comments: Allows COs to nominate characters for awards
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	$qry = "SELECT name, player, rank, ship FROM {$spre}characters WHERE id='$cid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($cname, $player, $rank, $ship) = mysql_fetch_array($result);

    $qry = "SELECT name, level FROM {$spre}awards WHERE id='$award'";
    $result = $database->openConnectionWithReturn($qry);
    list ($aname, $level) = mysql_fetch_array($result);

    $qry = "SELECT email FROM {$mpre}users WHERE id='" . uid . "'";
    $result = $database->openConnectionWithReturn($qry);
    list ($nemail) = mysql_fetch_array($result);

    $date = time();
    if ($level == '1')
    	$approved = "2";
    else
    	$approved = "1";

	$pname = get_usertype($database, $mpre, $spre, $cid, $uflag);
	$pname = addslashes($pname);

	$qry = "SELECT email FROM {$mpre}users WHERE id='" . UID . "'";
	$result = $database->openConnectionWithReturn($qry);
	list ($coemail) = mysql_fetch_array($result);

    $qry = "INSERT INTO {$spre}awardees
    		SET date='$date', award='$award', recipient='$cid', player='$player',
            	rank='$rank', ship='$ship', reason='$reason', nominator='$pname',
                nemail='$nemail', approved='$approved'";
    $database->openConnectionNoReturn($qry);
    $rid = mysql_insert_id();

    if ($approved == "2")
    {
    	$aname = addslashes($aname);
    	$qry = "INSERT INTO {$spre}record
        		SET pid='$player', cid='$cid', level='In-Character', date='$date',
                	entry='Award: $aname', details='$reason', name='$pname', admin='n'";
        $database->openConnectionNoReturn($qry);

		$qry = "SELECT email FROM {$mpre}users WHERE id='$player'";
        $result = $database->openConnectionWithReturn($qry);
        list ($email) = mysql_fetch_array($result);

		$cname = stripslashes($cname);
		$aname = stripslashes($aname);
		$reason = stripslashes($reason);

	   	$mailersubject = "Congratulations - You've Received An Award!";
		$mailerbody = "Hello, $cname, and congratulations!\n\n";
        $mailerbody .= "You've just been awarded the $fleetname $aname.  Your Commanding Officer had this to say about you:\n";
		$mailerbody .= "---\n";
		$mailerbody .= $reason;
        $mailerbody .= "\n---\n\n";
        $mailerbody .= "Head on over to {$live_site}/index.php?option=ifs&task=common&action=common&lib=areason&rid=$rid to receive your award!\n";
		$mailerbody .= "\n\nThis message was automatically generated.";

		$header = "From: " . email-from;
		mail ($email, $mailersubject, $mailerbody, $header);

	   	$mailersubject = "One Of Your Crew Received An Award!";
		$mailerbody = "Hello,\n\n";
		$mailerbody .= "A member of your crew, $cname, has just been awarded the $fleetname $aname!\n";
        $mailerbody .= "You had this to say about him/her:\n";
		$mailerbody .= "---\n";
		$mailerbody .= $reason;
        $mailerbody .= "\n---\n\n";
        $mailerbody .= "Head on over to {$live_site}/index.php?option=ifs&task=common&action=common&lib=areason&rid=$rid to view the award!\n";
		$mailerbody .= "\n\nThis message was automatically generated.";

		$header = "From: " . email-from;
		mail ($coemail, $mailersubject, $mailerbody, $header);
	}
    else
    {
	   	$mailersubject = "Pending Award";
		$mailerbody = "Award: $aname\n";
        $mailerbody .= "There is a new pending $fleetname Award submission waiting for your approval.\n";
        $mailerbody .= "Head on over to {$live_site}/index.php?option=ifs&task=awards&action=pending to review this submission.\n";
		$mailerbody .= "\n\nThis message was automatically generated.";

		$header = "From: " . email-from;
		mail (webmasteremail, $mailersubject, $mailerbody, $header);

	   	$mailersubject = "Pending Award";
        $mailerbody .= "You've just submitted an award for approval.\n\n";
		$mailerbody = "Award: $aname\n";
		$mailerbody .= "Crew: $cname\n";
		$mailerbody .= "\n\nThis message was automatically generated.";

		$header = "From: " . email-from;
		mail ($coemail, $mailersubject, $mailerbody, $header);

	}

    echo "<h1>$fleetname Awards</h1>\n";
    echo "<p>Your submission has been received.  Thanks for taking good care of your crew!</p><br /><br />\n";
}
?>