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
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	$qry = "UPDATE {$spre}taskforces SET jag='$djag' WHERE tf='$tfid' AND tg='0'";
    $database->openConnectionNoReturn($qry);

	echo "<h1>Update Divisional JAG</h1><br />\n";
    echo "Divisional JAG for Task Force {$tfid} changed to {$djag}.\n";
}
?>