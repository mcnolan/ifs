<?
	/**
	 *	Mambo Site Server Open Source Edition Version 4.0
	 *	Dynamic portal server and Content managment engine
	 *	17-11-2002
 	 *
	 *	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 4.0
	 *	File Name: HTML_users.php.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *				Emir Sakic - saka@hotmail.com
	 *	Date: 17/11/2002
	 * 	Version #: 4.0
	 *	Comments:
	**/

	class HTML_users {
		function showUsers($option, $uid, $name, $username, $email, $block, $count, $offset, $rows_per_page){ ?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<?echo $action;
				echo $pages;?>
				<TD COLSPAN="4" CLASS="heading" WIDTH="90%">Registered Users</TD>
				<TD WIDTH="10%" CLASS="heading" ALIGN="center">Blocked</TD>
			</TR>
			<?
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($uid); $i++){?>
			<TR BGCOLOR="<? echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $uid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<TD><? echo $name[$i]; ?></td>
				<TD><? echo $username[$i]; ?></td>
				<td><a href="mailto:<? echo "$email[$i]"; ?>"><? echo "$email[$i]"; ?></a></TD>
				<?	if ($block[$i] == "1"){
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
				<?		} else {?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
				<?			}
						}
					else {
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?		} else {?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?			}
						}
				 if ($k == 1){
						$k = 0;
						}
				   else {
				   		$k++;
						}?>
				<?
				}?>
			<TR BGCOLOR="#999999">
				<TD COLSPAN="5" ALIGN="center" CLASS="heading" WIDTH="100%"><?

				// By Emir Sakic <saka@hotmail.com>

				$pages_in_list = 10;				// set how many pages you want displayed in the menu

				// Calculate # of pages
				$pages = ceil($count / $rows_per_page);
				$from = ($offset-1) * $rows_per_page;

				$poffset = floor(($offset-1)/10);
				$from = $poffset*10;
				if (empty($prev)) $prev = 0;

				if ($poffset>0) {
					$prev = $poffset-1;
					$prev_offset = (($poffset-1)*10)+1;
					print "<a href=\"$PHP_SELF?option=Users&offset=1\" title=\"first list\"><b><<</b></a> \n";
					print "<a href=\"$PHP_SELF?option=Users&offset=$prev_offset\" title=\"previous list\"><b><</b></a> \n";
				}

				for ($i = $from+1; $i <= $from+$pages_in_list; $i++) {
					if (($i-1)<$pages) {
						$poffset = floor(($i-1)/10); //round down
						if ($i == $offset) {
							print "<b>$i</b> ";
						} else {
				    		print "<a href=\"$PHP_SELF?option=Users&offset=$i\" title=\"page $i\"><b>$i</b></a> ";
				    	}
				    }
				}

				if (($i-1)<$pages) {
					$next = $poffset+1;
					$next_offset = $i;
					print " <a href=\"$PHP_SELF?option=Users&offset=$next_offset\" title=\"next list\"><b>></b></a>\n";
					$max_poffset = floor($pages/$pages_in_list-0.1);
					$max_offset = $max_poffset*$pages_in_list + 1;
					print " <a href=\"$PHP_SELF?option=Users&offset=$max_offset\" title=\"final list\"><b>>></b></a>";
				}

				//Loop:
				$i = $count+($offset-1)*$rows_per_page;

				?></TD>
			</TR>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<? echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
		<?	}

		function edituser($option, $uid, $username, $name, $email, $block){?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="heading">Edit User</TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Name:</TD>
				<TD WIDTH='90%'><? echo $name; ?></TD>
			</TR>
			<TR>
				<TD>Username:</TD>
				<TD><? echo $username; ?></TD>
			<TR>
				<TD>Email:</TD>
				<TD><a href="mailto:<? echo $email; ?>"><? echo $email; ?></a></TD>
			</TR>
			<TR>
				<TD></TD>
			<? if ($block == 1){?>
					<TD><INPUT TYPE="checkbox" NAME="block" VALUE="true" CHECKED>Block User</TD>
			<?		}
			   else {?>
			   		<TD><INPUT TYPE="checkbox" NAME="block" VALUE="true">Block User</TD>
			<?		}?>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR BGCOLOR=#999999>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='option' VALUE="<? echo $option; ?>">
			<INPUT TYPE='hidden' NAME='uid' VALUE="<? echo $uid; ?>">
			<INPUT TYPE='hidden' NAME='pname' VALUE="<? echo $name; ?>">
			<INPUT TYPE='hidden' NAME='pemail' VALUE="<? echo $email; ?>">
			<INPUT TYPE='hidden' NAME='puname' VALUE="<? echo $username; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
		<?	}

		function newuser($option){ ?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="heading">Add New User</TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Name:</TD>
				<TD WIDTH='90%'><INPUT TYPE='text' NAME='realname' SIZE='25'></TD>
			</TR>
			<TR>
				<TD>Email:</TD>
				<TD><INPUT TYPE='text' NAME='email' SIZE='25'></TD>
			</TR>
			<TR>
				<TD>Username:</TD>
				<TD><INPUT TYPE='text' NAME='username' SIZE='25'></TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR BGCOLOR=#999999>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='option' VALUE="<? echo $option; ?>">
			</FORM>
		<?	}
		}
?>
