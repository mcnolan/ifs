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
  * Date:	10/22/04
  * Comments: Main ship admin page for TFCOs
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	// Let people with admin-access choose which TF to play with
	if ($uflag['t'] == 2)
    {
		if (!$adminship && !$sid)
        {
			?>
			<br /><br />
			<center>Hey, you're an admin!  That makes you special!<br />
            Choose which TF you want to modify.<br />
			<form action="index.php?option=ifs&amp;task=tfco&amp;action=<? echo $action ?>" method="post">
				<select name="adminship">
					<?php
			        $qry = "SELECT tf, name FROM {$spre}taskforces WHERE tg='0' ORDER BY tf";
			        $result = $database->openConnectionWithReturn($qry);
			        while ( list ($tfid, $tfname) = mysql_fetch_array($result) )
						echo "<option value=\"$tfid\">$tfname</option>\n";
					?>
				</select>
				<input type="submit" value="Submit" />
            </form></center>
			<?php
	        $tfid = "selecting";
		}
        // Once you've chosen a TF, we need the system to think you're the TFCO
        elseif (!$sid)
        {
			$tfid = $adminship;
	        $name = "Mr. Big-Shot Admin";
	    }
        else
	    	$tfid = "na";
	}
    elseif ($uflag['t'] == 1)
    {
		$qry = "SELECT t.name, t.tf
        		FROM {$spre}taskforces t, {$spre}characters c
                WHERE c.player='" . uid . "' AND t.tg=0 AND t.co=c.id";
		$result=$database->openConnectionWithReturn($qry);
		list($tfname,$tfid)=mysql_fetch_array($result);
	}

	if ($uflag['t'] >= 1)
    {
		if (!$tfid)
			echo "<br /><br /><center>You have a TFCO User Level, but you are not listed as the CO of a TF!<br />" .
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
    			case 'report':
			    	include("tf/tfco/report.php");
			        break;
			    case 'save_report':
		    		include("tf/tfco/report2.php");
		        	break;
			    case 'tools':
			    	include("tf/tfco/tools.php");
			        break;
            	case 'listing':
            		include("tf/tfco/listing.php");
	                break;
                case 'stats':
                	include("tf/tfco/stats.php");
                    break;
				default:
                	include("tf/tfco/listing.php");
                	break;
			}
	    }
	}
    else
		echo "You do not have access to this area!";
}
?>