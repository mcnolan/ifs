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
  * Date:	9/23/03
  * Comments: Initializes and handles database queries
 ***/

function sqlerror($query)
{
    global $relpath;
    echo "Database error!  Did not execute query: " . $query;

    // OK, now log the error =)
    // Get various info
    $now = date("F j, Y, g:i a");
    $ip = getenv("REMOTE_ADDR");
    $rmethod = getenv("REQUEST_METHOD");
    $uri = getenv("REQUEST_URI");
    $referer = getenv("HTTP_REFERER");

    $filename = $relpath . "errorlog";
    $spacer = "\n";
    $handle= fopen($filename,'a');

    fputs($handle, "$now - sql - $ip - $uri - $query\n");
    fputs($handle, "-----------\n");

    fclose($handle);

    include ($relpath . "includes/footer.php");
    exit;
}

class database
{
    function database()
    {
        GLOBAL $relpath, $dbcon, $mpre, $spre, $sdb;
        include ($relpath . "configuration.php");
        $dbcon = mysql_connect($host, $user, $password);
        mysql_select_db ($db, $dbcon);
    }

    function openConnectionWithReturn($query)
    {
        GLOBAL $dbcon;
        $result = mysql_query($query, $dbcon) or sqlerror($query);
        return $result;
	}

    function openConnectionNoReturn($query)
    {
        GLOBAL $dbcon;
        mysql_query($query, $dbcon) or sqlerror($query);
	}

    function openShipsWithReturn($query)
    {
        GLOBAL $relpath, $dbcon;
        include ($relpath . "configuration.php");
        if ($user_ships == "")
        	$user_ships = $user;
        if ($password_ships == "")
        	$password_ships = $password;

        if ($user == $user_ships && $password == $password_ships)
            if ($db == $db_ships)
                $result = mysql_query($query, $dbcon) or sqlerror($query);
            else
            {
                mysql_select_db($db_ships, $dbcon);
                $result = mysql_query($query, $dbcon) or sqlerror($query);
                mysql_select_db($db, $dbcon);
            }
        else
        {
            $shipscon = mysql_connect ($host, $user_ships, $password_ships);
            mysql_select_db ($db_ships, $shipscon);
            $result = mysql_query($query, $shipscon) or sqlerror($query);
            mysql_close ($shipscon);
        }
        return $result;
    }
}
?>