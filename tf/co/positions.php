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
  * This file based on code from Open Positions List
  * Copyright (C) 2002, 2003 Frank Anon
  *
  * Date:	12/22/03
  * Comments: Allows COs to edit positions for the OPL
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br>
	<center>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="100" valign="top">&nbsp;</td>
			<td width="15">&nbsp;</td>
			<td width="100%">
				<center><h2>Edit Positions</h2></center>
				<i>Below is a list of positions for your ship<br />
				This list is used in generating your ship's listing on the Open Positions List.</i><br />

				<table>
					<form method="post" action="index.php?option=ifs&amp;task=co&amp;action=save_pos">
						<input type="hidden" name="sid" value="<?php echo $sid ?>" />
						<input type="hidden" name="pos_act" value="remove" />
                        <?php
                        if ($adminship)
                           	echo "<input type=\"hidden\" name=\"adminship\" value=\"{$adminship}\">\n";
                        ?>
						<tr><th colspan="2">Remove Current Positions</th></tr>
						<tr>
                        	<td><b>Position</b></td>
							<td width="15"><b>Remove</b></td>
                        </tr>
						<?
						$filename = "tf/positions.txt";
						$contents = file($filename);
						$length = sizeof($contents);
						$counter = 0;

						do
                        {
							$pos = trim($contents[$counter]);
							$pos = addslashes($pos);

							$qry = "SELECT pos FROM {$spre}positions WHERE ship='$sid' AND action='rem' AND pos='$pos'";
							$result = $database->openConnectionWithReturn($qry);

							if (!mysql_num_rows($result))
                            {
								$pos = stripslashes($pos);

								echo "<tr><td>";
								echo $pos . "</td>\n";

								echo "<td><input type=\"checkbox\" name=\"check[]\" value=\"$pos\" /></td></tr>\n";
							}
							$counter = $counter + 1;
						} while ($counter < ($length));

						$qry = "SELECT pos FROM {$spre}positions WHERE ship='$sid' AND action='add'";
						$result = $database->openConnectionWithReturn($qry);
						while ( list ($pos) = mysql_fetch_array($result) )
                        {
                        	$pos = htmlentities($pos);
							echo "<tr><td>";
							echo $pos . "</td>";
							echo "<td><input type=\"checkbox\" name=\"check[]\" value=\"$pos\" /></td></tr>\n";
						}

						?>
						<tr>
                        	<td>&nbsp;</td>
							<td><input type="submit" value="Submit" /></td>
                        </tr>
					</form>
				</table>

				<br /><br />

				<table>
					<form method="post" action="index.php?option=ifs&amp;task=co&amp;action=save_pos">
						<input type="hidden" name="sid" value="<?php echo $sid ?>" />
						<input type="hidden" name="pos_act" value="add" />
                        <?php
                        if ($adminship)
                           	echo "<input type=\"hidden\" name=\"adminship\" value=\"{$adminship}\" />\n";
                        ?>
						<tr><th colspan="2">Add Positions</th></tr>
						<tr>
                        	<td><b>Position</b></td>
							<td width="15"><b>Add</b></td>
                        </tr>

						<?php
						$qry = "SELECT pos FROM {$spre}positions WHERE ship='$sid' AND action='rem'";
						$result = $database->openConnectionWithReturn($qry);
						while ( list ($pos) = mysql_fetch_array($result) )
                    	{
							echo "<tr><td>$pos</td>";
							echo "<td><input type=\"checkbox\" name=\"check[]\" value=\"$pos\" /></td></tr>\n";
						}
						?>
						<tr>
                        	<td><input type="text" length="25" name="other" /></td>
							<td><input type="checkbox" name="o1" /></td>
                        </tr>

						<tr>
                        	<td><input type="text" length="25" name="other2" /></td>
							<td><input type="checkbox" name="o2" /></td>
                        </tr>

						<tr>
                        	<td><input type="text" length="25" name="other3" /></td>
							<td><input type="checkbox" name="o3" /></td>
                        </tr>

						<tr>
                        	<td>&nbsp;</td>
							<td><input type="submit" value="Submit" /></td>
                        </tr>
					</form>
				</table>

		  		<br /><br />
			</td>
			<td width="15">&nbsp;</td>
		  </tr>

	</table>
	<br />
	<?php
}
?>