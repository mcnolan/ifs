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
  * Date:	5/02/04
  * Comments: JAG banlist admin
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if ($lib != "")
    	include ("tf/jag/banlist2.php");
    else
    {
		// Expire old bans
		$time = time();
		$qry = "SELECT id FROM {$spre}banlist WHERE expire<'$time' AND expire!='0' AND active='1'";
	    $result = $database->openConnectionWithReturn($qry);
	    while (list($bid) = mysql_fetch_array($result))
        {
	    	$qry2 = "UPDATE {$spre}banlist SET active='0' WHERE id='$bid' OR alias='$bid'";
	    	$database->openConnectionNoReturn($qry2);
		}

   	    $auth = get_usertype($database, $mpre, $spre, $cid, $uflag);
		?>
		<br /><center>
		Welcome to JAG Banlist Admin<br />
		Please note that your login will time out after about 10 minutes of inactivity.
		</center><br /><br />

	    <h1>Add a ban:</h1>
    	<form action="index.php?option=ifs&amp;task=jag&amp;action=bans&amp;lib=badd" method="post">
	    	Email Address: <input type="text" name="email" size="30" /><br />
    	    IP Address (use * for wildcard): <input type="text" name="banip" size="15" maxlength="15" /><br />
        	<i>Both email <b>and</b> IP are not required</i><br /><br />

	        Reason:<br />
    	    <textarea name="reason" rows="5" cols="30"></textarea><br /><br />

            Length: <input type="text" name="length" size="5" /> days (0 for no expiry)<br />

            Type:
            <select name="level">
               	<option value="all">Full Ban</option>
                <option value="command">Ban from Command</option>
            </select>
            <br /><br />

			Date: <?php echo date("F j, Y", time()) ?>
    	    <input type="hidden" name="bandate" value="<?php echo time() ?>" /><br />

	        Authorized by: <?php echo $auth ?>
    	    <input type="hidden" name="auth" value="<?php echo $auth ?>" /><br />
	        <input type="submit" value="Ban!" />
    	</form>

	    <br /><br />

		<h1>Active Bans:</h1><br />
    	<table width="100%" align="center" border="1">
	    	<tr>
	        	<th>Ban ID</th>
    	        <th>Date</th>
        	    <th>Authorized By</th>
            	<th>Email</th>
    	        <th>IP</th>
	            <th>&nbsp;</th>
	        </tr>
    	    <tr>
        		<th colspan="3">Reason</th>
                <th>Expiry</th>
                <th colspan="2">Level</th>
	        </tr>
    	    <tr>
	        	<td colspan="6">&nbsp;</td>
        	</tr>
			<?php
			$qry = "SELECT id, date, auth, reason, expire, level
            		FROM {$spre}banlist WHERE alias='0' AND active='1'";
	    	$result = $database->openConnectionWithReturn($qry);

            if (!mysql_num_rows($result))
            	echo "<tr><td colspan=\"6\" align=\"center\">We're such a good fleet!  Not a single ban!</td></tr>\n";

		    while (list ($mid, $mdate, $mauth, $reason, $expire, $level) = mysql_fetch_array($result))
            {
            	if ($expire == '0')
                	$expire = "Permanent";
                else
                	$expire = date("F d, Y", $expire);

                if ($level == "all")
                	$level = "Full Ban";
                elseif ($level == "command")
                	$level = "Ban from Command";
    	    	?>
				<tr>
            		<td><?php echo $mid ?></td>
                	<td><?php echo date("F j, Y", $mdate) ?>
	                <td><?php echo $mauth ?></td>
    	            <td>
        	        	<?php
            	        $qry2 = "SELECT email FROM {$spre}banlist WHERE (alias='$mid' OR id='$mid') AND active='1' ORDER BY date";
                	    $result2 = $database->openConnectionWithReturn($qry2);
                    	while (list ($email) = mysql_fetch_array($result2))
	                    	if ($email != "")
		                    	echo $email . "<br />\n";
                		?>
	                </td>
    	            <td>
        	        	<?php
            	        $qry2 = "SELECT ip FROM {$spre}banlist WHERE (alias='$mid' OR id='$mid') AND active='1' ORDER BY date";
                	    $result2 = $database->openConnectionWithReturn($qry2);
                    	while (list ($banip) = mysql_fetch_array($result2))
							if ($banip != "")
		                    	echo $banip . "<br />\n";
                		?>
	                </td>
    	            <td valign="bottom">
        	        	<a href="index.php?option=ifs&amp;task=jag&amp;action=bans&amp;lib=bdet&amp;bid=<?php echo $mid ?>">Details/<br />Edit</a><br />
        	        	<a href="index.php?option=ifs&amp;task=jag&amp;action=bans&amp;lib=bdel&amp;bid=<?php echo $mid ?>">Unban</a><br />
                	</td>
	            </tr>
		        <tr>
                	<td>&nbsp;</td>
	    	    	<td colspan="2"><?php echo $reason ?></td>
                    <td><?php echo $expire ?></td>
                    <td colspan="2"><?php echo $level ?></td>
    	    	</tr>
	        	<tr>
		        	<td colspan="6">&nbsp;</td>
    		    </tr>
	        <?php
    	    }
	    echo "</table><br />\n";
		?>

		<h1>Inactive Bans:</h1><br />
    	<table width="100%" align="center" border="1">
	    	<tr>
	        	<th>Ban ID</th>
    	        <th>Date</th>
        	    <th>Authorized By</th>
            	<th>Email</th>
    	        <th>IP</th>
	            <th>&nbsp;</th>
	        </tr>
    	    <tr>
        		<th colspan="3">Reason</th>
                <th>Expiry</th>
                <th colspan="2">Level</th>
	        </tr>
    	    <tr>
	        	<td colspan="6">&nbsp;</td>
        	</tr>
			<?php
			$qry = "SELECT id, date, auth, reason, expire, level
            		FROM {$spre}banlist WHERE alias='0' AND active='0'";
	    	$result = $database->openConnectionWithReturn($qry);

            if (!mysql_num_rows($result))
            	echo "<tr><td colspan=\"6\" align=\"center\">We're such a good fleet!  Not a single ban!</td></tr>\n";

		    while (list ($mid, $mdate, $mauth, $reason, $expire, $level) = mysql_fetch_array($result))
            {
            	if ($expire == '0')
                	$expire = "Permanent";
                else
                	$expire = date("F d, Y", $expire);

                if ($level == "all")
                	$level = "Full Ban";
                elseif ($level == "command")
                	$level = "Ban from Command";
    	    	?>
				<tr>
            		<td><?php echo $mid ?></td>
                	<td><?php echo date("F j, Y", $mdate) ?></td>
	                <td><?php echo $mauth ?></td>
    	            <td>
        	        	<?php
            	        $qry2 = "SELECT email FROM {$spre}banlist WHERE (alias='$mid' OR id='$mid') AND active='0' ORDER BY date";
                	    $result2 = $database->openConnectionWithReturn($qry2);
                    	while (list ($email) = mysql_fetch_array($result2))
	                    	if ($email != "")
		                    	echo $email . "<br />\n";
                		?>
	                </td>
    	            <td>
        	        	<?php
            	        $qry2 = "SELECT ip FROM {$spre}banlist WHERE (alias='$mid' OR id='$mid') AND active='0' ORDER BY date";
                	    $result2 = $database->openConnectionWithReturn($qry2);
                    	while (list ($banip) = mysql_fetch_array($result2))
							if ($banip != "")
		                    	echo $banip . "<br />\n";
                		?>
	                </td>
    	            <td valign="bottom">
        	        	<a href="index.php?option=ifs&amp;task=jag&amp;action=bans&amp;lib=bundel&amp;bid=<?php echo $mid ?>">Activate</a><br />
                	</td>
	            </tr>
		        <tr>
                	<td>&nbsp;</td>
	    	    	<td colspan="2"><?php echo $reason ?></td>
                    <td><?php echo $expire ?></td>
                    <td colspan="2"><?php echo $level ?></td>
    	    	</tr>
	        	<tr>
		        	<td colspan="6">&nbsp;</td>
    		    </tr>
	        <?php
    	    }
	    echo "</table><br />\n";
    }
}
?>