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
  * Date:	6/03/04
  * Comments: Configuration variables
  *
  * See CHANGELOG for patch details
  *
 ***/

/********************
 * mySQL settings	*
 ********************/
$host = 'localhost';				// mySQL server

/* 	Feel free to change the following prefixes.  The install script reads this
    config file, so you don't need to worry about the defaults.			*/
$mpre = 'www_';						// prefix for webpage-related tables
$spre = 'ifs_';						// prefix for simm-related tables
$sdb = 'sdb_';						// prefix for shipdb tables

$user = 'username';						// mySQL username
$password = 'password';					// mySQL password
$db = 'ifs';						// mySQL database

/********************
 * Email config		*
 ********************/
// The "from" address of IFS-generated email
$emailfrom = "IFS Mail <user@domain.com>";
// The webmaster's email address
$webmasteremail = "user@domain.com";

/********************
 * Misc Settings	*
 ********************/
$maxchars = "5";            		// Max. number of characters per player
$fleetname = 'My Fleet';			// Name of the fleet
$live_site = 'http://www.whatever.com';	// URL to your site
$fleetdesc = 'This text will appear in the bottom section of your front page, and is generally used to describe your fleet.';
$fleetbanner = 'images/example-banner.jpg';	//

// Legacy settings from the Mambo config file.  Dunno how important they are
// Path settings
$base_path = '/path/to/ifs';
//Shouldn't have to adjust below
$pdf_path = $base_path + 'pdf/';
$image_path = $base_path + 'images/stories';
$sitename = $fleetname;
$col = 3;
$row = 3;

if ($directory !='uploadfiles'){
	$title[0] = 'Story Images';
	$dir[0]=$base_path + 'images/stories'; 
	$picurl[0]=$live_site + '/images/stories/';
	$tndir[0]=$live_site + '/images/stories/';
} else {
	$title[0]='Uploaded File Images';
	$dir[0]=$base_path + 'uploadfiles/$Itemid';
	$picurl[0]=$live_site + '/uploadfiles/$Itemid';
	$tndir[0]=$live_site + '/uploadfiles/$Itemid';
}

/********************
 * Various IDs		*
 ********************/
// you shouldn't need to touch this unless you've been playing with the db
define ("UNASSIGNED_SHIP", "1");
define ("TRANSFER_SHIP", "2");
define ("DELETED_SHIP", "3");
define ("FSS_SHIP", "4");
define ("PENDING_RANK", "1");

/********************
 * Constants	    *
 ********************/
// you shouldn't need to touch these, either.  In fact, don't.  =)
define ("email-from", $emailfrom);
define ("fleetname", $fleetname);
define ("webmasteremail", $webmasteremail);
define ("live_site", $live_site);
?>
