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
  * Date:	1/23/03
  * Comments: Displays various Fleet statistics
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	// total ships
	$qry = "SELECT COUNT(*) FROM {$spre}ships WHERE tf<>'99'";
    $result = $database->openConnectionWithReturn($qry);
    list ($ships) = mysql_fetch_array($result);

	// active ships
	$qry = "SELECT count(*) FROM {$spre}ships
    		WHERE tf<>'99' AND (status='Operational' OR status='Docked at Starbase')";
    $result = $database->openConnectionWithReturn($qry);
    list ($actships) = mysql_fetch_array($result);

	// open ships
	$qry = "SELECT count(co) FROM {$spre}ships WHERE tf<>'99' AND co='0'";
    $result = $database->openConnectionWithReturn($qry);
    list ($openships) = mysql_fetch_array($result);

	$inships = $ships - $actships - $openships;
	$coships = $ships - $openships;

	// ships in queue
	$qry = "SELECT count(tf) FROM {$spre}ships WHERE tf='99' AND tg='1'";
    $result = $database->openConnectionWithReturn($qry);
    list ($queue) = mysql_fetch_array($result);

	// ships mothballed
	$qry = "SELECT count(tf) FROM {$spre}ships WHERE tf='99' AND tg='2'";
    $result = $database->openConnectionWithReturn($qry);
    list ($mothball) = mysql_fetch_array($result);

	// Real characters (chars assigned to any ship not in the Admin TF)
	$realcharcount = 0;
	$qry = "SELECT COUNT(*) FROM {$spre}characters c, {$spre}ships s WHERE s.tf<>'99' AND c.ship = s.id";
    $result = $database->openConnectionWithReturn($qry);
	list ($realcharcount) = mysql_fetch_array($result);

	// Total characters (chars assigned to any ship other than Deleted Characters)
	$totalchar = 0;
	$qry = "SELECT COUNT(*) FROM {$spre}characters c, {$spre}ships s WHERE s.id<>'74' AND c.ship = s.id";
    $result = $database->openConnectionWithReturn($qry);
	list ($totalchar) = mysql_fetch_array($result);

	// Total characters assigned to active ships
	$actcharcount = 0;
	$qry = "SELECT COUNT(*) FROM {$spre}characters c, {$spre}ships s WHERE (s.status='Operational' OR s.status='Docked at Starbase') AND c.ship = s.id";
    $result = $database->openConnectionWithReturn($qry);
	list ($actcharcount) = mysql_fetch_array($result);

	// total players (users with at least one character)
	$qry = "SELECT player FROM {$spre}characters WHERE ship<>'74' GROUP BY player";
	$result = $database->openConnectionWithReturn($qry);
	$pnum = mysql_num_rows($result);

	$avgchar = round(($realcharcount / $coships),1);
    $otherchar = $totalchar - $realcharcount;
	$actavgchar = round(($actcharcount / $actships),1);
	$sleepchar = $realcharcount - $actcharcount;
	$charperplay = round(($totalchar / $pnum),1);

	?>
	<br />
	<center><font size="+2"><b><u>Obsidian Fleet Statistics</u></b></font></center><br />
	<br />
	<b>Total Ships: </b><?php echo $ships ?> (does not include Queue and Mothball)<br />
	&nbsp;&nbsp;&nbsp;<b>CO'ed Ships: </b><?php echo $coships ?><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Active Ships: </b><?php echo $actships ?><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Inactive Ships: </b><?php echo $inships ?><br />
	&nbsp;&nbsp;&nbsp;<b>Open Ships: </b><?php echo $openships ?><br />
	<br />
    <b>Total Characters:</b> <?php echo $totalchar ?><br />
	&nbsp;&nbsp;&nbsp;<b>Active Characters:</b> <?php echo $actcharcount ?><br />
	&nbsp;&nbsp;&nbsp;<b>Inactive Characters:</b> <?php echo $sleepchar ?><br />
	&nbsp;&nbsp;&nbsp;<b>Other Characters (pending, R10):</b> <?php echo $otherchar ?><br /><br />

	<b>Average Characters per CO'ed Ship:</b> <?php echo $avgchar ?><br />
	<b>Average characters per active ship:</b> <?php echo $actavgchar ?><br /><br />

	<b>Total Players:</b> <?php echo $pnum ?><br />
	<b>Average Characters per Player:</b> <?php echo $charperplay ?><br />

	<br />
	Queued Ships: <?php echo $queue ?><br />
	Mothballed Ships: <?php echo $mothball ?><br />

	<br /><br />
	<u><b>Task Force Listings</b></u><br /><br />
	<?php
	$qry = "SELECT tf, name FROM {$spre}taskforces WHERE tg='0' AND tf<>'99' ORDER BY tf";
	$result = $database->openConnectionWithReturn($qry);
	while ( list ($tfid,$tfname) = mysql_fetch_array($result) )
    {
		$qry2 = "SELECT id FROM {$spre}ships WHERE tf='$tfid'";
		$result2=$database->openConnectionWithReturn($qry2);
		$ships = mysql_num_rows($result2);

		$qry3 = "SELECT id FROM {$spre}ships WHERE tf='$tfid' AND (status='Operational' OR status='Docked at Starbase')";
		$result3=$database->openConnectionWithReturn($qry3);
		$actships = mysql_num_rows($result3);

		$qry3 = "SELECT id FROM {$spre}ships WHERE tf='$tfid' AND co='0'";
		$result3=$database->openConnectionWithReturn($qry3);
		$openships = mysql_num_rows($result3);

		$inships = $ships - $actships - $openships;
		$coships = $ships - $openships;

	    $qry2 = "SELECT COUNT(*) FROM {$spre}ships s, {$spre}characters c
        			WHERE s.tf='$tfid' AND s.id = c.ship";
		$result2 = $database->openConnectionWithReturn($qry2);
        list($charcount) = mysql_fetch_array($result2);

	    $qry = "SELECT COUNT(*) FROM {$spre}characters c, {$spre}ships s
        			WHERE (s.status='Operational' OR s.status='Docked at Starbase')
                    AND c.ship = s.id AND s.tf='$tfid'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($actcharcount) = mysql_fetch_array($result);

		if ($coships != 0)
			$avgchar = round(($charcount / $coships),1);
		else
			$avgchar = 0;
		$actavgchar = round(($actcharcount / $actships),1);

		?>
		<b>Task Force: </b>Task Force <?php echo $tfid; ?> -- <?php echo $tfname; ?><br />
		<b>Total Ships: </b><?php echo $ships; ?><br />
		&nbsp;&nbsp;&nbsp;<b>CO'ed Ships: </b><?php echo $coships; ?><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Active Ships: </b><?php echo $actships; ?><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Inactive Ships: </b><?php echo $inships; ?><br />
		&nbsp;&nbsp;&nbsp;<b>Open Ships: </b><?php echo $openships; ?><br />
		<b>Total Characters:</b> <?php echo $charcount; ?><br />
		<b>Average Characters per CO'ed Ship:</b> <?php echo $avgchar; ?><br />
		<b>Average Characters per active ship:</b> <?php echo $actavgchar; ?><br />
		<br />
		<?php
	}
}
?>