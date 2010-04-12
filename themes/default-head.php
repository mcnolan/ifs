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
  * Version:	1.13n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
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
// This needs to be in a PHP echo() command to avoid PHP thinking it's a
//		PHP command
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!--
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net - http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Version:	1.14n
  * Release Date: June 3, 2004
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  -->

<head>
<title><?php echo fleetname ?></title>
<link rel="stylesheet" href="<?php echo $relpath ?>themes/default.css" type="text/css" />
</head>

<body>
<?php
$newstop = "";
$logintop = "";
$searchtop = "";

if ($pop != "y")
	echo "<center><img src=\"". $fleetbanner . "\" alt=\"".$fleetname."\"></center><br /><br />\n";
?>
