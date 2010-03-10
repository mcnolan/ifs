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
  * Comments: JAG tools
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if ($uflag['j'] >= 1)
    {
		switch ($action)
        {
			case 'bans':
            	include("tf/jag/banlist.php");
                break;
			case 'common':
	    		include("tf/tools.php");
	    	    break;
            case 'tools2':
            	include("tf/jag/tools2.php");
                break;
	        default:
	        	include("tf/jag/tools.php");
	            break;
	    }
	}
    else
		echo "You do not have access to this area!";
}

?>