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
  * This file based on code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  *	Date: 12/13/03
  *	Comments: Function displays selected weblink category and titles from the database.
 ***/

class weblinks {
	function displaylist($topictext, $topicid, $title, $sid, $id, $date, $url)
    {
    	?>
		<table width="98%" cellpadding="4" cellspacing="4" border="0" align="center">
		<tr>
			<td colspan="2">
				<p class="articlehead">Web Links</p>
			</td>
		</tr>
		<tr>
	        <td width="50%" valign="top" >
	            <p>We are regularly out on the web. When we find some great site we list
	              them here for to enjoy, however we would love you to come back. From
	              the box below choose one of our Link topics, then select a URL to visit.</p>
	        </td>
	        <td width="50%" valign="top">
	            <!-- insert image here -->
	        </td>
	    </tr>
	    <tr>
	        <td valign="top" colspan="2">
	            <?php
	            if ($id <> "")
	            {
	                ?>
	                <hr noshade size="1" />
	                <table width="100%" border="0" cellspacing="0" cellpadding="0">
	                <tr>
	                    <td width="32" height="20" align="center" bgcolor="#999999">&nbsp;</td>
	                    <td width="100%" height="20" bgcolor="#999999">
	                        <b><font color="#FFFFFF">Web Link</font></b>
	                    </td>
	                </tr>
	                <?php
	                $color = array("#333333", "#666666");
	                $k = 0;
	                for ($i = 0; $i < count($sid["$topictext[$id]"]); $i++)
	                {
	                    $test = $time["$topictext[$id]"][$i];
	                    $count = $counter["$topictext[$id]"][$i];
	                    $date = split(" ",$test);
	                    $datesplit = split("-", $date[0]);
	                    ?>

	                    <tr bgcolor = "<?php echo $color[$k] ?>">
	                        <?php
	                        $today = date("n d Y");
	                        $todaydate = split(" ", $today);
	                        $sum = $todaydate[2] - $datesplit[0];
	                        ?>
	                        <td width="32" height="20" align="center">
	                            <img src="images/FP_images/wwwicon.gif" width="32" height="16" align="absbottom" vspace="3" hspace="10" />
	                        </td>
	                        <td width="100%" height="20">
	                            <a href="<?php echo $url["$topictext[$id]"][$i] ?>" target="_blank">
	                            <?php echo $title["$topictext[$id]"][$i] ?></a>
	                        </td>
	                    </tr>
	                    <?php
	                    if ($k == 1)
	                        $k = 0;
	                    else
	                        $k++;
	                }
	                ?>
	                </table>
	                <hr noshade size="1" />
	                <?php
	            }
	            ?>
	            <p><div class="articlehead">Categories</div><br />
	            <?php
	            for ($i = 0; $i < count($topicid); $i++)
	            {
	                if (($id == $i) && ($id <> ""))
	                    echo "<li> <a class=\"category\">$topictext[$i]</a>&nbsp;</li>\n";
	                else
	                    echo "<li> <a class=\"category\" href=\"index.php?option=weblinks&Itemid=4&topid=$i\">$topictext[$i]</a>&nbsp;</li>\n";
	            }
	            ?>
	        </td>
	    </tr>
	    </table>
		<?php
    }
}
?>