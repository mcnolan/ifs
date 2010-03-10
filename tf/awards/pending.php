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
  * Comments: View Pending Awards to approve/deny them
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if (!$save)
    {
		$qry = "SELECT a.id, a.date, a.nominator, b.name, c.name, s.name, a.reason
	    		FROM {$spre}awardees a, {$spre}awards b, {$spre}characters c, {$spre}ships s
	            WHERE a.award=b.id AND a.recipient=c.id AND c.ship=s.id AND a.approved='1'
	            ORDER BY date";
	    $result = $database->openConnectionWithReturn($qry);

	    ?>
	    <table width="85%" border="1" cellspacing="1" cellpadding="10">
	    	<tr>
	        	<th>Date Submitted</th>
	            <th>Award</th>
	            <th>Character</th>
	            <th>Ship</th>
	            <th>&nbsp;</th>
	        </tr>

	        <?php
            while (list($aid, $date, $nominator, $aname, $cname, $sname, $reason) = mysql_fetch_array($result))
            {
            	?>
	        	<tr>
	            	<td><?php echo date("F j, Y", $date) ?></td>
	                <td><?php echo $aname ?></td>
					<td><?php echo $cname ?></td>
	                <td><?php echo $sname ?></td>
	                <td>
	                	<form action="index.php?option=ifs&amp;task=awards&amp;action=pending&amp;save=<?php echo $aid ?>" method="post">
                        <input type="hidden" NAME="approve" value="approve" />
	                    <input type="submit" value="Approve" />
	                    </form>
	                	<form action="index.php?option=ifs&amp;task=awards&amp;action=pending&amp;save=<?php echo $aid ?>" method="post">
                        <input type="hidden" NAME="approve" value="deny" />
	                    <input type="submit" value="Reject" />
	                    </form>
	                </td>
	            </tr>
	            <tr>
	            	<td>&nbsp;</td>
	                <td colspan="3">
                    	<?php echo $reason ?>
                        <br /><br />
                        Submitted By: <?php echo $nominator ?>
                    </td>
                    <td>&nbsp;</td>
                </tr>
            	<?php
            }
        echo "</table>\n";
    }
    else
    {
    	if ($approve == "approve")
        {
	    	$qry = "UPDATE {$spre}awardees SET approved='2' WHERE id='$save'";
            $database->openConnectionNoReturn($qry);

		    $qry = "SELECT a.date, a.nemail, b.name, r.rankdesc, c.name, s.name
		    	 	FROM {$spre}rank r, {$spre}characters c, {$spre}ships s, {$spre}awardees a, {$spre}awards b
		            WHERE a.award=b.id AND a.recipient=c.id AND a.rank=r.rankid AND a.ship=s.id AND a.id='$save'";
		    $result = $database->openConnectionWithReturn($qry);
            list ($date, $email, $aname, $rank, $cname, $sname) = mysql_fetch_array($result);

		   	$mailersubject = "$fleetname Award Status";
			$mailerbody = "On " . date("F j, Y", $date) . " you nominated $rank $cname ($sname) for the $aname.\n\n";
	        $mailerbody .= "the nomination has been reviewed, and we are glad to inform you that the award as been approved\n\n";
	        $mailerbody .= "thanks for taking good care of your crew!\n";
			$mailerbody .= "\n\nthis message was automatically generated.";

			$header = "From: " . email-from;
			mail ($email, $mailersubject, $mailerbody, $header);
        }
        elseif ($approve == "deny")
        {
	    	$qry = "UPDATE {$spre}awardees SET approved='0' WHERE id='$save'";
            $database->openConnectionNoReturn($qry);

		    $qry = "SELECT a.date, a.nemail, b.name, r.rankdesc, c.name, s.name
		    	 	FROM {$spre}rank r, {$spre}characters c, {$spre}ships s, {$spre}awardees a, {$spre}awards b
		            WHERE a.award=b.id AND a.recipient=c.id AND a.rank=r.rankid AND a.ship=s.id AND a.id='$save'";
		    $result = $database->openConnectionWithReturn($qry);
            list ($date, $email, $aname, $rank, $cname, $sname) = mysql_fetch_array($result);

		   	$mailersubject = "$fleetname Award Status";
			$mailerbody = "On " . date("F j, Y", $date) . " you nominated $rank $cname ($sname) for the $aname.\n\n";
	        $mailerbody .= "the nomination has been reviewed, but unfortunately we must inform you that the award was denied\n\n";
	        $mailerbody .= "there are many reasons for which an award might be denied, including an incomplete submission or simply too much competition for the award.";
			$mailerbody .= "For more information regarding this nomination, please email $webmasteremail\n";
			$mailerbody .= "\n\nthis message was automatically generated.";

			$header = "From: " . email-from;
			mail ($email, $mailersubject, $mailerbody, $header);
		}
        redirect("");
    }
}
?>