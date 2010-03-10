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
  * Comments: Calls component pages that make up the main page outline
  *
 ***/

// For security check
define ("IFS", TRUE);
define ("IFS-index", TRUE);

// header includes db and session init, theme selection, top banner, etc
$reqtype = "";
$relpath = "";
$title = "Powered by Obsidian Fleet IFS (please change this to your title)";
require ("includes/header.php");

// main page, including menus, components, and an include to the main "meat"
require ("themes/" . $cur_theme . "-main.php");

// footer includes copyright disclaimer, etc
$no_back_to = 1;
require ("includes/footer.php");

?>