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
  * Date:	5/05/04
  * Comments: Functions for viewing & manipulating crew entries
  *
 ***/

// View Academy history
function crew_academy ($database, $mpre, $spre, $pid)
{
    $qry = "SELECT name, email FROM {$mpre}users WHERE id='$pid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($pname, $pemail) = mysql_fetch_array($result);

	$qry = "SELECT st.id, r.rankdesc, c.name, s.name, co.name,
    			st.status, st.sdate, st.edate
            FROM {$spre}acad_courses co, {$spre}characters c, {$spre}ships s,
            	{$spre}acad_students st, {$spre}rank r
            WHERE st.course=co.course AND st.pid='$pid' AND st.cid=c.id
            	AND c.ship=s.id AND c.rank=r.rankid AND co.section='0'
            ORDER BY st.sdate DESC";
    $result = $database->openConnectionWithReturn($qry);

    echo "<h1>Academy History for $pname - $pemail</h1>\n";
    echo "<br /><br />\n";

    while (list($sid, $rank, $cname, $ship, $course, $status,
    		$start, $end) = mysql_fetch_array($result) )
    {
		echo "<u>$course</u><br />\n";
        echo "Character: $rank $cname<br />\n";
        echo "Ship: $ship<br />\n";

        $qry2 = "SELECT c.name, u.email
                 FROM {$spre}characters c, {$mpre}users u,
                    {$spre}acad_students s, {$spre}acad_instructors i
                 WHERE s.id='$sid' AND s.inst=i.id AND i.cid=c.id AND c.player=u.id";
        $result2 = $database->openConnectionWithReturn($qry2);
        if (list($instname, $instemail) = mysql_fetch_array($result2))
            echo "Instructor: $instname - $instemail<br />\n";

        echo "Registered on: " . date("F j, Y, g:i a", $start) . "<br />\n";

        if ($status == "c")
        	echo "Status: Completed (pass) - " . date("F j, Y", $end) .
             	 "<br />\n";
        else if ($status == "w")
        	echo "Status: Waiting to begin<br />\n";
        else if ($status == "f")
        	echo "Status: Failed - " . date("F j, Y", $end) . "<br />\n";
        else if ($status == "d")
        	echo "Status: Dropped Out - " . date("F j, Y", $end) . "<br />\n";
        else if ($status == "p")
        	echo "Status: In Progress<br />\n";
        echo "<br />\n";

		echo "<table border=\"1\">\n";
    	$qry2 = "SELECT date, section, secname, grade, comments, name
        		 FROM {$spre}acad_marks WHERE sid='$sid' AND section !='0'
                 ORDER BY section";
        $result2 = $database->openConnectionWithReturn($qry2);

        while (list ($sdate, $secid, $secname, $grade, $comments, $name)
        		= mysql_fetch_array($result2) )
        {
        	echo "<tr><td valign=\"top\">\n";
        	echo "$secname<br />\n";
            echo date("F j, Y", $sdate) . "<br />\n";
            echo "$name</td>\n";
            echo "<td>$grade %</td></tr>\n";
        }
        echo "</table><br /><br />\n";
    }
}

// Auto-OPM
// *** STILL IN TESTING ***
function crew_assign ($database, $mpre, $spre, $class1, $class2, $position1, $position2)
{
	$contents = file($relpath . "tf/positions.txt");
	$length = sizeof($contents);
	do
    {
		$counter = $counter + 1;
		$contents[$counter] = trim($contents[$counter]);
        $poslist .= $contents[$counter] . "\n";
	} while ($counter < ($length - 1));

	// Selected position is on master list
	if (strstr($poslist, $position1))
    {
		$qry = "SELECT s.id, s.name, COUNT(*) AS crew
				FROM {$spre}ships s, {$spre}characters c, ${spre}positions p
				WHERE s.class = '$class1' AND c.ship = s.id
                AND p.pos='$position1' AND p.ship=s.id AND p.action<>'rem'
				GROUP BY s.id ORDER BY crew";
       	$result = $database->openConnectionWithReturn($qry);
		if (mysql_num_rows($result))
        {
			$listing = "";
            while(list($sid, $sname, $crewcount) = mysql_fetch_array($result))
            {
            	$qry2 = "SELECT id, name FROM {$spre}characters WHERE ship='$sid' AND pos='$position1'";
                $result2 = $database->openConnectionWithReturn($qry2);
                if (!mysql_num_rows($result2))
	            	$listing .= "$sid - $sname<br />";
           	}
            if ($listing != "")
            {
            	echo "Best Results:<br />";
                echo $listing;
            }
            else
            	echo "No matches - please assign manually.";
                // go to 2nd choice pos?
        }
        else
			echo "No Matches - please assign manually.";
    }
    else
    {
		$qry = "SELECT s.id, s.name, COUNT(*) AS crew
				FROM {$spre}ships s, {$spre}characters c, ${spre}positions p
				WHERE s.class = '$class1' AND c.ship = s.id
                AND p.pos='$position1' AND p.ship=s.id AND p.action='add'
				GROUP BY s.id ORDER BY crew";
       	$result = $database->openConnectionWithReturn($qry);
		if (mysql_num_rows($result))
        {
        	$listing = "";
            while(list($sid, $sname, $crewcount) = mysql_fetch_array($result))
            {
            	$qry2 = "SELECT id, name FROM {$spre}characters
                		 WHERE ship='$sid' AND pos='$position1'";
                $result2 = $database->openConnectionWithReturn($qry2);
                if (!mysql_num_rows($result2))
	            	$listing .= "$sid - $sname<br />";
			}
            if ($listing != "")
            {
            	echo "Best Results:<br />";
                echo $listing;
            }
            else
            	echo "No matches - please assign manually.<br />";
		}
        else
	       	echo "No matches - please assign manually.<br />";
    }
}

// Delete all crew (used to clear out the Transfer queue)
function crew_delete_all ($database, $mpre, $spre, $deletechars, $delreason)
{
	for ($i=0; $i<sizeof($deletechars); $i++)
    {
		$id = $deletechars[$i];

		$deltime = date("Y-m-d H:i:s") . " from Pending Character Pool";
		$qry = "UPDATE {$spre}characters
        		SET ship='" . DELETED_SHIP . "',other='$deltime' WHERE id='{$id}'";
		$database->openConnectionNoReturn($qry);

		$qry = "SELECT username FROM {$mpre}users WHERE id='" . uid . "'";
		$result = $database->openConnectionWithReturn($qry);
		list ($uname) = mysql_fetch_array($result);

		// Papertrails are good.  Log this!
	    $qry = "INSERT INTO {$spre}logs
        		(date, user, action, comments)
                VALUES (now(), '" . uid . " $uname', 'Character Deleted',
                	'$id from transfer character pool')";
		$database->openConnectionNoReturn($qry);
    }

	redirect("");
}

// Confirm crew delete
function crew_delete_confirm ($database, $mpre, $spre, $id, $shipid, $uflag)
{
	echo "<font size=\"+2\"><b>Confirm Crew Delete</b></font><br /><br />\n";
    $qry = "SELECT name FROM {$spre}characters WHERE id='$id' AND ship='$shipid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($cname) = mysql_fetch_array($result);

    if (!$cname)
    	echo "Database error - cannot find character ID!<br /><br />\n";
	else
    {
    	?>
		Do you really want to delete <?php echo $cname ?>?<br /><br />
        <form action="index.php?option=<?php echo option ?>&task=<?php echo task ?>&action=common&lib=cdel2" method="post">
		<input type="hidden" name="cid" value="<?php echo $id ?>" />
        <input type="hidden" name="sid" value="<?php echo $shipid ?>" />

        Reason for deletion:<br />
        <textarea name="reason" rows="5" cols="60" wrap="physical"></textarea><br /><br />

		<table border="0"><tr><td>
        <input type="submit" value="DELETE!" /></form></td><td>
        <form action="index.php?option=<?php echo option ?>&task=<?php echo task ?>" method="post">
        <input type="submit" value="Cancel" /></form></td></tr></table>
		<?php
    }
}

// Do crew delete
function crew_delete_save ($database, $mpre, $spre, $id, $shipid, $reason, $uflag)
{
	$deltime = date("Y-m-d H:i:s") . " from ship $shipid";
	$qry = "UPDATE {$spre}characters SET ship='74',other='$deltime' WHERE id=" . $id;
	$result=$database->openConnectionWithReturn($qry);

    // take them off the academy wait lists, if needed
    $qry = "SELECT s.id FROM {$spre}acad_students s, {$spre}characters c
            WHERE c.id='$id' AND c.player=s.pid AND s.status='w'";
    $result = $database->openConnectionWithReturn($qry);
    while (list($stuid) = mysql_fetch_array($result))
    {
    	$qry = "DELETE FROM {$spre}acad_students WHERE id='$stuid'";
        $database->openConnectionNoReturn($qry);
    }

    $qry = "SELECT s.id, u.email, c.name
    		FROM {$spre}acad_students s, {$spre}characters c, {$mpre}users u,
            	{$spre}acad_instructors i, {$spre}characters c2
            WHERE c.id='$id' AND c.player=s.pid AND s.inst=c2.id
            	AND c2.player=u.id AND s.status='p'";
    $result = $database->openConnectionWithReturn($qry);
    $recip = "";
    while (list($stuid, $instemail, $charname) = mysql_fetch_array($result))
    	$recip .= ", $instemail";

    if ($recip)
    {
    	$recip = substr($recip, 2);
	    $subject = "Obsidian Fleet Academy - Student Removal";
	    $body = "A student in one of your classes has been removed from ";
	    $body .= "his/her ship.\n\n";
	    $body .= "Character: $charname\n\n";
	    $body .= "This message was automatically generated.\n\n";

	    $headers = "From: " . email-from . "\n";
	    $headers .= "X-Sender:<OFHQ> \n";
	    $headers .= "X-Mailer: PHP\n";
	    $headers .= "Return-Path: <webmaster@obsidianfleet.net>\n";

	    mail($recip, $subject, $body, $headers);
    }

	// if it's a co or xo, remove them from the ship listing too
	$qry = "SELECT co, xo FROM {$spre}ships WHERE id='$shipid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($coid, $xoid) = mysql_fetch_array($result);

	if ($coid == $id)
    {
		$qry = "UPDATE {$spre}ships SET co='0' WHERE id='$shipid'";
		$database->openConnectionNoReturn($qry);

        // Remove CO userlevel
   		$qry = "SELECT u.id, u.flags
        		FROM {$mpre}users u, {$spre}characters c
                WHERE c.id='$coid' AND c.player=u.id";
  	    $result = $database->openConnectionWithReturn($qry);
        list ($userid, $userflags) = mysql_fetch_array($result);

        $userflags = str_replace("c", "", $userflags);
   	    $qry = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$userid'";
        $database->openConnectionNoReturn($qry);

        // Add a 90-day ban, too
        $date = time();
        $expire = time() + 60*60*24*90;
        $auth = get_usertype($database, $mpre, $spre, $cid, $uflag);
        $qry = "SELECT u.email FROM {$mpre}users u, {$spre}characters c
        		WHERE u.id=c.player AND c.id='$coid'";
        $result = $database->openConnectionWithReturn($qry);
        list($email) = mysql_fetch_array($result);

        $qry = "INSERT INTO {$spre}banlist
        		SET date='$date', auth='$auth',
                	reason='90-day penalty on resignation/removal from command',
                    email='$email', level='command',
                    expire='$expire', active='1'";
		$database->openConnectionNoReturn($qry);

	}
    elseif ($xoid == $id)
    {
		$qry = "UPDATE {$spre}ships SET xo='0' WHERE id='$shipid'";
		$database->openConnectionNoReturn($qry);
	}

    /*
    // Remove from PBB listings
	$qry = "SELECT username FROM pbb_users WHERE user_char='$id'";
	$result = $database->openPBBWithReturn($qry);
	list ($tvar) = mysql_fetch_array($result);

	if ($tvar)
    {
  		$qry = "UPDATE pbb_users SET user_active='0' WHERE user_char='$id'";
		$result = $database->openPBBWithReturn($qry);
	}
    */

	$qry = "SELECT username FROM {$mpre}users WHERE id='" . uid . "'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uname) = mysql_fetch_array($result);

	// Papertrails are good.  Log this!
    $qry = "INSERT INTO {$spre}logs
    		(date, user, action, comments)
            VALUES (now(), '" . uid . " $uname', 'Character Deleted', '$id from ship $shipid')";
	$database->openConnectionNoReturn($qry);

	// JAG should be notified when someone is removed.  So let's do it.
    $qry = "SELECT name, tf, tg FROM {$spre}ships WHERE id='$shipid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($sname, $tfid, $tgid) = mysql_fetch_array($result);

    $qry = "SELECT name, rank, player FROM {$spre}characters WHERE id=" . $id;
    $result = $database->openConnectionWithReturn($qry);
    list ($cname, $rankid, $pid) = mysql_fetch_array($result);

	$qry = "SELECT rankdesc FROM {$spre}rank WHERE rankid='$rankid'";
	$result = $database->openConnectionWithReturn($qry);
	list($rankname) = mysql_fetch_array($result);

	$qry = "SELECT email FROM {$mpre}users WHERE id='$pid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($pemail) = mysql_fetch_array($result);

	$qry = "SELECT jag FROM {$spre}taskforces WHERE tf='$tfid' AND tg='0'";
    $result = $database->openConnectionWithReturn($qry);
    list ($jag) = mysql_fetch_array($result);

    $coname = get_usertype($database, $mpre, $spre, $cid, $uflag);
	$qry = "SELECT email FROM {$mpre}users WHERE id='" . UID . "'";
	$result = $database->openConnectionWithReturn($qry);
	list ($coemail) = mysql_fetch_array($result);

   	$mailersubject = "JAG - Player Removed on " . $sname;
	$mailerbody = "Ship Name: " . $sname . "\n";
	$mailerbody .= "TF/TG: {$tfid} / {$tgid}\n";
	$mailerbody .= "Crew: " . $cname . "\n";
	$mailerbody .= "Rank: ". $rankname . "\n";
	$mailerbody .= "Email: " . $pemail . "\n";
	$mailerbody .= "Performed by: " . $coname . " ({$coemail})\n\n";
	$mailerbody .= "Reason:\n";
	$mailerbody .= $reason;
	$mailerbody .= "\n\nThis message was automatically generated.";

	$header = "From: ". email-from;
	mail ($jag, $mailersubject, $mailerbody, $header);

	// We should also add this to the service record
	$coname = addslashes($coname);
	$time = time();
	$details .= $reason;
	$qry = "SELECT player FROM {$spre}characters WHERE id='$id'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uid) = mysql_fetch_array($result);

	$qry = "INSERT INTO {$spre}record
    		SET pid='$uid', cid='$id', level='Out-of-Character', date='$time',
            	entry='Removal: $cname', details='$details', name='$coname'";
	$database->openConnectionNoReturn($qry);
	$qry = "INSERT INTO {$spre}record
    		SET pid='$uid', cid='$id', level='Player', date='$time',
            	entry='Character Deletion: $cname', details='CID: $id',
                name='Obsidian Fleet IFS'";
	$database->openConnectionNoReturn($qry);

	redirect("");
}

// Edit Crew page
function crew_edit ($database, $spre, $mpre, $cid, $sid, $action, $uflag)
{
	$qry = "SELECT id FROM {$spre}characters WHERE id='$cid'";
    $result = $database->openConnectionWithReturn($qry);
    if (!mysql_num_rows($result) && $action != "add")
    	echo "Bad Character ID!";

    else
    {
	    $qry = "SELECT c.player
        		FROM {$spre}ships s, {$spre}characters c
                WHERE s.id='$sid' AND s.co=c.id";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($couid) = mysql_fetch_array($result);

	    $qry = "SELECT * FROM {$spre}rank ORDER BY rankid";
	    $result=$database->openConnectionWithReturn($qry);
	    list($rid,$rname,$rimg,$rcol)=mysql_fetch_array($result);

	    if ($action != 'add')
        {
	        $qry2 = "SELECT id, name, race, gender, rank, ship, pos, player, pending
            		 FROM {$spre}characters WHERE id=" . $cid;
	        $result2=$database->openConnectionWithReturn($qry2);
	        list($cid,$cname,$crace,$cgender,$crank,$sid,$pos,$player,$pending)
            	=mysql_fetch_array($result2);

	        $qry3 = "SELECT email FROM {$mpre}users WHERE id='$player'";
	        $result3=$database->openConnectionWithReturn($qry3);
	        list($cemail)=mysql_fetch_array($result3);
	    }

	    $qry3 = "SELECT name FROM {$spre}ships WHERE id='$sid'";
	    $result3=$database->openConnectionWithReturn($qry3);
	    list($sname)=mysql_fetch_array($result3);

	    ?>
	    <br />
	    <table border="0" cellpadding="0" cellspacing="0" align="center"><tr>
	        <td width="100" valign="top">&nbsp;</td>
	        <td width="15">&nbsp;</td>
	        <td width="100%">
	        <center><h2>Edit a Crewman</h2></center>
	            <form method="post" action="index.php?option=<?php echo option ?>&task=<?php echo task ?>&action=common&lib=cedit">
	            <input type="hidden" NAME="cid" VALUE="<?php echo $cid ?>" />
	            <i>All of the following information is required.</i><br />
                <table cellspacing="5">
                <tr>
                    <td align="right" width="200"><b>Name: </b></td>
                    <td>
                        <input type="text" name="cname" size="30" value="<?php echo $cname ?>" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><font size="-1">
                        <i>DO NOT include the rank with the character's name.
                        It will be automatically generated when you pick the rank below</i>
                    </font></td>
                </tr>
                <tr>
                    <td align="right"><b>Race: </b></td>
                    <td>
                        <input type="text" name="race" size="30" value="<?php echo $crace ?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Gender: </b></td>
                    <td>
                        <input type="text" name="gender" size="30" value="<?php echo $cgender ?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>E-mail Address: </b></td>
                    <?php
                    if ($action == "add")
                        echo "<td><input type=\"text\" name=\"email\" size=\"30\" /></td>\n";
                    else
                        echo "<td>$cemail</td>\n";
                    ?>
                </tr>
                <tr>
                    <td align="right"><b>Ship: </b></td>
                    <td><?php echo $sname ?></td>
                </tr>
                <tr>
                    <td align="right"><b>Position: </b></td>
                    <td>
                        <?php
                        $qry2 = "SELECT t.tf
                                FROM {$spre}characters c, {$spre}taskforces t, {$spre}ships s
                                WHERE t.tg=0 AND t.co=c.id AND c.player='$uid' AND s.tf=t.tf
                                    AND s.id='$sid'";
                        $result2 = $database->openConnectionWithReturn($qry2);
                        list ($usertf) = mysql_fetch_array($result2);

                        $qry2 = "SELECT t.tf
                                FROM {$spre}characters c, {$spre}taskforces t, {$spre}ships s
                                WHERE t.tg!=0 AND t.co=c.id AND c.player='$uid' AND s.tf=t.tf
                                    AND s.id='$sid' AND s.tg=t.tg";
                        $result2 = $database->openConnectionWithReturn($qry2);
                        list ($usertg) = mysql_fetch_array($result2);

                        $qry2 = "SELECT co FROM {$spre}ships WHERE id='$sid'";
                        $result2 = $database->openConnectionWithReturn($qry2);
                        list ($coid) = mysql_fetch_array($result2);
                        if ($coid == 0 && $action=="add" &&
                        	($usertf || $uflag['t'] == 2 || $usertg || $uflag['g'] == 2) )
                            $pos = "Commanding Officer";

                        if ($pos != "Commanding Officer")
                        {
                            echo "<select name=\"position\">\n";

                            $filename = $relpath . "tf/positions.txt";
                            $contents = file($filename);
                            $length = sizeof($contents);
                            $counter = 0;
                            $matched = 0;

                            do
                            {
                                $pos2 = trim($contents[$counter]);
                                $pos2 = addslashes($pos2);

                                $qry2 = "SELECT pos FROM {$spre}positions
                                		 WHERE ship='$sid' AND action='rem' AND pos='$pos2'";
                                $result2 = $database->openConnectionWithReturn($qry2);

                                if (!mysql_num_rows($result2))
                                {
                                    $pos2 = stripslashes($pos2);
                                    if ($pos == $pos2)
                                    {
                                        echo "<option value=\"{$pos2}\" selected=\"selected\">{$pos2}</option>\n";
                                        $matched = 1;
                                    }
                                    else
                                        echo "<option value=\"{$pos2}\">{$pos2}</option>\n";
                                }
                                $counter = $counter + 1;

                            } while ($counter < ($length));

                            $qry2 = "SELECT pos FROM {$spre}positions
                            		 WHERE ship='$sid' AND action='add'";
                            $result2 = $database->openConnectionWithReturn($qry2);

                            while (list ($pos2) = mysql_fetch_array($result2))
                            {
                                if ($pos == $pos2)
                                {
                                    echo "<option value=\"{$pos2}\" selected=\"selected\">{$pos2}</option>\n";
                                    $matched = 1;
                                }
                                else
                                    echo "<option value=\"{$pos2}\">{$pos2}</option>\n";
                            }
                            if ($matched == 0)
                                echo "<option value=\"Other\" selected=\"selected\">Other</option>>\n";
                            else
                                echo "<option value=\"Other\">Other</option>\n";
                            echo "</select><br />\n";

                            echo "If other: ";
                            echo "<input type=\"text\" name=\"otherpos\" size=\"30\" value=\"";
                            if ($matched != 1)
                            	echo $pos;
                            echo "\" /><br />\n";

                        }
                        else
                        {
                            echo "Commanding Officer";
                            echo "<input type=\"hidden\" name=\"position\" value=\"Commanding Officer\" />";
                        }
						?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Rank:</b></td>
                    <td>
                        <select name="rank" size="1">
						<?php
                        while($rid)
                        {
                        	echo "<option value=\"{$rid}\"";
                            if ($rid == $crank)
                            	echo " selected=\"selected\"";
                            echo ">{$rname} ({$rcol})</option>\n";

                            list($rid,$rname,$rimg,$rcol)=mysql_fetch_array($result);
                        }
						?>
                        </select>
                    </td></tr><tr><td>&nbsp;</td><td>
                        <font size="-1"><i>The rank is color sensitive.  Please make
                        	admin officers red, services yellow, science teal, diplomat purple,
                            intel grey, and marine staff green!</i></font><br /><br />
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Pending:</b></td>
                    <td>
                        <?php
                        echo "<input type=\"checkbox\" name=\"pending\"";
                        if ($pending == "1")
                            echo " checked=\"checked\"";
                        echo " />\n";
                        ?>
                        <i>If this box is checked, it will show up on the OPM Listings,
                        	and the OPM Hounds will chase you and tell you to process the app!</i>
                    </td>
                </tr>
                <tr>
                    <td width="100%" colspan=2">
                    	<?php
						if ($action == "add")
                        	echo "<input type=\"hidden\" name=\"add\" value=\"yes\" />\n";
						?>
                        <input type="hidden" name="sid" value="<?php echo $sid ?>" />
                        <input type="submit" value="Edit" /><input type="reset" value="Clear Form" />
                    </td>
                </tr>
                </table>
	            </form>
	        </td>
	        <td width="15">&nbsp;</td>
	        </tr>
	    </table>
	    <?php
    }
}

// Reason for promotion of demotion
function crew_edit_reason ($database, $spre, $mpre, $add, $position, $otherpos, $name, $email, $race, $gender, $rank, $sid, $crewid, $pending, $uflag)
{
	if ($add == "yes")
        crew_edit_save($database, $spre, $mpre, $add, $position, $otherpos, $name, $email, $race, $gender, $rank, '', $sid, $crewid, $pending, $uflag);
	else
    {
		$qry = "SELECT rank FROM {$spre}characters WHERE id='$crewid'";
		$result = $database->openConnectionWithReturn($qry);
		list ($oldrankid) = mysql_fetch_array($result);

		$qry = "SELECT level FROM {$spre}rank WHERE rankid = '$oldrankid'";
    	$result = $database->openConnectionWithReturn($qry);
		list ($oldranklevel) = mysql_fetch_array($result);

	    $qry = "SELECT level FROM {$spre}rank WHERE rankid = '$rank'";
    	$result = $database->openConnectionWithReturn($qry);
	    list ($newranklevel) = mysql_fetch_array($result);

	  	if ($oldranklevel == $newranklevel)
    	    crew_edit_save($database, $spre, $mpre, $add, $position, $otherpos, $name, $email, $race, $gender, $rank, '', $sid, $crewid, $pending, $uflag);
		else
        {
	 	   ?>

	        <form action="index.php?option=<?php echo option ?>&task=<?php echo task ?>&action=common&lib=cedit2" method="post">
			<input type="hidden" name="cid" value="<?php echo $crewid ?>" />
        	<input type="hidden" name="sid" value="<?php echo $sid ?>" />

			<?php
			if ($oldranklevel < $newranklevel)
				echo "Reason for promotion:<br />\n";
    	    else
        		echo "Reason for demotion:<br />\n";
	        ?>
	        <textarea name="reason" rows="5" cols="60" wrap="physical"></textarea><br /><br />

			<table border="0"><tr><td>
    	    <input type="hidden" name="position" value="<?php echo $position ?>" />
			<input type="hidden" name="otherpos" value="<?php echo $otherpos ?>" />
	        <input type="hidden" name="cname" value="<?php echo $name ?>" />
    	    <input type="hidden" name="email" value="<?php echo $email ?>" />
        	<input type="hidden" name="race" value="<?php echo $race ?>" />
	        <input type="hidden" name="gender" value="<?php echo $gender ?>" />
    	    <input type="hidden" name="rank" value="<?php echo $rank ?>" />
        	<input type="hidden" name="pending" value="<?php echo $pending ?>" />
	        <input type="submit" value="Submit" /></form></td><td>
    	    <form action="index.php?option=<?php echo option ?>&task=<?php echo task ?>" method="post">
        	<input type="submit" value="Cancel" /></form></td></tr></table>

            <?php
		}
	}
}

// Save changes
function crew_edit_save ($database, $spre, $mpre, $add, $position, $otherpos, $name, $email, $race, $gender, $rank, $reason, $sid, $crewid, $pending, $uflag)
{
	if ($position == "Other")
    {
		$position = $otherpos;
        $postype = "crew";
	}
    elseif ($position == "Commanding Officer")
    	$postype = "command";
    else
    	$postype = "crew";

    if ($pending == "on")
    	$pending = "1";
    elseif ($pending == "")
    	$pending = "0";

	if ($add == "yes")
    {
		if ($reason = check_ban($database, $mpre, $spre, $email, 'na', $postype))
        {
			echo "This player has been banned from Obsidian Fleet!<br /><br />\n";
		    echo $reason . "\n";
		}
        elseif( $name != "" && $email != "" && $position != "")
        {
			// find out if this person already has a UID
			$qry = "SELECT id FROM {$mpre}users WHERE email='$email'";
			$result = $database->openConnectionWithReturn($qry);
			list ($uid) = mysql_fetch_array($result);

			// if they don't have a UID, create one
			if (!$uid)
            {
            	list ($username, $pass, $uid) = make_uid ($database, $mpre, $name, $name, $email);

				$name = stripslashes($name);

				$recipient = "name <$email>";
				$subject = "Obsidian Fleet New User Details";
				$message = "Hello $name,\n\n";
				$message .= "You have received this email because you have requested to join an Obsidian \n";
				$message .= "Fleet simm. As such, the system has automatically generated a user ID and\n";
				$message .= "password for you, in order to allow you to access features on the Obsidian\n";
				$message .= "Fleet website. Your user name and password is:\n\n";
				$message .= "Username - $username\n";
				$message .= "Password - $pass\n\n";
				$message .= "If you would like to find out more information on what your Obsidian Fleet\n";
				$message .= "ID can do, please read the article located at\n";
				$message .= "http://www.obsidianfleet.net/index.php?option=faq&Itemid=5&topid=0\n";
				$message .= "For any other questions, please email webmaster@obsidianfleet.net\n\n";
				$message .= "If you have an Obsidian Fleet ID already, and would like to combine them\n";
				$message .= "into one ID, please email webmaster@obsidianfleet.net\n\n";
				$message .= "You have been added because you requested to join the crew of an Obsidian Fleet simm.\n";
				$message .= "If you have received this email in error, simply ignore it. Please do not\n";
				$message .= "respond to this email as it is automatically generated for information\n";
				$message .= "purposes only.\n\n";
				$message .= "Thanks for simming in Obsidian Fleet,\n";
				$message .= "Obsidian Fleet webmaster\n\n";

				$headers .= "From: " . email-from . "\n";
				$headers .= "X-Sender:<OFHQ> \n";
				$headers .= "X-Mailer: PHP\n"; // mailer
				$headers .= "Return-Path: <webmaster@obsidianfleet.net>\n";  // Return path for errors

				mail($recipient, $subject, $message, $headers);
echo $message;
				$qry2 = "INSERT INTO {$spre}logs
                		 (date, user, action, comments)
                         VALUES (now(), '" . uid . " $username', 'User created',
                         	'by $couid $couname')";
				$database->openConnectionNoReturn($qry2);

			    $details = "UID created: " . $uid . "<br />\n";
			}
            else
				$details = "UID found: " . $uid . "<br />\n";

			$qry2 = "SELECT username FROM {$mpre}users WHERE id='" . uid . "'";
			$result2 = $database->openConnectionWithReturn($qry2);
			list ($couname) = mysql_fetch_array($result2);

			$qry = "INSERT INTO {$spre}characters
            		(id,name,race,gender,rank,ship,pos,player,app,pending)
                    VALUES(NULL,'$name','$race','$gender',$rank,$sid,'$position','$uid','0','$pending')";
			$result=$database->openConnectionWithReturn($qry);

            $qry = "SELECT id FROM {$spre}characters WHERE id=LAST_INSERT_ID()";
            $result = $database->openConnectionWithReturn($qry);
            list ($cid) = mysql_fetch_array($result);

            $qry = "SELECT name FROM {$spre}ships WHERE id='$sid'";
            $result = $database->openConnectionWithReturn($qry);
            list ($sname) = mysql_fetch_array($result);

            $coname = addslashes(get_usertype($database, $mpre, $spre, $cid, $uflag));

			$details .= "Ship: " . $sname . "<br />\n";
            $time = time();
			$qry = "INSERT INTO {$spre}record
            		SET pid='$uid', cid='$cid', level='Out-of-Character', date='$time',
                    	entry='Character Created: $name', details='$details', name='$coname'";
			$database->openConnectionNoReturn($qry);
			$qry = "INSERT INTO {$spre}record
            		SET pid='$uid', cid='$cid', level='Player', date='$time',
                    	entry='Character Created: $name', details='CID: $cid',
                        name='Obsidian Fleet IFS'";
			$database->openConnectionNoReturn($qry);

            // If it's a CO, they deserve the userlevel too...
            if ($position == "Commanding Officer")
            {
            	$qry = "SELECT flags FROM {$mpre}users WHERE id='$uid'";
                $result = $database->openConnectionWithReturn($qry);
                list ($userflags) = mysql_fetch_array($result);

                if (!strstr($userflags, "c"))
                {
                	$userflags = "c" . $userflags;
                    $qry = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$uid'";
                    $database->openConnectionNoReturn($qry);

	                $qry = "UPDATE {$spre}ships SET co='$cid' WHERE id='$sid'";
	                $database->openConnectionNoReturn($qry);
                }
            }

            /*
			// sync the PBB userdb if needed
			$qry = "SELECT name, format FROM {$spre}ships WHERE id='$sid'";
			$result=$database->openConnectionWithReturn($qry);
			list ($sname, $format) = mysql_fetch_array($result);

			if ($format == "Play by Bulletin Board") {

				$qry = "SELECT password FROM {$mpre}users WHERE id='$uid'";
				$result=$database->openConnectionWithReturn($qry);
				list ($password) = mysql_fetch_array($result);

				$qry = "INSERT INTO pbb_users (user_id, username, user_password, user_char, user_regdate) VALUES (NULL,'$name','$password',LAST_INSERT_ID(), time())";
				$result = $database->openPBBWithReturn($qry);

				// now set up groups
				$qry = "SELECT group_id FROM pbb_groups WHERE group_name='$sname'";
				$result = $database->openPBBWithReturn($qry);
				list ($gid) = mysql_fetch_array($result);

				$qry = "INSERT INTO pbb_user_group (group_id, user_id, user_pending) VALUES ('$gid', LAST_INSERT_ID(), '0')";
				$result = $database->openPBBWithReturn($qry);
			}
            */

            redirect("");
		}
        else
			echo "You did not enter all required information.  Hit your BACK button and try again. <br /><br />\n\n";
	}
    else
    {
		if ($name != "" && $position != ""){

			$qry = "UPDATE {$spre}characters SET name='$name' WHERE id=" . $crewid;
			$result=$database->openConnectionWithReturn($qry);

            $qry = "SELECT pending, ptime FROM {$spre}characters WHERE id='$crewid'";
            $result = $database->openConnectionWithReturn($qry);
            list ($oldpending, $oldptime) = mysql_fetch_array($result);
            if ($oldpending == '0' && $pending == '1')
				$ptime = time();
            elseif ($oldpending == '1' && $pending == '1')
            	$ptime = $oldptime;

            /*
			// sync the PBB userdb if needed
			$qry = "SELECT name, format FROM {$spre}ships WHERE id='$sid'";
			$result=$database->openConnectionWithReturn($qry);
			list ($sname, $format) = mysql_fetch_array($result);

			if ($format == "Play by Bulletin Board") {
				$qry = "UPDATE pbb_users SET username='$name' WHERE user_char=" . $crewid;
				$result = $database->openPBBWithReturn($qry);
			}
            */

			$qry = "UPDATE {$spre}characters
            		SET race='$race', gender='$gender', pending='$pending', ptime='$ptime'
                    WHERE id=" . $crewid;
			$result=$database->openConnectionWithReturn($qry);

			if ($reason)
            {
		        $coname = get_usertype($database, $mpre, $spre, $crewid, $uflag);

                $qry = "SELECT name, rank, player FROM {$spre}characters WHERE id=" . $crewid;
   	   		    $result = $database->openConnectionWithReturn($qry);
    	        list ($cname, $rankid, $pid) = mysql_fetch_array($result);

	            $qry = "SELECT rankdesc, level FROM {$spre}rank WHERE rankid='$rankid'";
   	   		    $result = $database->openConnectionWithReturn($qry);
    	        list ($oldrank, $oldranklevel) = mysql_fetch_array($result);

                $qry = "SELECT rankdesc, level FROM {$spre}rank WHERE rankid='$rank'";
   	   		    $result = $database->openConnectionWithReturn($qry);
    	        list ($newrank, $newranklevel) = mysql_fetch_array($result);

                if ($oldranklevel > $newranklevel)
                {
					$qry = "SELECT name, tf FROM {$spre}ships WHERE id='$sid'";
		            $result = $database->openConnectionWithReturn($qry);
		            list ($sname, $tfid) = mysql_fetch_array($result);

		            $qry = "SELECT email FROM {$mpre}users WHERE id='$pid'";
    	   		    $result = $database->openConnectionWithReturn($qry);
	    	        list ($pemail) = mysql_fetch_array($result);

					$qry = "SELECT jag FROM {$spre}taskforces WHERE tf='$tfid' AND tg='0'";
				    $result = $database->openConnectionWithReturn($qry);
				    list ($jag) = mysql_fetch_array($result);

					$mailersubject = "JAG - Player Demoted on " . $sname;
					$mailerbody = "Ship Name: " . $sname . "\n";
					$mailerbody .= "Crew: " . $cname . "\n";
					$mailerbody .= "Old Rank: " . $oldrank . "\n";
					$mailerbody .= "New Rank: " . $newrank . "\n";
					$mailerbody .= "Email: " . $pemail . "\n";
					$mailerbody .= "Performed by: " . $coname . "\n\n";
					$mailerbody .= "Reason:\n";
					$mailerbody .= $reason;
					$mailerbody .= "\n\nThis message was automatically generated.";

					$header = "From: " . email-from;
					mail ($jag, $mailersubject, $mailerbody, $header);

                    $entry = "Demotion: " . $cname;
                }
                else
					$entry = "Promotion: " . $cname;

                // We should also add this to the service record
				$coname = addslashes($coname);
                $time = time();
                $details = "Old Rank: " . $oldrank . "<br />\n";
                $details .= "New Rank: " . $newrank . "<br />\n";
                $details .= $reason;
                $qry = "INSERT INTO {$spre}record
                		SET pid='$pid', cid='$crewid', level='Out-of-Character', date='$time',
                        	entry='$entry', details='$details', name='$coname'";
				$database->openConnectionNoReturn($qry);
            }

			if ($area != "co" || $position != "Commanding Officer")
            {
				$qry = "UPDATE {$spre}characters SET rank=" . $rank . " WHERE id=" . $crewid;
				$result=$database->openConnectionWithReturn($qry);
			}

	        if ($position == "other")
				$position = $otherpos;

            $qry = "UPDATE {$spre}characters SET pos='$position' WHERE id=" . $crewid;
			$result=$database->openConnectionWithReturn($qry);

            redirect("");
		}
        else
			echo "You did not enter all required information.  Hit your BACK button and try again.<br /><br />\n\n";
	}
}

// Search for all crew associated with an email address
function crew_list_email ($database, $mpre, $spre, $email, $uflag)
{
   	echo "<font size=\"+2\">Searching for email address {$email}...</font><br /><br />\n";

	$qry = "SELECT id FROM {$mpre}users WHERE email='$email'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uid) = mysql_fetch_array($result);

	if ($uid)
    {
		$qry = "SELECT id, name, ship FROM {$spre}characters WHERE player='$uid'";
		$result = $database->openConnectionWithReturn($qry);

		while ( list($cid,$name,$sid)=mysql_fetch_array($result) )
        {
			$qry2 = "SELECT name FROM {$spre}ships WHERE id='$sid'";
			$result2=$database->openConnectionWithReturn($qry2);
			list($ship)=mysql_fetch_array($result2);

			echo "($cid) ";
            echo "<a href=\"index.php?option=" . option . "&task=" . task . "&action=common&lib=cview&cid={$cid}\">";
            echo "$name</a> on ";
            echo "<a href=\"index.php?option=" . option . "&task=" . task . "&action=common&lib=sview&sid={$sid}\">";
            echo "$ship</a> (";
            echo "<a href=\"index.php?option=" . option . "&task=" . task . "&action=common&lib=rview&cid={$cid}\">";
			echo "service record</a>)<br />\n";
		}
	}
    else
		echo "Email address not found!<br /><br />\n\n";
}

// List all characters associated with a player ID
function crew_list_id ($database, $mpre, $spre, $pid, $uflag)
{
   	echo "<font size=\"+2\">Searching for Player ID#{$pid}...</font><br /><br />\n";

	$qry = "SELECT id FROM {$mpre}users WHERE id='$pid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uid) = mysql_fetch_array($result);

	if ($uid)
    {
		$qry = "SELECT id, name, ship FROM {$spre}characters WHERE player='$uid'";
		$result = $database->openConnectionWithReturn($qry);

		if (!mysql_num_rows($result))
			echo "No characters found.<br />\n";

		while ( list($cid,$name,$sid)=mysql_fetch_array($result) )
        {
			$qry2 = "SELECT name FROM {$spre}ships WHERE id='$sid'";
			$result2=$database->openConnectionWithReturn($qry2);
			list($ship)=mysql_fetch_array($result2);

			echo "($cid) ";
            echo "<a href=\"index.php?option=" . option . "&task=" . task . "&action=common&lib=cview&cid={$cid}\">";
            echo "$name</a> on ";
            echo "<a href=\"index.php?option=" . option . "&task=" . task . "&action=common&lib=sview&sid={$sid}\">";
            echo "$ship</a> (";
            echo "<a href=\"index.php?option=" . option . "&task=" . task . "&action=common&lib=rview&cid={$cid}\">";
			echo "service record</a>)<br />\n";
		}
	}
    else
		echo "Invalid ID!<br /><br />\n\n";
}

// Transfer a character to another simm
function crew_transfer ($database, $mpre, $spre, $cid, $sid)
{
	echo "<font size=\"+2\"><u><b>Character Transfer</b></u></font><br /><br />\n";

	$qry = "SELECT id, name, player, ship FROM {$spre}characters WHERE id='$cid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($test, $charname, $pid, $oldsid) = mysql_fetch_array($result);

	if (!$test)
		echo "<font size=\"+1\">Bad character ID!</font><br /><br />\n\n";
	else
    {
	    $qry = "SELECT id, name FROM {$spre}ships WHERE id='$sid'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($stest, $sname) = mysql_fetch_array($result);

	    if (!$stest)
	        echo "<font size=\"+1\">Bad destination ID!</font><br /><br />\n\n";
	    else
        {
	        $qry = "SELECT name FROM {$spre}ships WHERE id='$oldsid'";
	        $result = $database->openConnectionWithReturn($qry);
	        list ($oldname) = mysql_fetch_array($result);

	        $ptime = time();
	        $pdate = date("F j, Y, g:i a", time());

	        $qry = "UPDATE {$spre}characters
            		SET ship='$sid', ptime='$ptime', other='Transferred on $pdate'
                    WHERE id='$cid'";
	        $database->openConnectionNoReturn($qry);

            // If it's a CO or XO, set their position "open" on the old ship
	        $qry = "SELECT id FROM {$spre}ships WHERE co='$cid'";
	        $result = $database->openConnectionWithReturn($qry);
	        list($coid) = mysql_fetch_array($result);

	        if ($coid)
            {
	            $qry = "UPDATE {$spre}ships SET co='0' WHERE ship='$coid'";
	            $database->openConnectionNoReturn($qry);
	        }

	        $qry = "SELECT id FROM {$spre}ships WHERE xo='$cid'";
	        $result = $database->openConnectionWithReturn($qry);
	        list($xoid) = mysql_fetch_array($result);

	        if ($xoid)
            {
	            $qry = "UPDATE {$spre}ships SET xo='0' WHERE ship='$xoid'";
	            $database->openConnectionNoReturn($qry);
	        }

            // Service record entry
	        $details = "Tranferred from: " . $oldname . "<br />\n";
	        $details .= "Transferred to: " . $sname . "<br />\n";
	        $time = time();

	        $name = get_usertype($database, $mpre, $spre, $cid, $uflag);

	        $qry = "INSERT INTO {$spre}record
            		SET cid='$cid', pid='$pid', level='Out-of-Character', date='$time',
                    	entry='Transfer', details='$details', name='$name'";
	        $database->openConnectionNoReturn($qry);

	        echo "Transfer successful!<br />\n";
	        echo "$charname transferred to $sname<br /><br />\n\n";
	    }
    }
}

// View the character's original app
function crew_view_app ($database, $spre, $cid)
{
	?>

  	<center>
	<h2>View Application</h2>
 	<br /><font size="+1">

	<?php
	$qry = "SELECT a.date, a.app
    		FROM {$spre}characters c, {$spre}apps a
            WHERE c.id='$cid' AND a.id=c.app";
    $result = $database->openConnectionWithReturn($qry);

    if (!mysql_num_rows($result))
    {
    	echo "Application Not Found.<br /><br />\n";
        echo "<font size=\"-1\">Applications received before June 24, 2003, are not on file.</font><br />\n\n";
    }
    else
    {
    	list ($date, $app) = mysql_fetch_array($result);
		$date = date("F j, Y, g:i a", $date);
    	?>
        Date: <?php echo $date ?><br /><br />
        <font size"-1">
        <?php echo nl2br($app) ?>
        </font>
        <br /><br />
        <?php
    }
}

?>
