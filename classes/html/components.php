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
  * Date:	12/13/03
  * Comments: Left/right menu components
  *
  * See CHANGELOG for patch details
  *
 ***/

class components
{
    function component($title, $content)
    {
    	?>
        <table width="95%" border="0" cellspacing="0" cellpadding="1" align="center">
	        <tr>
	            <td width="160">
                	<span class="componentHeading">
                    	<?php echo $title ?>
                    </span><br />
                    <?php echo $content ?>
                </td>
	        </tr>
        </table>
        <br /><br />
        <?php
    }

    function survey($pollTitle, $optionText, $pollID, $voters, $title)
    {
    	?>
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
	        <tr>
	            <td colspan="2">
	                <form name="form2" method="post" action="pollBooth.php">
	                <p><span class="componentHeading"><?php echo $title ?></span><br /><br />
	                <span class="poll"><?php echo $pollTitle ?></span></p>
	            </td>
	        </tr>
	        <?php
            for ($i = 0; $i < count($optionText); $i++)
            {
            	?>
	            <tr>
	                <td valign="top"><input type="radio" name="voteID" value="<?php echo $voters[$i] ?>" /></td>
	                <td class="poll" valign="top"><?php echo $optionText[$i] ?></td>
	            </tr>
	            <?php
            }
            ?>
	        <tr>
	            <td colspan="2">
                	<div align="center"><br />
                        <input type="hidden" name="polls" value="<?php echo $pollID ?>" />
                        <input type="submit" name="task" value="Vote" /></form>&nbsp;&nbsp;
                        <form action="index.php?option=surveyresult&task=Results&polls=<?php echo $pollID ?>" method="post">
	                        <input type="submit" name="task" VALUE="Results" />
                        </form>
                    </div>
                </td>
	        </tr>
        </table>
        <br /><br />
	    <?php
    }

    function AuthorLogin($title, $option, $logintop)
    {
    	?>
        <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
	        <td><span class="componentHeading">
	            <?php
	            if ($logintop)
	                echo "<img src=\"{$logintop}\" />";
	            else
	                echo "Login";
	            ?>
	        <br/></span></td>
        </tr>
        <tr>
            <td>
            	<form action="usermenu.php" method="post" name="login">
	                Username<br /><input type="text" name="username" size="10" /> <br />
	                Password <br /><input type="password" name="passwd" size="10" /><br />
				    <?php /* <INPUT TYPE="checkbox" NAME="remember"> Remember Me<br> <br> */ ?>
	                <input type="hidden" name="op2" value="login" />
	                <input type="hidden" name="option" value="<?php echo $option ?>" />
	                <input type="submit" name="Submit" value="Login" />
                </form>
            </td>
        </tr>
        <tr>
            <td><a href="index.php?option=registration&task=lostPassword">Lost password</a>?</td>
        </tr>
        </table>
	    <br /><br />
	    <?php
    }
}
?>
