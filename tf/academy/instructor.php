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
  * Date:	5/10/04
  * Comments: List individual instructors' class list
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
	if ($uflag['d'] == 2 && $lib)
		$pid = $lib;
	else
		$pid = UID;

	$qry = "SELECT c.name FROM {$spre}characters c, {$spre}acad_instructors i
			WHERE i.cid=c.id AND i.pid='$pid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($iname) = mysql_fetch_array($result);

    echo "<h1>Instructor Class List - $iname</h1>\n";
	?>

    <form action="index.php?option=ifs&amp;task=academy&amp;action=save&amp;lib=inst" method="post">
    <table border="2" width="95%">
    <tr>
        <th>Date Submitted</th>
        <th>Course</th>
        <th>Section</th>
        <th>Character</th>
        <th>Ship</th>
        <th>CO</th>
    </tr>

    <?php
    $qry = "SELECT st.id, st.sdate, co.course, co.name, ch.id, ch.name, sh.name,
    			c2.id, c2.name, u.email, MAX(m.section), ch.player, u2.email
            FROM {$spre}acad_students st, {$spre}acad_courses co, {$mpre}users u,
                {$spre}characters ch, {$spre}ships sh, {$spre}characters c2,
                {$spre}acad_marks m, {$spre}acad_instructors i, {$mpre}users u2
            WHERE st.status='p' AND st.inst=i.id AND st.course=co.course
            	AND co.section='0' AND st.cid=ch.id AND ch.ship=sh.id AND ch.player=u.id
                AND sh.co=c2.id AND c2.player=u.id AND m.sid=st.id AND i.pid='$pid'
            GROUP BY co.course, st.sdate";
    $result = $database->openConnectionWithReturn($qry);

	if (!mysql_num_rows($result))
		$noUpdateButton = 1;

    while (list($sid, $sdate, $cid, $cname, $chid, $character, $ship,
    	$coid, $co, $coemail, $secid, $pid, $chemail) = mysql_fetch_array($result) )
    {
    	$secid++;
        $qry2 = "SELECT name FROM {$spre}acad_courses
        		 WHERE course='$cid' AND section='$secid'";
        $result2 = $database->openConnectionWithReturn($qry2);
		list ($secname) = mysql_fetch_array($result2);

        echo "<tr>\n";
        echo "<td>" . date("F j, Y", $sdate) . "</td>\n";
        echo "<td>$cname</td>\n";
        echo "<td>$secid - $secname</td>\n";
        echo "<td>$character<br />$chemail</td>\n";
        echo "<td>$ship</td>\n";

		if ($chid == $coid)
        {
        	$qry2 = "SELECT c1.name, u1.email, c2.name, u2.email
            		 FROM {$spre}characters c1, {$spre}characters c2,
                     	{$mpre}users u1, {$mpre}users u2, {$spre}ships s,
                        {$spre}taskforces t1, {$spre}taskforces t2
                     WHERE s.co='$coid' AND s.tf=t1.tf AND t1.tg='0'
                     	AND s.tf=t2.tf AND s.tg=t2.tg AND t1.co=c1.id
                        AND t2.co=c2.id AND c1.player=u1.id AND c2.player=u2.id";
            $result2 = $database->openConnectionWithReturn($qry2);
            list ($tfco, $tfcoemail, $tgco, $tgcoemail)
            	= mysql_fetch_array($result2);

            echo "<td>TFCO: $tfco $tfcoemail <br />\n";
            echo "TGCO: $tgco $tgcoemail </td>\n";
        }
        else
        	echo "<td>CO: $co $coemail</td>\n";
        ?>
        </tr><tr>
        <td colspan="5">
			<select name="stupdate[<?php echo $sid ?>]">
            	<option value="1" selected="selected">No change</option>
				<option value="2">Complete Section</option>
                <option value="3">Fail Course</option>
                <option value="4">Drop Out</option>
            </select> &nbsp;
            Grade: <input type="textbox" name="mark[<?php echo $sid ?>]" size="3" /><br />
            To graduate from the course, complete the last section called "Graduation".
        </td>
        <td>
        	<a href="index.php?option=ifs&amp;task=academy&amp;action=common&amp;lib=cacad&amp;pid=<?php echo $pid ?>">View Academy Records</a>
			<br />
        	<a href="index.php?option=ifs&amp;task=academy&amp;action=common&amp;lib=rview&amp;pid=<?php echo $pid . "&amp;cid=$chid" ?>">View Service Record</a>
        </td>
        </tr>
        <tr><td colspan="6">&nbsp;</td></tr>
        <?php
    }
	if (!$noUpdateButton)
	    echo "<tr><td align=\"right\"><input type=\"submit\" value=\"Update\" /></td></tr>\n";
    echo "</table></form>\n";

	if ($uflag['d'] ==2)
	{
		?>
		<br /><br />
		<form action="index.php?option=ifs&amp;task=academy&amp;action=inst" method="post">
		Switch Instructor: <select name="lib">
			<option value=""></option>
			<?php
			$qry = "SELECT i.pid, c.name
					FROM {$spre}acad_instructors i, {$spre}characters c
					WHERE i.active='1' AND c.id=i.cid";
			$result = $database->openConnectionWithReturn($qry);
			while (list($ipid, $iname) = mysql_fetch_array($result))
				if ($ipid == $lib)
					echo "<option value=\"$ipid\" selected=\"selected\">$iname</option>\n";
				else if ($ipid == uid && !$lib)
					echo "<option value=\"$ipid\" selected=\"selected\">$iname</option>\n";
				else
					echo "<option value=\"$ipid\">$iname</option>\n";
		echo "</select><br />\n";
		echo "<input type=\"submit\" value=\"Switch\" /></form>\n";
	}
}
?>