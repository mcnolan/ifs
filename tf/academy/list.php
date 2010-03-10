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
  * Date:	5/04/04
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
    if ($lib == "old")
    {
    	echo "<h1>Archived Course List</h1>\n";
    	$qry = "SELECT course, name FROM {$spre}acad_courses WHERE active='0' AND section='0'";
        $result = $database->openConnectionWithReturn($qry);
        while (list($cid, $cname) = mysql_fetch_array($result))
        	echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=list&amp;lib=$cid\">$cname</a><br />\n";
	}
    else
    {
	    // Do listing thingy at top to let person choose the course to view
	    $qry = "SELECT course, name FROM {$spre}acad_courses
        		WHERE active='1' AND section='0'";
	    $result = $database->openConnectionWithReturn($qry);

	    if (!$lib)
	        echo "Current Students";
	    else
	        echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=list\">Current Students</a>";

	    while (list($courseid, $coursename) = mysql_fetch_array($result))
	    {
	        echo " | ";
	        if ($lib == $courseid)
	            echo $coursename;
	        else
	            echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=list&amp;lib=$courseid\">$coursename</a>";
	    }

	    echo "<h1>$coursename</h1>\n";

	    if (!$lib)
	    {
	        ?>
	        <table border="2" width="95%">
	        <tr>
	            <th>Date Submitted</th>
	            <th>Course</th>
	            <th>Character</th>
	            <th>Ship</th>
	            <th>Assigned To</th>
	        </tr>

	        <?php
            $qry = "SELECT st.id, st.sdate, co.course, co.name, ch.name,
                        sh.name, c2.name
                    FROM {$spre}acad_students st, {$spre}acad_courses co,
                        {$spre}characters ch, {$spre}characters c2,
                        {$spre}ships sh, {$spre}acad_instructors i
                    WHERE st.status='p' AND st.course=co.course
                        AND co.section='0' AND st.cid=ch.id
                        AND ch.ship=sh.id AND st.inst=i.id AND i.cid=c2.id
                    ORDER BY st.sdate";
	        $result = $database->openConnectionWithReturn($qry);
	        while (list($sid, $sdate, $cid, $cname, $character, $ship, $inst)
	            = mysql_fetch_array($result) )
	        {
	            echo "<tr>\n";
	            echo "<td>" . date("F j, Y, g:i a", $sdate) . "</td>\n";
	            echo "<td>$cname</td>\n";
	            echo "<td>$character</td>\n";
	            echo "<td>$ship</td>\n";
                echo "<td>$inst</td></tr>\n";
	        }
	        echo "</table></form>\n";
	    }
	    else
	    {
	        ?>
	        <table border="2" width="95%">
	        <tr>
	            <th>Date Submitted / Completed</th>
	            <th>Character</th>
	            <th>Ship</th>
	            <th>Assigned To</th>
	            <th>Status</th>
	        </tr>

	        <?php
	        $qry = "SELECT st.id, st.sdate, st.edate, st.status, c2.name,
	                    ch.name, sh.name, st.cid
	                FROM {$spre}acad_students st, {$spre}acad_instructors i,
	                    {$spre}ships sh, {$spre}characters c2, {$spre}characters ch
	                WHERE st.course='$lib' AND st.cid=ch.id AND ch.ship=sh.id
	                    AND st.inst=i.id AND i.cid=c2.id
	                ORDER BY st.sdate DESC";
	        $result = $database->openConnectionWithReturn($qry);
	        while (list($sid, $sdate, $edate, $status, $inst, $character, $ship, $cid)
	            = mysql_fetch_array($result) )
	        {
	            echo "<tr>\n";
	            echo "<td>" . date("F j, Y, g:i a", $sdate) . "<br />\n";
	            if ($edate)
	                echo date("F j, Y, g:i a", $edate) . "</td>\n";
	            else
	                echo "n/a</td>\n";
	            echo "<td>$character</td>\n";
	            echo "<td>$ship</td>\n";

                if ($status == "w" || $status == "d")
                	$inst = "n/a";
                echo "<td>$inst</td>\n";

	            echo "<td>";
	                if ($status == "w")
	                    echo "Waiting List";
	                else if ($status == "d")
	                    echo "Dropped Out";
	                else if ($status == "c" || $status == "f")
                    {
	                    $qry2 = "SELECT grade FROM {$spre}acad_marks
	                             WHERE sid='$sid'";
	                    $result2 = $database->openConnectionWithReturn($qry2);
	                    list ($grade) = mysql_fetch_array($result2);

	                    if ($status == "c")
	                        echo "Completed: $grade";
	                    else
	                        echo "Failed: $grade";
                    }
	                else if ($status == "p")
						echo "In Progress";
					else
	                    echo "Unknown";
	            echo "</td>\n</tr>\n";
	        }
	        echo "</table></form>\n";
	    }

	    echo "<br /><br />\n";
	    echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=list&amp;lib=old\">View Old Archived Courses</a>\n";
	    echo "<br /><br />\n";
    }
}
?>