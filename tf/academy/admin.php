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
  * Comments: Admin interface for Academy settings and stuffs
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
    if (!$lib)
    {
        echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=admin&amp;lib=cadd\">Add a course</a>\n";
        echo "<br /><hr /><br />\n";

	    $qry = "SELECT course, name FROM {$spre}acad_courses
        		WHERE active='1' AND section='0'";
	    $result = $database->openConnectionWithReturn($qry);
	    while (list($cid, $cname) = mysql_fetch_array($result))
	    {
	        echo "<h1>$cname</h1>\n";
	        echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=admin&amp;lib=cedit&amp;cid=$cid\">Edit this course</a>\n";
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
	        echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=cdel&amp;cid=$cid\">Delete this course</a>\n";
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
	        echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=admin&amp;lib=sadd&amp;cid=$cid\">Add a Section</a>\n";
	        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
	        echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=admin&amp;lib=iadd&amp;cid=$cid\">Add an Instructor</a>\n";

	        echo "<br /><br />\n";
			echo "<u>Sections / Chapters</u><br />\n";
	        $qry2 = "SELECT section, name FROM {$spre}acad_courses
            		 WHERE course='$cid' AND section != '0' AND active='1'
                     ORDER BY section";
	        $result2 = $database->openConnectionWithReturn($qry2);
	        while (list ($sid, $sname) = mysql_fetch_array($result2))
	        {
	            echo "$sname (";
	            echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=admin&amp;lib=sedit&amp;cid=$cid&amp;sid=$sid\">edit</a>";
	            echo " - ";
	            echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=sdel&amp;cid=$cid&amp;sid=$sid\">delete</a>";
                echo ")<br />\n";
	        }

	        echo "<br /><br />\n";
			echo "<u>Instructors</u><br />\n";
	        $qry2 = "SELECT c.name , i.id
	                 FROM {$spre}acad_instructors i, {$spre}characters c
	                 WHERE i.course='$cid' AND i.active='1' AND i.cid=c.id";
	        $result2 = $database->openConnectionWithReturn($qry2);
	        while (list ($instname, $instid) = mysql_fetch_array($result2))
	        {
	            echo "$instname (";
	            echo "<a href=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=idel&amp;cid=$cid&amp;iid=$instid\">delete</a>";
	            echo ")<br />\n";
	        }

	        echo "<br /><hr /><br />\n";
	    }
    }
    else if ($lib == "cedit")
    {
    	$qry = "SELECT course, name, descrip, pass, coord
        		FROM {$spre}acad_courses
				WHERE active='1' AND section='0' AND course='$cid'";
        $result = $database->openConnectionWithReturn($qry);
        list ($cid, $cname, $desc, $pass, $coord) = mysql_fetch_array($result);

		echo "<h1>Edit Course</h1>\n";
        echo "<form action=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=cedit\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"cid\" value=\"$cid\" />\n";
		echo "Course Name: <input type=\"text\" name=\"cname\" value=\"$cname\" /><br />\n";
        echo "Passing Mark: <input name=\"pass\" type=\"text\" value=\"$pass\" /><br />\n";
        echo "Course Coordinator: <select name=\"coord\">\n";
	        echo "<option value=\"0\">None</option>\n";
        	$qry2 = "SELECT i.id, c.name
            		 FROM {$spre}acad_instructors i, {$spre}characters c
                     WHERE i.course='$cid' AND i.cid=c.id AND i.active='1'";
            $result2 = $database->openConnectionWithReturn($qry2);
            while (list($iid, $iname) = mysql_fetch_array($result2))
            {
            	echo "<option value=\"$iid\"";
                if ($iid == $coord)
                	echo " selected=\"selected\"";
                echo ">$iname</option>\n";
            }
        echo "</select><br /><br />\n";

        echo "Course Description:<br />\n";
        echo "<textarea name=\"desc\" rows=\"5\" cols=\"60\">$desc</textarea>\n";
        echo "<br /><br />\n";
        echo "<input type=\"submit\" value=\"Update\" /><br />\n\n";
    }
    else if ($lib == "sedit")
    {
    	$qry = "SELECT name, descrip
        		FROM {$spre}acad_courses WHERE active='1' AND course='$cid' AND section='$sid'";
        $result = $database->openConnectionWithReturn($qry);
        list ($sname, $desc) = mysql_fetch_array($result);

		echo "<h1>Edit Section</h1>\n";
        echo "<form action=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=sedit\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"cid\" value=\"$cid\" />\n";
		echo "<input type=\"hidden\" name=\"sid\" value=\"$sid\" />\n";
		echo "Section Name: <input type=\"text\" name=\"sname\" value=\"$sname\" />\n";
        echo "<br /><br />\n";

        echo "Section Description:<br />\n";
        echo "<textarea name=\"desc\" rows=\"5\" cols=\"60\">$desc</textarea>\n";
        echo "<br /><br />\n";
        echo "<input type=\"submit\" value=\"Update\" /><br />\n\n";
    }
    else if ($lib == "cadd")
    {
		echo "<h1>Add A Course</h1>\n";
        echo "<form action=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=cadd\" method=\"post\">\n";
		echo "Course Name: <input type=\"text\" name=\"cname\" /><br />\n";
        echo "Passing Mark: <input name=\"pass\" type=\"text\" /><br />\n";
        echo "Course Coordinator: (select this later)\n";
		echo "<br /><br />\n";

        echo "Course Description:<br />\n";
        echo "<textarea name=\"desc\" rows=\"5\" cols=\"60\"></textarea>\n";
        echo "<br /><br />\n";
        echo "<input type=\"submit\" value=\"Add\" /><br />\n\n";
	}
    else if ($lib == "sadd")
    {
    	$qry = "SELECT section, name
        		FROM {$spre}acad_courses
                WHERE active='1' AND course='$cid' AND section != '0'
                ORDER BY section";
        $result = $database->openConnectionWithReturn($qry);

		echo "<h1>Add Section</h1>\n";
        echo "<form action=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=sadd\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"cid\" value=\"$cid\" />\n";
		echo "Section Name: <input type=\"text\" name=\"sname\" />\n";
        echo "<br /><br />\n";

        echo "Section Description:<br />\n";
        echo "<textarea name=\"desc\" rows=\"5\" cols=\"60\"></textarea>\n";
        echo "<br /><br />\n";

        echo "Section Ordering:<br />\n";
        echo "Insert... ";
        echo "<select name=\"order\">\n";
        echo "<option value=\"0\">At the beginning</option>\n";
        while (list ($sid, $sname) = mysql_fetch_array($result))
	        echo "<option value=\"$sid\">After '$sname'</option>\n";
        echo "</select>\n";
        echo "<br /><br />\n";

        echo "<input type=\"submit\" value=\"Add\" /><br />\n\n";
    }
    else if ($lib == "iadd")
    {
    	$qry = "SELECT course, name
        		FROM {$spre}acad_courses WHERE active='1' AND section='0'";
        $result = $database->openConnectionWithReturn($qry);

		echo "<h1>Add Instructor</h1>\n";
        echo "<form action=\"index.php?option=ifs&amp;task=academy&amp;action=admin&amp;lib=iadd2\" method=\"post\">\n";
		echo "Course: <select name=\"course\">\n";
        while (list ($cid, $cname) = mysql_fetch_array($result))
        	echo "<option value=\"$cid\">$cname</option>\n";
        echo "</select>\n";
        echo "<br /><br />\n";

        echo "Instructor Email: <input name=\"iemail\" type=\"text\" />\n";
        echo "<br /><br />\n";
        echo "<input type=\"submit\" value=\"Continue\" /><br />\n\n";
    }
    else if ($lib == "iadd2")
    {
        $qry = "SELECT name FROM {$spre}acad_courses
        		WHERE course='$course' AND section='0'";
        $result = $database->openConnectionWithReturn($qry);
        list ($coursename) = mysql_fetch_array($result);

        $qry = "SELECT id FROM {$mpre}users WHERE email='$iemail'";
        $result = $database->openConnectionWithReturn($qry);
        list ($pid) = mysql_fetch_array($result);

    	$qry = "SELECT c.id, c.name FROM {$spre}characters c, {$mpre}users u
        		WHERE u.email='$iemail' AND c.player=u.id";
        $result = $database->openConnectionWithReturn($qry);

		echo "<h1>Add Instructor (part 2)</h1>\n";
        echo "<form action=\"index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=iadd\" method=\"post\">\n";
		echo "<input name=\"course\" type=\"hidden\" value=\"$course\" />\n";
		echo "<input name=\"ipid\" type=\"hidden\" value=\"$pid\" />\n";

        echo "Course: $coursename<br />\n";
        echo "Instructor Email: $iemail<br /><br />\n";

        echo "Select Character: <select name=\"ichar\">\n";
        while (list($cid, $cname) = mysql_fetch_array($result))
        	echo "<option value=\"$cid\">$cname</option>\n";
        echo "</select>\n";

        echo "<br /><br />\n";
        echo "<input type=\"submit\" value=\"Add\" /><br />\n\n";
    }
}
?>