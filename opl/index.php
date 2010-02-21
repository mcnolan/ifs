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
  * This file based on code from Open Positions List
  * Copyright (C) 2002, 2003 Frank Anon
  *
  * Date:	12/12/03
  * Comments: Open Positions List main page
 ***/


if (!defined("IFS"))
	redirect("index.php?option=opl");

?>
<br /><center><h1>Open Positions List</h1></center><br />
<?

switch ($task)
{
	case "find":
		include ("find.php");
		break;
	case "about":
		include ("about.php");
		break;
	default:
	    ?>

	    <p>Search by:
        <a href="#class">Class</a> |
        <a href="#name">Name</a> |
        <a href="#pos">Positions</a></p>

	    <p><a name="class">
	    <i><u>Search by class:</u></i><br />
	    <form action="index.php?option=opl&task=find" method="post">

	    <select name="class">
	    <option selected="selected" value="All">All</option>
	    <?php
        $qry = "SELECT c.name
	            FROM {$sdb}classes c, {$sdb}types t, {$sdb}category d
	            WHERE c.active='1' AND c.category=d.id AND d.type=t.id AND t.support='n'
	            ORDER BY name";
	    $result = $database->openShipsWithReturn($qry);
	    while ( list ($sname) = mysql_fetch_array($result) )
            echo "<option value=\"{$sname}\">$sname</option>\n";
	    ?>
	    </select><br /><br />

	    <input type="hidden" name="srClass" value="yes" />
	    <input type="submit" value="Search" />
	    <input type="reset" value="Reset" />
	    </form></a>

        <br /><br />

	    <a name="name">
	    <u><i>Search by ship name:</i></u><br />
	    <form action="index.php?option=opl&task=find" method="post">
	    <select name="ship">

	    <option value="All" selected="selected">All</option>
	    <?php
        $qry = "SELECT name FROM {$spre}ships WHERE tf<>'99' ORDER BY name";
        $result = $database->openConnectionWithReturn($qry);
        while ( list ($sname) = mysql_fetch_array($result) )
            echo "<option value=\"{$sname}\">$sname</option>";
	    ?>
	    </select><br /><br />

	    <input type="hidden" name="srName" value="yes" />
	    <input type="submit" value="Search" />
	    <input type="reset" value="Reset" />
	    </form></a>

	    <br /><br />

	    <a name="pos">
	    <u><i>Search by Position</i></u><br />
	    <form action="index.php?option=opl&task=find" method="post">
	    <select name="position">
	    <option selected="selected" value="-----Select Position----">-----Select Position----</option>
	    <option value="Commanding Officer">Commanding Officer</option>
	    <?php
        $filename = $relpath . "tf/positions.txt";
        $contents = file($filename);
        $length = sizeof($contents);
        if ($length == 1)
        {
            $filename = "tf/positions.txt";
            $contents = file($filename);
            $length = sizeof($contents);
        }

        $counter = 0;
        do
        {
            $counter = $counter + 1;
            $contents[$counter] = trim($contents[$counter]);
            echo "<option value=\"$contents[$counter]\">$contents[$counter]</option>\n";
        } while ($counter < ($length - 1));
	    ?>
	    </select><br /><br />

	    <input type="hidden" name="srPos" value="yes" />
	    <input type="submit" value="Search" />
	    <input type="reset" value="Reset" />
	    </form></a>

	    <br /></p>

	    <?php
}

if ($task != "about")
	echo "<p><a href=\"index.php?option=opl&task=about\">About the Open Positions List</a></p>";

if ($task)
	echo "<p><a href=\"index.php?option=opl\">Return to OPL Search page</a></p>";

?>