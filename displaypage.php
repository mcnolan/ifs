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
  * Date:	12/9/02
  *	Comments: Display page, reading from a file or a page read from the database.
  *
 ***/

require ("classes/html/displaypage.php");
$display = new displaycontent();

switch ($op)
{
    case "file":
        $qry="SELECT link FROM {$mpre}menu WHERE id='$Itemid'";
        $result=$database->openConnectionWithReturn($qry);
        list($link) = mysql_fetch_array($result);

        $basedir = "$link";
        $file=file($basedir);
        $file=implode("\n",$file);
        $file=str_replace("\\'", "'",$file);
        $file=str_replace("\\\"", "\"",$file);
        $content=$file;
        $heading="";
        $display->displaypage($content, $heading);
        break;

    case "page":
        $qry="SELECT content, heading FROM {$mpre}menucontent WHERE menuid='$Itemid'";
        $result=$database->openConnectionWithReturn($qry);
        list($content, $heading) = mysql_fetch_array($result);

        $display->displaypage($content, $heading);
        break;
}

?>