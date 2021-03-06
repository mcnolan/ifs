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
  * Version:	1.13n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date	12/13/03
  * Comments: Main front page
  *
  * See CHANGELOG for patch details
  *
 ***/

class body
{
    function indexbody($sid, $introtext, $exttext, $title, $time, $newsimage, $imageposition, $category, $count, $charnum, $shipnum, $newstop)
    {
	global $fleetname, $fleetdesc;
        if ($newstop)
        	echo "<img src=\"{$newstop}\"  alt=\"News\" /><br>";
        echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"100%\" valign=\"top\" class=\"highlight\">";
	        echo "<table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"6\"><tr><td width=\"100%\" valign=\"top\" class=\"tdbg\">";
    	        for ($i = 0; $i < count($sid); $i++)
                {
                	echo "<span class=\"articlehead\">{$title[$i]}</span><br />\n";
                    echo "<span class=\"small\">{$time[$i]}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    echo "{$category[$i]}</span><br />\n";

                    if ($newsimage[$i] != "")
                    {
                    	$size = getimagesize("images/stories/$newsimage[$i]");
                        echo "<img src=\"images/stories/{$newsimage[$i]}\" hspace=\"12\" vspace=\"12\" " .
                        	 "align=\"{$imageposition[$i]}\" width=\"{$size[0]}\" height=\"{$size[1]}\" /><br />\n";
                    }

                    echo "<span class=\"newsarticle\">{$introtext[$i]}</span><br />\n";
                    if ($exttext[$i])
                    {
                    	echo "<span class=\"small\">";
                        echo "<a href=\"index.php?option=news&task=viewarticle&sid={$sid[$i]}\">";
                        echo "<span class=\"small\">Read On</span></a>... &nbsp;&nbsp;";
                        echo "({$count[$i]})</span><br />\n\n";
                    }
                    echo "<br /><img src=\"images/divider.gif\" width=\"100%\" height=\"1\" /><br /><br />\n";
				}
	        echo "</td></tr></table>\n";
		echo "</td></tr></table>\n";

        ?>
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td valign="top" class="highlight">
            <table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0" align="center"><tr><td valign="top" align="center" class="tdbg">
            </td></tr></table>
        </td></tr></table>

	    <!-- Fleet Intro -->
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	        <tr><td class="highlight">
	            <table width="100%"><tr><td class="highlight" height="20" alighn="center">
	                <center><b><span class="fleetstats"><? echo $fleetname; ?> is the proud home of <? echo $charnum ?> characters serving on <? echo $shipnum ?> ships.</span></b></center>
	            </td></tr></table>
	            <table width="100%" border="0" cellspacing="1" cellpadding="0">
	                <tr><td class="fleetdesc">
	                    <? echo $fleetdesc;?>
	                </td></tr>
	            </table>
	        </td></tr>
	    </table>

    	<?php
	}
}
?>
