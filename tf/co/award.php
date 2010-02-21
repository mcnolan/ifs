<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net
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
  * Comments: Allows COs to nominate characters for awards
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	$qry = "SELECT c.id, r.rankdesc, c.name FROM {$spre}rank r, {$spre}characters c
    		WHERE c.ship='$sid' AND c.rank=r.rankid ORDER BY r.level, c.name";
    $result = $database->openConnectionWithReturn($qry);

	$qry2 = "SELECT id, name, level FROM {$spre}awards WHERE active='1' ORDER BY level, name";
    $result2 = $database->openConnectionWithReturn($qry2);
    ?>
    <h1>Nominate Crew for Awards</h1>
    <form action="index.php?option=ifs&amp;task=co&amp;action=awardsave" method="post">
    <input type="hidden" name="sid" value="<?php echo $sid ?>">

    Crew: <select name="cid">
    <option selected="selected"></option>
    <?php
    while (list($cid, $rname, $cname) = mysql_fetch_array($result))
    	echo "<option value=\"$cid\">$rname $cname</option>\n";
    ?>
    </select><br /><br />

    Award: <select name="award">
    <option selected="selected"></option>
    <?php
	while (list($aid, $aname, $level) = mysql_fetch_array($result2))
    	echo "<option value=\"$aid\">$aname (level $level)</option>\n";
    ?>
    </select><br /><br />

    Reason (include sample posts if necessary):<br />
    <textarea name="reason" rows="10" cols="70"></textarea><br /><br />

    Submitted By: <?php echo get_usertype($database, $mpre, $spre, '0', $uflag) ?><br /><br />

	<input type="submit" value="Submit" />
    </form>
    <?php
}
?>