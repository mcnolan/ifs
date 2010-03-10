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
  * Date:	12/13/03
  * Comments: Checks userlevel for pages requiring restricted access
  *
 ***/

if ($database=="")
{
    $login = "PHP error!  Please email <a href=\"" . webmaster-email . "\">" . webmaster-email . "</a>";
    return;
}

if ($HTTP_COOKIE_VARS["session"]!="")                  // do we have a cookie set?
{
    $cryptSessionID=md5($HTTP_COOKIE_VARS["session"]);
    $qry6="SELECT userid, guest FROM {$mpre}session WHERE session_ID='$cryptSessionID'";
    $result6=$database->openConnectionWithReturn($qry6);
    if (mysql_num_rows($result6)!=0)                    // means we have a cookie & matching session
        list($uid,$guest)=mysql_fetch_array($result6);
    else
    {
        $guest = 1;                                     // being a guest isn't so bad...
        $uid = 0;
    }
}
else                                                    // huh?  didn't we just set a cookie above?
{
    $uid = "0";
    $guest = "1";
}

if ($guest != 1)
{
    if ($uflag[$reqtype] > 0)
        $login = "success";
    else
    {
        $login = "Login failed!<br />";                 // someone's being bad!
        $login .= "You don't have access to this area.<br /><br />";
    }
}
else
{
    $login = "Please login.";                           // well, yeah, if you're a guest, you can't
    $dest = substr($PHP_SELF, 1);                       // be looking in our restricted areas, can you?
    exit;
}
?>