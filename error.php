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
  * Comments: Error page; writes to the errorlog
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	switch ($task)
    {
    	case "403":
        	$error = "403 Forbidden";
            break;
        case "404":
        	$error = "404 Page Not Found";
            break;
        case "500":
        	$error = "500 Server Error";
        default:
        	$error = "none?";
            break;
    }

    if ($error != "none?")
    {
		header("Status: " . $error);

		$title = substr($error, 0, strpos($error, " ")) . " -" . substr($error, strpos($error, " "));

		// OK, now log the error =)
		$now = date("F j, Y, g:i a");
		$ip = getenv("REMOTE_ADDR");
		$rmethod = getenv("REQUEST_METHOD");
		$referer = getenv("HTTP_REFERER");
		$uri = getenv("REQUEST_URI");
		$filename = "errorlog";
		$spacer = "\n";

		$handle= fopen($filename,'a');
		fputs($handle, "$now - $task - $ip - $rmethod $uri - $referer\n");
		fputs($handle, "-----------\n");

		fclose($handle);

		?>

        <center>
		<h1><? echo $title ?></h1>

		<p>
		The page you requested, <b><? echo $uri ?></b>, cannot be displayed.<br /><br />
		We have logged this problem and will try to fix it ASAP.<br />
		</p>
        </center>

        <?php
    }
}
?>