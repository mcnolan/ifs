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
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	12/13/03
  * Comments: Do initialization; check if auth.php is needed; show banner
  *
 ***/


//  Start TIMER
list ($stimer1, $stimer2) = explode (" ", microtime ());
$stimer = (float)$stimer1 + (float)$stimer2;

// If the relpath variable was set as a HTML form POST or GET item, this is
// probably a hacking attempt.
if (($HTTP_POST_VARS['relpath']) || ($HTTP_GET_VARS['relpath']))
{
    echo "Hacking attempt!";
    exit;
}
else
{
   	// Start output buffering
    ob_start("ob_gzhandler");

	// Addslashes if needed
    require_once ($relpath . "includes/addslash.php");

    // Get ready for db queries
	if ($database=='')
    {
		require ($relpath . "classes/database.php");
		$database = new database();
	}

    // detection makes for fun stats later!
    if ($detection <> "detected")
	{
		$browse = getenv("HTTP_USER_AGENT");

		if (preg_match("/MSIE/i", "$browse"))
			$browsename = "MSIE";
		elseif (preg_match("/Mozilla/i", "$browse"))
			$browsename = "Netscape";
		else
			$browsename = "Unknown";

		$qry = "UPDATE {$mpre}counter SET count = count + 1 WHERE name='{$browsename}'";
		$database->openConnectionNoReturn($qry);

		if (phpversion() <= "4.2.1")
			$browse = getenv("HTTP_USER_AGENT");
		else
			$browse = $_SERVER['HTTP_USER_AGENT'];

		if (preg_match("/Mac/i", $browse))
			$OSname = "Mac";
		elseif (preg_match("/Windows/i", $browse))
			$OSname = "Windows";
		elseif (preg_match("/Linux/i", $browse))
			$OSname = "Linux";
		elseif (preg_match("/FreeBSD/i", $browse))
			$OSname = "FreeBSD";
		else
			$OSname = "Unknown";

		$qry = "UPDATE {$mpre}counter SET count = count + 1 WHERE type='OS' AND name='{$OSname}'";
		$database->openConnectionNoReturn($qry);

        setcookie("detection", "detected");
	}

    // Do the session thing
	include_once ($relpath . "SessionCookie.php");

    // Set a few constants
    require ($relpath . "configuration.php");
    define ("option", $option);
    define ("task", $task);
    define ("action", $action);
    define ("emailfrom", $emailfrom);
    define ("webmasteremail", $webmasteremail);
    define ("maxchars", $maxchars);
    define ("fleetname", $fleetname);
    if (!defined("uid"))				   				// Should be defined in SessionCookie...
    	define ("uid", 0, TRUE);						//  but just in case...

    // Include our "lib" pages
    include_once ($relpath . "tf/lib.php");				// IFS-based stuff
	include_once ($relpath . "includes/lib.php");		// More general stuff

    // if this is supposed to be a protected page, make sure it's protected
	if ($reqtype)
		require ($relpath . "includes/auth.php");

	// Get templated page headers
	$qry = "select cur_theme,col_main from " . $mpre . "system where id=0";
	$result = $database->openConnectionWithReturn($qry);
	list ($cur_theme,$col_main)=mysql_fetch_array($result);

	if ($override_theme)
	{
		echo "Over-riding theme: Using {$override_theme}<br /><br />\n\n";
		$cur_theme = $override_theme;
	}

	include ( $relpath . "themes/" . $cur_theme . "-head.php");

    // Perform JavaScript check
    $qry = "SELECT js FROM {$mpre}session WHERE session_id='$cryptSessionCookie'";
    $result = $database->openConnectionWithReturn($qry);
    list($jscript) = mysql_fetch_array($result);
    if ($jscript == "1")
    	define("JS", true);
    elseif (!$js)
    {
	    echo "<form name=\"tester\" action=\"{$PHP_SELF}\" method=\"post\">\n";
	    echo "<input type=\"hidden\" name=\"js\" value=\"on\" />\n";
	    echo "</form>\n";
	    echo "<script type=\"javascript\"><!--\n";
	    echo "   document.tester.submit()\n";
	    echo "//-->\n";
	    echo "</script>";
	}
    elseif ($js == "on")
    {
	    $qry = "UPDATE {$mpre}session SET js='1' WHERE session_id='$cryptSessionCookie'";
	    $database->openConnectionNoReturn($qry);
    	define("JS", true);
    }

}

?>