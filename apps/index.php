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
  * Date:	12/12/03
  * Comments: App switchboard
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	switch ($task)
    {
		case 'crew':
    		include("apps/app.php");
    	    break;
        case 'crew2':
        	include("apps/app2.php");
            break;
        case 'co':
        	include("apps/co_app.php");
            break;
        case 'co2':
        	include("apps/co_app2.php");
            break;
		case 'sample':
			include("apps/sample.php");
			break;
        case 'ship':
        	include("apps/ship_app.php");
            break;
        case 'ship2':
        	include("apps/ship_app2.php");
            break;
        default:
        	include("apps/app.php");
            break;
    }
}

?>