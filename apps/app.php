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
  * Version:	1.13n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * Date:	1/15/04
  * Comments: Crew application
  *
  * See CHANGELOG for patch details
  *
 ***/

if (!defined("IFS"))
	require ("../includes/lib.php");

?>
<html><head></head><body>
<p align="center">
	<a href="index.php?option=app&amp;task=crew">Player Application</a> |
	<a href="index.php?option=app&amp;task=co">CO Application</a> |
	<a href="index.php?option=app&amp;task=ship">Ship Application</a>
</p>

<table width="95%" align="center">
<tr><td>

	<form action="index.php?option=app&amp;task=crew2" method="post" name="Application">
	<table border="0" width="100%" align="center">
	<tr><td>

	<h1 align="center">
	<b><font size="5"></font></b></h1>
	<center>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Player Information</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">
	    Your Real Name:</font></td>
	    <td width="622">
	    
	    <input type="text" size="37" name="Name" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Your Real Age:</font></td>
	    <td width="622">
	    
	    <input type="text" size="37" name="Age" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Email Address:</font></td>
	    <td valign="top" width="622">
	    
	    <input type="text" size="37" name="Email" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    AOL Instant Messenger Screen name:</font></td>
	    <td valign="top" width="622">
	    
	    <input type="text" size="37" name="AOLIM" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    ICQ Number:</font></td>
	    <td valign="top" width="622">
	    
	    <input type="text" size="37" name="ICQ" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Yahoo! Messenger Screen name:</font></td>
	    <td valign="top" width="622">
	    
	    <input type="text" size="37" name="Yahoo" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362" height="14">

	    Will you follow all the Rules:</font></td>
	    <td valign="top" width="622" height="14"><br />
	    <select name="Follow_OF_Rules" size="1">
	    <option selected="selected" value="-----Select----">-----Select----</option>
	    <option value="Yes">Yes</option>
	    <option value="No">No</option>
	    </select>
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362" height="100">

	    Role Playing Experience</font></td>
	    <td valign="top" width="622" height="100">
	    
	    <textarea name="RPG_Experience" rows="4" cols="50"></textarea>
	    </font></td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Simm Information</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Desired Ship Class:</font></td>
	    <td valign="top" width="622">
	    
	    <?php
	    if (!$ship)
	    {
	        echo "<select name=\"desiredclass\">\n";
	        echo "<option selected=\"selected\">Any</option>\n";
	        $qry = "SELECT c.name
	                FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
	                WHERE c.category=d.id AND d.type=t.id AND t.support='n'
	                ORDER BY c.name";
	        $result = $database->openShipsWithReturn($qry);
	        while ( list ($sname) = mysql_fetch_array($result) )
	            echo "<option>$sname</option>\n";

	    }
	    else
	    {
	        $qry = "SELECT class FROM {$spre}ships WHERE name='$ship'";
	        $result = $database->openConnectionWithReturn($qry);
	        list ($shipclass) = mysql_fetch_array($result);
	        echo "<input type=\"hidden\" name=\"desiredclass\" value=\"{$shipclass}\" />\n";
	        echo $shipclass;
	    }
	    ?>
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Alternate Ship Class:</font></td>
	    <td valign="top" width="622">
	    
	    <select name="altclass">
	    <option selected="selected">Any</option>
	    <?php
        $qry = "SELECT c.name
                FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
                WHERE c.category=d.id AND d.type=t.id AND t.support='n'
                ORDER BY c.name";
        $result = $database->openShipsWithReturn($qry);
        while ( list ($sname) = mysql_fetch_array($result) )
            echo "<option>$sname</option>\n";

	    ?>
	    </select>
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362" height="50">

	    Ship Name:</font></td>
	    <td valign="top" width="622" height="50">
	    

	    <?php
	    if (!$ship)
	    {
	        echo "<select name=\"Ship\">\n";
	        echo "<option selected=\"selected\">Any</option>\n";
	        $qry = "SELECT name FROM {$spre}ships WHERE tf<>'99' AND co<>'0' ORDER BY name";
	        $result = $database->openConnectionWithReturn($qry);
	        while ( list ($sname) = mysql_fetch_array($result) )
	            echo "<option>$sname</option>\n";
	        echo "</select>\n";
	    }
	    else
	    {
        	$ship = stripslashes($ship);
	        echo "<input type=\"hidden\" name=\"Ship\" value=\"{$ship}\" />\n";
	        echo $ship . "\n";
	    }
	    ?>
	    </font></td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Character Information</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Character's Name:</font></td>
	    <td valign="top" width="622">
	    
	    <input type="text" size="37" name="Characters_Name" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Character's Race:</font></td>
	    <td valign="top" width="622">
	    
	    <input type="text" size="37" name="Characters_Race" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Character's Gender:</font></td>
	    <td valign="top" width="622"><b>
	    <input type="text" size="37" name="Characters_Gender" />
	    </b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362" height="150">

	    Character Bio:<br />
        <?php redirect("apps/sample.php?app=crew&amp;field=bio&amp;pop=y", "Example", 500, 700) ?>
        </font></td>
	    <td valign="top" width="622" height="150">
	    
	    <textarea name="Character_Bio" rows="8" cols="50"></textarea>
	    </font></td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Sample Post</font></b><br />
	    Please reply to the situation with you in the same position as your first desired position.<br />
	    <?php redirect("apps/sample.php?app=crew&amp;field=post&amp;pop=y", "Example", 500, 700) ?>
		</b></font></td></tr>
		<tr>
	    <td valign="top" width="362" height="210"><br />
	    You are in the lounge when suddenly the ship shakes violently and the lights go out. A few seconds later, the emergency lights come on. A few crewmen try the door, but it doesn't work -- it seems like power is out throughout the whole ship.
		</td><td valign="top" width="622" height="210">
	    <br />
	    <textarea name="Sample_Post" rows="11" cols="50"></textarea>
	    </font></td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Position</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    First Choice:</font></td>
	    <td valign="top" width="622">
	    
	    <select name="First_Desired_Position" size="1">";
	    <option>-----Select Position----</option>";
	    <?php
	    $posoptions = "";
	    if (!$ship)
	    {
	        $filename = $relpath . "tf/positions.txt";
	        $contents = file($filename);
	        $length = sizeof($contents);
	        if ($length == 1)
	        {
	            $filename = $relpath . "tf/positions.txt";
	            $contents = file($filename);
	            $length = sizeof($contents);
	        }

	        $counter = 0;
	        do
	        {
	            $counter = $counter + 1;
	            $contents[$counter] = trim($contents[$counter]);
	            $posoptions .= "<option value=\"$contents[$counter]\">$contents[$counter]</option>\n";
	        } while ($counter < ($length - 1));
	    }
	    else
	    {
	        $qry = "SELECT id FROM {$spre}ships WHERE name='$ship'";
	        $result = $database->openConnectionWithReturn($qry);
	        list ($sid) = mysql_fetch_array($result);

	        $filename = $relpath . "tf/positions.txt";
	        $contents = file($filename);
	        $length = sizeof($contents);
	        $counter = 0;
	        do
	        {
	            $counter = $counter + 1;
	            $contents[$counter] = trim($contents[$counter]);

	            $pos = addslashes($contents[$counter]);
	            $qry = "SELECT id FROM {$spre}characters WHERE ship='$sid' AND pos='$pos'";
	            $result = $database->openConnectionWithReturn($qry);
	            if (!mysql_num_rows($result))
	            {
	                $qry2 = "SELECT action FROM {$spre}positions WHERE ship='$sid' AND pos='$pos' AND action='rem'";
	                $result2 = $database->openConnectionWithReturn($qry2);
	                if (!mysql_num_rows($result2))
	                    $posoptions .= "<option value=\"$contents[$counter]\">$contents[$counter]</option>\n";
	            }
	        } while ($counter < ($length - 1));

	        $qry = "SELECT pos FROM {$spre}positions WHERE ship = '$sid' AND action = 'add'";
	        $result = $database->openConnectionWithReturn($qry);
	        while ( list ($pos) = mysql_fetch_array($result2) )
	            $posoptions .= "<option value=\"$pos\">$pos</option>\n";
	    }
	    echo $posoptions . "\n";
	    ?>
	    <option value="Other">Other</option>
	    </select><br />
	    If other: <input type="text" name="otherpos1" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    Second Choice:</font></td>
	    <td valign="top" width="622">
	    
	    <select name="Second_Desired_Position" size="1">
	    <option selected="selected">-----Select Position----</option>
	    <?php
	    echo $posoptions;
	    ?>
	    <option value="Other">Other</option>
	    </select<br />
	    If other: <input type="text" name="otherpos2" />
	    </font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362"><font color="#000000" height="50">

	    Officer or Enlisted:</font></td>
	    <td valign="top" width="622" height="50">
	    
	    <select name="Officer_or_Enlisted" size="1">
	    <option selected="selected">----- Enlisted Personnel or Officer ----</option>
	    <option value="Enlisted">Enlisted</option>
	    <option value="Warrent">Warrent</option>
	    <option value="Officer">Officer</option>
	    </select>
	    </font></td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Reference</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="362">

	    How did you Hear About Us?:</font></td>
	    <td valign="top" width="622">
	    
	    <select name="Reference" size="1">
	    <option selected="selected">-----Select Reference----</option>
	    <option value="Already In OF">Already in the Fleet</option>
	    <option value="Friend">Friend</option>
	    <option value="Link">Link from another site</option>
	    <option value="Search Engine">Search Engine</option>
	    <option value="Browsing the Internet">Browsing the Internet</option>
	    <option value="Other">Other</option>
	    </select>
	    <br />
	    <input type="text" size="37" name="Reference_Other" />
	    </font></td>
	    </tr>

    </table>
    </center>
    </td>
    </tr>
    </table>
	<center>
	<input type="submit" name="Submit" value="Submit Application" />
	<input type="reset" name="Reset" value="Reset Application" />
	</center>
	</form>

</td></tr></table>
</body></html>
