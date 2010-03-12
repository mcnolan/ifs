<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Updated By: Nolan
  *		john.pbem@gmail.com
  *
  * Version:	1.14n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  *
  * See CHANGELOG for patch details
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
	case 'reassign':
		include("tf/academy/reassign.php");
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
