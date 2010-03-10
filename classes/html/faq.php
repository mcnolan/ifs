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
  * Date: 12/13/03
  *	Comments: Display FAQ stuff
 ***/

class faq
{
	function faqlist($topictext, $topicid, $title, $sid, $id, $counter)
    {
	    ?>
	    <table width="98%" cellpadding="4" cellspacing="4" border="0" align="center">
	    <tr>
			<td colspan="2">
	        	<span class="articlehead">FAQ's</span>
	        	<hr noshade size="1" />
	    	</td>
	    </tr>
	    <tr>
	    	<td width="50%" valign="top" >
	        	<p>From the list below choose one of our FAQ's topics, then select a article
		          to read. If you have a question which is not in this section, please
		          contact us. </p>
	    	</td>
	    	<td width="50%" height="73">
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
						<tr><td width="32" height="20" align="center" bgcolor="#999999">&nbsp;</td>
			            <td width="100%" height="20" bgcolor="#999999"><b><font color="#FFFFFF">
			            <?php echo $topictext[$id] ?></font></b></td>
						</tr>

                        <?php
						$color = array("#000000", "#666666");
	                    $k = 0;
	                    for ($i = 0; $i < count($sid["$topictext[$id]"]); $i++)
                        {
	                        $test = $date["$topictext[$id]"][$i];
	                        $count = $counter["$topictext[$id]"][$i];
	                        $date = split(" ",$test);
	                        $datesplit = split("-", $date[0]);
				            ?>

	                        <tr bgcolor="<?php echo $color[$k] ?>">
	                        <td width="32" height="20" align="center">
                            	<img src="images/FP_images/document.gif" width="32" height="16" align="absbottom" vspace="3" hspace="3" />
                            </td>
	                        <td width="100%" height="20">
                            	<a href="index.php?option=faq&task=show&artid=<?php echo $sid["$topictext[$id]"][$i] ?>">
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
		                echo "<li> <a class=\"category\" href=\"index.php?option=faq&Itemid=5&topid={$i}\">$topictext[$i]</a>&nbsp;</li>\n";
	            }
			    ?>
				</p>
			</td></tr>
		</table>

        <?php
	}

    function showfaq($title, $id, $content)
    {
    	?>
        <table align="center" width="90%" cellspacing="2" cellpadding="2" border="0" height="100%" class="popupwindow">
        <tr>
            <td class="componentHeading" colspan="2" width="90%"><?php echo $title ?></td>
        </tr>
        <tr>
            <td valign="top" height="90%" colspan="4"><?php echo $content ?></td>
        </tr>
        </table>

        <?php
	}

}
?>