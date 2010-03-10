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
  * Comments: JAG banlist admin
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	switch ($lib)
    {
    	// Add a ban
    	case "badd":
        	if ($email != "")
            {
	        	$qry = "SELECT id FROM {$spre}banlist WHERE email='$email' AND active='1'";
	            $result = $database->openConnectionWithReturn($qry);
                if (mysql_num_rows($result))
                	$alreadyemail = 1;
            }
        	if ($banip != "")
            {
	        	$qry = "SELECT id FROM {$spre}banlist WHERE ip='$banip' AND active='1'";
	            $result = $database->openConnectionWithReturn($qry);
                if (mysql_num_rows($result))
                	$alreadyip = 1;
            }

			if ($email == "" && $banip == "")
            	echo "We need at least the email address <i>or</i> IP address!";
            elseif ($alreadyemail)
            	echo "This email is already banned...";
            elseif ($alreadyip)
            	echo "This IP is already banned...";
            else
            {
            	$expire = time() + ($length * 60 * 60 * 24);
				$qry = "INSERT INTO {$spre}banlist SET date='$bandate', auth='$auth', reason='$reason', alias='0', email='$email', ip='$banip', active='1', expire='$expire', level='$level'";
				$database->openConnectionNoReturn($qry);
                ?>

                <h1>Banlist Admin</h1><br /><br />
                The following user has been <b>BANNED</b>:<br />
                Email: <?php echo $email ?><br />
                IP: <?php echo $banip ?><br /><br />
                (<?php echo date("F j, Y", $bandate) ?>, by <?php echo $auth ?>)<br />
                <?php echo stripslashes($reason) ?>
                <br /><br />
                <i>All future applications matching this record will be denied.<br />
                Please note that this does not affect any current characters this person
                may have; these need to be removed by the CO/TFCO/FCops/Triad/etc</i>

                <?php
            }
            break;

		//Details on a ban
        case "bdet":
			$qry = "SELECT id, date, auth, reason, active, expire, level
            		FROM {$spre}banlist WHERE id='$bid'";
	    	$result = $database->openConnectionWithReturn($qry);
		    list ($mid, $mdate, $mauth, $reason, $active, $expire, $level) = mysql_fetch_array($result);

			if ($expire == "0")
            	$length = "0";
            else
				$length = round(($expire - time()) / (60*60*24));
   	    	?>
			Ban ID: <?php echo $mid ?><br />
            Date of Original Ban: <?php echo date("F j, Y", $mdate) ?><br />
            Authorized By: <?php echo $mauth ?><br /><br />

            <?php
            if ($active == "1")
            	echo "<b>THIS BAN IS ACTIVE</b><br /><br />\n";
            else
            	echo "<b>THIS BAN IS INACTIVE</b><br /><br />\n";
            ?>

            <form action="index.php?option=ifs&amp;task=jag&amp;action=bans&amp;lib=save" method="post">
	            Ban expires in <input type="text" name="length" size="5" value="<?php echo $length ?>" /> days
                <?php
                if ($expire == "0")
                	echo "(that's a permanent ban)<br />\n";
                else
                	echo "(on " . date("F d, Y", $expire) . ")<br />\n";
                ?>
	            <br />

	            Bantype:<br />
	            <select name="level">
    	           	<option value="all"<?php if ($level == "all") echo " selected\"selected\"" ?>>Full Ban</option>
        	        <option value="command"<?php if ($level == "command") echo " selected=\"selected\"" ?>>Ban from Command</option>
            	</select>
	            <br />

            Reason:<br />
	    	    <textarea name="reason" rows="5" cols="30"><?php echo $reason ?></textarea><br />
                <input type="hidden" name="bid" value="<?php echo $mid ?>" />
            	<input type="submit" value="Update" />
            </form>
            <br />

            <u>Email Addresses:</u><br />
            <?php
            $qry = "SELECT email, date, auth FROM {$spre}banlist
            		WHERE alias='$bid' OR id='$bid' ORDER BY date";
            $result = $database->openConnectionWithReturn($qry);
            while (list ($email, $date, $auth) = mysql_fetch_array($result))
               	if ($email != "")
                {
                   	echo $email . "<br />\n";
                    echo "(" . date("F j, Y", $date) . ", by " . $auth . ")<br /><br />\n";
                }
    	    $auth = get_usertype($database, $mpre, $spre, $cid, $uflag);
            ?>

            <form action="index.php?option=ifs&amp;task=jag&amp;action=bans&amp;lib=semail" method="post">
            	Add: <input type="text" name="email" size="30" /><br />
                Authorized by: <?php echo $auth ?><br />
            	<input type="hidden" name="auth" value="<?php echo $auth ?>" />
                Date: <?php echo date("F j, Y", time()) ?><br />
	    	    <input type="hidden" name="bandate" value="<?php echo time() ?>" />
	    	    <input type="hidden" name="bid" value="<?php echo $bid ?>" />
                <input type="submit" value="Add Alias" />
            </form><br /><br />

			<u>IP Addresses:</u><br />
            <?php
            $qry = "SELECT ip, date, auth FROM {$spre}banlist
            		WHERE alias='$bid' OR id='$bid' ORDER BY date";
            $result = $database->openConnectionWithReturn($qry);
            while (list ($banip, $date, $auth) = mysql_fetch_array($result))
               	if ($banip != "")
                {
                   	echo $banip . "<br />\n";
                    echo "(" . date("F j, Y", $date) . ", by " . $auth . ")<br /><br />\n";
                }
    	    $auth = get_usertype($database, $mpre, $spre, $cid, $uflag);
            ?>

            <form action="index.php?option=ifs&amp;task=jag&amp;action=bans&amp;lib=sip" method="post">
            	Add: <input type="text" name="banip" size="15" maxlength="15" /><br />
                Authorized by: <?php echo $auth ?><br />
            	<input type="hidden" name="auth" value="<?php echo $auth ?>" />
                Date: <?php echo date("F j, Y", time()) ?><br />
	    	    <input type="hidden" name="bandate" value="<?php echo time() ?>" />
	    	    <input type="hidden" name="bid" value="<?php echo $bid ?>" />
                <input type="submit" value="Add Alias" />
            </form><br /><br />
            <?php
        	break;


        case "bdel":
        	$qry = "UPDATE {$spre}banlist SET active='0' WHERE id='$bid' OR alias='$bid'";
            $database->openConnectionNoReturn($qry);
			echo "<h1>Banlist Admin</h1><br /><br />\n";
            echo "The user has been <b>UNBANNED</b>.<br /><br />\n";

			$lib = "";
            include("tf/jag/banlist.php");
            break;


        case "bundel":
        	$qry = "SELECT expire FROM {$spre}banlist WHERE id='$bid'";
            $result = $database->openConnectionWithReturn($qry);
            list ($expire) = mysql_fetch_array($result);

            if ($expire < time())
            	$expire = "0";

        	$qry = "UPDATE {$spre}banlist SET active='1', expire='$expire'
            		WHERE id='$bid' OR alias='$bid'";
            $database->openConnectionNoReturn($qry);
			echo "<h1>Banlist Admin</h1><br /><br />\n";
            echo "The user has been <b>BANNED</b>.<br /><br />\n";

			$lib = "";
            include("tf/jag/banlist.php");
            break;


        case "semail":
        	$qry = "SELECT id FROM {$spre}banlist WHERE email='$email'";
            $result = $database->openConnectionWithReturn($qry);
            if (mysql_num_rows($result))
              	echo "This email is already banned...";
            else
            {
	        	$qry = "INSERT INTO {$spre}banlist
                		SET date='$bandate', auth='$auth', alias='$bid',
                        	email='$email', active='1'";
				$database->openConnectionNoReturn($qry);
				redirect("&amp;action=bans&amp;lib=bdet&amp;bid={$bid}");
            }
            break;


        case "sip":
        	$qry = "SELECT id FROM {$spre}banlist WHERE ip='$banip'";
            $result = $database->openConnectionWithReturn($qry);
            if (mysql_num_rows($result))
              	echo "This IP is already banned...";
            else
            {
	        	$qry = "INSERT INTO {$spre}banlist
                		SET date='$bandate', auth='$auth', alias='$bid',
                        	ip='$banip', active='1'";
				$database->openConnectionNoReturn($qry);
                redirect("&amp;action=bans&amp;lib=bdet&amp;bid={$bid}");
            }
            break;


        case "save":
        	$length = time() + ($length * 60 * 60 * 24);
			$qry = "UPDATE {$spre}banlist
            		SET reason='$reason', expire='$length', level='$level'
                    WHERE id='$bid'";
            $database->openConnectionNoReturn($qry);
			redirect("&amp;action=bans&amp;lib=bdet&amp;bid={$bid}");
    }

}
?>