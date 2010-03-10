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
  * Date:   1/1/04
  *	Comments: Displays users online
 ***/

if ($ondetails == "1")
{
    echo "<center><span class=\"articlehead\"><font size=\"+1\"><u>" .
    	 "Who's Online?</u></font></span><br /><br />\n";
    $qry = "SELECT s.username, u.flags
    		FROM {$mpre}session s, {$mpre}users u
            WHERE s.guest=0 AND s.userid=u.id AND s.active='1'
            ORDER BY s.username";
    $result = $database->openConnectionWithReturn($qry);

    if (mysql_num_rows($result))
        while (list ($uname, $userflags) = mysql_fetch_array($result))
            if (strstr(strtolower($userflags), 'a'))
                echo "<i>" . stripslashes($uname) . "</i><br />\n";
            else
                echo stripslashes($uname) . "<br />\n";
    else
        echo "No members...";

    echo "<br /><br />\n";
    $qry2 = "SELECT session_id FROM {$mpre}session WHERE guest=1 AND active='1'";
    $result2=$database->openConnectionWithReturn($qry2);
    echo "And " . mysql_num_rows($result2) . " guests.<br />\n";

    echo "<br /><br /></center>\n";

    $qry = "DELETE FROM {$mpre}session WHERE time IS NULL";
    $result = $database->openConnectionNoReturn($qry);
}
else
{
    $qry2 = "SELECT session_id FROM {$mpre}session WHERE guest=1 AND active='1'";
    $result2=$database->openConnectionWithReturn($qry2);
    $content="Guests: " . mysql_num_rows($result2) . "<br />";

    $qry2 = "SELECT s.session_id
    		 FROM {$mpre}session s, {$mpre}users u
             WHERE s.guest=0 AND s.userid=u.id AND active='1'";
    $result2=$database->openConnectionWithReturn($qry2);
    $content.="Members: " . mysql_num_rows($result2) . "<br />";

    $content.="&nbsp;<a href=\"index.php?option=online\">Details</a>";
}
?>