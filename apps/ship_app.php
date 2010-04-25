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
  * Comments: Ship application
  *
  * See CHANGELOG for patch details
  *
 ***/

if (!defined("IFS"))
	require ("../includes/lib.php");

?>

<p align="center"><a href="index.php?option=app&task=crew">Player Application</a> | <a href="index.php?option=app&task=co">CO Application</a> | <a href="index.php?option=app&task=ship">Ship Application</a></P>


<table width="95%" align="center">
<td>

<h1 align="center">Ship Application Form</h1>
<form action="index.php?option=app&task=ship2" method="post">

<center>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Player Information</font></b></font></td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

    Your Real Name:</td>
    <td width="564">
    <input type="text" size="35" name="Name" />
    </td>
    </tr>
    <tr>

    <td align=right valign="top" width="251">

    Your Real Age:</td>
    <td width="564">
    <input type="text" size="35" name="Age" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251" height="50">
    Email Address:</td>
    <td valign="top" width="564" height="50">
    <input type="text" size="35" name="Email" />
    </td>
    </tr>

    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Contact Information</font></b> (fill in all that apply)</font></td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

    AOL Instant Messenger Screen name:</td>
    <td valign="top" width="564">
    <input type="text" size="35" name="AOLIM" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

    ICQ Number:</td>
    <td valign="top" width="564">
    <input type="text" size="35" name="ICQ" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251" height="50">

    Yahoo! Messenger Screen name:</td>
    <td valign="top" width="564" height="50">
    <input type="text" size="35" name="Yahoo" />
    </td>
    </tr>

    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Player Experience</font></b> (please be specific)</font></td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

    List all other SIMM Groups (including groups names, ships, etc):</td>
    <td valign="top" width="564">
    <textarea name="RPG_Experience" rows="4" cols="50"></textarea>
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

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
    <td align=right valign="top" width="251">

    Will you follow all the rules:</td>
    <td valign="top" width="564" height="65">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Yes<input type="radio" name="rules" value="yes" /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No<input type="radio" name="rules" value="no" />

    </td>
    </tr>

    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Ship Information</font></b></font></td>
    </tr>

    <td align=right valign="top" width="251">

    Ship Name </td>
    <td valign="top" width="564">
    <input type="text" name="ship" size="50" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">
    Ship Class:</td>

    <td valign="top" width="564">
    <input type="text" name="shipclass" size="50" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">
    Sim Website</td>

    <td valign="top" width="564">
    <input type="text" name="website" size="50" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">
    Length of time active</td>

    <td valign="top" width="564">
    <input type="text" name="active" size="50" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251" height="100">
    Please state your Reasons for wanting to join the Fleet.</td>

    <td valign="top" width="564" height="100">
    <textarea name="reason" rows="4" cols="50"></textarea>
    </td>
    </tr>

    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Character Information</font></b></font></td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

    Character's Name:</td>
    <td valign="top" width="564">
    <input type="text" size="37" name="Characters_Name" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

    Character's Race:</td>
    <td valign="top" width="564">
    <input type="text" size="37" name="Characters_Race" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251">

    Character's Gender:</td>
    <td valign="top" width="564">
    <input type="text" size="37" name="Characters_Gender" />
    </td>
    </tr>

    <tr>
    <td align=right valign="top" width="251" height="150">

    Character Bio:<br />
    Please make this as detailed as you can. The better it is, the more likely you are to succeed in your application</td>
    <td valign="top" width="564" height="150">
    <textarea name="Character_Bio" rows="8" cols="50"></textarea>
    </td>
    </tr>

    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Sample Post</font></b> (please reply to the situation below)</font></td>
    </tr>

    <tr>
    <td align="left" valign="top" width="251" height="175">
    You are in the lounge when suddenly the ship shakes violently and the lights
    go out. A few seconds later, the emergency lights come on. A few crewmen
    try the door, but it doesn't work -- it seems like power is out throughout
    the whole ship.</td>
    <td valign="top" width="564" height="175">
    <textarea name="Sample_Post" rows="9" cols="50"></textarea>
    </td>
    </tr>

    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Other Comments</font></b></font></td>
    </tr>

    <tr>
    <td align="left" valign="top" width="251" height="75">

    If you have any extra comments, please enter them here.
    </td>
    <td valign="top" width="564" height="75">
    <textarea name="extra_comments" rows="5" cols="50"></textarea>
    </td>
    </tr>

    <tr><td width="362" bgcolor="#333333" colspan="2">
    <b><font size="2">Reference</font></b></font></td>
    </tr>

    <tr>
    <td align="left" valign="top" width="251">

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
    <input type="text" size="20" name="Reference_Other">

    </td>
    </tr>
    </table>
    </center>


    <input type=submit value="Submit Application">
    <input type=reset value="Clear Comments">
    </form>

</td></tr></table>
