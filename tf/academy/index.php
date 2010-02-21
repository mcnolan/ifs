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
  * Comments: Academy tools
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if ($uflag['d'] >= 1)
    {
		switch ($action)
        {
            case 'admin':
	        	if ($uflag['d'] == 2)
	                include("tf/academy/admin.php");
                else
                	echo "You do not have access to this area!";
	            break;
            case 'common':
            	include("tf/tools.php");
            	break;
        	case 'inst':
            	include("tf/academy/instructor.php");
                break;
            case 'list':
            	include("tf/academy/list.php");
                break;
            case 'save':
            	include("tf/academy/save.php");
                break;
            case 'wait':
            	include("tf/academy/wait.php");
                break;
	        default:
	        	include("tf/academy/list.php");
	            break;
	    }
	}
    else
		echo "You do not have access to this area!";
}

?>