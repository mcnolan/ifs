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
  * Comments: Admin tool for playing with peoples' userlevels
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
    echo "<h1>Userlevel Admin</h1><br />\n";

	switch ($lib)
    {
		case "disp":
        	if ($cid)
            {
            	$qry = "SELECT player FROM {$spre}characters WHERE id='$cid'";
                $result = $database->openConnectionWithReturn($qry);
                list ($euid) = mysql_fetch_array($result);
            }

          	$qry = "SELECT name, flags FROM {$mpre}users WHERE id='$euid'";
            $result = $database->openConnectionWithReturn($qry);

			if (!mysql_num_rows($result))
            	echo "UID not found";
            else
            {
	            list ($uname, $curflag) = mysql_fetch_array($result);
    	        echo "<b>$euid - $uname</b><br /><br />\n";
        	    ?>
				<form action="index.php?option=ifs&amp;task=admin&amp;action=ulev&amp;lib=save" method="post">
    	        	<input type="hidden" name="euid" value="<?php echo $euid ?>" />
    	        	<input type="hidden" name="uname" value="<?php echo $uname ?>" />
	    	        <table width="100%" align="center" border="1" cellpadding="5">
    	    	    	<tr>
        	    	    	<th>
            	    	    	Flag (admin-type in italics)
                	    	</th>
	                    	<th>
		                    	No Access
    		                </th>
        		            <th>
            		        	Regular Access
                		    </th>
                    		<th>
		                    	Super Access
    		                </th>
                            <th>
                            	Main Flag
                            </th>
        		        </tr>

						<?php
			            $qry = "SELECT name, flag, admin FROM {$spre}flags ORDER BY flag";
    			        $result = $database->openConnectionWithReturn($qry);

						while (list ($fname, $fid, $admin) = mysql_fetch_array($result))
                        {
    	            	    echo "<tr>\n";
                            	if ($admin == "1")
		    	               		echo "<td><i>{$fname}</i></td>\n";
                                else
		    	               		echo "<td>{$fname}</td>\n";
    	    	               	echo "<td>";
		        	                if (!strstr($curflag, $fid))
        	        	            	echo "<input type=\"radio\" name=\"flag[{$fid}]\" value=\"0\" checked=\"checked\" />";
		                	        else
        	                	    	echo "<input type=\"radio\" name=\"flag[{$fid}]\" value=\"0\" />";
		                    	echo "</td>\n";
		                        echo "<td>";
	    	                        if (strstr($curflag, $fid))
	        	                    	echo "<input type=\"radio\" name=\"flag[{$fid}]\" value=\"1\" checked=\"checked\" />";
	            	                else
	                	            	echo "<input type=\"radio\" name=\"flag[{$fid}]\" value=\"1\" />";
	                    		echo "</td>\n";
		                        echo "<td>";
		                            if (strstr($curflag, strtoupper($fid)))
	    	                        	echo "<input type=\"radio\" name=\"flag[{$fid}]\" value=\"2\" checked=\"checked\" />";
	        	                    else
	            	                	echo "<input type=\"radio\" name=\"flag[{$fid}]\" value=\"2\" />";
	                    		echo "</td>\n";
                                echo "<td>";
                                	if ($curflag{0} == $fid)
	                                	echo "<input type=\"radio\" name=\"mainflag\" value=\"{$fid}\" checked=\"checked\" />";
                                    else
	                                	echo "<input type=\"radio\" name=\"mainflag\" value=\"{$fid}\" />";
                            	echo "</td>\n";
		                    echo "</tr>\n";
		            	}
	    	            ?>
	        	    </table><br />
                    <i>Note that regular triad access includes super access to everything else,<br />
                    and that no other flags need to be set.</i><br /><br />

					Main Character:
                    <select name="mainchar">
	                    <?php
						$qry = "SELECT mainchar FROM {$mpre}users WHERE id='$euid'";
                        $result = $database->openConnectionWithReturn($qry);
                        list ($mainchar) = mysql_fetch_array($result);

	                    $qry = "SELECT c.id, r.rankdesc, c.name, s.name
                        		FROM {$spre}rank r, {$spre}characters c, {$spre}ships s
                                WHERE c.player='$euid' AND c.ship=s.id AND c.rank=r.rankid";
						$result = $database->openConnectionWithReturn($qry);

						while (list ($cid, $rname, $coname, $sname) = mysql_fetch_array($result))
                        {
	                    	echo "<option value=\"$cid\"";
                            if ($cid == $mainchar)
                            	echo " selected=\"selected\"";
                            echo ">$rname {$coname}, $sname</option>\n";
	                	}
    	                ?>
                    </select><br />
                	<input type="submit" value="Update" />
	            </form>
    	        <?php
            }
        	break;


        case "save":
   	        echo "<b>$euid - $uname</b><br /><br />\n";
        	if ($flag[$mainflag] == "0")
            	echo "the main flag must be set to have at least regular access!";
            else
            {
	            $qry = "SELECT name, flag FROM {$spre}flags ORDER BY flag";
		        $result = $database->openConnectionWithReturn($qry);

				if ($flag[$mainflag] == "1")
		            $userflags = strtolower($mainflag);
                elseif ($flag[$mainflag] == "2")
		            $userflags = strtoupper($mainflag);
				while (list ($fname, $fid) = mysql_fetch_array($result))
                {
                	if ($fid != $mainflag)
                    {
	        	        if ($flag[$fid] == "1")
                        {
					        $userflags .= strtolower($fid);
                            echo $fname . " set to regular access.<br />\n";
        	        	}
                        elseif ($flag[$fid] == "2")
                        {
					        $userflags .= strtoupper($fid);
                            echo $fname . " set to super access.<br />\n";
                        }
                    }
                    else
	        	        if ($flag[$fid] == "1")
                            echo $fname . " set to regular access. <b>MAIN FLAG</b><br />\n";
        	        	elseif ($flag[$fid] == "2")
                            echo $fname . " set to super access. <b>MAIN FLAG</b><br />\n";
        	    }
                $qry = "SELECT c.id, r.rankdesc, c.name, s.name FROM {$spre}rank r, {$spre}characters c, {$spre}ships s WHERE c.id='$mainchar' AND c.ship=s.id AND c.rank=r.rankid";
				$result = $database->openConnectionWithReturn($qry);
                list ($mcid, $mcrank, $mcname, $mcship) = mysql_fetch_array($result);
                echo "<br />($mcid) <i>$mcrank $mcname, $mcship</i> set as main character.<br /><br />\n";

                $qry = "UPDATE {$mpre}users SET flags='$userflags', mainchar='$mainchar' WHERE id='$euid'";
                $database->openConnectionNoReturn($qry);
                echo "Done.\n";
            }
        	break;


        case "sname":
        	$qry = "SELECT id, username FROM {$mpre}users WHERE username LIKE '%{$uname}%' ORDER BY username";
            $result = $database->openConnectionWithReturn($qry);

            while (list ($uid, $uname) = mysql_fetch_array($result))
            	echo "<a href=\"index.php?option=ifs&amp;task=admin&amp;action=ulev&amp;lib=disp&amp;euid={$uid}\">$uid - $uname</a><br />\n";
            echo "<br /><br />\n";
        	break;


        default:
	    	?>
			<form action="index.php?option=ifs&amp;task=admin&amp;action=ulev&amp;lib=sname" method="post">
		    	Search for a user by username:
	    	    <input type="text" name="uname" size="30" />
	        	<input type="submit" value="Submit" />
	        </form>
	        <br />

			<form action="index.php?option=ifs&amp;task=admin&amp;action=ulev&amp;lib=disp" method="post">
		    	Select a user by ID:
	    	    <input type="text" name="euid" size="5" />
	        	<input type="submit" value="Submit" />
	        </form>
	        <br />

			<form action="index.php?option=ifs&amp;task=admin&amp;action=ulev&amp;lib=disp" method="post">
		    	Select a user by characer ID (the player for this character):
	    	    <input type="text" name="cid" size="5" />
	        	<input type="submit" value="Submit" />
	        </form>
	        <br /><br />
			<?php
        	break;
    }
}

?>