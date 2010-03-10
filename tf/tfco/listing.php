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
  * Comments: QuickLink for TFCO ship listings
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	TFCO Ship Listings<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	</center><br /><br />

	<u>With Graphics:</u><br />
	<a href="index.php?option=ships&amp;tf=<?php echo $tfid ?>&amp;tg=all">All TF<?php echo $tfid ?> ships</a><br />

	<?php
	$qry = "SELECT tg, name FROM {$spre}taskforces WHERE tf='$tfid' AND tg!='0' ORDER BY tg";
	$result = $database->openConnectionWithReturn($qry);

	while (list ($tgid, $tgname) = mysql_fetch_array($result))
		echo "<a href=\"index.php?option=ships&amp;tf={$tfid}&amp;tg={$tgid}\">Task Group {$tgid} - {$tgname}</a><br />\n";
	?>

	<br /><br />

	<u>Text-Only:</u><br />
	<a href="index.php?option=ships&amp;tf=<?php echo $tfid ?>&amp;tg=all&textonly=1">All TF<?php echo $tfid ?> ships</a><br />

	<?php
	$qry = "SELECT tg, name FROM {$spre}taskforces WHERE tf='$tfid' AND tg!='0' ORDER BY tg";
	$result = $database->openConnectionWithReturn($qry);

	while (list ($tgid, $tgname) = mysql_fetch_array($result))
		echo "<a href=\"index.php?option=ships&amp;tf={$tfid}&amp;tg={$tgid}&textonly=1\">Task Group {$tgid} - {$tgname}</a><br />\n";

}
?>