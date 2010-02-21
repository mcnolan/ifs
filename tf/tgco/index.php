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
  * Date:	5/03/04
  * Comments: Main ship admin page for TGCOs
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	// Let people with admin-access choose which TG to play with
	if ($uflag['g'] == 2 || $uflag['t'] > 0)
    {
		if (!$adminship && !$sid)
        {
			?>
			<br /><br />
			<center>Hey, you're an admin!  That makes you special!<br />
            Choose which TG you want to modify.<br />
			<form action="index.php?option=ifs&amp;task=tgco&amp;action=<? echo $action ?>" method="post">
				<select name="adminship">
					<?php
                    if ($uflag['t'] == 1)
                    {
	                    $qry = "SELECT t.name, t.tf
	                            FROM {$spre}taskforces t, {$spre}characters c
	                            WHERE c.player='" . uid . "' AND t.tg=0 AND t.co=c.id";
	                    $result=$database->openConnectionWithReturn($qry);
	                    list($tfname,$tfid)=mysql_fetch_array($result);
                        $tflimit = "AND tf='$tfid'";
                    }
                    else
                    	$tflimit = "";

			        $qry = "SELECT tf, tg, name FROM {$spre}taskforces
		                    WHERE tg!='0' $tflimit ORDER BY tf, tg";
			        $result = $database->openConnectionWithReturn($qry);
			        while ( list ($tfid, $tgid, $tgname) = mysql_fetch_array($result) )
						echo "<option value=\"{$tfid}-{$tgid}\">$tfid - $tgid $tgname</option>\n";
					?>
				</select>
				<input type="submit" value="Submit" />
            </form></center>
			<?php
	        $tfid = "selecting";
		}
        // Once you've chosen a TG, we need the system to think you're the TGCO
        elseif (!$sid)
        {
			$tfid = substr($adminship, 0, strpos($adminship, "-"));
            $tgid = substr($adminship, strpos($adminship, "-")+1);
	        $name = "Mr. Big-Shot Admin";
	    }
        else
	    	$tfid = "na";
	}
    elseif ($uflag['g'] == 1)
    {
		$qry = "SELECT t.name, t.tf, t.tg
        		FROM {$spre}taskforces t, {$spre}characters c
                WHERE c.player='" . uid . "' AND t.tg!=0 AND t.co=c.id";
		$result=$database->openConnectionWithReturn($qry);
		list($tgname,$tfid,$tgid)=mysql_fetch_array($result);
	}

	if ($uflag['g'] > 0)
    {
		if (!$tfid)
			echo "<br /><br /><center>You have a TGCO User Level, but you are not listed as the CO of a TG!<br />" .
            	 "Sorry, can't let you in!</center><br /><br /><br />\n";
		elseif ($tfid != 'selecting')
        {
			switch ($action)
            {
	        	case 'acad':
    	        	include("tf/tfco/academy.php");
        	        break;
	        	case 'common':
    	        	include("tf/tools.php");
        	        break;
            	case 'listing':
            		redirect("index.php?option=ships&tf={$tfid}&tg={$tgid}");
	                break;
                case 'stats':
                	include("tf/tfco/stats.php");
                    break;
				default:
            		redirect("index.php?option=ships&tf={$tfid}&tg={$tgid}");
                	break;
			}
	    }
	}
    else
		echo "You do not have access to this area!";
}
?>