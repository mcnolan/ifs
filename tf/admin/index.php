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
  * Date:	12/21/03
  * Comments: Uber-Admin page
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if ($uflag['a'] >= 1)
    {
		switch ($action)
        {
        	case 'shipdb':
            	include("tf/admin/sdbadmin.php");
                break;
			case 'tools':
	    		include("tf/admin/tools.php");
	    	    break;
            case 'uid':
            	include("tf/admin/uid.php");
                break;
            case 'ulev':
            	include("tf/admin/ulevels.php");
                break;
	        default:
	        	include("tf/admin/links.php");
	            break;
	    }
	}
    else
		echo "You do not have access to this area!";
}

?>