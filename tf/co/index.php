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
  * Date:	10/22/04
  * Comments: Main ship admin page for COs
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if ($action == 'save_report')
	   	include("tf/co/report2.php");
    else
    {
    	// Give people with admin access to CO area the ability to choose
        // which ship to play with
		if ($uflag['c'] == 2)
        {
        	// Haven't chosen a ship yet, eh?
			if (!$adminship && !$sid)
            {
				?>
				<br /><br />
				<center><a class="ifsheading">CO Area</a><br /><br />
				Hey, you're an admin!  That makes you special!<br />
                Choose which ship you want to modify.<br />
				<form action="index.php?option=ifs&amp;task=co&amp;action=<?php echo $action ?>" method="post">
					<select name="adminship">
						<?php
		    	    	$qry = "SELECT id, name FROM {$spre}ships WHERE tf!='99' ORDER BY name";
		    	    	$result = $database->openConnectionWithReturn($qry);
			        	while ( list ($sid, $sname) = mysql_fetch_array($result) )
							echo "<option value=\"$sid\">$sname</option>\n";
						?>
					</select>
					<input type="submit" value="Submit" />
        	    </form></center>
				<?php
	        	$sid = "selecting";
		    }

            // Now that a ship has been chosen, we make the system think that
            // you're the CO so that it lets you in.
            elseif (!$sid)
            {
				$sid = $adminship;
	        	$name = "Mr. Big-Shot Admin";
		    }
		}

        // Regular CO access?  Well, we need to find your ship...
        elseif ($uflag['c'] == 1)
        {
			$qry = "SELECT name, ship FROM {$spre}characters
            		WHERE player='$uid' AND pos='Commanding Officer'
                    	AND ship!='" . UNASSIGNED_SHIP . "'
                        AND ship!='" . TRANSFER_SHIP. "'
                        AND ship!='" . DELETED_SHIP . "'
                        AND ship!='" . FSS_SHIP . "'";
			$result=$database->openConnectionWithReturn($qry);
			list($name,$sid)=mysql_fetch_array($result);
		}

		if ($uflag['c'] >= 1)
        {
			if (!$sid)
				echo "<br /><br /><center>You have a CO User Level, " .
                	 "but you are not listed as the CO of a ship!<br />\n" .
                     "Sorry, can't let you in!</center><br /><br /><br />\n";
			elseif ($sid != 'selecting')
            {
				switch ($action)
                {
                	case 'acad':
                    	include("tf/co/academy.php");
                        break;
                	case 'award':
                    	include("tf/co/award.php");
                        break;
                    case 'awardsave':
                    	include("tf/co/award2.php");
                    	break;
    	    		case 'common':
        	    		include("tf/tools.php");
            	    	break;
					case 'positions':
			    		include("tf/co/positions.php");
	    			    break;
		    		case 'save_pos':
			    		include("tf/co/positions2.php");
				        break;
    				case 'report':
			    		include("tf/co/report.php");
		    	    	break;
			    	case 'save_report':
				    	include("tf/co/report2.php");
				        break;
			    	case 'view':
				    	include("tf/co/view.php");
			    	    break;
					default:
    	            	include("tf/co/view.php");
        	            break;
				}
		    }
		}
        else
			echo "You do not have access to this area!";
	}
}
?>