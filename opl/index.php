<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Updated By: Nolan
  *		john.pbem@gmail.com
  *
  * Version:	1.15n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  * Patch 1.15n:  April 2010
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
  *
  * See CHANGELOG for patch details
 ***/


if (!defined("IFS"))
	redirect("index.php?option=opl");

?>
<br /><center><h1>Search Open Positions List</h1></center><br />
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
	    <form action="index.php?option=opl&task=find" method="post">
	<table cellspacing="5">	    
		<tr>
	    	<td width="30%"><i><u>Ship Class:</u></i></td>
		<td><select name="class">
	    <option selected="selected" value="All">Any Class</option>
	    <?php
        $qry = "SELECT c.name
	            FROM {$sdb}classes c, {$sdb}types t, {$sdb}category d
	            WHERE c.active='1' AND c.category=d.id AND d.type=t.id AND t.support='n'
	            ORDER BY name";
	    $result = $database->openShipsWithReturn($qry);
	    while ( list ($sname) = mysql_fetch_array($result) )
            echo "<option value=\"{$sname}\">$sname</option>\n";
	    ?>
	    </select></td>
		</tr>
		<tr>
		<td><u><i>Ship name:</i></u></td>

		<td><select name="ship">
	    <option value="All" selected="selected">Any Ship</option>
	    <?php
        $qry = "SELECT name FROM {$spre}ships WHERE tf<>'99' ORDER BY name";
        $result = $database->openConnectionWithReturn($qry);
        while ( list ($sname) = mysql_fetch_array($result) )
            echo "<option value=\"{$sname}\">$sname</option>";
	    ?>
	    </select></td>
		</tr>
	 	<tr>
	    	<td><u><i>Position</i></u></td>
	    	<td><select name="position">
	    <option selected="selected" value="All">-----Any Position----</option>
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
	    </select></td>
		</tr>
		
		<tr>
		<td>Simm Type</td>
		<td>
		<?
		$formats = file($relpath . "tf/formats.txt");
		foreach($formats as $format) {
		?>
		<input type="checkbox" name="format[]" value="<? echo $format; ?>"> <? echo $format; ?>
		<?
		}
		?>
		</td>
		</tr>

		<tr>
		<td></td>
		<td><input type="hidden" name="srClass" value="yes" /> <input type="submit" value="Search" /> <input type="reset" value="Reset" /></td>
		</tr>
	</table>

	    </form>

	    <br /></p>

	    <?php
}

if ($task != "about")
	echo "<p><a href=\"index.php?option=opl&task=about\">About the Open Positions List</a></p>";

if ($task)
	echo "<p><a href=\"index.php?option=opl\">Return to OPL Search page</a></p>";

?>
