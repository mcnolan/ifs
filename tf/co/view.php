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
  * Date:	1/6/04
  * Comments: Main ship admin page for COs
  *
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br><center>
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="100%" align="center">
				Welcome, <?php echo $name; ?>, to the CO's Administration Interface.<br />
				Please note that your login will time out after about 10 minutes of inactivity.
				<br /><br />

	            <?php
	            $qry = "SELECT name FROM {$spre}characters WHERE (pos='Pending' OR rank='".PENDING_RANK."') AND ship='$sid'";
				$result = $database->openConnectionWithReturn($qry);

	            if ( mysql_num_rows($result) )
                {
                	?>
	            	<table width="50%" border="2"><tr><td>
	            	<center><font size="+2"><b><u>You have pending crew members!!</u></b></font><br />
	                <font size="+1">
                    <?php
	                while ( list ($cname) = mysql_fetch_array($result) )
	                	echo $cname . "<br />\n";
					?>
		            </font><br />
					</center></td></tr></table>
                    <?php
	            }

	            ship_view_info($database, $mpre, $spre, $sid, $uflag);
                ?>
			</td>
			<td width="15">&nbsp;</td>
		</tr>
	</table>
	<br />
	<?php
}
?>
