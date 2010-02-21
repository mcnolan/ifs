<?php
	/**	
	 *	Mambo Site Server Open Source Edition Version 3.0.5
	 *	Dynamic portal server and Content managment engine
	 *	27-11-2002
 	 *
	 *	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left 
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 3.0.5
	 *	File Name: HTML_administrators.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/
	
	class HTML_administrators {
		function showadministrators($option, $uid, $name, $usertype){ ?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function isChecked(isitchecked){
					if (isitchecked == false){
						document.adminForm.boxchecked.value--;
						}
					else {
						document.adminForm.boxchecked.value++;
						}
					}
			//-->
			</SCRIPT>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD COLSPAN="2" CLASS="heading">Site Administrators</TD>
			</TR>
			<? 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($uid); $i++){
				if ($usertype[$i]!="superadministrator"){
					$type="";
				}else{
					$type="- super administrator";
				}?>
			<TR BGCOLOR="<? echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $uid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<TD WIDTH="100%"><? echo "$name[$i] $type"; ?></TD>
				<? if ($k == 1){
						$k = 0;
						}
				   else {
				   		$k++;
						}?>
				<?
				}?>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<? echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
		<?	}
		
		function editadministrator($option, $uid, $name, $email, $uname, $password, $usertype, $sendEmail){?>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="heading">Edit Administrator</TD>
			</TR>
			<TR>
				<TD COLSPAN=2>&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Name:</TD>
				<TD WIDTH='85%'><INPUT TYPE='text' NAME='realname' VALUE="<? echo $name; ?>" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Email:</TD>
				<TD WIDTH='85%'><INPUT TYPE='text' NAME='email' VALUE="<? echo $email; ?>" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Username:</TD>
				<TD WIDTH='85%'><INPUT TYPE='text' NAME='username' VALUE="<? echo $uname; ?>" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>New Password:</TD>
				<TD WIDTH='85%'><INPUT TYPE='password' NAME='npassword' VALUE="" SIZE='25'></TD>
			</TR>
			<TR>
				<TD WIDTH='150'>Verify Password:</TD>
				<TD WIDTH='85%'><INPUT TYPE='password' NAME='vpassword' VALUE="" SIZE='25'></TD>
			</TR>
			<? if ($usertype == "superadministrator"){?>
				<TR>
				<?if ($sendEmail==1){?>
					<TD COLSPAN=2><INPUT TYPE="checkbox" NAME="emailAdmin" VALUE="1" Checked>&nbsp;&nbsp;Receive Email Notification</TD>
				<?}else{?>
					<TD COLSPAN=2><INPUT TYPE="checkbox" NAME="emailAdmin" VALUE="1">&nbsp;&nbsp;Receive Email Notification</TD>
				<?}?>
				</TR>
				<TR>
					<TD COLSPAN="2"><B>** You are currently the Super Administrator **</B></TD>
				</TR>
			<?	}?>	
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
			<INPUT TYPE='hidden' NAME='puname' VALUE="<? echo $uname; ?>">
			<INPUT TYPE='hidden' NAME='ppassword' VALUE="<? echo $password; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
		<?	}
		
		function newadministrator($option){ ?>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="heading">Add New Administrator</TD>
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
			</TABLE>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='option' VALUE="<? echo $option; ?>">
			</FORM>
		<?	}
		}
?>
