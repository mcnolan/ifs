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
  * Date:	5/07/04
  * Comments: Submit crew to the Academy
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	echo "<h1>Academy Information</h1>\n";

    if (!$lib)
    {
    	?>
        <u>Submit Player</u><br />
        <form action="index.php?option=ifs&amp;task=tfco&amp;action=acad&amp;lib=new" method="post">
        <input type="hidden" name="sid" value="<?php echo $sid ?>" />
        <select name="cid">
        	<?php
            $qry = "SELECT c.id, c.name, s.name
            		FROM {$spre}characters c, {$spre}ships s
                    WHERE s.tf='$tfid' AND s.co=c.id
					ORDER BY s.name";
            $result = $database->openConnectionWithReturn($qry);
            while (list($cid, $cname, $sname) = mysql_fetch_array($result))
            	echo "<option value=\"$cid\">$cname ($sname)</option>\n";
            ?>
        </select><br /><br />

        <select name="course">
        	<?php
            $qry = "SELECT course, name FROM {$spre}acad_courses
            		WHERE active='1' AND section='0'";
            $result = $database->openConnectionWithReturn($qry);
            while (list($courseid, $coursename) = mysql_fetch_array($result))
            	echo "<option value=\"$courseid\">$coursename</option>\n";
            ?>
        </select><br /><br />

        <input type="submit" value="Submit" />
        </form>
        <br /><br />

        <?php
	    $qry = "SELECT s.id, s.cid, r.rankdesc, c.name, c.player, co.name,
        			s.status, s.sdate
	            FROM {$spre}acad_students s, {$spre}characters c,
                	{$spre}rank r, {$spre}acad_courses co, {$spre}ships sh
	            WHERE s.cid=c.id AND sh.co=c.id AND c.rank=r.rankid
                	AND s.course=co.course AND co.section='0' AND sh.tf='$tfid'
                ORDER BY s.sdate DESC";
	    $result = $database->openConnectionWithReturn($qry);
        ?>
        <table border="1" width="95%">
        <tr>
        	<th>Character</th>
            <th>Course</th>
            <th>Instructor</th>
            <th>Status</th>
            <th>Registration Date</th>
            <th>&nbsp;</th>
        </tr>
        <?php
        while (list($stuid, $cid, $rank, $cname, $pid, $course,
                $status, $start) = mysql_fetch_array($result) )
        {
        	echo "<tr>\n";
            echo "<td>$cname</td>\n";
            echo "<td>$course</td>\n";

            $qry2 = "SELECT c.name, u.email
            		 FROM {$spre}characters c, {$mpre}users u,
                     	{$spre}acad_students s
                     WHERE s.id='$stuid' AND s.inst=c.id AND c.player=u.id";
            $result2 = $database->openConnectionWithReturn($qry2);
            if (list($instname, $instemail) = mysql_fetch_array($result))
	            echo "<td>$inst<br />$instemail</td>\n";
            else
            	echo "<td>n/a</td>\n";

        	if ($status == "w")
            	echo "<td>Waiting List</td>\n";
            else if ($status == "p")
            	echo "<td>In Progress</td>\n";
            else if ($status == "c")
            	echo "<td>Completed (passed)</td>\n";
            else if ($status == "f")
            	echo "<td>Failed</td>\n";
            else if ($status == "d")
            	echo "<td>Dropped Out</td>\n";

            echo "<td>" . date("F j, Y", $start) . "</td>\n";
            echo "<td>";
			echo "<a href=\"index.php?option=ifs&amp;task=" . task . "&amp;action=common&amp;lib=cacad&amp;pid=$pid\">Details</a>";
            echo "</td>\n";
            echo "</tr>\n";
        }
    }

    // Submitting a player
    else if ($lib == "new")
    {
    	$qry = "SELECT s.status FROM {$spre}acad_students s, {$spre}characters c
				WHERE c.id='$cid' AND c.player=s.pid AND s.course='$course'
                	AND (s.status='w' OR s.status='p' OR s.status='c')";
    	$result = $database->openConnectionWithReturn($qry);

    	if (list ($status) = mysql_fetch_array($result))
        {
        	echo "<b>";
        	if ($status == "w")
            	echo "This person is already on the waiting list!";
            else if ($status == "p")
            	echo "This person is already taking the course!";
            else if ($status == "c")
            	echo "This person has already completed the course!";
            echo "  The request was not processed.</b><br /><br />\n\n";
        }
        else
        {
        	$qry = "SELECT player FROM {$spre}characters WHERE id='$cid'";
            $result = $database->openConnectionWithReturn($qry);
            list ($pid) = mysql_fetch_array($result);

			$now = time();
        	$qry = "INSERT INTO {$spre}acad_students
            		SET cid='$cid', pid='$pid', course='$course',
                    	status='w', sdate='$now'";
            $database->openConnectionNoReturn($qry);

            echo "<b>Player has been submitted to the Academy.</b><br /><br />\n\n";
        }
        $lib = "";
        include("tf/tfco/academy.php");
    }
}
?>