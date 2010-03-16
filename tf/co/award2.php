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

	   	require_once "includes/mail/award_player.mail.php";
		
	   	require_once "includes/mail/award_co.mail.php";
	}
    else
    {
	   	require_once "includes/mail/award_pending_co.mail.php";
		require_once "includes/mail/award_pending_site.mail.php";

	}

    echo "<h1>$fleetname Awards</h1>\n";
    echo "<p>Your submission has been received.  Thanks for taking good care of your crew!</p><br /><br />\n";
}
?>
