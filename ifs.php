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
  * Date:	12/9/03
  * Comments: Acts as a switchboard for IFS functions
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if (strpos($task, ".") === false &&
    	strpos($task, "/") === false &&
        strpos($task, "\\") === false &&
        strpos($task, "?") === false &&
        strpos($task, "=") === false)
    {
        if ($task != "common")
		   	include("tf/{$task}/index.php");
        else
           	include("tf/tools.php");
	}
    else
    	echo "Hacking attempt!!!";
}

?>