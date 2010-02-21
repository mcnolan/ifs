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
  *	Comments: Display pathway of navigation.
 ***/

if ((trim($SubMenu)!="")||($SubMenu!=0))
{
    $qry = "SELECT componentid, link, contenttype, name, id
    		FROM {$mpre}menu WHERE id='$SubMenu'";
    $result = $database->openConnectionWithReturn($qry);
    $i = 0;

    for ($i=0;
    	 list($componentid, $link[$i], $contenttype[$i], $name[$i], $id[$i])=mysql_fetch_array($result);
         $i++);

    while ($componentid <> 0)
    {
	    $qry = "SELECT componentid, link, contenttype, name, id
	            FROM {$mpre}menu WHERE id='$componentid'";
	    $result = $database->openConnectionWithReturn($qry);
	    $i = 0;

	    for ($i=0;
	         list($componentid, $link[$i], $contenttype[$i], $name[$i], $id[$i])=mysql_fetch_array($result);
	         $i++);
    }

    $j = count($name);
    $j--;
    print "<a href=\"index.php\">Home</a>  ";
    for ($k = $j; $k > 0; $k--){
        if ($name[$k]!="")
        {
             if ($contenttype[$k]=="web")
             {
                $correctLink= eregi("http://", $link);
                if ($correctLink==1)
                    $newlink= "<a href=\"$link[$k]\" target=\"_window\">$name[$k]</a>";
                else
                    $newlink="http://$link";
            }
            else if ($contenttype[$k]=="file")
                $newlink= " <a href=\"index.php?option=displaypage&Itemid=$id[$k]&op=file&SubMenu=$id[$k]\">$name[$k]</a>";
            else if ($contenttype[$k]=="typed")
                $newlink= " <a href=\"index.php?option=displaypage&Itemid=$id[$k]&op=page&SubMenu=$id[$k]\">$name[$k]</a>";

            if ($newlink!="")
                $path .= "| $newlink ";
        }
    }
    echo $path;
}
else
{
    $i=0;
    $qry="SELECT componentid, name, link, contenttype, id
     	  FROM {$mpre}menu WHERE id='$Itemid'";
    $result=$database->openConnectionWithReturn($qry);
    list($componentid, $name[$i], $link[$i], $contenttype[$i], $id[$i])=mysql_fetch_array($result);

    while ($componentid <> 0)
    {
	    $qry="SELECT componentid, name, link, contenttype, id
	     	  FROM {$mpre}menu WHERE id='$componentid'";
	    $result=$database->openConnectionWithReturn($qry);
		for ($i=0;
		     list($componentid, $name[$i], $link[$i], $contenttype[$i], $id[$i])=mysql_fetch_array($result);
             $i++);
    }
    $j = count($name);
    $j--;

    if (eregi("option", $REQUEST_URI))
        print "<A HREF=\"index.php\">Home</A>  ";

    for ($k = $j; $k >= 0; $k--)
    {
        if ($name[$k]!="")
        {
            if ($contenttype[$k]=="web")
            {
                $correctLink= eregi("http://", $link);
                if ($correctLink==1)
                    $newlink= "<a href=\"$link[$k]\" target=\"_window\">$name[$k]</a>";
                else
                    $newlink="http://$link";
            }
            else if ($contenttype[$k]=="file")
                $newlink= "  <a href=\"index.php?option=displaypage&Itemid=$id[$k]&op=file&SubMenu=$id[$k]\">$name[$k]</a>";
            else if ($contenttype[$k]=="typed")
                $newlink= "  <a href=\"index.php?option=displaypage&Itemid=$id[$k]&op=page&SubMenu=$id[$k]\">$name[$k]</a>";

            if ($newlink!="")
                $path .= "| $newlink ";
        }
    }
    echo $path;
}
?>