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
  * Date: 12/22/03
  * Comments: Legacy Mambo code - not sure if it's even used
  *
 ***/

function rand_string()
{
    $allchar = "abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ0123456789";

    $str = "" ;
    $pass_len = 100;
    mt_srand ((double) microtime() * 1000000);
    for ( $i = 0; $i< mt_rand(0,$pass_len) ; $i++ )
        $str .= substr( $allchar, mt_rand (0,62), 1 ) ;

    $random_string = md5($rand_string.time()+3242300);
    return $random_string;
}

?>