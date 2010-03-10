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
  * Date:	12/19/03
  * Comments: Functions for viewing & manipulating service records
  *
 ***/

// Add details to service record
function record_add_details ($database, $spre, $mpre, $cid, $level, $date, $entry, $name, $radmin, $uflag)
{
    $qry = "SELECT name FROM {$spre}characters WHERE id='$cid'";
    $result = $database->openConnectionWithReturn($qry);
    list($cname) = mysql_fetch_array($result);

    $entry = stripslashes($entry);
	?>
	<br />
	<center><h2>Service Record for <?php echo $cname ?></h2></center>

	<form action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&action=common&lib=rsave" method="post">

	<b>Type:</b> <?php echo $level ?>
    <input type="hidden" name="level" value="<?php echo $level ?>" />
    <?php
    if ($radmin == "on")
    	echo "<br /><b>Admin-level</b>\n";
    ?>
    <input type="hidden" name="radmin" value="<?php echo $radmin ?>" />
    <br /><br />

	<b>Date:</b> <?php echo date("F j, Y", $date) ?>
   	<input type="hidden" name="date" value="<?php echo $date ?>" />
    <br /><br />

	<b>Entry:</b> <?php echo $entry ?>
   	<input type="hidden" name="entry" value="<?php echo $entry ?>" />
    <br /><br />

	<b>By:</b> <?php echo $name ?>
   	<input type="hidden" name="pname" value="<?php echo $name ?>" />
    <br /><br />

    <b>Details:</b><br />
   	<textarea name="details" rows="5" cols="50">Enter details</textarea>
    <br />
    Please use &lt;br /&gt; to indicate new lines.
    <br /><br />

	<input type="hidden" name="cid" value="<?php echo $cid ?>" />
	<input type="hidden" name="sid" value="na" />
    <input type="Submit" value="Submit" /></form>

	<?php
}

// Save new service record entry
function record_add_save ($database, $spre, $mpre, $cid, $level, $date, $entry, $name, $details, $radmin, $uflag)
{
	$qry = "SELECT player FROM {$spre}characters WHERE id='$cid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($pid) = mysql_fetch_array($result);

    if ($radmin == "on")
    	$radmin = "y";
    else
    	$radmin = "";

	$qry = "INSERT INTO {$spre}record
    		SET pid='$pid', cid='$cid', level='$level',
            	date='$date', entry='$entry', details='$details',
                name='$name', admin='$radmin'";
   	$result = $database->openConnectionNoReturn($qry);

    $entry = stripslashes($entry);
    $details = stripslashes($details);
    $name = stripslashes($name);
	?>

    <font size="+1"><b>Entry Made</b></font>
   	<br /><br />

  	<b>Level:</b> <?php echo $level ?>
    <?php
    if ($radmin == "y")
    	echo "<br /><b>Admin-level</b>\n";
    ?>
   	<br /><br />

	<b>Date:</b> <?php echo date("F j, Y", $date) ?>
   	<br /><br />

	<b>Entry:</b> <?php echo $entry ?>
    <br /><br />

    <b>Details:</b><br />
    <?php echo $details ?>
    <br /><br />

	<b>By:</b> <?php echo $name ?>
    <br /><br />

    <?php
}

// View details on service record
function record_details ($database, $spre, $mpre, $rid, $op, $uflag)
{
	$qry = "SELECT level, date, entry, details, name, cid, admin
    		FROM {$spre}record WHERE id='$rid'";
   	$result = $database->openConnectionWithReturn($qry);
    list ($level, $date, $entry, $details, $name, $cid, $radmin) = mysql_fetch_array($result);

    $qry = "SELECT name FROM {$spre}characters WHERE id='$cid'";
    $result = $database->openConnectionWithReturn($qry);
    list ($cname) = mysql_fetch_array($result);
	?>

  	<center>
	<h2>Service Record for <?php echo $cname ?></h2>
 	<br /><font size="+1">

	<table border="1" cellpadding="10" cellspacing="1" width="70%">
    	<tr>
        	<td width="100">
            	<b>Type:</b>
            </td>
        	<td width="500">
            	<?php
                echo $level;
                if ($radmin == "y")
                	echo "<br /><b>Admin-level</b>";
                ?>
            </td>
        </tr>

        <tr>
        	<td width="100">
            	<b>Date:</b>
            </td>
            <td width="500">
            	<?php echo date("F j, Y", $date) ?>
            </td>
        </tr>

        <tr>
        	<td width="100">
            	<b>Entry:</b>
            </td>
            <td width="500">
            	<?php echo $entry ?>
            </td>
        </tr>

        <tr>
        	<td width="100">
                <b>Details:</b>
            </td>
            <td width="500">
            	<?php echo $details ?>
            </td>
        </tr>

		<tr>
        	<td width="100">
				<b>By:</b>
            </td>
            <td width="500">
            	<?php echo $name ?>
            </td>
        </tr>
	</table>

	<?php
    if ($op == "RecordDetails")
		echo "<a href=\"index.php?option=user&amp;op=ServiceRecord&amp;cid=" . $cid . "\">Back to Service Record</a>";
    else
	    echo "<a href=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=rview&amp;cid=" . $cid . "\">Back to Service Record</a>";
	?>
    <br /><br />

    </font>
    Y'know, this is all thanks to Obsidian Fleet, since they released
    the IFS software which you're using right now.  Why not take a look -
    they're at http://www.obsidianfleet.net<br /><br />

    </center>

    <?php
}

// View service record
function record_view ($database, $spre, $mpre, $cid, $op, $uflag)
{
	$qry = "SELECT flag FROM {$spre}flags WHERE admin='1'";
    $result = $database->openConnectionWithReturn($qry);

	$isadmin = 0;
	while ( list($adminflags) = mysql_fetch_array($result) )
    	if ($uflag[$adminflags] >= 1)
        	$isadmin = 1;

    $qry = "SELECT name, player FROM {$spre}characters WHERE id='$cid'";
    $result = $database->openConnectionWithReturn($qry);
    list($cname, $pid) = mysql_fetch_array($result);

    if (!mysql_num_rows($result))
    	echo "Character ID not found!<br />";
    else
    {
		?>
		<br />
		<center><h2>Service Record for <?php echo $cname ?></h2></center>

		<table border="1" cellpadding="3" cellspacing="1" align="center">
			<tr>
	    	    <th>Date</th>
    			<th>Type</th>
		        <th>Entry</th>
    		    <th>Entered By</th>
        		<th>Details</th>
		    </tr>

			<?php
    	    $qry = "SELECT id, level, date, entry, name, admin
            		FROM {$spre}record WHERE cid='$cid'
                    	AND level='In-Character' ORDER BY level,date";
    		$result = $database->openConnectionWithReturn($qry);

   			echo "<tr><td colspan=\"5\"><center>" .
            	 "<font size=\"+1\">In-Character Records</font>" .
                 "</center></td></tr>\n";

		    while ( list($rid, $lvl, $date, $record, $name, $radmin) = mysql_fetch_array($result) )
            {
            	if ($radmin == "n" || $radmin == "" || ($isadmin == 1 && $radmin == "y"))
                {
					echo "<tr><td>";
    	    		echo date("F j, Y", $date);
	    	    	echo "</td>\n<td>";
	    		    echo $lvl;
                	if ($radmin == "y")
    	            	echo "<br /><b>Admin-level</b>";
	    	    	echo "</td>\n<td>";
					echo $record;
    		    	echo "</td>\n<td>";
	        		echo $name;
		        	echo "</td>\n<td>";
	        	    if ($op == "ServiceRecord")
    	    		    echo "<form action=\"index.php?option=user&amp;op=RecordDetails\" method=\"post\"\n>";
					else
		    		    echo "<form action=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=rdetails\" method=\"post\">\n";
	            	echo "<input type=\"hidden\" name=\"rid\" value=\"" . $rid . "\" />\n";
    	        	echo "<input type=\"hidden\" name=\"sid\" value=\"na\" />\n";
	    	    	echo "<input type=\"SUBMIT\" value=\"Details\" /></form>\n";
					echo "</tr>\n";
                }
			}

	        echo "<tr><td colspan=\"5\">&nbsp;</td></tr>\n";

	        $qry = "SELECT id, level, date, entry, name, admin
            		FROM {$spre}record
                    WHERE cid='$cid' AND level='Out-of-Character'
                    ORDER BY level,date";
    		$result = $database->openConnectionWithReturn($qry);

   			echo "<tr><td colspan=\"5\"><center>" .
            	 "<font size=\"+1\">Out-of-Character Records</font>" .
                 "</center></td></tr>\n";

		    while ( list($rid, $lvl, $date, $record, $name, $radmin) = mysql_fetch_array($result) )
            {
            	if ($radmin == "n" || $radmin == "" || ($isadmin == 1 && $radmin == "y"))
                {
					echo "<tr><td>";
    	    		echo date("F j, Y", $date);
	    	    	echo "</td>\n<td>";
	    		    echo $lvl;
                	if ($radmin == "y")
    	            	echo "<br /><b>Admin-level</b>";
	    	    	echo "</td>\n<td>";
					echo $record;
    		    	echo "</td>\n<td>";
	        		echo $name;
		        	echo "</td>\n<td>";
	        	    if ($op == "ServiceRecord")
    	    		    echo "<form action=\"index.php?option=user&amp;op=RecordDetails\" method=\"post\">\n";
					else
		    		    echo "<form action=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=rdetails\" method=\"post\">\n";
	            	echo "<input type=\"hidden\" name=\"rid\" value=\"" . $rid . "\" />\n";
    	        	echo "<input type=\"hidden\" name=\"sid\" value=\"na\" />\n";
	    	    	echo "<input type=\"SUBMIT\" value=\"Details\" /></form>\n";
					echo "</tr>\n";
                }
			}

	        echo "<tr><td colspan=5>&nbsp;</td></tr>\n";

	        $qry = "SELECT id, level, date, entry, name, admin FROM {$spre}record WHERE pid='$pid' AND level='Player' ORDER BY level,date";
    		$result = $database->openConnectionWithReturn($qry);

   			echo "<tr><td colspan=\"5\"><center>" .
            	 "<font size=\"+1\">Player Records</font>" .
                 "</center></td></tr>\n";

		    while ( list($rid, $lvl, $date, $record, $name, $radmin) = mysql_fetch_array($result) )
            {
            	if ($radmin == "n" || $radmin == "" || ($isadmin == 1 && $radmin == "y"))
                {
					echo "<tr><td>";
    	    		echo date("F j, Y", $date);
	    	    	echo "</td>\n<td>";
	    		    echo $lvl;
                	if ($radmin == "y")
    	            	echo "<br /><b>Admin-level</b>";
	    	    	echo "</td>\n<td>";
					echo $record;
    		    	echo "</td>\n<td>";
	        		echo $name;
		        	echo "</td>\n<td>";
	        	    if ($op == "ServiceRecord")
    	    		    echo "<form action=\"index.php?option=user&amp;op=RecordDetails\" method=\"post\">\n";
					else
		    		    echo "<form action=\"index.php?option=" . option . "&amp;task=" . task . "&amp;action=common&amp;lib=rdetails\" method=\"post\">\n";
	            	echo "<input type=\"hidden\" name=\"rid\" value=\"" . $rid . "\" />\n";
    	        	echo "<input type=\"hidden\" name=\"sid\" value=\"na\" />\n";
	    	    	echo "<input type=\"SUBMIT\" value=\"Details\" /></form>";
					echo "</tr>";
                }
			}

	        echo "<tr><td colspan=5>&nbsp;</td></tr>\n";

			if ((($isadmin == 1) || ((task == "co") && (get_usertype($database, $mpre, $spre, $cid, $uflag)))) && $op != "ServiceRecord")
            {
       	       	$uname = get_usertype($database, $mpre, $spre, $cid, $uflag);
                if ($uname)
                {
					?>
					<form action="index.php?option=<?php echo option ?>&amp;task=<?php echo task ?>&amp;action=common&amp;lib=radd" method="post">
					    <tr>
						    <td><input type="hidden" name="date" value="<?php echo time() ?>" /><?php echo date("F j, Y") ?></td>
							<td>
						    	<select name="level">
									<option value="In-Character">In-Character</option>
				    	    	    <option value="Out-of-Character">Out-of-Character</option>
                                    <option value="Player">Player</option>
						        </select><br />
                                <?php
                                if ($isadmin == 1)
	                                echo "<input type=\"checkbox\" name=\"radmin\" /> Admin-level";
                                ?>
					    	</td>

						    <td><input type="text" name="entry" /></td>

				            <td>
			    	        	<?php
			           			echo "<input type=\"hidden\" name=\"pname\" value=\"" . $uname . "\" />" . $uname;
			    	    		?>
				             </td>
						    <td>
			    				<input type="hidden" name="cid" value="<?php echo $cid ?>" />
				                <input type="hidden" name="sid" value="na" />
			    				<input type="SUBMIT" value="Add"></form>
							</td>
						</tr>
                    </form>
                    <?php
				}
                else
                {
					echo "<tr><td colspan=\"5\" align=center>\n";
					echo "Error!  L1 - Cannot get user\n";
                  	echo "</td></tr>\n";
                }
			}
		echo "</table>\n";
	    echo "<p>Y'know, that's all thanks to Obsidian Fleet, since they released ";
	    echo "the IFS software which you're using right now.  Why not take a look - ";
	    echo "they're at http://www.obsidianfleet.net<br /><br /></p>";
	}
}
?>