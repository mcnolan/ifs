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
  * Comments: View & Process Pending Characters
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to the Pending Character Pool<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	<br /><br />
    <a href="#unassigned">Unassigned Characters</a> |
    <a href="#transfer">Transferred Characters</a>

    <br /><br />
    <a name="unassigned"></a>
	<h1>Unassigned Characters:</h1><br />

	<table border="1" width="100%">
		<?php
        $qry = "SELECT id, name, race, gender, rank, pos, player, ship, other
        		FROM {$spre}characters
                WHERE ship='" . UNASSIGNED_SHIP . "' ORDER BY ptime";
		$result=$database->openConnectionWithReturn($qry);

		if ( !mysql_num_rows($result) )
        {
			?>
			<tr>
				<td width="100%"><center><i>No unassigned characters</i><center></td>
			</tr>
			<?php
		}
        else
        {
			?>
		 	<tr>
		 		<td><b>ID #<br /></b></td>
		 		<td><b>Rank</b></td>
		 		<td><b>Name</b></td>
		 		<td><b>Position</b></td>
		 		<td><b>E-mail</b></td>
		 		<td>&nbsp;</td>
		 	</tr>
			<?
			while( list($cid,$cname,$crace,$cgen,$rank,$pos,$pid,$sid,$other)=mysql_fetch_array($result) )
            {
            	echo "<tr>\n";
					$qry2 = "SELECT rankid, rankdesc,image FROM {$spre}rank WHERE rankid=" . $rank;
					$result2=$database->openConnectionWithReturn($qry2);
					list($rid,$rname,$rimg)=mysql_fetch_array($result2);

					$qry2 = "SELECT email FROM " . $mpre . "users WHERE id = '$pid'";
					$result2=$database->openConnectionWithReturn($qry2);
					list($email)=mysql_fetch_array($result2);

					?>
					<td width="50"><?php echo $cid ?></td>
					<td width="100"><img src="../../images/<?php echo $rimg ?>" alt="<?php echo $rname ?>" /></td>
					<td width="200"><?php echo $rname . " " . $cname; ?></td>
					<td width="200"><?php echo $pos ?></td>
					<td width="100"><?php echo $email ?></td>
					<td width="100"><?php echo $other ?></td>
				</tr>
                <tr>
					<td>
                    	&nbsp;
                	</td>
                    <td colspan="5">
                    	<table width="100%" border="0"><tr><td>
							<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=capp" method="post">
								<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
								<input type="hidden" name="sid" value="<?php echo $sid ?>" />
								<input type="submit" value="View App" />
							</form>
                        </td><td>
							<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=cview" method="post">
								<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
								<input type="hidden" name="sid" value="<?php echo $sid ?>" />
								<input type="submit" value="Edit" />
							</form>
                        </td><td>
							<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=cdel" method="post">
								<input type="hidden" name="sid" value="<?php echo $sid ?>" />
								<input type="hidden" name="cid" value="<?echo $cid ?>" />
								<input type="submit" value="Delete" />
							</form>
                        </td><td>
	                    	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=rview" method="post">
	    	                    <input type="hidden" name="cid" value="<?php echo $cid ?>" />
								<input type="hidden" name="sid" value="<?php echo $sid ?>" />
	        	                <input type="submit" value="Service Record" />
	           	            </form>
                        </td><td align="right">
	                        <form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=ctrans" method="post">
	                        	<input type="hidden" name="cid" value="<?php echo $cid ?>" />
	                            <input type="text" name="sid" size="5" value="ship id" />
	                            <input type="submit" value="Transfer" />
	                        </form>
                        </td></tr></table>
					</td>
				</tr>
                <tr>
                	<td colspan="6">
                    	&nbsp;
                    </td>
                </tr>
				<?
			}
		}
        ?>
    </table>

	<br /><br />
    <a name="transfer"></a>
	<h1>Transferred Characters:</h1><br />

	<table border="1" width="100%">
		<?
        $qry = "SELECT id, name, race, gender, rank, pos, player, ship, other
        		FROM {$spre}characters WHERE ship='" . TRANSFER_SHIP . "'
                ORDER BY ptime";
		$result=$database->openConnectionWithReturn($qry);
        $savedResult = $result;

		if( !mysql_num_rows($result) )
        {
			?>
			<tr>
				<td width="100%"><center><i>No transferred characters</i><center></td>
			</tr>
			<?php
		}
        else
        {
			?>
		 	<tr>
		 		<td><b>ID #</b></td>
		 		<td><b>Rank</b></td>
		 		<td><b>Name</b></td>
		 		<td><b>Position</b></td>
		 		<td><b>E-mail</b></td>
		 		<td>&nbsp;</td>
		 	</tr>
			<?php
			while( list($cid,$cname,$crace,$cgen,$rank,$pos,$pid,$sid,$other)=mysql_fetch_array($result) )
			{
                echo "<tr>\n";
					$qry2 = "SELECT rankid, rankdesc,image FROM {$spre}rank WHERE rankid=" . $rank;
					$result2=$database->openConnectionWithReturn($qry2);
					list($rid,$rname,$rimg)=mysql_fetch_array($result2);

					$qry2 = "SELECT email FROM " . $mpre . "users WHERE id = '$pid'";
					$result2=$database->openConnectionWithReturn($qry2);
					list($email)=mysql_fetch_array($result2);

					?>
					<td width="50"><?php echo $cid ?></td>
					<td width="100"><img src="../../images/<?php echo $rimg ?>" alt="<?php echo $rname ?>" /></td>
					<td width="200"><?php echo $rname . " " . $cname; ?></td>
					<td width="200"><?php echo $pos ?></td>
					<td width="100"><?php echo $email ?></td>
					<td width="100"><?php echo $other ?></td>
				</tr>
                <tr>
					<td>
                        &nbsp;
                	</td>
                    <td colspan="5">
                    	<table width="100%" border="0"><tr><td>
							<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=capp" method="post">
								<input type="hidden" name="cid" value="<?php echo $cid ?>" />
								<input type="hidden" name="sid" value="<?php echo $sid ?>">
								<input type="submit" value="View App">
							</form>
                        </td><td>
							<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=cview" method="post">
								<input type="hidden" name="cid" value="<?php echo $cid ?>">
								<input type="hidden" name="sid" value="<?php echo $sid ?>">
								<input type="submit" value="Edit">
							</form>
                        </td><td>
							<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=cdel" method="post">
								<input type="hidden" name="sid" value="<?php echo $sid ?>">
								<input type="hidden" name="cid" value="<?php echo $cid ?>">
								<input type="submit" value="Delete">
							</form>
                        </td><td>
	                    	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=rview" method="post">
	    	                    <input type="hidden" name="cid" value="<?php echo $cid ?>">
								<input type="hidden" name="sid" value="<?php echo $sid ?>">
	        	                <input type="submit" value="Service Record">
	           	            </form>
                        </td><td align="right">
	                        <form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=ctrans" method="post">
	                        	<input type="hidden" name="cid" value="<?php echo $cid ?>">
	                            <input type="text" name="sid" size="5" value="ship id">
	                            <input type="submit" value="Transfer">
	                        </form>
                        </td></tr></table>
					</td>
				</tr>
                <tr>
                	<td colspan="6">
                    	&nbsp;
                    </td>
                </tr>
				<?
			}
		}
    echo "</table>\n";
}
?>