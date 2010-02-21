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
  * Comments: Display usermenu
 ***/

class HTML_usermenu
{
	function showMenuComponent($uName, $uid, $usertype, $id, $name, $link, $option)
    {
    	?>
		<table>
			<?php
            if ($usertype == "User")
            {
            	?>
				<tr>
					<td height="30">Hi <?php echo $uName ?>!</td>
				</tr>
				<?php
            }
            ?>
			<tr>
				<td class=componentHeading><?php echo $usertype ?> Menu</td>
			</tr>
			<?php
            $numItems=count($id);
			for ($i=0; $i < $numItems; $i++)
            {
				if (trim($name[$i])!="")
                	{
                    	?>
						<tr>
							<td><li><a href="<?php echo $link[$i] ?>"><?php echo $name[$i] ?></a></td>
						</tr>
						<?php
                    }
			}
            ?>
		</table>
		<?php
    }
}
?>