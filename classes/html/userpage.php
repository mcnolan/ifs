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
  * Date: 1/6/04
  * Comments: Display userpage
 ***/

class HTML_user
{
    function newsform($secid, $secname, $uid, $option, $Imagename, $text_editor)
    {
    	?>
        <form action="index.php" method="post" name="adminform">
            <table cellpadding="5" cellspacing="0" border="0" width="100%"  align="center">
            <tr>
                <td class="articlehead" colspan="2">Submit A News Story</td>
            </tr>
            <tr>
                <td width="100">Title:</td>
                <td colspan="2">
                	<input type="text" name="newstitle" SIZE="70" value="<?php echo $title ?>" />
                </td>
            </tr>
            <tr>
                <td>Section:</td>
                <td colspan="2">
                    <select name="newssection">
                        <option value="" selected="selected">Select A Section</option>
	                    <?php
                        for ($i = 0; $i < count($secid); $i++)
                            echo "<option value=\"{$secid[$i]}\">{$secname[$i]}</option>\n";
                        ?>
                    </select><br />
                    News about ships should go under TF21, TF72, or IFO News.
                </td>
            </tr>
            <tr>
                <td valign="top">Introduction:</td>
                <td valign="top" colspan="2">
                	<textarea cols="70" rows="10" name="introtext"></textarea>
                </td>
            </tr>
            <?php
            if ($text_editor == true)
            {
            	?>
                <tr>
                    <td>&nbsp;</td>
                    <td valign="top">
                    	<?php redirect("administrator/inline_editor/editor.htm?content=introtext", "Edit Text In Editor", 450, 650) ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td valign="top">Extended Text:</td>
                <td valign="top" colspan="2">
                	<textarea cols="70" rows="10" name="fultext"></textarea>
                </td>
            </tr>
            <?php
            if ($text_editor == true)
            {
            	?>
	            <tr>
	                <td>&nbsp;</td>
	                <td valign="top">
                    	<?php redirect("administrator/inline_editor/editor.htm?content=fultext", "Edit Text In Editor", 450, 650) ?>
                    </td>
    	        </tr>
	            <?php
            }
            ?>
            <tr>
                <td colspan="3">
                	<input type="hidden" name="option" value="<?php echo $option ?>" />
                    <input type="hidden" name="op" value="SaveNewNews" />
                    <input type="hidden" name="uid" value="<?php echo $uid ?>" />
                    <input type="hidden" name="Imagename2" value="<?php echo $Imagename ?>" />
                    <input type="submit" name="submit" value="Add News" />
                </td>
            </tr>
        	</table>
	    </form>
		<?php
	}

	function articleform($secid, $secname, $uid, $option, $Imagename, $text_editor)
    {
    	?>
	    <form action="index.php" method="post" name="adminform">
	        <table cellpadding="5" cellspacing="0" border="0" width="100%" align="center">
	        <tr>
	            <td class="articlehead" colspan="2">Submit An Article</td>
	        </tr>
	        <tr>
	            <td>Image:</td>
	            <td>
                	<input type="text" name="Imagename" disabled="disabled" value="<?php echo $Imagename ?>" />&nbsp;&nbsp;
	                <?php
                    if ($Imagename=="")
	                    redirect("upload.php?uid={$uid}&option={$option}&type=articles", "Upload Image", 180, 350);
                    ?>
	            <td width="250">
                	<img src="images/6977transparent.gif" name="imagelib" width="69" height="77" />
                </td>
	        </tr>
	        <tr>
	            <td width="100">Title:</td>
	            <td colspan="2">
                	<input type="text" name="arttitle" SIZE="70" value="<?php echo $title ?>" /></td>
	        </tr>
	        <tr>
	            <td>Section:</td>
	            <td colspan="2">
	                <select name="artsection">
	                        <option value="" selected="selected">select a Section</option>
	                    	<?php
                            for ($i = 0; $i < count($secid); $i++)
								echo "<option value=\"{$secid[$i]}\">{$secname[$i]}</option>\n";
                            ?>
	                </select><br />
	            </td>
	        </tr>
	        <tr>
	            <td valign="top">Content:</td>
	            <td valign="top" colspan="2">
                	<textarea cols="70" rows="15" name="pagecontent"></textarea>
                </td>
	        </tr>
	        <?php
            if ($text_editor == true)
            {
            	?>
	            <tr>
	                <td>&nbsp;</td>
	                <td valign="top">
                    	<?php redirect("administrator/inline_editor/editor.htm?content=pagecontent", "Edit in Text Editor", 450, 650) ?>
                    </td>
	            </tr>
		        <?php
            }
            ?>
	        <tr>
	            <td>&nbsp;</td>
	            <td colspan="2">
                	Remain Anonymous?&nbsp;&nbsp;
                    <input type="checkbox" name="anonymous" />
                </td>
	        </tr>

	        <tr>
	            <td colspan="3">
                	<input type="hidden" name="option" value="<?php echo $option ?>" />
	                <input type="hidden" name="op" value="SaveNewArticle" />
	                <input type="hidden" name="uid" value="<?php echo $uid ?>" />
	                <input type="hidden" name="Imagename2" value="<?php echo $Imagename ?>" />
	                <input type="submit" name="submit" value="Add Article" />
	            </td>
	        </tr>
	    	</table>
	    </form>
		<?php
    }

	function FAQform($secid, $secname, $uid, $option, $text_editor)
    {
    	?>
	    <form action="index.php" method="post" name="adminform">
	        <table cellpadding="5" cellspacing="0" border="0" width="100%" align="center">
	        <tr>
	            <td class="articlehead" colspan="5">Submit A FAQ</td>
	        </tr>
	        <tr>
	            <td width="100">Title:</td>
	            <td colspan="3">
                	<input type="text" name="faqtitle" size="70" value="<?php echo $title ?>">
                </td>
	        </tr>
	        <tr>
	            <td>Section:</td>
	            <td colspan="3">
	                <select name="faqsection">
	                        <option value="" selected="selected">select a Section</option>
	            	        <?php
                            for ($i = 0; $i < count($secid); $i++)
	                            echo "<option value=\"{$secid[$i]}\">{$secname[$i]}</option>\n";
		                    ?>
	                </select>
	            </td>
	        </tr>
	        <tr>
	            <td valign="top">Content:</td>
	            <td valign="top" colspan="3">
                	<textarea cols="70" rows="15" name="pagecontent"></textarea>
                </td>
	        </tr>
	        <?php
            if ($text_editor == true)
            {
            	?>
	            <tr>
	                <td>&nbsp;</td>
	                <td valign="top">
                    	<?php redirect("administrator/inline_editor/editor.htm?content=pagecontent", "Edit in Text Editor", 450, 650) ?>
                    </td>
	            </tr>
		        <?php
            }
            ?>
	        <tr>
	            <td colspan="5">
                	<input type="hidden" name="option" value="<?php echo $option ?>" />
	                <input type="hidden" name="op" value="SaveNewFAQ" />
	                <input type="hidden" name="uid" value="<?php echo $uid ?>" />
	                <input type="submit" name="submit" value="Add FAQ" />
	            </td>
	        </tr>
	        </table>
	    </form>
		<?php
    }

	function linkform($secid, $secname, $uid, $option)
    {
    	?>
	    <form action="index.php" method="post" name="NewLink">
	        <table cellpadding="5" cellspacing="0" border="0" width="100%" align="center">
	        <tr>
	            <td class="articlehead" colspan="5">Submit A Web link</td>
	        </tr>
	        <tr>
	            <td width="100">name:</td>
	            <td colspan="3"><input type="text" name="linktitle" SIZE="50" /></td>
	        </tr>
	        <tr>
	            <td>Section:</td>
	            <td colspan="3">
	                <select name="linksection">
	                        <option value="" selected="selected">select a Section</option>
		                    <?php
                            for ($i = 0; $i < count($secid); $i++)
	                            echo "<option value=\"{$secid[$i]}\">{$secname[$i]}</option>\n";
                            ?>
	                </select>
	            </td>
	        </tr>
	        <tr>
	            <td >URL:</td>
	            <td colspan="3"><input type=TEXT name="linkUrl" size="80" /></td>
	        </tr>
	        <tr>
	            <td colspan="5">
                	<input type="hidden" name="option" value="<?php echo $option ?>" />
	                <input type="hidden" name="op" value="SaveNewLink" />
	                <input type="hidden" name="uid" value="<?php echo $uid ?>" />
	                <input type="submit" name="submit" value="Add Link" />
	            </td>
	        </tr>
	        </table>
	    </form>
		<?php
    }

	function userEdit($uid, $name, $username, $email, $option, $result2, $shiplist, $bday)
    {
        ?>
	    <form action="index.php" method="post" name="EditUser">
	        <table cellpadding="5" cellspacing="0" border="0" width="100%" align="center">
	        <tr>
	            <td class="articlehead" colspan="2">Edit Your Details</td>
	        </tr>
	        <tr>
	            <td width="35%">Your name:</td>
	            <td><input type="text" name="name2" value="<?php echo $name ?>" /></td>
	        </tr>
	        <tr>
	            <td>Email:</td>
	            <td><input type="text" name="email2" value="<?php echo $email ?>" SIZE="35" /></td>
	        <tr>
	            <td>User name:</td>
	            <td><input type="text" name="username2" value="<?php echo $username ?>" /></td>
	        </tr>
	        <tr>
	            <td>Password:</td>
	            <td><input type="password" name="pass2" value="" /></td>
	        </tr>
	        <tr>
	            <td>Verify Password:</td>
	            <td><input type="password" name="verifyPass" /></td>
	        </tr>
	        <tr>
	            <td>Birthday (optional):</td>
	            <td>
	                <select name="bdaymon">
	                    <option value="00"<?php if ($bday['month'] == "00") echo " selected=\"selected\"" ?>>--</option>
	                    <option value="01"<?php if ($bday['month'] == "01") echo " selected=\"selected\"" ?>>January</option>
	                    <option value="02"<?php if ($bday['month'] == "02") echo " selected=\"selected\"" ?>>February</option>
	                    <option value="03"<?php if ($bday['month'] == "03") echo " selected=\"selected\"" ?>>March</option>
	                    <option value="04"<?php if ($bday['month'] == "04") echo " selected=\"selected\"" ?>>April</option>
	                    <option value="05"<?php if ($bday['month'] == "05") echo " selected=\"selected\"" ?>>May</option>
	                    <option value="06"<?php if ($bday['month'] == "06") echo " selected=\"selected\"" ?>>June</option>
	                    <option value="07"<?php if ($bday['month'] == "07") echo " selected=\"selected\"" ?>>July</option>
	                    <option value="08"<?php if ($bday['month'] == "08") echo " selected=\"selected\"" ?>>August</option>
	                    <option value="09"<?php if ($bday['month'] == "09") echo " selected=\"selected\"" ?>>September</option>
	                    <option value="10"<?php if ($bday['month'] == "10") echo " selected=\"selected\"" ?>>October</option>
	                    <option value="11"<?php if ($bday['month'] == "11") echo " selected=\"selected\"" ?>>November</option>
	                    <option value="12"<?php if ($bday['month'] == "12") echo " selected=\"selected\"" ?>>December</option>
	                </select>
	                <select name="bdayday">
	                    <option value="00"<?php if ($bday['day'] == "00") echo "selected=\"selected\"" ?>>--</option>
	                    <?php
	                    for ($i=1; $i<=31; $i++)
                        {
	                        if ($i < 10)
                            	$i = '0' . $i;
	                        echo "<option value=\"{$i}\"";
	                        if ($bday['day'] == "{$i}")
                            	echo "selected=\"selected\"";
	                        echo ">{$i}</option>\n";
	                    }
	                    ?>
	                </select>
	            </td>
	        </tr>

	        <tr>
	            <td valign="top">Your Characters:</td>
	            <td><?php echo $shiplist ?></td>
	        </tr>

	        <tr>
	            <td colspan="2">
                	<input type="hidden" name="uid" value="<?php echo $uid ?>" />
	                <input type="hidden" name="option" value="<?php echo $option ?>" />
	                <input type="hidden" name="op" value="saveUserEdit" />
	                <input type="submit" name="submit" value="Save Changes" />
	            </td>
	        </tr>
		    </table>
	    </form>
		<?php
    }

	function confirmation()
    {
    	?>
	    <table>
	        <tr>
	            <td class="articlehead">Submission Success!</td>
	        </tr>
	        <tr>
	            <td>
                	Your article has been successfully submitted to our administrators.
                	It will be reviewed before being published on the site.
                </td>
	        </tr>
	    </table>
		<?php
    }

	function frontpage()
    {
    	redirect("index.php?option=login");
    }
}
?>