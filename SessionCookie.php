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
  * This file based on code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	5/11/04
  * Comments: Checks / sets session information
  *
 ***/

$past = time()-900;
$lifetime= (time() + 60*60*24*365);

// delete outdated sessions
$qry="DELETE FROM {$mpre}session WHERE (time < $past) AND remember='0'";
$database->openConnectionNoReturn($qry);
$qry="UPDATE {$mpre}session SET active='0' WHERE (time < $past) AND remember='1'";
$database->openConnectionNoReturn($qry);

$current_time = time();
$userip = getenv("REMOTE_ADDR");

if ($HTTP_COOKIE_VARS["session"]=="")              // we need to set a cookie?
{
    $existSessionID=0;
    while ($existSessionID==0)
    {
        $randnum=getSessionID1();
        if ($randnum!="")
        {
            $cryptrandnum=md5($randnum);
            $qry="SELECT session_id FROM {$mpre}session WHERE session_id='$cryptrandnum'";
            $result=$database->openConnectionWithReturn($qry);
            if (mysql_num_rows($result)==0)	        // wait until we have a unique session ID
                $existSessionID=1;
        }
    }
    if ($existSessionID=1)                         // set the new cookie, and enter session info in db
    {
        setcookie("session", "$randnum", $lifetime, "/");

        $qry="DELETE FROM {$mpre}session WHERE ip='$userip'";
        $database->openConnectionNoReturn($qry);

        $qry="INSERT INTO {$mpre}session
        	  SET username='', userid='', time=$current_time, session_id='$cryptrandnum',
              	guest='1', ip='$userip', active='1'";
        $database->openConnectionNoReturn($qry);
    }
}

if ($HTTP_COOKIE_VARS["session"]!="")             // make sure we have a cookie
{
    $cvar = $HTTP_COOKIE_VARS["session"];
    $sessionCookie=$HTTP_COOKIE_VARS["session"];
    $cryptSessionCookie=md5($HTTP_COOKIE_VARS["session"]);

    $qry = "DELETE FROM {$mpre}session WHERE ip='$userip' AND session_id<>'$cryptSessionCookie'";
    $result = $database->openConnectionWithReturn($qry);

    if ($option=="logout")
    {
        $qry="UPDATE {$mpre}session
        	  SET guest=1, username='', userid='', remember='0'
              WHERE session_id='$cryptSessionCookie'";
        $database->openConnectionNoReturn($qry);
        $option2 = preg_replace("/~/", "&", $option2);
        if ($option2)
            $option2 = "?" . $option2;

        if (substr(dirname($_SERVER['PHP_SELF']), -1) == "/") {
            $headerpath = substr(dirname($_SERVER['PHP_SELF']), 0, -1);
        } else {
            $headerpath = dirname($_SERVER['PHP_SELF']);
        }
        header("Location: http://" . $_SERVER['HTTP_HOST'] . $headerpath . "/index.php{$option2}");
        exit;

    }
    else
    {
        $qry = "SELECT username, ip FROM {$mpre}session WHERE session_id='$cryptSessionCookie'";
        $result=$database->openConnectionWithReturn($qry);
        if (mysql_num_rows($result)> 0)            // matching session found in db
        {
            list ($username, $ip)=mysql_fetch_array($result);
            if ($username=="")                     // no user name -- must be a guest
                $guest = 1;
            else                                  // if not a guest, then set userlevel
            {
                $qry = "SELECT u.id, u.flags
                		FROM {$mpre}session s, {$mpre}users u
                        WHERE s.userid = u.id AND s.session_id='$cryptSessionCookie'";
                $result = $database->openConnectionWithReturn($qry);
                list ($uid, $flags) = mysql_fetch_array($result);

                if (strstr($flags, 'a') || strstr($flags, 'A'))
                    $uberadmin = "1";
                else
                    $uberadmin = "0";

                $qry = "SELECT flag, admin FROM {$spre}flags ORDER BY flag";
                $result = $database->openConnectionWithReturn($qry);
                list ($fid, $admin) = mysql_fetch_array($result);

                define ("uid", $uid, TRUE);

                while ($fid)
                {
                    if ($admin == 1 && !defined("admin"))
                        define("admin", 1);

                    if (strstr($flags, strtoupper($fid)) || $uberadmin == "1")
                        $uflag[$fid] = 2;
                    elseif (strstr($flags, $fid))
                        $uflag[$fid] = 1;
                    else
                        $uflag[$fid] = 0;
                    list ($fid, $admin) = mysql_fetch_array($result);
                }
            }

            // don't let the session time-out if it's in use... re-set the cookie, too
            $qry="UPDATE {$mpre}session
            	  SET time=$current_time, active='1'
                  WHERE session_id='$cryptSessionCookie'";
            $database->openConnectionNoReturn($qry);
            setcookie("session", "$sessionCookie", $lifetime, "/");

        }
        else                                      // no session found - so let's give them one
        {
	        $qry="INSERT into {$mpre}session
            	  SET username='', userid='', time=$current_time, session_id='$cryptSessionCookie',
                  	guest='1', ip='$userip'";
	        $database->openConnectionNoReturn($qry);
        }
    }
}

function getSessionID1()
{
    mt_srand ((double) microtime() * 1000000);
    $pass_len = mt_rand (20,40);
    $allchar = "abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ0123456789";
    $str = "" ;
    for ( $i = 0; $i<$pass_len ; $i++ )
        $str .= substr( $allchar, mt_rand (0,62), 1 ) ;
    $timestamp= time();
    $str=$str.$timestamp;
    return($str);
}

?>