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
  * Comments: JAG tools
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to JAG Tools<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	</center><br /><br />

	<h1>Character list</h1>
	<form action="index.php?option=ifs&amp;task=jag&amp;action=common&amp;lib=clistem" method="post">
		Find the characters associated with an email address or player ID#<br />
		Email address: <input type="text" name="email" size="30" /><br />
		<input type="hidden" name="op" value="list" />
		<input type="submit" value="Submit" />
    </form>

	<form action="index.php?option=ifs&task=jag&action=common&lib=clistid" method="post">
		<br />Player ID: <input type="text" name="pid" size="5" /><br />
		<input type="hidden" name="op" value="list2" />
		<input type="submit" value="Submit" />
    </form>
	<br /><br />

	<h1>Find Service Record info</h1>
	<form action="index.php?option=ifs&task=jag&action=common&lib=rview" method="post">
		Character ID: <input type="text" name="cid" size="5" /><br />
		<input type="hidden" name="op" value="record" />
		<input type="submit" value="Submit" />
    </form>
	<br /><br />

    <h1>Assign Divisional JAG Officers</h1>
   	<?
    $qry = "SELECT tf, name, jag FROM {$spre}taskforces WHERE tg='0' ORDER BY tf";
    $result = $database->openConnectionWithReturn($qry);

    while (list ($tfid, $tfname, $djag) = mysql_fetch_array($result))
    {
    	?>
	    <form action="index.php?option=ifs&task=jag&action=tools2" method="post">
        	Task Force <?php echo $tfid ?> - <?php echo $tfname ?><br />
            <input type="text" name="djag" value="<?php echo $djag ?>" size="30" />
            <input type="hidden" name="tfid" value="<?php echo $tfid ?>" />
            <input type="submit" value="Update TF<?php echo $tfid ?>" />
        </form>
        <?
    }

}
?>