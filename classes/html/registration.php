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
  * Comments: Display registration info
 ***/

class registration
{
    function lostPassForm($option)
    {
    	?>
		<table cellpadding="5" cellspacing="0" border="0" bgcolor="#000000" width="60%">
            <tr>
                <td valign="top" class="articlehead">Lost your Password?</td>
            </tr>
            <tr>
                <td>
                	<font size="2">No problem. Just type your User name and click on send button.<br />
                    You'll receive a Confirmation Code by Email, then return here and retype your
                    User name and your Code, after that you'll receive your new Password by Email.
                    <br />
                    <form action="index.php" method="post">
                        User name: <input type="text" name="checkusername" size="25" /><br />
                        Email Address: <input type="text" name="confirmEmail" size="35" />
                        <br /><br />
                        <input type="hidden" name="option" value="<?php echo $option ?>" />
                        <input type="hidden" name="task" value="sendNewPass" />
                        <input type="submit" value="Send Password" />
                    </form>
                </td>
            </tr>
        </table>
		<?php
    }

	function registerForm($option)
    {
        ?>

		<table cellpadding="5" cellspacing="0" border="0" bgcolor="#000000" width="60%">
            <tr>
                <td valign="top" colspan="2" class="articlehead">
                	Create an account
                </td>
            </tr>
            <tr>
                <td width="100"><form action="index.php" method="post">
                    Name:
                </td>
                <td><input type="text" name="yourname" /></td>
            </tr>
            <tr>
                <td>User Name:</td>
                <td><input type="text" name="username1" /></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" name="email" size="30" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="pass" size="15" /></td>
            </tr>
            <tr>
                <td>Verify Password:</td>
                <td><input type="password" name="verifyPass" size="15" /></td>
            </tr>
            <tr>
                <td colspan="2">
                	<input type="hidden" name="option" value="<?php echo $option ?>" />
                    <input type="hidden" name="task" value="saveRegistration" />
                    <input type="submit" value="Send Registration" />
                    </form>
                </td>
            </tr>
        </table>

        <?php
    }
}
?>