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
  * Date:	5/11/04
  * Comments: Common functions
  *
 ***/

// Include "sub-libraries"
include_once($relpath . "tf/lib-awards.php");
include_once($relpath . "tf/lib-crew.php");
include_once($relpath . "tf/lib-record.php");
include_once($relpath . "tf/lib-ship.php");

// Check to see if the email address or IP is banned
function check_ban ($database, $mpre, $spre, $email, $ip, $type)
{
	// Expire old bans fist
	$time = time();
	$qry = "SELECT id FROM {$spre}banlist WHERE expire<'$time' AND expire!='0' AND active='1'";
    $result = $database->openConnectionWithReturn($qry);
    while (list($bid) = mysql_fetch_array($result))
    {
    	$qry2 = "UPDATE {$spre}banlist SET active='0' WHERE id='$bid' OR alias='$bid'";
    	$database->openConnectionNoReturn($qry2);
	}

	$qry = "SELECT date, auth, reason, alias, level
    		FROM {$spre}banlist
            WHERE ( (email='$email' AND email!='') OR (ip='$ip' AND ip!='') )
            	AND active='1'";
    $result = $database->openConnectionWithReturn($qry);

    if (!mysql_num_rows($result))
    {
	    // Check wildcard IPs
	    $qry2 = "SELECT ip FROM {$spre}banlist WHERE ip LIKE '%*%' AND active='1'";
	    $result2 = $database->openConnectionWithReturn($qry2);
	    list($banip) = mysql_fetch_array($result2);
        while ($banip && !$wildcard)
	    {
	        $wildcard = check_wild_IP($ip, $banip);
	        if ($wildcard)
            {
	            $qry = "SELECT date, auth, reason, alias, level
	                    FROM {$spre}banlist WHERE ip='$banip'";
	            $result = $database->openConnectionWithReturn($qry);
            }
            list($banip) = mysql_fetch_array($result2);
	    }
    }

    // If a result was returned, then this person's banned!
    if (mysql_num_rows($result))
    {
    	list ($date, $auth, $reason, $alias, $level) = mysql_fetch_array($result);

        // {$alias != "0"} indicates that the matched ban actually
        //      links to a different ban (ie, multiple email/IPs)
        if ($alias != "0")
        {
            $qry = "SELECT date, auth, reason FROM {$spre}banlist WHERE id='$alias'";
            $result = $database->openConnectionWithReturn($qry);
            list ($date, $auth, $reason) = mysql_fetch_array($result);
        }

		// If it's a command ban, then we need to make sure it's a command app
        if ( ($level == "command" && ($type == "ship" || $type == "command")) ||
			  $level != "command")
        {
    	    $reason = date("F j, Y", $date) . "<br /><br />" . $reason . "\n";
			$reason = "Authorized by: " . $auth . "<br /><br />" . $reason . "\n";
	        return $reason;			// Returns positive
        }
    }
    // No results - person's not banned
    return;
}

// Helper function to recursively check wildcard IP bans
function check_wild_IP($ip, $banip)
{
	if ((strlen($ip) == 0 && strlen($banip) == 0) || $banip == "*")
    	return true;
    else if (strlen($ip) == 0 || strlen($banip) == 0)
    	return false;

    if (strstr($banip, "*") === false)
    	if ($ip != $banip)
	    	return false;
        else
        	return true;

    if ($banip{0} != "*")
    {
		$wildpos = strpos($banip, "*");
        $teststring = substr($banip, 0, $wildpos-1);

        if (substr($ip, 0, $wildpos-1) == $teststring)
        	return check_wild_IP(substr($ip, $wildpos), substr($banip, $wildpos));
        else
        	return false;
    }

    $wildpos = strpos(substr($banip, 1), "*");
    if ($wildpos == false)
    	$wildpos = strlen($banip);
    $teststring = substr($banip, 1, $wildpos);
    $testlen = strlen($teststring);

    if ($modip = strstr($ip, $teststring))
        return check_wild_IP(substr($modip, $testlen), substr($banip, $wildpos+1));
    else
    	return false;
}

// Gets usertype of person performing action
function get_usertype ($database, $mpre, $spre, $cid, $uflag)
{
	// CO area - make sure TFCOs (etc) show up as "Commanding Officer"
    if (task == "co")
    {
		$qry = "SELECT r.rankdesc, c.name
        		FROM {$spre}characters c, {$spre}ships s, {$spre}rank r
                WHERE c.player='" . uid . "' AND c.pos='Commanding Officer'
                	AND s.co=c.id AND r.rankid=c.rank";
		$result = $database->openConnectionWithReturn($qry);
		list ($rname,$cname) = mysql_fetch_array($result);

        if ($rname)
        	return "Commanding Officer ({$rname} {$cname})";
    }

    // This *should* never be true.  If they don't have uber-CO-access, then they
    //  should have a result from above.  But just in case... since I don't trust myself...
	if (task == "co" && $uflag['c'] != 2)
        return;

	// Now we're assuming a FSS position
	$qry = "SELECT flags FROM {$mpre}users WHERE id='" . uid . "'";
    $result = $database->openConnectionWithReturn($qry);
    list ($flags) = mysql_fetch_array($result);

	$qry = "SELECT name FROM {$spre}flags WHERE flag='" . $flags{0} . "'";
    $result = $database->openConnectionWithReturn($qry);
    list ($primeflag) = mysql_fetch_array($result);

    $qry = "SELECT r.rankdesc, c.name
    		FROM {$spre}characters c, {$spre}rank r, {$mpre}users u
            WHERE r.rankid=c.rank AND c.id=u.mainchar AND u.id='" . uid . "'";
	$result = $database->openConnectionWithReturn($qry);
    list ($rname, $cname) = mysql_fetch_array($result);

    // Note, if this person doesn't have a "main character" set via the Triad menu's
    //  "userlevels" tool, it will return the flag name and empty brackets, ie "Triad ( )"
    return "{$primeflag} ({$rname} {$cname})";
}