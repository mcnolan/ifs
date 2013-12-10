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
  * Date: 1/6/04
  * Comments: Checks the value of magic_quotes_gpc and adds slashes if needed
  *			  Also checks and simulates register_globals=on
  *	  		  This is in a seperate page so that require_once can be used
  *
  * See CHANGELOG for patch details
  *
 ***/

if (!get_magic_quotes_gpc())
{
	add_magic_quotes('_GET');
	add_magic_quotes('_POST');
	add_magic_quotes('_COOKIE');
	add_magic_quotes('_SESSION');
}
else if ( ini_get('register_globals') == "")
{
	force_reg_globals('_GET');
	force_reg_globals('_POST');
	force_reg_globals('_COOKIE');
	force_reg_globals('_SESSION');
}

function add_magic_quotes($vars,$suffix = '')
{
	eval("\$vars_val =& \$GLOBALS[$vars]$suffix;");

	if (is_array($vars_val))
    {
		reset($vars_val);
		while (list($key,$val) = each($vars_val))
			add_magic_quotes($vars,$suffix."['$key']");
	}
    else
    {
		$vars_val = addslashes($vars_val);
		eval("\$GLOBALS$suffix = \$vars_val;");
	}
}

function force_reg_globals ($vars, $suffix = '')
{
	eval("\$vars_val =& \$GLOBALS[$vars]$suffix;");

	if (is_array($vars_val))
    {
		reset($vars_val);
		while (list($key,$val) = each($vars_val))
			force_reg_globals($vars,$suffix."['$key']");
	}
    else
		eval("\$GLOBALS$suffix = \$vars_val;");

}
?>
