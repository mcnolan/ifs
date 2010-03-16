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
  * Version:	1.14n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This program contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
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

		   	require_once "includes/mail/award_accepted.mail.php";
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

		   	require_once "includes/mail/award_denied.mail.php";
		}
        redirect("");
    }
}
?>
