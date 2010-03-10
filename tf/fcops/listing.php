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
  * Date:	1/28/04
  * Comments: FCOps Ship Listing
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to the FCOps Ship Listing<BR>
	Please note that your login will time out after about 10 minutes of inactivity.
	<br /><br />

	<center>Sort by:
	<?php
    if ($sort != "")
		if ($show)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=$show\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing\">";
    else
    	echo "<a>";
    echo "name</a> |\n";

	if ($sort != "class")
		if ($show)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=$show&amp;sort=class\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=class\">";
	else
    	echo "<a>";
    echo "class</a> |\n";

	if ($sort != "tf")
		if ($show)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=$show&amp;sort=tf\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=tf\">";
	else
    	echo "<a>";
    echo "TF</a> |\n";

	if ($sort != "crew")
		if ($show)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=$show&amp;sort=crew\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=crew\">";
	else
    	echo "<a>";
    echo "crew</a>\n";
    echo "</center><br />\n";

	echo "<center>Show:\n";
	if ($show != "")
		if ($sort)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=$sort\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing\">";
	else
    	echo "<a>";
    echo "all</a> |\n";

	if ($show != "active")
		if ($sort)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=$sort&amp;show=active\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=active\">";
	else
    	echo "<a>";
    echo "active</a> |\n";

	if ($show != "inactive")
		if ($sort)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=$sort&amp;show=inactive\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=inactive\">";
	else
    	echo "<a>";
    echo "inactive</a> |\n";

	if ($show != "open")
		if ($sort)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=$sort&amp;show=open\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=open\">";
	else
    	echo "<a>";
    echo "Open</a> |\n";

	if ($show != "queue")
		if ($sort)
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;sort=$sort&amp;show=queue\">";
		else
			echo "<a href=\"index.php?option=ifs&amp;task=fcops&amp;action=listing&amp;show=queue\">";
	else
    	echo "<a>";
    echo "Queue & Mothball</a>\n";
	echo "</center><br />\n";
    ?>

	<table border="1" width="100%">
		<tr>
			<td><b>Ship Name</b></td>
			<td><b>Class</b></td>
			<td><b>Status</b></td>
			<td><b>TF / TG</b></td>
		</tr>
        <tr>
        	<td></td>
			<td><b>CO Name</b></td>
            <td><b>CO Email</b></td>
			<td><b>Crew</b></td>
        </tr>
        <tr>
        	<td colspan="4">&nbsp;</td>
        </tr>
		<?php
		switch ($sort)
        {
			case "class":
				$sort = "class,";
				break;
			case "tf":
				$sort = "tf, tg,";
				break;
        	case "crew":
        		$sort = "cnum ASC,  ";
		}

	   	$qry = "SELECT s.id, COUNT(c.ship) AS cnum, s.name, s.class, s.co, s.tf,
        			s.tg, s.status, s.format, s.website
                FROM {$spre}characters c, {$spre}ships s
                WHERE c.ship = s.id OR s.co = '0'
                GROUP BY s.id ORDER BY $sort name";
	    $result = $database->openConnectionWithReturn($qry);


		while (	list($sid,$crew,$sname,$sclass,$coid,$tfid,$tgid,$status,$format)=mysql_fetch_array($result) )
        {
			if ($coid)
            {
				$qry2 = "SELECT name, rank, player FROM " . $spre . "characters WHERE id='$coid'";
				$result2=$database->openConnectionWithReturn($qry2);
				list($coname,$rid,$uid)=mysql_fetch_array($result2);

				$qry2 = "SELECT rankdesc FROM " . $spre . "rank WHERE rankid='$rid'";
				$result2=$database->openConnectionWithReturn($qry2);
				list($rank)=mysql_fetch_array($result2);

				$qry2 = "SELECT email FROM " . $mpre . "users WHERE id='$uid'";
				$result2=$database->openConnectionWithReturn($qry2);
				list($email)=mysql_fetch_array($result2);
			}
            else
            {
				$coname = "None<br />&nbsp;";
				$rank = "";
				$email = "&nbsp;";
			}

			$qry2 = "SELECT name FROM " . $spre . "taskforces WHERE tf='$tfid' AND tg='$tgid'";
			$result2=$database->openConnectionWithReturn($qry2);
			list($tg)=mysql_fetch_array($result2);

			if (($show == "inactive") && ($status != "Waiting for Crew") && ($status != "Waiting for Command Academy completion"))
				$noshow = '1';
			elseif (($show == "active") && ($status != "Operational"))
				$noshow = '1';
			elseif (($show == "open") && ($coid != "0"))
				$noshow = '1';
			elseif (($show == "queue") && (($tfid != '99') || ($tgid == '3')))
				$noshow = '1';
			else
				$noshow = '0';

			if ($noshow != '1')
            {
				?>
				<tr>
					<td>
						<?php echo "($sid)<br />$sname" ?><br />
					</td>
					<td>
						<?php echo $sclass ?> class
					</td>
					<td>
						<?php echo $status ?>
					</td>
					<td>
						<?php echo "$tfid / $tg" ?>
					</td>
				</tr>
                <tr>
                	<td>&nbsp;</td>
					<td>
						<?php echo $rank . " " . $coname; ?>
                    </td>
                    <td>
						<?php echo $email; ?>
					</td>
					<td>
						<?php
                        if (!$coid)
							echo "No Crew";
						else
							echo "Crew: $crew";
						?>
                    </td>
                </tr>
                <tr>
                	<td colspan="4">
                    	&nbsp;
                    </td>
                </tr>
				<?php
			}
		}
		?>
		</tr>
	</table><br />
	<?php
}
?>