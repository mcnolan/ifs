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
  * Date:	12/22/03
  * Comments: Prepares monthly report
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	$qry = "SELECT name FROM {$spre}taskforces WHERE tf='$tfid' AND tg='0'";
    $result = $database->openConnectionWithReturn($qry);
    list ($tfname) = mysql_fetch_array($result);

	// total ships
	$qry = "SELECT COUNT(*) FROM {$spre}ships WHERE tf='$tfid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($ships) = mysql_fetch_array($result);

	// active ships
	$qry = "SELECT count(*) FROM {$spre}ships WHERE tf='$tfid' AND
    			(status='Operational' OR status='Docked at Starbase')";
    $result = $database->openConnectionWithReturn($qry);
    list ($actships) = mysql_fetch_array($result);

	// open ships
	$qry = "SELECT count(co) FROM {$spre}ships WHERE tf='$tfid' AND co='0'";
    $result = $database->openConnectionWithReturn($qry);
    list ($openships) = mysql_fetch_array($result);

	$inships = $ships - $actships - $openships;
	$coships = $ships - $openships;

  	// Total characters
	$qry = "SELECT COUNT(*) FROM {$spre}characters c, {$spre}ships s WHERE s.tf='$tfid' AND c.ship = s.id";
    $result = $database->openConnectionWithReturn($qry);
	list ($totalchar) = mysql_fetch_array($result);

    $avchar = $totalchar / $coships;

	?>
	<br />
	<center>
    <form method="post" action="index.php?option=ifs&amp;task=tfco&amp;action=save_report">
        <?php
        if ($adminship)
            echo "<input type=\"hidden\" name=\"adminship\" value=\"{$adminship}\" />\n";
        ?>
        Welcome to the monthly report generator.  As a TFCO in Obsidian Fleet,
        you are required to submit a monthly report to the FCOps and Triad.<br /><br />
        Please check and complete the following information<br /><br />
        Your login will not time-out while submitting the report.<br />
        <br />
        <b>Task Force: </b><?php echo $tfid ?> - <?php echo $tfname ?><br />
        <br />
        <b>Total Ships: </b><?php echo $ships ?><br />
        &nbsp;&nbsp;&nbsp;<b>CO'ed Ships: </b><?php echo $coships ?><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Active Ships: </b><?php echo $actships ?><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Inactive Ships: </b><?php echo $inships ?><br />
        &nbsp;&nbsp;&nbsp;<b>Open Ships: </b><?php echo $openships ?><br />
        <br />
        <b>Total Characters: </b><?php echo $totalchar ?><br />
        <b>Average Characters per COed ship: </b><?php echo $avchar ?><br />
        <br />

        <p><b>Promotions:</b><br />
        <textarea name="promotions" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <p><b>New COs since last report:</b><br />
        <textarea name="newco" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <p><b>COs that Resigned since last report:</b><br />
        <textarea name="resigned" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <p><b>Website Updates:</b><br />
        <textarea name="webupdates" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <p><b>Other Notes:</b><br />
        <textarea name="other" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <input type="SUBMIT" value="Submit" />
        <input type="RESET" value="Clear Form" />
    </form>
	<?php
}
?>