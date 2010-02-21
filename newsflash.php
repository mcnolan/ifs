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
  * Date:	12/9/03
  * Comments: Display newsflash (news of the day)
 ***/

require ("classes/html/newsflash.php");
$newsflash = new newsflash();

$qry4 = "SELECT newsflashID
		 FROM {$mpre}newsflash WHERE showflash=1";
$result4 = $database->openConnectionWithReturn($qry4);
$numrows = mysql_num_rows($result4);

// Get a random newsflash if any exist
if ($numrows>1)
{
    $numrows = $numrows-1;
    mt_srand((double)microtime()*1000000);
    $newsnum = mt_rand(0, $numrows);
}
else
    $newsnum = 0;

$qry4="SELECT flashcontent FROM {$mpre}newsflash WHERE showflash=1 LIMIT $newsnum,1";
$result4 = $database->openConnectionWithReturn($qry4);
list($flashcontent)=mysql_fetch_array($result4);

if (trim($flashcontent)!="")
    $newsflash->WriteNewsflash($flashcontent);
?>