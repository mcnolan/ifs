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
  * Comments: Allows Awards Director to nominate characters for awards
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	echo "<h1>Grant An Award:</h1><br />\n";

	if (!$sid)
    {
    	?>
    	Which ship is this person on?<br />
        <form action="index.php?option=ifs&amp;task=awards&amp;action=award" method="post">
    	<select name="sid">
        <?php
        $qry = "SELECT id, name FROM {$spre}ships WHERE tf<>'99' AND co<>'0'
                ORDER BY name";
        $result = $database->openConnectionWithReturn($qry);
        while ( list ($sid, $sname) = mysql_fetch_array($result) )
            echo "<option value=\"$sid\">$sname</option>\n";

        echo "</select>\n";
        echo "<input type=\"submit\" value=\"Go\"></form>\n";
    }
    elseif (!$cid)
    {
  	  $qry = "SELECT c.id, r.rankdesc, c.name FROM {$spre}rank r, {$spre}characters c
	            WHERE c.ship='$sid' AND c.rank=r.rankid ORDER BY r.level, c.name";
	    $result = $database->openConnectionWithReturn($qry);

	    $qry2 = "SELECT id, name, level FROM {$spre}awards WHERE active='1' ORDER BY level, name";
	    $result2 = $database->openConnectionWithReturn($qry2);
	    ?>
	    <form action="index.php?option=ifs&amp;task=awards&amp;action=award" method="post">
	    <input type="hidden" name="sid" value="<?php echo $sid ?>">

	    Crew: <select name="cid">
	    <option selected="selected"></option>
	    <?php
	    while (list($cid, $rname, $cname) = mysql_fetch_array($result))
	        echo "<option value=\"$cid\">$rname $cname</option>\n";
	    ?>
	    </select><br /><br />

	    Award: <select name="award">
	    <option selected="selected"></option>
	    <?php
	    while (list($aid, $aname, $level) = mysql_fetch_array($result2))
	        echo "<option value=\"$aid\">$aname (level $level)</option>\n";
	    ?>
	    </select><br /><br />

	    Reason (include sample posts if necessary):<br />
	    <textarea name="reason" rows="10" cols="70"></textarea><br /><br />

	    Submitted By: <?php echo get_usertype($database, $mpre, $spre, '0', $uflag) ?><br /><br />

	    <input type="submit" value="Submit" />
	    </form>
	    <?php
	}
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
        $approved = "2";

	    $pname = get_usertype($database, $mpre, $spre, $cid, $uflag);
	    $pname = addslashes($pname);

        $qry = "SELECT u.email
	            FROM {$mpre}users u, {$spre}ships s, {$spre}characters c
	            WHERE s.id='$ship' AND s.co=c.id AND c.player=u.id";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($coemail) = mysql_fetch_array($result);

	    $qry = "INSERT INTO {$spre}awardees
	            SET date='$date', award='$award', recipient='$cid', player='$player',
	                rank='$rank', ship='$ship', reason='$reason', nominator='$pname',
	                nemail='$nemail', approved='$approved'";
	    $database->openConnectionNoReturn($qry);
	    $rid = mysql_insert_id();

        $aname = addslashes($aname);
        $qry = "INSERT INTO {$spre}record
                SET pid='$player', cid='$cid', level='In-Character', date='$date',
                    entry='Award: $aname', details='$reason', name='$pname', admin='n'";
        $database->openConnectionNoReturn($qry);

        $qry = "SELECT email FROM {$mpre}users WHERE id='$player'";
        $result = $database->openConnectionWithReturn($qry);
        list ($email) = mysql_fetch_array($result);

        require_once "includes/mail/award_player.mail.php";

        require_once "includes/mail/award_co.mail.php";

	    echo "<h1>Fleet Awards</h1>\n";
	    echo "<p>And the award has been granted!  Poof!  Like magic!</p><br /><br />\n";
    }
}
?>
