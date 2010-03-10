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
  * Date:	1/11/04
  * Comments: FCOps Tools - fun!
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to FCOps Tools<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	</center><br /><br />

	<form action="index.php?option=ifs&amp;task=fcops&amp;action=common&amp;lib=ctrans" method="post">
		<u>transfer Character:</u><br />
		Character ID: <input type="text" name="cid" size="3" /><br />
		transfer Destination ID: <input type="text" name="sid" size="3" /><br />
		<input type="hidden" name="op" value="tchar" />
		<input type="submit" value="Submit" />
    </form>
	<br /><br />

	<form action="index.php?option=ifs&amp;task=fcops&amp;action=common&amp;lib=strans" method="post">
		<U>transfer Ship:</U><br />
		Ship ID: <input type="text" name="sid" size="3" /><br />
		Destination TF: <input type="text" name="tfid" size="3" /><br />
		Destination TG: <input type="text" name="tgid" size="3" /><br />
		<input type="hidden" name="op" value="tship" />
		<input type="submit" value="Submit" />
    </form>
    <br /><br />

	<u>Task Force Command Staff Admin:</u><br />
    <table border="2" width="100%" cellspacing="2" cellpadding="2">
	    <?php
    	$qry = "SELECT tf, name FROM {$spre}taskforces WHERE tg='0'";
	    $result = $database->openConnectionWithReturn($qry);

		while (list ($tfid, $tfname) = mysql_fetch_array($result))
        {
	        $qry2 = "SELECT c.name, s.name
            		 FROM {$spre}taskforces t, {$spre}characters c, {$spre}ships s
                     WHERE t.tf='$tfid' AND t.tg='0' AND t.co=c.id AND s.co=c.id";
	        $result2 = $database->openConnectionWithReturn($qry2);
            list($tfco, $tfflag) = mysql_fetch_array($result2);
    		?>
			<tr><td colspan="2">
		    	<form action="index.php?option=ifs&amp;task=fcops&amp;action=tools2" method="post">
	        		<input type="hidden" name="reftf" value="<?php echo $tfid ?>" />
	        		<input type="hidden" name="reftg" value="0" />
	        		<input type="hidden" name="tgid" value="0" />
			    	Task Force&nbsp;
			        <input type="text" name="tfid" value="<?php echo $tfid ?>" size="3" /> -&nbsp;
	    		    <input type="text" name="tfname" value="<?php echo $tfname ?>" size="35" /><br />

			        CO:&nbsp;
			        <select name="tfcoid">
				        <?php
        			    $qry2 = "SELECT c.id, c.name, s.name, r.rankdesc FROM
            					{$spre}characters c, {$spre}ships s, {$spre}rank r WHERE
                			    c.id=s.co AND s.tf='$tfid' AND c.rank=r.rankid
                                ORDER BY c.rank DESC, c.name";
			            $result2 = $database->openConnectionWithReturn($qry2);
    			        while (list($coid, $cname, $sname, $rname)=mysql_fetch_array($result2))
        			    	if ($cname == $tfco)
	        			    	echo "<option value=\"{$coid}\" selected=\"selected\">{$rname} {$cname}, {$sname}</option>\n";
                			else
		            			echo "<option value=\"{$coid}\">{$rname} {$cname}, {$sname}</option>\n";
    	    	    	?>
	    	    	</select><br />
                    <table border="0"><tr><td>
                        <input type="submit" value="Update Task Force" /></form>
                    </td><td>
                        <form action="index.php?option=ifs&amp;task=fcops&amp;action=tools2" method="post">
                        <input type="hidden" name="reftf" value="<?php echo $tfid ?>" />
                        <input type="hidden" name="tfid" value="delete" />
                        <input type="submit" value="Delete Task Force" /></form>
                    </td></tr></table>
    	    </td></tr>
	        <?php
		    $qry2 = "SELECT tg, name FROM {$spre}taskforces
            		 WHERE tf='$tfid' AND tg<>'0' ORDER BY tg";
	        $result2 = $database->openConnectionWithReturn($qry2);

	        while (list ($tgid, $tgname) = mysql_fetch_array($result2))
            {
            	$qry3 = "SELECT c.name, s.name
                		 FROM {$spre}characters c, {$spre}ships s, {$spre}taskforces t
                         WHERE t.tf='$tfid' AND c.id=t.co AND s.co=c.id";
                $result3 = $database->openConnectionWithReturn($qry3);
                list($tgco, $tgflag) = mysql_fetch_array($result3);
    	      	?>
			    <tr>
			      	<td width="15%">&nbsp;</td>
			        <td>
				    	<form action="index.php?option=ifs&amp;task=fcops&amp;action=tools2" method="post">
			        		<input type="hidden" name="reftf" value="<?php echo $tfid ?>" />
			        		<input type="hidden" name="reftg" value="<?php echo $tgid ?>" />
				        	<input type="hidden" name="tfid" value="<?php echo $tfid ?>" />
					    	Task Group&nbsp;
			    	    	<input type="text" name="tgid" value="<?php echo $tgid ?>" size="3" /> -&nbsp;
			    		    <input type="text" name="tfname" value="<?php echo $tgname ?>" size="35" /><br />

					        CO:&nbsp;
					        <select name="tfcoid">
				    		    <?php
				        		$qry3 = "SELECT c.id, c.name, s.name, r.rankdesc FROM
            							{$spre}characters c, {$spre}ships s, {$spre}rank r WHERE
                					    c.id=s.co AND s.tf='$tfid' AND s.tg='$tgid' AND c.rank=r.rankid
                                        ORDER BY c.rank DESC, c.name";
				        	    $result3 = $database->openConnectionWithReturn($qry3);
    				        	while (list($coid, $cname, $sname, $rname)=mysql_fetch_array($result3))
	        				    	if ($cname == $tgco)
		        		    			echo "<option value=\"{$coid}\" selected=\"selected\">{$rname} {$cname}, {$sname}</option>\n";
			                		else
					            		echo "<option value=\"{$coid}\">{$rname} {$cname}, {$sname}</option>\n";
        			    		?>
				        	</select><br />
                            <table border="0"><tr><td>
	    	    		    	<input type="submit" value="Update Task Group" /></form>
                            </td><td>
	                            <form action="index.php?option=ifs&amp;task=fcops&amp;action=tools2" method="post">
	                            <input type="hidden" name="reftf" value="<?php echo $tfid ?>" />
	                            <input type="hidden" name="reftg" value="<?php echo $tgid ?>" />
	                            <input type="hidden" name="tfid" value="<?php echo $tfid ?>" />
	                            <input type="hidden" name="tgid" value="delete" />
                                <input type="submit" value="Delete Task Group" /></form>
                            </td></tr></table>
            	    </td>
	            </tr>
    	        <?php
	        }
            ?>
            <tr>
                <td width="15%">&nbsp;</td>
                <td>
                    <form action="index.php?option=ifs&amp;task=fcops&amp;action=tools2" method="post">
                        <input type="hidden" name="reftf" value="<?php echo $tfid ?>" />
                        <input type="hidden" name="reftg" value="new" />
                        <input type="hidden" name="tfid" value="<?php echo $tfid ?>" />
                        Task Group&nbsp;
                        <input type="text" name="tgid" value="" size="3" /> -&nbsp;
                        <input type="text" name="tfname" value="" size="35" /><br />

                        CO:&nbsp;
                        <select name="tfcoid">
                            <?php
                            $qry3 = "SELECT c.id, c.name, s.name, r.rankdesc FROM
                                    {$spre}characters c, {$spre}ships s, {$spre}rank r WHERE
                                    c.id=s.co AND s.tf='$tfid' AND c.rank=r.rankid
                                    ORDER BY c.rank DESC, c.name";
                            $result3 = $database->openConnectionWithReturn($qry3);
                            while (list($coid, $cname, $sname, $rname)=mysql_fetch_array($result3))
								echo "<option value=\"{$coid}\">{$rname} {$cname}, {$sname}</option>\n";
                            ?>
                        </select><br />
                        <input type="submit" value="Add Task Group" /></form>
                </td>
            </tr>
            <?php
  	    echo "<tr><td colspan=\"2\"><hr><br /></td></tr>\n";
	    }
        ?>
        <tr><td colspan="2">
            <form action="index.php?option=ifs&amp;task=fcops&amp;action=tools2" method="post">
                <input type="hidden" name="reftf" value="new" />
                <input type="hidden" name="reftg" value="0" />
                <input type="hidden" name="tgid" value="0" />
                Task Force&nbsp;
                <input type="text" name="tfid" value="" size="3" /> -&nbsp;
                <input type="text" name="tfname" value="" size="35" /><br />

                CO:&nbsp;
                <select name="tfcoid">
                    <?php
                    $qry2 = "SELECT c.id, c.name, s.name, r.rankdesc FROM
                            {$spre}characters c, {$spre}ships s, {$spre}rank r WHERE
                            c.id=s.co AND s.tf='$tfid' AND c.rank=r.rankid
                            ORDER BY c.rank DESC, c.name";
                    $result2 = $database->openConnectionWithReturn($qry2);
                    while (list($coid, $cname, $sname, $rname)=mysql_fetch_array($result2))
	                    echo "<option value=\"{$coid}\">{$rname} {$cname}, {$sname}</option>\n";
                    ?>
                </select><br />
                <input type="submit" value="Add Task Force" />
            </form>
        </td></tr>
        <?php
	echo "</table><br /><br />\n";
}
?>