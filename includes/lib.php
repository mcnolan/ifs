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
  * Comments: Common functions
  *
 ***/

// Create a new user record
function make_uid ($database, $mpre, $yourname, $username, $email)
{
	// Validate username, or generate a random one if the submitted name is in use
	$qry="SELECT id FROM {$mpre}users WHERE username='$username'";
	$result=$database->openConnectionWithReturn($qry);
	while (mysql_num_rows($result)!=0)
    {
		$username = "name" . rand(1,50);
		$qry="SELECT id FROM {$mpre}users WHERE username='$username'";
		$result=$database->openConnectionWithReturn($qry);
	}

	$pass = rand(1000,9999);
	$cryptpass=md5($pass);

    // Add check to make sure email isn't in use
    $qry = "SELECT id FROM {$mpre}users WHERE email='$email'";
    $result = $database->openConnectionWithReturn($qry);
    if (mysql_num_rows($result) > 0)
    {
    	echo "Error, cannot create user account!";
        die();
    }
    else
    {
		$qry="INSERT INTO {$mpre}users
        		(name, username, email, password)
                VALUES ('$yourname', '$username', '$email', '$cryptpass')";
		$database->openConnectionNoReturn($qry);

		$qry = "SELECT id FROM {$mpre}users WHERE username='$username'";
		$result=$database->openConnectionWithReturn($qry);
		list ($uid)=mysql_fetch_array($result);

		return array ($username, $pass, $uid);
    }
}

// Standard Redirect, allowing for javascript popups for header-based redirects
function redirect ($url, $link = "",  $popheight = 0, $popwidth = 0)
{
	if ($link == "")
    {
    	if ($url == "" || substr($url, 0, 1) == "&")
        {
	        // Get the appropriate path to the script,
	        // accounting for differences on different servers
	        if (substr(dirname($_SERVER['PHP_SELF']), -1) == "/")
	            $headerpath = substr(dirname($_SERVER['PHP_SELF']), 0, -1);
	        else
	            $headerpath = dirname($_SERVER['PHP_SELF']);

	        // Use header-based redirect
	        header("Location: http://" . $_SERVER['HTTP_HOST'] . $headerpath .
	               "/index.php?option=" . option . "&task=" . task . $url);
        }
        else
        	header("Location: {$url}");
	    exit;
	}

    // We can now assume a pop-up is desired.  Use javascript if enabled...
    if (defined("JS"))
	  	echo "<a href=\"javascript: var t=window.open" .
             "('{$url}','setPop','width={$popwidth},height={$popheight},scrollbars=yes')\">" .
             "{$link}</a>\n";
    else
        echo "<a href=\"{$url}\" target=\"_blank\">{$link}</a>\n";
}