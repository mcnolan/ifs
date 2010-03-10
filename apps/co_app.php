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
  * Comments: CO Application
  *
  *
  * See CHANGELOG for patch details
  *
 ***/

if (!defined("IFS"))
   	require("../includes/lib.php");
?>

<p align="center">
<a href="index.php?option=app&task=crew">Player Application</a> |
<a href="index.php?option=app&task=co">CO Application</a> |
<a href="index.php?option=app&task=ship">Ship Application</a>
</p>

<table width="95%" align="center">
	<td>

	<h1 align="center">CO's Application Form</h1>

	<form action="index.php?option=app&task=co2" method="post">
	<center>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">


	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Player Information</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    Your Real Name:</td>
	    <td width="564">
	    <input type="text" size="35" name="Name" />
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    Your Real Age:</td>
	    <td width="564">
	    <input type="text" size="35" name="Age" />
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500" height="50">Email Address:</td>
	    <td valign="top" width="564" height="50">
	    <input type="text" size="35" name="Email" />
	    </td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Contact Info</font></b> (fill in all that apply)</font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    AOL Instant Messenger Screen name:</td>
	    <td valign="top" width="564">
	    <input type="text" size="35" name="AOLIM" />
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    ICQ Number:</td>
	    <td valign="top" width="564">
	    <input type="text" size="35" name="ICQ" />
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500" height="50">

	    Yahoo! Messenger Screen name:</td>
	    <td valign="top" width="564" height="50">
	    <input type="text" size="35" name="Yahoo" />
	    </td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Player Experience</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    <tr>
	    <td align="right" valign="top" width="500">

	    List all SIMM Groups (including groups names, ships, etc):</td>
	    <td valign="top" width="564">
	    <textarea name="RPG_Experience" rows="3" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    How long have you been simming:</td>
	    <td valign="top" width="564">
	    <select name="Time_In_Other_RPGs" size="1">
	    <option selected="selected" value="-----Select----">-----Select----</option>
	    <option value="0 - 3 Months">0 - 3 Months</option>
	    <option value="4 - 6 Months">4 - 6 Months</option>
	    <option value="7 - 9 Months">7 - 9 Months</option>
	    <option value="10 months - 1 Year">10 months - 1 Year</option>
	    <option value="1 - 5 Years">1 - 5 Years</option>
	    <option value="Over 5 Years">Over 5 Years</option>
	    </select>
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500" height="65">

	    Will you follow all the rules?</td>
	    <td valign="top" width="564" height="65">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yes<input type="radio" name="rules" value="yes" /><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No<input type="radio" name="rules" value="no" />

	    </td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Ship Information</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    Ship Class:</td>
	    <td valign="top" width="564">
	    <select name="desiredclass">
	    <option value="Any" selected="selected">Any</option>
	    <?
	        $qry = "SELECT c.name
	                FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
	                WHERE c.category=d.id AND d.type=t.id AND t.support='n'
	                ORDER BY c.name";
	        $result = $database->openShipsWithReturn($qry);
	        while ( list($sname) = mysql_fetch_array($result) )
	            echo "<option value=\"{$sname}\">$sname</option>\n";
	    ?>
	    </select>
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    Alternate Ship Class:</td>
	    <td valign="top" width="564">
	    <select name="altclass">
	    <option value="Any" selected="selected">Any</option>
	    <?
	        $qry = "SELECT c.name
	                FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
	                WHERE c.category=d.id AND d.type=t.id AND t.support='n'
	                ORDER BY c.name";
	        $result = $database->openShipsWithReturn($qry);
	        while ( list ($sname) = mysql_fetch_array($result) )
	            echo "<option value=\"{$sname}\">$sname</option>\n";
	    ?>
	    </select>
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500" height="50">

	    Desired Ship:</td>
	    <td valign="top" width="564" height="50">
	    <select name="ship">
	    <option value="Any" selected="selected">Any</option>
	    <?
        	$ship = stripslashes($ship);
        	$qry = "SELECT name FROM {$spre}ships WHERE tf<>'99' AND co='0' ORDER BY name";
	        $result = $database->openConnectionWithReturn($qry);
	        while ( list($sname) = mysql_fetch_array($result) )
	            if ($ship == $sname)
	                echo "<option selected=\"selected\" value=\"{$sname}\">$sname</option>\n";
	            else
	                echo "<option value=\"{$sname}\">$sname</option>\n";
	    ?>
	    </select>
	    </td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Character Information</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    Character's Name:</td>
	    <td valign="top" width="564">
	    <input type="text" size="37" name="Characters_Name" />
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    Character's Race:</td>
	    <td valign="top" width="564">
	    <input type="text" size="37" name="Characters_Race" />
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500">

	    Character's Gender:</td>
	    <td valign="top" width="564">
	    <input type="text" size="37" name="Characters_Gender" />
	    </td>
	    </tr>

	    <tr>
	    <td align="right" valign="top" width="500" height="150">

	    Character Bio:<br />
	    Please make this as detailed as you can. The better it is, the more likely you are to succeed in your application</td>
	    <td valign="top" width="564" height="150">
	    <textarea name="Character_Bio" rows="8" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Questionnaire</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" colspan="2">
	    Instructions: Please answer the following questions honestly and completely. Take time to consider your answers. The answers are subjective, thus there are no &quot;right&quot; or &quot;wrong&quot; replies. Your answers will be judged by the TFCO the ship you are applying for is in. If, after review, he feels that you are not qualified, he will suggest you take a position as ship XO, Department Head, or Command Intern for further training before you attend Command Class. If he finds you are ready for command he will assign you to a ship and you'll be entered into Command Class. Every opportunity for success is afforded the candidate.<br /><br /></td>
	    </tr>


	    <tr>
	    <td align="left" valign="top" width="500">

	    1) What do you think are the duties of a ship's Commanding Officer, both
	    in-character and out-of-character?</td>
	    <td valign="top" width="564">
	    <textarea name="q1" rows="9" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" width="500">

	    2) What role do you think XOs and department heads should play in helping run
	    the ship / simm?</td>
	    <td valign="top" width="564">
	    <textarea name="q2" rows="9" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" width="500">

	    3) How do you plan to recruit?</td>
	    <td valign="top" width="564">
	    <textarea name="q3" rows="9" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" width="500">

	    4) Posting has dropped to an all-time low, there are only 1 or 2 posts a week.
	    What will you do to motive your crew into posting again?</td>
	    <td valign="top" width="564">
	    <textarea name="q4" rows="9" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" width="500">

	    5) A crewmember has come to you, complaining about someone else and accusing
	    them of being control-freaks. How do you handle it?</td>
	    <td valign="top" width="564">
	    <textarea name="q5" rows="9" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" width="500" height="175">

	    6) You disagree with a decision made by the Admiralty and other CO's of the
	    fleet. What do you do?</td>
	    <td valign="top" width="564" height="175">
	    <textarea name="q6" rows="9" cols="50"></textarea>
	    </td>
	    </tr>


	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Sample Post</font></b>
        Please reply to the situation below:</font></td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" width="500" height="175">
	    You are in the lounge when suddenly the ship shakes violently and the lights
	    go out. A few seconds later, the emergency lights come on. A few crewmen
	    try the door, but it doesn't work -- it seems like power is out throughout
	    the whole ship.</td>
	    <td valign="top" width="564" height="175">
	    <textarea name="Sample_Post" rows="9" cols="50"></textarea>
	    </td>
	    </tr>

	    <tr><td width="362" bgcolor="#333333" colspan="2">
	    <b><font size="2">Reference</font></b></font></td>
	    </tr>

	    <tr>
	    <td align="left" valign="top" width="500">

	    How did you Hear About Us?:</td>
	    <td valign="top" width="564">
	    <select name="Reference" size="1">
	    <option selected="selected" value="select">-----Select Reference----</option>
	    <option value="Already In OF">Already in the Fleet</option>
	    <option value="Friend">Friend</option>
	    <option value="Link from another site">Link from another site</option>
	    <option value="Search Engine">Search Engine</option>
	    <option value="Browsing the Internet">Browsing the Internet</option>
	    <option value="Other">Other</option>
	    </select>
	    <br />
	    <input type="text" size="20" name=Reference_Other />
	    </td>
	    </tr>
	</table>
	</center>
	<p align="center">
	<input type="submit" value="Submit Application" />
	<input type="reset" value="Clear Comments" />
	</p>
	</form>

	</td>
</table>
