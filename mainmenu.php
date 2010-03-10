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
  * Date:	12/13/03
  * Comments: Display main menu
 ***/

if (! ((trim($SubMenu)=="")||($SubMenu=="0")) )
	$componentid=$SubMenu;

/*
if (!$option)
	echo "<a href=\"index.php\">Home</a><br />\n";
*/

$qry="SELECT id, name, link, contenttype, browserNav
      FROM {$mpre}menu
      WHERE componentid='$componentid' AND menutype='mainmenu' AND inuse=1
      ORDER BY ordering";
$result=$database->openConnectionWithReturn($qry);
while ( list($id, $name, $link, $contenttype, $browserNav)=mysql_fetch_array($result) )
{
    $qry2="SELECT id FROM {$mpre}menu WHERE componentid='$id'";
    $result2=$database->openConnectionWithReturn($qry2);
    $numres=mysql_num_rows($result2);
    if ($numres!=0)
        $SubMenu=$id;
    else
        $SubMenu="";

    if ($contenttype=="mambo")
        echo "<a href=\"$link&amp;id=$id\">$name</a><br />\n";
    else if ($contenttype=="web")
    {
        $correctLink= eregi("http://", $link);
        $isindex = eregi("index.php", $link);
        if ($isindex != 1 && $correctLink !=1 )
	            $link="http://$link";
        if ($browserNav==1)
            echo "<a href=\"$link\">$name</a><br />\n";
        else
        {
            redirect($link, $name, 550, 780);
            echo "<br />\n";
        }

    }
    else if ($contenttype=="file")
        echo "<a href=\"index.php?option=displaypage&amp;Itemid=$id&amp;op=file&amp;SubMenu=$SubMenu\">" .
             "$name</a><br />\n";
    else if ($contenttype=="typed")
        echo "<a href=\"index.php?option=displaypage&amp;Itemid=$id&amp;op=page&amp;SubMenu=$SubMenu\">" .
             "$name</a><br />\n";
}

echo "</font>"
?>