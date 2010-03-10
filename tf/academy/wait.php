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
  * Date:	5/03/04
  * Comments: List Academy waiting list
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

    <h1>Academy Waiting List</h1>

    <form action="index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=lupdate" method="post">
    <table border="2" width="95%">
    <tr>
        <th>Date Submitted</th>
        <th>Course</th>
        <th>Character</th>
        <th>Ship</th>
        <th>Assign To</th>
    </tr>

    <?php
    $qry = "SELECT st.id, st.sdate, co.course, co.name, ch.name, sh.name
            FROM {$spre}acad_students st, {$spre}acad_courses co,
                {$spre}characters ch, {$spre}ships sh
            WHERE st.status='w' AND st.course=co.course AND co.section='0'
                AND st.cid=ch.id AND ch.ship=sh.id
            ORDER BY st.sdate";
    $result = $database->openConnectionWithReturn($qry);
    while (list($sid, $sdate, $cid, $cname, $character, $ship)
        = mysql_fetch_array($result) )
    {
        echo "<tr>\n";
        echo "<td>" . date("F j, Y, g:i a", $sdate) . "</td>\n";
        echo "<td>$cname</td>\n";
        echo "<td>$character</td>\n";
        echo "<td>$ship</td>\n";
        ?>
        <td>
            <select name="student[<?php echo $sid ?>]">
                <option value="0" selected="selected">Leave on Wait List</option>
                <?php
                $qry2 = "SELECT i.id, c.name
                         FROM {$spre}acad_instructors i, {$spre}characters c
                         WHERE i.course='$cid' AND i.cid=c.id AND i.active='1'";
                $result2 = $database->openCOnnectionWithReturn($qry2);
                while (list($iid, $iname) = mysql_fetch_array($result2))
                    echo "<option value=\"$iid\">$iname</option>\n";
                ?>
            </select>
        </td></tr>
        <?php
    }
    echo "<tr><td colspan=\"5=\" align=\"right\"><input type=\"submit\" value=\"Update\" /><br />\n";
    echo "Note that instructors are <i>not</i> automatcally notified of changes;<br />\n";
    echo "You must email them and tell them to check their IFS class lists for updates.</td></tr>\n";
    echo "</table></form>\n";

}
?>