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
  *	Comments: The function listing retrieves all article categories and titles from the database.
 ***/

class articles
{
    function listarticles($topictext, $topicid, $title, $sid, $id, $indent)
    {
    ?>
	<table width="98%" cellpadding="4" cellspacing="4" border="0" align="center">
		<tr><td colspan="2">
		    <span class="articlehead">Database</span>
		</td></tr>
		<tr><td width="50%" valign="top" >
		    <p>Select from the box below to choose the area.</p>
		</td><td width="50%" valign="top">
        	&nbsp; <!-- insert image here? -->
        </td></tr>
		<tr><td valign="top" colspan="2">
		    <?php
            if ($id <> "")
            {
            	?>
			    <hr noshade="noshade" size="1" />
			    <table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
					<td width="100%" height="20" bgcolor="#999999"><b><font color="#FFFFFF">
			        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			        <?php echo $topictext[$id] ?></font></b></td>
					</tr>
					<?php
					$color = array("#000000", "#666666");
                  	$k = 0;
                  	for ($i = 0; $i < count($sid["$topictext[$id]"]); $i++)
                    {
                    	$test = $date["$topictext[$id]"][$i];
	                    $count = $counter["$topictext[$id]"][$i];
    	                $articleauthor = $author["$topictext[$id]"][$i];
        	            $datesplit = split("-", $test);
                        echo "<tr bgcolor=\"{$color[$k]}\">\n";
						echo "<td width=\"100%\" height=\"20\">\n";
            			$spaces = $indent["$topictext[$id]"][$i];
		                for ($x = 0; $x < $spaces; $x++)
							echo "&nbsp;&nbsp;&nbsp;&nbsp;";

		                if ($spaces == 0)
		                    echo "<img src=\"images/FP_images/document.gif\" width=\"32\" " .
                            	 "height=\"16\" align=\"absbottom\" vspace=\"3\" hspace=\"3\" />\n";
						else
		                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";

            			echo "<a href=\"index.php?option=articles&task=show&artid={$sid["$topictext[$id]"][$i]}\">\n";
						echo $title["$topictext[$id]"][$i] . "</a></font></td></tr>\n";

					    if ($k == 1)
	                        $k = 0;
	                    else
	                        $k++;
                    }
				echo "</table>\n";
				echo "<hr noshade size=\"1\" />\n";
            }
            echo "<p><div class=\"articlehead\">Categories</div><br />";

            for ($i = 0; $i < count($topicid); $i++)
                if (($id == $i) && ($id <> ""))
                    echo "<li> <a class=\"category\">$topictext[$i]</a>&nbsp;</li>\n";
                else
                    echo "<li> <a class=\"category\" href=\"index.php?option=articles&Itemid=3&topid=$i\">$topictext[$i]</a>&nbsp;</li>\n";

	    echo "</td></tr>\n";
    echo "</table>\n";
	}

    function showarticle($title, $artid, $author, $content)
    {
    	?>
        <table align="center" width="90%" cellspacing="2" cellpadding="2" border="0" height="100%">
        <tr>
            <td class="articlehead" width="100%"><?php echo $title ?></td>
        </tr>
        <tr>
            <td valign="top" height="90%"><?echo $content;?></td>
        </tr>
        </table>
        <?php
    }
}
?>