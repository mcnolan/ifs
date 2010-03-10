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
  * Date:	12/22/03
  * Comments: OPM tools
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to OPM Tools<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	</center><br /><br />

	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=ctrans" method="post">
		<u>Transfer:</u><br />
		Character ID: <input type="text" name="cid" size="3" /><br />
		Transfer Destination ID: <input type="text" name="sid" size="3" /><br />
		<input type="submit" value="Submit" />
    </form>
	<br /><br />

	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=clistem" method="post">
		<u>Character list</u><br />
		Find the characters associated with an email address or player ID#<br />
		Email address: <input type="text" name="email" size="30" /><br />
		<input type="submit" value="Submit" />
    </form>

	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=clistid" method="post">
		<br />Player ID: <input type="text" name="pid" size="5" /><br />
		<input type="submit" value="Submit" />
    </form>
	<br /><br />

	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=cview" method="post">
		<u>Character Lookup</u><br />
		Find the character info for an ID#<br />
		Character ID: <input type="text" name="cid" size="5" /><br />
		<input type="submit" value="Submit" />
    </form>

	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=rview" method="post">
		<br />Find Service Record info<br />
		Character ID: <input type="text" name="cid" size="5" /><br />
		<input type="submit" value="Submit" />
    </form>
	<br /><br />

	<form action="index.php?option=ifs&amp;task=opm&amp;action=common&amp;lib=sview" method="post">
		<u>Ship Lookup</u><br />
		Find the ship info for an ID#<br />
		Ship ID: <input type="text" name="sid" size="5" /><br />
		<input type="submit" value="Submit" />
    </form>
	<br /><br />

	<?
}
?>