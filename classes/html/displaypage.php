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
  * Comments: Display page
 ***/

class displaycontent
{
	function displaypage($content, $heading)
    {
		echo "<table cellpadding=\"0\" cellspacing=\"5\" border=\"0\" bgcolor=\"#000000\" width=\"100%\">\n";
	        if ($heading!="")
	        {
	            ?>
	            <tr>
	                <td class="articlehead"><?php echo $heading ?></td>
	            </tr>
	            <td>
	                <td>&nbsp;</td>
	            </tr>
	            <?php
	        }
	        ?>
	        <tr>
	            <td><?php echo $content ?></td>
	        </tr>
	    </table>
        <?php
    }
}
?>