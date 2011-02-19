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
  * Version:	1.15n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  * Patch 1.15n:  April 2010
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	10/22/04
  * Comments: Functions for viewing & manipulating ship info
  *
  * See CHANGELOG for patch details
  *
 ***/

function ship_add ($database, $mpre, $spre, $uflag, $tfid, $format, $sname, $class, $registry, $status, $grpid)
{
	$qry = "SELECT id FROM {$spre}ships WHERE name='$sname' OR registry='$registry'";
    $result = $database->openConnectionWithReturn($qry);
    if (mysql_num_rows($result))
    {
	    echo "<center><h1>Ship Not Added!!</h1><br />\n";
    	echo "Name and/or Registry already in use!</center>\n";
    }
    else
    {
		$qry = "INSERT INTO {$spre}ships
        		SET name='$sname', registry='$registry', class='$class',
                	tf='$tfid', tg='$grpid', status='$status', format='$format',
                    sorder='3'";
		$database->openConnectionNoReturn($qry);

	    echo "<center><h1>Ship Added</h1><br />\n";
	    echo "<font size=\"+1\">\n";
	    echo "Name: $sname<br />\n";
	    echo "Registry: $registry<br />\n";
		echo "Class: $class<br />\n";
	    echo "Format: $format<br />\n";
	    echo "TF: $tfid<br />\n";
	    echo "TG: $grpid<br />\n";
	    echo "Status: $status<br /><br />\n";

	    echo "<a href=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=sview&amp;sid=" . mysql_insert_id() . "\">Ship Manifest</a><br />\n";
	    echo "<a href=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=sadmin&amp;sid=" . mysql_insert_id() . "\">Ship Admin</a><br /><br />\n";
    }
}

// Save changes from admin screen
function ship_admin_save ($database, $mpre, $spre, $shipid, $coid, $name, $registry, $class, $website, $format, $grpid, $status, $image, $sorder, $notes, $uflag)
{
	$qry = "SELECT co, tf, status FROM {$spre}ships WHERE id='$shipid'";
	$result=$database->openConnectionWithReturn($qry);
	list($co, $tfid, $oldstatus)=mysql_fetch_array($result);

    // Change in CO?
	if ($co != $coid)
    {
		$qry = "SELECT id FROM {$spre}ships WHERE co='$coid'";
		$result=$database->openConnectionWithReturn($qry);
		list($sid)=mysql_fetch_array($result);

		if ($sid)
        {
			$qry = "UPDATE {$spre}ships SET co='0' WHERE id='$sid'";
			$database->openConnectionNoReturn($qry);
		}

		$qry = "UPDATE {$spre}characters SET ship='$shipid' WHERE id='$coid'";
		$database->openConnectionNoReturn($qry);

       	$qry = "SELECT u.id, u.flags FROM {$mpre}users u, {$spre}characters c WHERE c.id='$coid' AND c.player=u.id";
        $result = $database->openConnectionWithReturn($qry);
        list ($userid, $userflags) = mysql_fetch_array($result);

        if (!strstr($userflags, "c"))
        {
           	$userflags = "c" . $userflags;
            $qry = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$userid'";
            $database->openConnectionNoReturn($qry);
        }

   		$qry = "SELECT u.id, u.flags FROM {$mpre}users u, {$spre}characters c WHERE c.id='$co' AND c.player=u.id";
  	    $result = $database->openConnectionWithReturn($qry);
        list ($userid, $userflags) = mysql_fetch_array($result);

        $userflags = preg_replace("/c/", "", $userflags);
   	    $qry = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$userid'";
        $database->openConnectionNoReturn($qry);
	}

	if ( ($oldstatus == "Waiting for Command Academy completion" && $status != $oldstatus) ||
		 ($oldstatus == "Open" && $status != $oldstatus) )
    {
		$body = "$name changed status from $oldstatus to $status.\n\n";
		$body .= "Congratulate them in the OF Update, or whatever it is you do with this info.\n\n";
		$header = "From: " . email-from;
		//mail ("lee@obsidianfleet.net", "Ship Status Change", $body, $header);
	}
	
	if($grpid == "") { $grpid = 0; }

	$qry = "UPDATE {$spre}ships
   			SET name='$name', registry='$registry', class='$class',
				website='$website', format='$format', co={$coid},
				tg={$grpid}, status='$status', image='$image',
				description='$notes'
                WHERE id={$shipid}";
	$result=$database->openConnectionWithReturn($qry);
    ?>

    <center><h1>Ship info updated</h1><br /><br />
    <font size=\"+1\">
    Name: <?php echo $name ?><br />
    Registry: <?php echo $registry ?><br />
	Class: <?php echo $class ?><br />
    Website: <?php echo $website ?><br />
    Format: <?php echo $format ?><br />
    CO: <?php echo $coid ?><br />
    TG: <?php echo $grpid ?><br />
    Status: <?php echo $status ?><br />
    Image: <?php echo $image ?><br />
    Description:<br />
    <table border="1"><tr>
    	<td><?php echo $notes ?></td>
    </tr></table></font><br /><br />
	<a href="index.php?option=ships&amp;tf=<?php echo $tfid ?>&amp;tg=<?php echo $grpid ?>">Return to Ship Listing</a><br />

	<?php
}

// Empty a ship's crew, transfer them all to "Transferred"
function ship_clear_crew ($database, $mpre, $spre, $sid, $reason, $uflag)
{
	$qry = "SELECT name FROM {$spre}ships WHERE id='$sid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($sname) = mysql_fetch_array($result);

    $qry = "SELECT id, player, name FROM {$spre}characters WHERE ship='$sid'";
    $result = $database->openConnectionWithReturn($qry);
    while (list($cid, $pid, $cname) = mysql_fetch_array($result))
    {
        $ptime = time();
		$pdate = date("F j, Y, g:i a", time());

		$qry2 = "UPDATE {$spre}characters
        		 SET ship='" . TRANSFER_SHIP . "', ptime='$ptime',
                 other='Transferred on $pdate' WHERE id='$cid'";
		$database->openConnectionNoReturn($qry2);

		$details = "Tranferred from: {$sname}<br />\n";
    	$details .= "Transferred to: Unassigned<br /><br />\n\n";
        $details .= $reason;
		$time = time();
	    $name = get_usertype($database, $mpre, $spre, $cid, $uflag);
		$qry2 = "INSERT INTO {$spre}record
        		 SET cid='$cid', pid='$pid', level='Out-of-Character',
                 date='$time', entry='Transfer', details='$details',
                 name='$name', admin='n'";
		$database->openConnectionNoReturn($qry2);
        $transnames .= $cname . "<br />";
    }

    $qry = "UPDATE {$spre}ships
    		SET co='0', xo='0', status='Waiting for CO '
            WHERE id='$sid'";
    $database->openConnectionNoReturn($qry);

    echo "<p align=\"center\"><font size=\"+2\"><b>\n";
    echo "$sname cleared.\n";
    echo "</b></font></p>\n";
    echo "<u>The following crew have been transferred to UNASSIGNED:</u><br />\n";
   	echo $transnames;
}

// Mothball a ship
function ship_delete ($database, $mpre, $spre, $sid, $uflag)
{
    $qry = "SELECT  name FROM {$spre}ships WHERE id='$sid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($sname) = mysql_fetch_array($result);

	// Set these crew as unassigned
    $qry = "SELECT id, name FROM {$spre}characters WHERE ship='$sid'";
    $result = $database->openConnectionWithReturn($qry);
    while (list($cid, $cname) = mysql_fetch_array($result))
    {
    	$details = "Tranferred from: {$sname}<br />\n";
    	$details .= "Transferred to: Unassigned<br /><br />\n\n";
        $details .= "Ship deleted.";
		$time = time();
	    $name = get_usertype($database, $mpre, $spre, $cid, $uflag);
		$qry2 = "INSERT INTO {$spre}record
        		 SET cid='$cid', pid='$pid', level='Out-of-Character',
                 date='$time', entry='Transfer', details='$details',
                 name='$name', admin='n'";
		$database->openConnectionNoReturn($qry2);
        $transnames .= $cname . "<br />";
	}

	$qry2 = "UPDATE {$spre}characters
    		 SET ship='" . TRANSFER_SHIP . "' WHERE ship='$sid'";
	$database->openConnectionNoReturn($qry2);

	$qry2 = "UPDATE {$spre}ships SET tf='99',tg='2' WHERE id='$sid'";
	$database->openConnectionNoReturn($qry2);

    echo "<p align=\"center\"><font size=\"+2\"><b>\n";
    echo "$sname deleted.\n";
    echo "</b></font></p>\n";
    echo "<u>The following crew have been transferred to UNASSIGNED:</u><br />\n";
	if ($transnames)
	   	echo $transnames;
    else
    	echo "None";
}

// Edit "description"
function ship_edit_notes ($database, $mpre, $spre, $shipid, $notes, $uflag)
{
	$qry = "SELECT co FROM {$spre}ships WHERE id='$shipid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($coid) = mysql_fetch_array($result);

	$qry = "UPDATE {$spre}ships
    		SET description='$notes' WHERE id=$shipid";
	$database->openConnectionNoReturn($qry);

	$qry = "SELECT username FROM {$mpre}users WHERE id='" . uid . "'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uname) = mysql_fetch_array($result);

	$qry = "INSERT INTO {$spre}logs
    	    (date, user, action, comments)
            VALUES (now(), '" . uid . " $uname', 'Notes updated', '$notes on ship $shipid')";
	$database->openConnectionNoReturn($qry);

    $qry = "SELECT name FROM {$spre}ships WHERE id='$shipid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($sname) = mysql_fetch_array($result);

	echo "<h1>Update Notes</h1>\n";
    echo "Notes for <i>$sname</i> changed to:<br />\n";
    echo "<table border=\"1\"><tr><td>$notes</td></tr></table><br />\n";
}

function ship_edit_website ($database, $mpre, $spre, $shipid, $url, $uflag)
{
	$qry = "SELECT co FROM {$spre}ships WHERE id='$shipid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($coid) = mysql_fetch_array($result);

	$qry = "UPDATE {$spre}ships SET website='$url' WHERE id=$shipid";
	$database->openConnectionNoReturn($qry);

	$qry = "SELECT username FROM {$mpre}users WHERE id='" . uid . "'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uname) = mysql_fetch_array($result);

	$qry = "INSERT INTO {$spre}logs
    	    (date, user, action, comments)
            VALUES (now(), '" . uid . " $uname', 'Website updated', '$url on ship $shipid')";
	$database->openConnectionNoReturn($qry);

	$qry = "SELECT name FROM {$spre}ships WHERE id='$shipid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($sname) = mysql_fetch_array($result);

	echo "<h1>Update Website</h1>\n";
	echo "Website for <i>$sname</i> changed to <i>$url</i>\n";
}

function ship_edit_xo ($database, $mpre, $spre, $shipid, $xoid, $uflag)
{
	$qry = "SELECT co FROM {$spre}ships WHERE id='$shipid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($coid) = mysql_fetch_array($result);

	$qry = "UPDATE {$spre}ships SET xo=$xoid WHERE id=$shipid";
	$database->openConnectionNoReturn($qry);

	$qry = "SELECT username FROM {$mpre}users WHERE id='" . uid . "'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uname) = mysql_fetch_array($result);

	$qry = "INSERT INTO {$spre}logs
    		(date, user, action, comments)
            VALUES (now(), '" . uid . " $uname', 'XO Updated', '$xoid on ship $shipid')";
	$database->openConnectionNoReturn($qry);

    $qry = "SELECT s.name, c.name
    		FROM {$spre}ships s, {$spre}characters c
            WHERE s.id='$shipid' AND s.xo=c.id";
    $result = $database->openConnectionWithReturn($qry);
    list ($sname, $cname) = mysql_fetch_array($result);

	echo "<h1>Update Executive Officer</h1>\n";
    echo "XO for <i>$sname</i> changed to <i>$cname</i>\n";
}

function ship_list ($database, $mpre, $spre, $sdb, $uflag, $textonly, $relpath, $sid, $sname, $reg, $site, $image, $co, $xo, $status, $class, $format, $tf, $tg, $desc)
{
	?>
	<center>
	<hr>

	<table width="600" border="0" cellspacing="3" cellpadding="3" align="center">
	     <tr><td align="center" colspan="2">
			 <?php
         	if( $site != 'none')
            {
            	echo "<a href=\"{$site}\" target=\"_blank\"><b><font size=\"+1\">";
				echo "$sname</font></b></a><br />\n";
   			}
            else
				echo "<b><font size=\"+1\">{$sname}</font></b><br />";

            echo $reg . "</td></tr><tr><td align=\"center\" colspan=\"2\">\n";

            if (!$textonly)
            {
	 			if ($site != 'none')
	  				echo "<a href=\"{$site}\" target=\"_blank\">";
   				echo "<img src=\"{$relpath}images/ships/{$image}\"  alt=\"$sname banner\" border=\"0\">\n";
                if ($site != "none")
                	echo "</a>\n";
   			}

 			echo "</td></tr><tr><td align=\"center\" width=\"50%\">\n";
			echo "<b>Commanding Officer:</b><br />";
			if ($co != 0)
            {
				$shipisopen = "no";

				$qry2 = "SELECT name,rank,player FROM {$spre}characters WHERE id=" . $co;
				$result2=$database->openConnectionWithReturn($qry2);
				list ($coname,$corank,$copid) = mysql_fetch_array($result2);
				$coname = stripslashes($coname);

				$qry2 = "SELECT email FROM {$mpre}users WHERE id='$copid'";
				$result2 = $database->openConnectionWithReturn($qry2);
				list($coemail)=mysql_fetch_array($result2);

				$qry2 = "SELECT rankdesc,image FROM {$spre}rank where rankid='$corank'";
				$result2=$database->openConnectionWithReturn($qry2);
				list($rname,$rurl)=mysql_fetch_array($result2);

                if (!$textonly)
					echo "<img src=\"{$relpath}images/{$rurl}\" align=\"absmiddle\"  alt=\"$rname\" border=\"0\" /><br />\n";
                echo "<a href=\"mailto:{$coemail}\">$rname $coname</a>\n";
			}
            else
            {
            	echo "&nbsp;&nbsp;&nbsp;Open -- apply today!\n";
 				$shipisopen = "yes";
   			}
			?>

   			</td><td align="center" width="50%">
   			<b>Executive Officer:</b><br />

			<?php
   			if($xo !=0)
            {
   				$qry2 = "SELECT name,rank,player FROM {$spre}characters WHERE id='$xo'";
   				$result2=$database->openConnectionWithReturn($qry2);
   				list ($xname,$xrank,$xpid) = mysql_fetch_array($result2);
   				$xname = stripslashes($xname);

   				$qry2 = "SELECT email FROM {$mpre}users WHERE id='$xpid'";
   				$result2=$database->openConnectionWithReturn($qry2);
   				list($xomail)=mysql_fetch_array($result2);

   				$qry2 = "SELECT rankdesc,image FROM {$spre}rank where rankid='$xrank'";
   				$result2=$database->openConnectionWithReturn($qry2);
   				list ($rname,$rurl) = mysql_fetch_array($result2);

                if (!$textonly)
	   				echo "<img src=\"{$relpath}images/{$rurl}\" align=\"absmiddle\"  alt=\"$rname\" border=\"0\" /><br />\n";
                echo "<a href=\"mailto:{$xomail}\">$rname $xname</a>\n";
   			}
            else
            	echo "&nbsp;&nbsp;&nbsp;Open -- apply today!\n";
			?>

		</td></tr><tr><td align="center">
	        <b>Status: </b><?php echo $status ?>
	        </td><td align="center">

	        <?php
	        $qry2 = "SELECT id FROM {$spre}characters WHERE ship='$sid'";
	        $result2=$database->openConnectionWithReturn($qry2);
	        $crewcount = mysql_num_rows($result2);
	        ?>

	        <b>Total Crew:</b> <?php echo $crewcount ?>

		</td></tr><tr><td align="center">
            <?php
			$qry2 = "SELECT id FROM {$sdb}classes WHERE name='$class'";
			$result2 = $database->openShipsWithReturn($qry2);
			list($classid) = mysql_fetch_array($result2);
			?>

			<b>Class: </b><?php redirect("{$relpath}shipdb.php?sclass={$classid}&pop=y", "{$class} class", 550, 780) ?><br />
            </td><td align="center">

			<?php
            if ($shipisopen == "no")
				echo "<b>Simm type:</b> {$format}<br />\n";
			?>
        </td></tr><tr><td align="center">
            <b>Task Force: </b><?php echo $tf ?><br />
	        </td><td align="center">
            <b>Task Group:</b> <?php echo $tg ?><br />
        </td></tr>

        <tr><td colspan="2" align="center">
	        <?php echo $desc ?>
        </td></tr>

        <?php
        // Admin view
        if ($uflag['t'] == 1)
        {
            $qry2 = "SELECT c.id, t.tf, t.name
            		 FROM {$spre}characters c, {$spre}taskforces t
                     WHERE t.co=c.id AND c.player=" . uid . " AND tg='0'";
            $result2 = $database->openConnectionWithReturn($qry2);
            list ($cid, $tfcoid, $tfname) = mysql_fetch_array($result2);
        }

        if ($uflag['g'] == 1)
        {
            $qry2 = "SELECT c.id, t.tf, t.tg, t.name
            		 FROM {$spre}characters c, {$spre}taskforces t
                     WHERE t.co=c.id AND c.player=" . uid . " AND tg!='0'";
            $result2 = $database->openConnectionWithReturn($qry2);
            list ($cid, $tfcoid, $tgcoid, $tgname) = mysql_fetch_array($result2);
        }

		$tsk = "";
        if ($uflag['t'] == 2 || ($uflag['t'] == 1 && $tfcoid == $tf) )
        	$tsk = "tfco";
		elseif ($uflag['g'] == 2 || ($uflag['g'] == 1 && $tfcoid == $tf && $tgcoid == $tg) )
			$tsk = "tgco";

		if ($uflag['o'] > 0)
			$tsk = "fcops";

        if ($tsk)
        {
            ?>
            <tr><td colspan="2" align="center">
                <table border="2" cellspacing="5" cellpadding="10"><tr><td>
                    <a href="index.php?option=ifs&amp;task=<?php echo $tsk ?>&amp;action=common&amp;lib=sadmin&amp;sid=<?php echo $sid ?>">Admin Edit</a>
                </td><td>
                    <a href="index.php?option=ifs&amp;task=<?php echo $tsk ?>&amp;action=common&amp;lib=sdel&amp;sid=<?php echo $sid ?>">Delete Ship</a>
                </td><td>
                    <a href="index.php?option=ifs&amp;task=<?php echo $tsk ?>&amp;action=common&amp;lib=sview&amp;sid=<?php echo $sid ?>">View Manifest</a>
                </td><td>
                    <a href="index.php?option=ifs&amp;task=<?php echo $tsk ?>&amp;action=common&amp;lib=srepl&amp;sid=<?php echo $sid ?>">View Past Reports</a>
                </td></tr></table>
            </td></tr>
            <?php
        }
        elseif ($uflag['p'] > 0)
        {
            ?>
            <tr><td colspan="2" align="center">
                <a href="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=sview&amp;sid=<?php echo $sid ?>">View Manifest</a>
            </td></tr>
            <?php
        }
	echo "</table><br />\n";
}

// Lists past monthly reports submitted by a ship
function ship_reports_list ($database, $mpre, $spre, $sid)
{
	$qry = "SELECT name FROM {$spre}ships WHERE id='$sid'";
    $result = $database->openConnectionWithReturn($qry);
    list($sname) = mysql_fetch_array($result);
    echo "<h1>Submitted Monthly Reports for <i>{$sname}</i></h1><br />\n";

	$qry = "SELECT id, co, date FROM {$spre}reports WHERE ship='$sid' ORDER BY id DESC";
    $result = $database->openConnectionWithReturn($qry);

    while (list($rid, $co, $date) = mysql_fetch_array($result))
    {
    	if ($co)
        	$co = " (" . $co . ")";
    	if ($date)
        {
        	$date = date("F j, Y", $date);
	    	echo "<a href=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=srepv&amp;rid={$rid}&amp;sid={$sid}\">{$date}{$co}</a><br />\n";
        }
        else
	    	echo "<a href=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=srepv&amp;rid={$rid}&amp;sid={$sid}\">(date unknown){$co}</a><br />\n";
    }
}

// Views a past monthly report
function ship_reports_view ($database, $mpre, $spre, $rid)
{
	$qry = "SELECT date, ship, co, url, status, crew, crewlist,
    			mission, missdesc, improvement, comments
            FROM {$spre}reports WHERE id='$rid'";
    $result = $database->openConnectionWithReturn($qry);
	list($date, $ship, $co, $site, $status, $crewcount, $crewlisting, $newcrew,
    	 $removedcrew, $promotions, $crewawards, $mission, $missdesc, $postnum,
         $siteupdates, $shipawards, $improvement, $comments, $cadets)
         = mysql_fetch_array($result);

	$qry = "SELECT name FROM {$spre}ships WHERE id='$ship'";
    $result = $database->openConnectionWithReturn($qry);
	list ($sname)=mysql_fetch_array($result);

   	if ($date)
       	$date = date("F j, Y", $date);
    else
		$date = "(unknown)";

    if (!$co)
    	$co = "(unknown)";

    if (!$crewlisting)
    	$crewlisting = "(unavailable)";
    else
    	$crewlisting = nl2br($crewlisting);

    ?>
	<h1>Monthly Report for the <?php echo $sname ?></h1>
    Date Submitted: <?php echo $date ?><br />
	Ship Name: <?php echo $sname ?><br />
	Commanding Officer: <?php echo $co ?><br />
	Ship's Website: <?php echo $site ?><br />
	Ship's Status: <?php echo $status ?><br />
	<br /><br />

    <u>Crew List:</u><br />
	<?php echo $crewlisting ?>
	<br /><br /><br />

    <u>Crew Information:</u><br />
	Total Crew: <?php echo $crewcount ?><br /><br />
	New Crew Since Last Report:<br />
	<?php echo $newcrew ?><br /><br />
	Crew Removed Since Last Report:<br />
	<?php echo $removedcrew ?><br /><br />
	Crew Promotions Since Last Report:<br />
	<?php echo $promotions ?><br /><br />
	Crew Award Nominations:<br />
	<?php echo $crewawards ?><br /><br />
    <br />

	<u>Simm Information:</u><br />
	Current Mission Title: <?php echo $mission ?><br /><br />
	Mission Description:<br />
	<?php echo $missdesc ?><br /><br />
	Approximate Number of Posts this Month: <?php echo $postnum ?><br /><br />
	Major Website Updates:<br />
	<?php echo $siteupdates ?><br /><br />
	Website or Ship Awards won (if any):<br />
	<?php echo $shipawards ?><br /><br />
	What have you done this month to improve the quality of your sim?<br />
	<?php echo $improvement ?><br /><br />
    <br />

	<u>Misc Information:</u><br />
	Additional Comments:<br />
	<?php echo $comments ?><br /><br />
	Cadet Academy Submissions:<br />
	<?php echo $cadets ?><br /><br />
    <?php
}

// Transfer a ship between TF/TGs
function ship_transfer ($database, $mpre, $spre, $sid, $tfid, $tgid)
{
	$qry = "SELECT id, name FROM {$spre}ships WHERE id='$sid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($test, $sname) = mysql_fetch_array($result);

	if (!$test)
		echo "<FONT SIZE=\"+1\">Bad ship ID!</FONT>";
    else
    {
	    $qry = "SELECT tf, name FROM {$spre}taskforces WHERE tf='$tfid' AND tg='0'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tftest, $tfname) = mysql_fetch_array($result);

	    if (!$tftest)
	        echo "<FONT SIZE=\"+1\">Bad destination TF ID!</FONT>";
        else
        {
	        $qry = "SELECT tg, name FROM {$spre}taskforces WHERE tf='$tfid' AND tg='$tgid'";
	        $result = $database->openConnectionWithReturn($qry);
	        list ($tgtest, $tgname) = mysql_fetch_array($result);

	        if (!$tgtest)
	            echo "<FONT SIZE=\"+1\">Bad destination TG ID!</FONT>";
            else
            {
	            $qry = "UPDATE {$spre}ships SET tf='$tfid', tg='$tgid' WHERE id='$sid'";
	            $database->openConnectionNoReturn($qry);

	            echo "Transfer successful!<br />\n";
	            echo "$sname transferred to $tfname - $tgname<br /><br />\n";
            }
        }
    }
}

// Admin editing screen
function ship_view_admin ($database, $mpre, $spre, $sdb, $sid, $uflag)
{
	GLOBAL $dbcon;
	$qry = "SELECT * FROM {$spre}ships WHERE id='$sid'";
	$result=$database->openConnectionWithReturn($qry);
	list($sid,$sname,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,$sorder,$report,$desc,$format)=mysql_fetch_array($result);

	$qry2 = "SELECT id, name
    		 FROM {$spre}characters
             WHERE pos='Commanding Officer'
             	AND (ship='$sid' OR ship='0' OR ship='77')";
	$result2=$database->openConnectionWithReturn($qry2);

	$qry3 = "SELECT tg, name FROM {$spre}taskforces WHERE tf='$tf'";
	$result3=$database->openConnectionWithReturn($qry3);
    ?>

    <br />
	<table border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td width="100%" height="300">
				<br />
				<form method="post" action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=sadmin2">
                <input type="hidden" name="sid" value="<?php echo $sid ?>" />
                <table width="640" cellspacing="1">
                <tr>
                    <td width="150">Ship Name:</td>
                    <td width="490"><input size="30" type="text" name="shipname" value="<?php echo $sname ?>" /></td>
                </tr>

                <tr>
                    <td width="150">Ship Registry:</td>
                    <td width="490"><input size="30" type="text" name="registry" value="<?php echo $reg ?>" /></td>
                </tr>

                <tr>
                    <td width="150">Ship Class:</td>
                    <td width="490">
                        <select name="class">
                            <?php
                            $qry = "SELECT c.name
                                    FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
                                    WHERE c.category=d.id AND d.type=t.id AND t.support='n'
                                    ORDER BY c.name";
                            $result = $database->openShipsWithReturn($qry);
                            while (list ($sname) = mysql_fetch_array($result))
                                if ($sname == $class)
                                    echo "<option value=\"{$sname}\" selected=\"selected\">$sname</option>\n";
                                else
                                    echo "<option value=\"{$sname}\">$sname</option>\n";

                            if ($class == "")
                                echo "<option value=\"\" selected=\"selected\"></option>\n";
                            else
                                echo "<option value=\"\"></option>\n";
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
	                
	                
                    <td width="150">Simm Type:</td>
                    <td width="490">
                        <select name="format">

                            <?php
				/*
                            if ($format == "Play by Email")
                                echo "<option value=\"Play by Email\" selected=\"selected\">Play by Email</option>\n";
                            else
                                echo "<option value=\"Play by Email\">Play by Email</option>\n";

                            if ($format == "Play by Bulletin Board")
                                echo "<option value=\"Play by Bulletin Board\" selected=\"selected\">Play by Bulletin Board</option>\n";
                            else
                                echo "<option value=\"Play by Bulletin Board\">Play by Bulletin Board</option>\n";
				if($format == "Play By Web") {
					echo "<option value=\"Play by Web\" selected=\"selected\">Play by Web</option>\n";
				} else {
					echo "<option value=\"Play by Web\">Play by Web</option>\n";
				}
				*/
				$formats = file($relpath . "tf/formats.txt");
				foreach($formats as $type) {
					echo "<option value=\"$type\"";
					if(trim($type) == trim($format)) { echo "selected=\"selected\""; }
					echo ">$type</option>";
				}
				?>

                        </select>
                    </td>
	                
	                
                    <td width="150">&nbsp;</td>
                    <td width="490">
                    	<!--<input type="hidden" name="format" value="Play by Email" />-->
                    </td>
                </tr>
                <tr>
                    <td width="150">Task Group:</td>
                    <td width="490">
                        <select name="grpid" size="1">
                            <?php
                            while( list($grp,$grpname)=mysql_fetch_array($result3) )
                            {
                                if ($grp == 0)
                                    list($grp,$grpname)=mysql_fetch_array($result3);

                                if($grp == $tg)
                                    echo "<option value=\"{$grp}\" selected=\"selected\">{$grpname}</option>\n";
                                else
                                    echo "<option value=\"{$grp}\">{$grpname}</option>\n";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td width="150">Website:</td>
                    <td width="490"><input size="30" type="text" name="website" value="<?php echo $site ?>" /></td>
                </tr>

                <tr>
                    <td width="150">CO:</td>
                    <td width="490">
                        <select name="coid" size="1">
                            <option value="0"<?php if($co == 0) echo " selected=\"selected\"" ?>>No CO</option>
                            <?php
                            while( list($cid,$coname)=mysql_fetch_array($result2) )
                                if($cid == $co)
                                    echo "<option value=\"{$cid}\" selected=\"selected\">{$coname}</option>\n";
                                else
                                    echo "<option value=\"{$cid}\">{$coname}</option>\n";
                            ?>
                        </select><br />
                        <i>Does not show COs already assigned to other ships</i>
                    </td>
                </tr>

                <tr>
                    <td width="150">Status:</td>
                    <td width="490">
                        <?php
                        $filename = "tf/status.txt";
                        $contents = file($filename);
                        $length = sizeof($contents);
                        $count = 0;

                        echo "<select name=\"status\">";
                        $counter = 0;
                        do
                        {
                            $contents[$counter] = trim($contents[$counter]);

                            if ($status == $contents[$counter])
                                echo "<option value=\"$contents[$counter]\" selected=\"selected\">$contents[$counter]</option>\n";
                            else
                                echo "<option value=\"$contents[$counter]\">$contents[$counter]</option>\n";
                            $counter = $counter + 1;
                        } while ($counter < $length);
                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td width="150">Image:</td>
                    <td width="490">images/ships/<input size="30" type="text" name="image" value="<?php echo $image ?>" /></td>
                </tr>

                <tr>
                    <td width="150">Notes:</td>
                    <td width="490"><textarea name="notes" rows="3" cols="50"><?php echo $desc ?></textarea></td>
                </tr>

                <tr>
                    <td colspan="2"><input type="submit" value="Edit" /></td>
                </tr>

                </table>
				</form></center>
			</td>
			<td width="15">&nbsp;</td>
		</tr>
	</table>
    <?php
}

// View ship manifest, etc
function ship_view_info ($database, $mpre, $spre, $sid, $uflag)
{
	$qry = "SELECT * FROM {$spre}ships WHERE id='$sid'";
	$result=$database->openConnectionWithReturn($qry);

    if (!mysql_num_rows($result))
    	echo "Bad Ship ID!";
    else
    {
	    list($sid,$sname,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,$sorder,$report,$desc)=mysql_fetch_array($result);

	    $qry = "SELECT name, rank FROM {$spre}characters WHERE id='$co'";
	    $result=$database->openConnectionWithReturn($qry);
	    list($name,$corank)=mysql_fetch_array($result);

	    $qry = "SELECT name FROM {$spre}taskforces WHERE tf='$tf' AND (tg='0' OR tg='$tg') ORDER BY tg ASC";
	    $result=$database->openConnectionWithReturn($qry);
	    list($tfname)=mysql_fetch_array($result);
	    list($tgname)=mysql_fetch_array($result);

	    ?>
	    <br /><center>
	    <table>
	        <tr>
	            <td><b>Ship Name: </b></td>
	            <td><?php echo $sname ?></td>
	        </tr>
	        <tr>
	            <td><b>Status:</b></td>
	            <td><?php echo $status ?></td>
	        </tr>

	        <tr>
	            <td><b>Task Force:</b></td>
	            <td>
	                TF <?php echo $tf ?> - <?php echo $tfname ?><br />
	                TG <?php echo $tg ?> - <?php echo $tgname ?>
	            </td>
	        </tr>

			<?php
            if (defined("admin"))
            {
            ?>
	            <tr>
	                <td width="150"><b>Last Report:</b></td>
	                <td width="490"><?php echo $report ?></td>
	            </tr>
	            <?php
            }
            ?>

	        <tr>
	            <td><b>Ship Website:</b></td>
	            <td>
				<?php
                if (!defined("admin"))
		            echo $site;
	            else
                {
                	?>
                    <form action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&action=common&lib=swebsite" method="post">
                        <input type="hidden" name="sid" value="<?php echo $sid; ?>">
                        <input type="text" name="url" size="50" value="<?php echo $site; ?>">
                        <input type="submit" value="Edit">
                    </form>
			 		<?php
                }
                ?>
	            </td>
	        </tr>

	        <tr>
	            <td><b>Notes:(ie, current mission)</b></td>
	            <td>
	                <form action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=snotes" method="post">
	                    <input type="hidden" name="sid" value="<?php echo $sid; ?>" />
	                    <textarea name="notes" rows="3" cols="50"><?php echo $desc; ?></textarea>
	                    <input type="submit" value="Edit" />
	                </form>
	            </td>
	        </tr>

	        <tr>
	            <td colspan="2">&nbsp;</td>
	        </tr>

	        <tr>
	            <td><b>Current XO:</b></td>
	            <td>
	                <form action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=sxo" method="post">
	                    <input type="hidden" name="sid" value="<?php echo $sid; ?>" />
	                    <select name="xoid">
	                        <?php
	                        $qry = "SELECT id, name FROM {$spre}characters WHERE ship='$sid'";
	                        $result=$database->openConnectionWithReturn($qry);

	                        if($xo == 0)
	                            echo "<option value=\"0\" selected=\"selected\">No XO currently aboard</option>\n";
	                        else
	                            echo "<option value=\"0\">No XO currently aboard</option>\n";

	                        while( list($cid,$cname)=mysql_fetch_array($result) )
	                            if($xo == $cid)
	                                echo"<option value=\"$cid\" selected=\"selected\">$cname</option\n";
	                            else
	                                echo"<option value=\"$cid\">$cname</option>\n";
						    ?>
	                    </select>
	                    <input type="submit" value="Assign" />
	                </form>
	            </td>
	        </tr>
	    </table>

	    <br />
	    <b>Current Crew:</b>
	    <table border=1>
	        <tr>
	            <td><b>ID #</b></td>
	            <td><b>Rank</b></td>
	            <td><b>Name</b></td>
	            <td><b>Position</b></td>
	        </tr>
	        <tr>
	            <td colspan="2"></td>
	            <td><b>E-mail</b></td>
	            <td>&nbsp;</td>
	        </tr>
	        <tr>
	            <td colspan="4">&nbsp;</td>
	        </tr>
			<?php
	        $qry = "SELECT id, name, race, gender, rank, pos, player, pending
            		FROM {$spre}characters WHERE ship='$sid'
                    ORDER BY pending DESC, rank ASC";
	        $result=$database->openConnectionWithReturn($qry);

	        if( !mysql_num_rows($result) )
            {
				?>
	            <tr>
	                <td width="100%" colspan="5">
                    	<center><i>No crew currently assigned</i><center>
                    </td>
	            </tr>
				<?php
	        }
            else
            {
	            while( list($cid,$cname,$crace,$cgen,$rank,$pos,$pid,$pending)=mysql_fetch_array($result) )
                {
	                echo "<tr>\n";
	                    $qry2 = "SELECT rankid, rankdesc,image FROM {$spre}rank WHERE rankid=" . $rank;
	                    $result2=$database->openConnectionWithReturn($qry2);
	                    list($rid,$rname,$rimg)=mysql_fetch_array($result2);

	                    $qry2 = "SELECT email FROM {$mpre}users WHERE id = '$pid'";
	                    $result2=$database->openConnectionWithReturn($qry2);
	                    list($email)=mysql_fetch_array($result2);
						?>
	                    <td><?php echo $cid ?></td>
	                    <td><img src="images/<?php echo $rimg ?>" alt="<?php echo $rname ?>" /></td>
	                    <td><?php echo $rname . " " . $cname ?></td>
	                    <td><?php echo $pos ?></td>
	                </tr>
	                <tr>
	                    <td colspan="2" align="center">
							<?php
	                        if ($pending == "1")
                            {
	                            echo "<font size=\"+1\"><b>PENDING</b></font><br />\n";
	                            echo "<a href=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=capp&amp;cid={$cid}&amp;sid={$sid}\">View App</a>\n";
	                        }
                            else
	                            echo "&nbsp;\n";
							?>
	                    </td>
	                    <td><?php echo $email ?></td>
	                    <?php
	                    if (defined("IFS"))
                        {
	                       ?>
	                        <td>
	                            <a href="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=cview&amp;cid=<?php echo $cid ?>&amp;sid=<?php echo $sid ?>">
	                                Edit</a> |
	                            <a href="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=cdel&amp;cid=<?php echo $cid ?>&amp;sid=<?php echo $sid ?>">
	                                Delete</a> |
	                            <a href="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=rview&amp;cid=<?php echo $cid ?>&amp;sid=<?php echo $sid ?>">
	                                Service Record</a>
	                        </td>
	                        <?
	                    }
                        else
	                        echo "<td>&nbsp;</td>\n";
	                    ?>
	                </tr>
	                <tr>
	                    <td colspan="4">&nbsp;</td>
	                </tr>
					<?php
	            }
	        }
			?>
	        <tr>
	            <td colspan="4" align="left">
	                <form action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&action=common&lib=cadd" method="post">
	                    <input type="hidden" name="sid" value="<?php echo $sid; ?>">
	                    <input type="submit" value="Add">
	                </form>
	            </td>
	        </tr>
	    </table><br /><br />
    </center>

    <u>Transfer all crew to unassigned:</u> (only TFCOs/FCOps/Triad can do this)<br />
    <form action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=sclear" method="post">
        <textarea name="reason" rows="5" cols="60" wrap="physical">Enter your reason here</textarea><br />
        <input type="hidden" name="sid" value="<?php echo $sid; ?>" />
        <input type="submit" value="Clear Crew" />
    </form>

    <?php
    }
}

?>
