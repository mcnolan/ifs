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
	$qry = "SELECT name, status, website
    		FROM {$spre}ships WHERE id='$sid'";
	$result = $database->openConnectionWithReturn($qry);
	list ($sname, $status, $site) = mysql_fetch_array($result);

	?>
	<br />
	<center>
    <form method="post" action="index.php?option=ifs&amp;task=co&amp;action=save_report">
        <?php
        if ($adminship)
            echo "<input type=\"hidden\" name=\"adminship\" value=\"{$adminship}\" />\n";
        ?>
        <input type="hidden" name="sid" value="<?php echo $sid ?>" />
        Welcome to the monthly report generator.<br /><br />
        Your login will not time-out while submitting the report.<br />
        <br />
        <b>Ship Name: </b><?php echo $sname ?><br />
        <b>Status: </b><?php echo $status ?><br />
        <b>Ship Website: </b><?php echo $site ?><br />
        <br />
        <b>Current Crew:</b>
        <table border="1">
            <tr>
                <td width="100"><b>Rank</b></td>
                <td width="200"><b>Name</b></td>
                <td width="200"><b>Position</b></td>
                <td width="100"><b>E-mail</b></td>
            </tr>

            <?php
            $qry = "SELECT id, name, race, gender, rank, pos, player
            		FROM {$spre}characters WHERE ship='$sid'";
            $result=$database->openConnectionWithReturn($qry);

            if( !mysql_num_rows($result) )
            {
                ?>
                <tr>
                    <td width="100%" colspan="4">
                    	<center><i>No crew currently assigned</i><center>
                    </td>
                </tr>
                <?php
            }
            else
            {
                while( list($cid,$cname,$crace,$cgen,$rank,$pos,$pid)=mysql_fetch_array($result) )
                {
                    $qry2 = "SELECT rankid, rankdesc,image FROM {$spre}rank WHERE rankid=" . $rank;
                    $result2=$database->openConnectionWithReturn($qry2);
                    list($rid,$rname,$rimg)=mysql_fetch_array($result2);

                    $qry2 = "SELECT email FROM {$mpre}users WHERE id = '$pid'";
                    $result2=$database->openConnectionWithReturn($qry2);
                    list($email)=mysql_fetch_array($result2);
                    ?>
                    <tr>
                        <td width="100"><img src="images/<?php echo $rimg ?>" alt="<?php echo $rname ?>"></td>
                        <td width="200"><?php echo $rname . " " . $cname; ?></td>
                        <td width="200"><?php echo $pos ?></td>
                        <td width="100"><?php echo $email ?></td>
                    </tr>
                    <?
                }
            }
            ?>
        </table>
        <br />

        <p><b><u>Simm Information:</u></b></p><br />

        <p><b>Current Mission Title:</b><br />
        <textarea name="mission" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <p><b>Mission Description::</b><br />
        <textarea name="missdesc" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <p><b>What have you done this month to improve the quality of your sim?: </b><br />
        <textarea name="improvement" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <p><b><u>Misc Information:</u></b></p><br />

        <p><b>Additional Comments:</b><br />
        <textarea name="comments" rows="5" cols="60" wrap="PHYSICAL"></textarea><br /><br />

        <input type="SUBMIT" value="Submit" />
        <input type="RESET" value="Clear Form" />
    </form>
	<?php
}
?>