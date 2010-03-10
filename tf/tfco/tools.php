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
  * Date:	1/6/04
  * Comments: TFCO Tools!
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to TFCO Tools<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	</center><br /><br />

	<a class="ifsheading"><font size="+1"><b>Add a Ship:</b></font></a><br />
    <?php
    $qry = "SELECT c.name
            FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
            WHERE c.category=d.id AND d.type=t.id AND t.support='n'
            ORDER BY c.name";
    $result = $database->openShipsWithReturn($qry);
    if ( mysql_num_rows($result) )
    {
    	?>
	    <form action="index.php?option=ifs&task=tfco&action=common&lib=sadd" method="post">
	        <input type="hidden" name="sid" value="na" />
	        <input type="hidden" name="tf" value="<?php echo $tfid ?>" />
	        <input type="hidden" name="format" value="Play By Email" />

	        Ship name:
	        <input type="text" name="sname" size="20" /><br /><br />

	        Class:
	        <select name="class">
	            <option selectd="selected"></option>
	            <?php
	            while ( list ($sname) = mysql_fetch_array($result) )
	                echo "<option value=\"$sname\">$sname</option>\n";
	            ?>
	        </select>
	        <br /><br />

	        Registry Number:
	        <input type="text" name="registry" size="20" /><br /><br />

	        Status:
	        <select name="status">
	            <?php
	            $filename = "tf/status.txt";
	            $contents = file($filename);
	            $length = sizeof($contents);
	            $count = 0;
	            $counter = 0;
	            do
	            {
	                $contents[$counter] = trim($contents[$counter]);
	                echo "<option value=\"$contents[$counter]\">$contents[$counter]</option>\n";
	                $counter = $counter + 1;
	            } while ($counter < $length);
	            ?>
	        </select>
	        <br /><br />

	        Task Group:
	        <select name="grpid" size="1">
	            <?php
	            $qry = "SELECT tg, name FROM {$spre}taskforces WHERE tf='$tfid' AND tg<>'0'";
	            $result = $database->openConnectionWithReturn($qry);
	            while (list($grp,$grpname)=mysql_fetch_array($result))
	                echo "<option value=\"{$grp}\">{$grpname}</option>\n";
	            ?>
	        </select>
	        <br /><br />

	        <input type="submit" value="Add">
	    </form>
        <?php
    }
	else
    	echo "You must create a ship class first...<br />\n";
    ?>
	<br /><br />

	<a class="heading"><font size="+1"><b>Add a CO:</b></font></a><br />
	<i>Only use this to add a CO that is <b>not</b> already in IFS!
    If they are already in the system (ie, they submitted an app through OFHQ),
    assign the CO through ship admin!</i><br />

	<?php
    $qry = "SELECT id, name FROM {$spre}ships WHERE tf='$tfid' AND co='0'";
	$result = $database->openConnectionWithReturn($qry);

    if (mysql_num_rows($result))
    {
		echo "<form action=\"index.php?option=ifs&amp;task=tfco&amp;action=common&amp;lib=cadd\" method=\"post\">\n";
		echo "<select name=\"sid\">\n";
	    while (list ($sid, $sname) = mysql_fetch_array($result))
	    	echo "<option value=\"$sid\">$sname</option>\n";
		echo "</select>\n";
		echo "<input type=\"submit\" value=\"Submit\" /></form>\n";
    }
    else
    	echo "<br />(not applicable - all your ships have COs!  Congrats!)\n";

	echo "<br /><br />\n";
}
?>