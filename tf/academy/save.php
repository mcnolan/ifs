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
  * Comments: List Academy students
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to Academy Tools<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	</center><br /><br />

    <?php
    if ($lib == "cdel")
    {
    	$qry = "UPDATE {$spre}acad_courses SET active='0' WHERE course='$cid'";
        $database->openConnectionNoReturn($qry);

        // Remove instructors too
    	$qry = "SELECT id FROM {$spre}acad_instructors
        		WHERE course='$cid' AND active='1'";
        $result = $database->openConnectionWithReturn($qry);

        $qry = "UPDATE {$spre}acad_instructors SET active='0' WHERE course='$cid'";
        $database->openConnectionNoReturn($qry);

        while (list($iid) = mysql_fetch_array($result))
        {
	        $qry2 = "SELECT j.id FROM {$spre}acad_instructors i, {$spre}acad_instructors j
	                WHERE i.id='$iid' AND i.pid=j.pid AND j.active='1' AND i.id != j.id";
	        $result2 = $database->openConnectionWithReturn($qry2);
	        if (!mysql_num_rows($result2))
	        {
	            $qry2 = "SELECT u.id, u.flags
	                    FROM {$spre}acad_instructors i, {$mpre}users u
	                    WHERE i.id='$iid' AND i.pid=u.id";
	            $result2 = $database->openConnectionWithReturn($qry2);
	            list ($pid, $userflags) = mysql_fetch_array($result2);

	            $userflags = str_replace("d", "", $userflags);
	            $userflags = str_replace("D", "", $userflags);
	            $qry2 = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$pid'";
	            $database->openConnectionNoReturn($qry2);
	        }
        }

        echo "<b>Course has been set inactive.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
    }
    else if ($lib == "sdel")
    {
    	$qry = "UPDATE {$spre}acad_courses SET active='0'
        		WHERE course='$cid' AND section='$sid'";
        $database->openConnectionNoReturn($qry);

        echo "<b>Section has been set inactive.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
	}
    else if ($lib == "idel")
    {
    	$qry = "UPDATE {$spre}acad_instructors SET active='0'
        		WHERE course='$cid' AND id='$iid'";
        $database->openConnectionNoReturn($qry);

        // Remove userlevel if needed
        $qry = "SELECT j.id FROM {$spre}acad_instructors i, {$spre}acad_instructors j
        		WHERE i.id='$iid' AND i.pid=j.pid AND j.active='1'";
        $result = $database->openConnectionWithReturn($qry);
        if (!mysql_num_rows($result))
        {
        	$qry = "SELECT u.id, u.flags
            		FROM {$spre}acad_instructors i, {$mpre}users u
                    WHERE i.id='$iid' AND i.pid=u.id";
            $result = $database->openConnectionWithReturn($qry);
            list ($pid, $userflags) = mysql_fetch_array($result);

	        $userflags = str_replace("d", "", $userflags);
	        $userflags = str_replace("D", "", $userflags);
	   	    $qry = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$pid'";
	        $database->openConnectionNoReturn($qry);
        }

        echo "<b>Instructor has been set inactive.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
	}
    else if ($lib == "cedit")
    {
    	$qry = "SELECT coord FROM {$spre}acad_courses
        		WHERE course='$cid' AND section='0'";
        $result = $database->openConnectionWithReturn($qry);
        list ($oldCoord) = mysql_fetch_array($result);

    	$qry = "UPDATE {$spre}acad_courses
        		SET name='$cname', pass='$pass', coord='$coord', descrip='$desc'
                WHERE course='$cid' AND section='0'";
        $database->openConnectionNoReturn($qry);

        if ($oldCoord != $coord)
        {
	        // Course coordinators get super Academy access
	        // Remove userlevel from old coordinator
            if ($oldCoord != "0")
            {
	            $qry = "SELECT course FROM {$spre}acad_courses
	                    WHERE coord = '$oldCoord' AND course != '$cid'";
	            $result = $database->openConnectionWithReturn($qry);
	            if (!mysql_num_rows($result))
	            {
	                $qry = "SELECT u.id, u.flags
	                        FROM {$spre}acad_instructors i, {$mpre}users u
	                        WHERE i.id='$oldCoord' AND i.pid=u.id";
	                $result = $database->openConnectionWithReturn($qry);
	                list ($pid, $userflags) = mysql_fetch_array($result);

	                $userflags = str_replace("D", "d", $userflags);
	                $qry = "UPDATE {$mpre}users SET flags='$userflags'
	                        WHERE id='$pid'";
	                $database->openConnectionNoReturn($qry);
	            }
            }

	        // Grant userlevel to new coordinator
            if ($coord != "0")
            {
	            $qry = "SELECT u.id, u.flags
	                    FROM {$mpre}users u, {$spre}acad_instructors i
	                    WHERE i.id='$coord' AND i.pid=u.id";
	            $result = $database->openConnectionWithReturn($qry);
	            list ($pid, $userflags) = mysql_fetch_array($result);

	            $userflags = str_replace("d", "D", $userflags);
	            if (!strstr($userflags, "D"))
	                $userflags = "D" . $userflags;
	            $qry = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$pid'";
	            $database->openConnectionNoReturn($qry);
            }
        }

        echo "<b>Course has been updated.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
	}
    else if ($lib == "sedit")
    {
    	$qry = "UPDATE {$spre}acad_courses SET name='$sname', descrip='$desc'
        		WHERE course='$cid' AND section='$sid'";
        $database->openConnectionNoReturn($qry);

        echo "<b>Section has been updated.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
	}
    else if ($lib == "cadd")
    {
    	$cid = 0;
    	do {
        	$cid++;
        	$qry = "SELECT course FROM {$spre}acad_courses WHERE course='$cid'";
            $result = $database->openConnectionWithReturn($qry);
        } while (mysql_num_rows($result));

    	$qry = "INSERT INTO {$spre}acad_courses
        		SET name='$cname', pass='$pass', descrip='$desc',
                course='$cid', section='0', active='1'";
        $database->openConnectionNoReturn($qry);

        $qry = "INSERT INTO {$spre}acad_courses
        		SET name='Graduation', pass='$pass', descrip='Successful " .
                	"completion of the course (this must always be the last " .
                    "section)', course='$cid', section='1', active='1'";
    	$database->openConnectionNoReturn($qry);

        echo "<b>Course has been added.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
    }
	else if ($lib == "sadd")
    {
    	$qry = "UPDATE {$spre}acad_courses SET section=section+1
        		WHERE section > '$order' AND course='$cid'";
        $database->openConnectionNoReturn($qry);

		$order++;
        $qry = "INSERT INTO {$spre}acad_courses
        		SET name='$sname', descrip='$desc', course='$cid',
                	section='$order', active='1'";
        $database->openConnectionNoReturn($qry);

        echo "<b>Section has been added.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
	}
    else if ($lib == "iadd")
    {
    	$qry = "SELECT id FROM {$spre}acad_instructors
        		WHERE pid='$ipid' AND cid='$ichar' AND course='$course'";
        $result = $database->openConnectionWithReturn($qry);

        if (mysql_num_rows($result))
        	$qry = "UPDATE {$spre}acad_instructors SET active='1'
            		WHERE pid='$ipid' AND cid='$ichar' AND course='$course'";
        else
        	$qry = "INSERT INTO {$spre}acad_instructors
            		SET pid='$ipid', cid='$ichar', course='$course', active='1'";
        $database->openConnectionNoReturn($qry);

        // Give them user-based access flag here
       	$qry = "SELECT flags FROM {$mpre}users WHERE id='$ipid'";
        $result = $database->openConnectionWithReturn($qry);
        list ($userflags) = mysql_fetch_array($result);

        if (!strstr($userflags, "d"))
        {
           	$userflags = "d" . $userflags;
            $qry = "UPDATE {$mpre}users SET flags='$userflags' WHERE id='$ipid'";
            $database->openConnectionNoReturn($qry);
        }

        echo "<b>Instructor has been added.</b><br /><br />\n";
        $lib = "";
        include("tf/academy/admin.php");
    }
    else if ($lib == "lupdate")
    {
    	foreach ($student as $stuid => $instid)
        {
        	if ($instid != "0")
            {
            	$qry = "UPDATE {$spre}acad_students
                		SET inst='$instid', status='p' WHERE id='$stuid'";
            	$database->openConnectionNoReturn($qry);

                $now = time();
		        $name = get_usertype($database, $mpre, $spre, 0, $uflag);
                $qry = "INSERT INTO {$spre}acad_marks
                		SET date='$now', sid='$stuid', section='0', name='$name'";
                $database->openConnectionNoReturn($qry);
            }
        }
        include("tf/academy/wait.php");
	}
    else if ($lib == "inst")
    {
    	foreach ($stupdate as $stuid => $action)
        {
			// Complete section
        	if ($action == "2")
            {
                $qry = "SELECT MAX(section) FROM {$spre}acad_marks WHERE sid='$stuid'";
                $result = $database->openConnectionWithReturn($qry);
                list ($secid) = mysql_fetch_array($result);
                $secid++;

                $qry = "SELECT c.name
                		FROM {$spre}acad_courses c, {$spre}acad_students s
                        WHERE s.id='$stuid' AND s.course=c.course
                        	AND c.section='" . ($secid+1) . "' AND active='1'";
                $result = $database->openConnectionWithReturn($qry);

            	if (!$mark[$stuid])
                	echo "Enter the mark for the section! Record not updated...<br />\n";
                else if (!mysql_num_rows($result))	   // Completed last section
                {
                	// Graduation!
                    $qry = "UPDATE {$spre}acad_marks
                    		SET grade='" . $mark[$stuid] . "'
                            WHERE sid='$stuid' AND section='0'";
                    $database->openConnectionNoReturn($qry);

                	$now = time();
					$qry = "UPDATE {$spre}acad_students
                    		SET edate='$now', status='c' WHERE id='$stuid'";
                    $database->openConnectionNoReturn($qry);

                    // Notify the person's CO (either ship or TFCO/TGCO)
                    $qry = "SELECT s.cid, c.id, u.email
                    		FROM {$spre}acad_students s, {$mpre}users u,
                            	{$spre}characters c, {$spre}ships h,
                                {$spre}characters a
                            WHERE s.cid=a.id AND a.ship=h.id AND h.co=c.id
                            	AND c.player=u.id AND s.id='$stuid'";
                    $result = $database->openConnectionWithReturn($qry);
                    list ($cid, $coid, $coemail) = mysql_fetch_array($result);

	                if ($cid == $coid)
	                {
	                    $qry = "SELECT u1.email, u2.email
	                            FROM {$spre}characters c1, {$spre}characters c2,
	                				{$mpre}users u1, {$mpre}users u2,
                                    {$spre}ships s, {$spre}taskforces t1,
                                    {$spre}taskforces t2
	                             WHERE s.co='$coid' AND s.tf=t1.tf AND t1.tg='0'
	                                AND s.tf=t2.tf AND s.tg=t2.tg
                                    AND t1.co=c1.id AND t2.co=c2.id
                                    AND c1.player=u1.id AND c2.player=u2.id";
	                    $result = $database->openConnectionWithReturn($qry);
	                    list ($tfcoemail, $tgcoemail)
	                        = mysql_fetch_array($result);

                    	$coemail = $tfcoemail . ", " . $tgcoemail;
                    }

                    $qry = "SELECT name
                    		FROM {$spre}acad_courses c, {$spre}acad_students s
                            WHERE s.course=c.course AND s.id='$stuid'";
                    $result = $database->openConnectionWithReturn($qry);
                    list ($coursename) = mysql_fetch_array($result);

                    $qry = "SELECT r.rankdesc, c.name, c.player, s.name
                    		FROM {$spre}characters c, {$spre}rank r, {$spre}ships s
                            WHERE c.id='$cid' AND c.rank=r.rankid AND c.ship=s.id";
                    $result = $database->openConnectionWithReturn($qry);
                	list ($rank, $charname, $player, $ship) = mysql_fetch_array($result);

                    $qry = "SELECT email FROM {$mpre}users WHERE id='" . UID . "'";
                    $result = $database->openConnectionWithReturn($qry);
                    list ($instemail) = mysql_fetch_array($result);
			        $name = get_usertype($database, $mpre, $spre, 0, $uflag);

					$subject = "Obsidian Fleet Academy Graduation";
                    $body = "Course: $coursename\n";
                    $body .= "Grade: " . $mark[$stuid] . "\n";
                    $body .= "Character: $rank $charname\n";
                    $body .= "Ship: $ship\n\n";
                    $body .= "Instructor: $name - $instemail\n\n";
                    $body2 = $body . "This message was automatically generated.\n\n";

	                $headers = "From: " . email-from . "\n";
	                $headers .= "X-Sender:<OFHQ> \n";
	                $headers .= "X-Mailer: PHP\n";
	                $headers .= "Return-Path: <webmaster@obsidianfleet.net>\n";

					mail($coemail, $subject, $body2, $headers);

                    // Service record entry
                    $name = addslashes($name);
					$qry = "INSERT INTO {$spre}record
				    		SET pid='$player', cid='$cid',
                            	level='Out-of-Character', date='$now',
				            	entry='Academy Completion: $coursename',
                                details='$body', name='Obsidian Fleet IFS'";
                    $database->openConnectionNoReturn($qry);
                }
                else
                {
                	$now = time();
	                $qry = "SELECT c.name
	                		FROM {$spre}acad_courses c, {$spre}acad_students s
	                        WHERE s.id='$stuid' AND s.course=c.course
	                        	AND c.section='$secid' AND active='1'";
	                $result = $database->openConnectionWithReturn($qry);
					list ($secname) = mysql_fetch_array($result);

			        $name = get_usertype($database, $mpre, $spre, 0, $uflag);
                	$qry = "INSERT INTO {$spre}acad_marks
                    		SET date='$now', sid='$stuid', section='$secid',
                            	secname = '$secname',
                                grade='" . $mark[$stuid] . "', name='$name'";
                    $database->openConnectionNoReturn($qry);

					echo "<b>Marks updated!</b><br />\n";
				}
            }

            // Fail the course
            else if ($action == "3")
            {
              	if (!$mark[$stuid])
                	echo "Enter the (failing) mark for the course! Record not updated...<br />\n";
                else
                {
		          	$now = time();
					$qry = "UPDATE {$spre}acad_students
	                   		SET edate='$now', status='f' WHERE id='$stuid'";
	                $database->openConnectionNoReturn($qry);

                      // Notify the person's CO (either ship or TFCO/TGCO)
                    $qry = "SELECT s.cid, c.id, u.email
                    		FROM {$spre}acad_students s, {$mpre}users u,
                            	{$spre}characters c, {$spre}ships h,
                                {$spre}characters a
                            WHERE s.cid=a.id AND a.ship=h.id AND h.co=c.id
                            	AND c.player=u.id AND s.id='$stuid'";
                    $result = $database->openConnectionWithReturn($qry);
                    list ($cid, $coid, $coemail) = mysql_fetch_array($result);

	                if ($cid == $coid)
	                {
	                    $qry = "SELECT u1.email, u2.email
	                            FROM {$spre}characters c1, {$spre}characters c2,
	                				{$mpre}users u1, {$mpre}users u2,
                                    {$spre}ships s, {$spre}taskforces t1,
                                    {$spre}taskforces t2
	                             WHERE s.co='$coid' AND s.tf=t1.tf AND t1.tg='0'
	                                AND s.tf=t2.tf AND s.tg=t2.tg
                                    AND t1.co=c1.id AND t2.co=c2.id
                                    AND c1.player=u1.id AND c2.player=u2.id";
	                    $result = $database->openConnectionWithReturn($qry);
	                    list ($tfcoemail, $tgcoemail)
	                        = mysql_fetch_array($result2);

                    	$coemail = $tfcoemail . ", " . $tgcoemail;
                    }

                    $qry = "SELECT name
                    		FROM {$spre}acad_courses c, {$spre}acad_students s
                            WHERE s.course=c.course AND s.id='$stuid'";
                    $result = $database->openConnectionWithReturn($qry);
                    list ($coursename) = mysql_fetch_array($result);

                    $qry = "SELECT r.rankdesc, c.name, c.player, s.name
                    		FROM {$spre}characters c, {$spre}rank r, {$spre}ships s
                            WHERE c.id='$cid' AND c.rank=r.rankid AND c.ship=s.id";
                    $result = $database->openConnectionWithReturn($qry);
                	list ($rank, $charname, $player, $ship) = mysql_fetch_array($result);

                    $qry = "SELECT email FROM {$mpre}users WHERE id='" . UID . "'";
                    $result = $database->openConnnectionWithReturn($qry);
                    list ($instemail) = mysql_fetch_array($result);
			        $name = get_usertype($database, $mpre, $spre, 0, $uflag);

					$subject = "Obsidian Fleet Academy Failure";
                    $body = "Course: $coursename\n";
                    $body .= "Grade: " . $mark[$stuid] . "\n";
                    $body .= "Character: $rank $charname\n";
                    $body .= "Ship: $ship\n\n";
                    $body .= "Instructor: $name - $instemail\n\n";
                    $body2 = $body . "This message was automatically generated.\n\n";

	                $headers = "From: " . email-from . "\n";
	                $headers .= "X-Sender:<OFHQ> \n";
	                $headers .= "X-Mailer: PHP\n";
	                $headers .= "Return-Path: <webmaster@obsidianfleet.net>\n";

					mail($coemail, $subject, $body2, $headers);

                    // Service record entry
                    $name = addslashes($name);
					$qry = "INSERT INTO {$spre}record
				    		SET pid='$player', cid='$cid',
                            	level='Out-of-Character', date='$now',
				            	entry='Failed Academy Course: $coursename',
                                details='$body', name='Obsidian Fleet IFS'";
                    $database->openConnectionNoReturn($qry);
                }
            }

            // Drop out
            else if ($action == "4")
            {
                $now = time();
                $qry = "UPDATE {$spre}acad_students
                        SET edate='$now', status='d' WHERE id='$stuid'";
                $database->openConnectionNoReturn($qry);

                  // Notify the person's CO (either ship or TFCO/TGCO)
                $qry = "SELECT s.cid, c.id, u.email
                        FROM {$spre}acad_students s, {$mpre}users u,
                            {$spre}characters c, {$spre}ships h,
                            {$spre}characters a
                        WHERE s.cid=a.id AND a.ship=h.id AND h.co=c.id
                            AND c.player=u.id AND s.id='$stuid'";
                $result = $database->openConnectionWithReturn($qry);
                list ($cid, $coid, $coemail) = mysql_fetch_array($result);

                if ($cid == $coid)
                {
                    $qry = "SELECT u1.email, u2.email
                            FROM {$spre}characters c1, {$spre}characters c2,
                                {$mpre}users u1, {$mpre}users u2,
                                {$spre}ships s, {$spre}taskforces t1,
                                {$spre}taskforces t2
                             WHERE s.co='$coid' AND s.tf=t1.tf AND t1.tg='0'
                                AND s.tf=t2.tf AND s.tg=t2.tg
                                AND t1.co=c1.id AND t2.co=c2.id
                                AND c1.player=u1.id AND c2.player=u2.id";
                    $result = $database->openConnectionWithReturn($qry);
                    list ($tfcoemail, $tgcoemail)
                        = mysql_fetch_array($result2);

                    $coemail = $tfcoemail . ", " . $tgcoemail;
                }

                $qry = "SELECT name
                        FROM {$spre}acad_courses c, {$spre}acad_students s
                        WHERE s.course=c.course AND s.id='$stuid'";
                $result = $database->openConnectionWithReturn($qry);
                list ($coursename) = mysql_fetch_array($result);

                $qry = "SELECT r.rankdesc, c.name, c.player, s.name
                        FROM {$spre}characters c, {$spre}rank r, {$spre}ships s
                        WHERE c.id='$cid' AND c.rank=r.rankid AND c.ship=s.id";
                $result = $database->openConnectionWithReturn($qry);
                list ($rank, $charname, $player, $ship) = mysql_fetch_array($result);

                $qry = "SELECT email FROM {$mpre}users WHERE id='" . UID . "'";
                $result = $database->openConnectionWithReturn($qry);
                list ($instemail) = mysql_fetch_array($result);
                $name = get_usertype($database, $mpre, $spre, 0, $uflag);

                $subject = "Obsidian Fleet Academy Drop-out";
                $body = "Course: $coursename\n";
                $body .= "Character: $rank $charname\n";
                $body .= "Ship: $ship\n\n";
                $body .= "Instructor: $name - $instemail\n\n";
                $body2 = $body . "This message was automatically generated.\n\n";

                $headers = "From: " . email-from . "\n";
                $headers .= "X-Mailer:PHP\n";
                $headers .= "Return-Path: <webmaster@obsidianfleet.net>\n";

                mail($coemail, $subject, $body2, $headers);

                // Service record entry
                $name = addslashes($name);
                $qry = "INSERT INTO {$spre}record
                        SET pid='$player', cid='$cid',
                            level='Out-of-Character', date='$now',
                            entry='Incomplete Academy Course: $coursename',
                            details='$body', name='Obsidian Fleet IFS'";
                $database->openConnectionNoReturn($qry);
            }
        }
        include("tf/academy/instructor.php");
	}
}
?>