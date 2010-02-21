<?
	/**	
	 *	Mambo Site Server Open Source Edition Version 4.0.11
	 *	Dynamic portal server and Content managment engine
	 *	27-11-2002
 	 *
	 *	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left 
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 4.0.11
	 *	File Name: HTML_forum.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class HTML_forum {
		function showforum($fid, $fname, $count, $publish, $checkedout, $editor, $messagesNum, $option, $published, $archive){ ?>
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
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD WIDTH="20">&nbsp;</TD>
				<TD WIDTH="60%" CLASS="heading">Forum Name</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading"># of topics</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Published</TD>
				<TD WIDTH=10% ALIGN="center" CLASS="heading">Archived</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Checked Out</TD>
			</TR>
			<? 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($fid); $i++){?>
				<TR BGCOLOR="<? echo $color[$k]; ?>">
					<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $fid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
					<TD WIDTH="60%"><? echo $fname[$i]; ?></TD>
					<TD WIDTH="10%" ALIGN="center"><? echo $messagesNum[$i]; ?></TD>
					<?if ($published[$i] == 1){
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
						<?}else{?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
						<?}
					}else {
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?}else{?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?}
					}?>
					
					<?if ($archive[$i] == 1){
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
						<?}else{?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
						<?}
					}else {
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?}else{?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?}
					}?>
			
					<?if ($checkedout[$i] == 0){?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
					<?}else{?>
						<TD WIDTH="10%" ALIGN="center"><? echo $editor[$i]; ?></TD>
					<?}?>
			
					<?if ($k == 1){
						$k = 0;
					}else {
			   			$k++;
					}?>
				</TR>
			<?}?>
			
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="chosen" VALUE="">
			<INPUT TYPE="hidden" NAME="act" VALUE="<? echo $act; ?>">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
		<?}
		
		function newforum($option, $adminIdList, $adminNameList){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="3">Add New Forum</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="3">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH="100%">
					<TABLE WIDTH="60%" CELLPADDING="3" CELLSPACING="0" BORDER="0" >
						<TR>
							<TD HEIGHT="30" WIDTH="15%">Forum Name:</TD>
							<TD HEIGHT="30" WIDTH="85%"><INPUT TYPE="text" NAME="forumName" SIZE="25" STYLE="WIDTH: 230px" MAXLENGTH="25"></TD>
						</TR>
						<TR>
							<TD HEIGHT="30" COLSPAN="2">Description:
						</TR>
						<TR>
							<TD COLSPAN="2"><TEXTAREA COLS="60" ROWS="10" NAME="description" STYLE="WIDTH: 700px"><?echo htmlentities($description);?></TEXTAREA></TD>
						</TR>
						<TR>
							<TD COLSPAN="2">&nbsp;</TD>
						</TR>
						<TR>
							<TD COLSPAN="2">
								<TABLE CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
									<TR>
										<TD><B>Moderation Options:</B></TD>
									</TR>
									<TR>
										<TD>Moderator:&nbsp;&nbsp; <SELECT NAME="moderatorID">
											<?for ($i=0; $i < count($adminIdList); $i++){?>
												 <OPTION VALUE="<?echo $adminIdList[$i];?>"><?echo $adminNameList[$i];?></OPTION>
											<?}?>
											</SELECT>	
										</TD>
									</TR>
									<TR>
										<TD><INPUT TYPE="checkbox" NAME="emailModerator" VALUE="1" Checked>&nbsp;&nbsp;Receive Email Notification</TD>
									</TR>
									<TR>
										<TD><INPUT TYPE="radio" NAME="moderate" VALUE="nothing">Do Not Moderate Anything &nbsp;&nbsp;
											<INPUT TYPE="radio" NAME="moderate" VALUE="TOPICS">Moderate Topics Only &nbsp;&nbsp;&nbsp;
											<INPUT TYPE="radio" NAME="moderate" VALUE="TOPICSREPLIES" CHECKED>Moderate Topics And Replies &nbsp;
										</TD>
									</TR>
									<TR>
										<TD><INPUT TYPE="checkbox" NAME="language" VALUE="1" CHECKED>Do Not Allow Offensive Language</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD COLSPAN="2">&nbsp;</TD>
						</TR>
						<TR>
							<TD COLSPAN="2"><!--<INPUT TYPE="button" NAME="send" VALUE="Create Forum" onClick="adminAddValidate();">&nbsp;&nbsp;
											<INPUT TYPE="button" NAME="cancel" VALUE="cancel" onClick="window.history.back()">-->
											<INPUT TYPE="hidden" NAME="actions" VALUE="add">
						</TR>
					</TABLE>
				</TD>
			</TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			</FORM>
		<?}

		function editforum($option, $forumName, $description, $moderateTopic, $moderateTopicReply, $moderateNothing, $uid, $language, $moderatorID, $moderatorName, $adminIdList, $adminNameList, $emailModerator){ ?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="3">Edit Forum</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="3">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH="100">Forum Name:</TD>
				<TD WIDTH="90%"><INPUT TYPE="text" NAME="forumName" VALUE="<? echo $forumName;?>" SIZE="25"></TD>
			</TR>
			<!--print "\t\t\t<FORM ACTION='editForum.php' METHOD='POST' NAME='edit'>\n";-->
			<TR>
				<TD HEIGHT="30' COLSPAN="2">Description:</TD>
			</TR>
			<TR>
				<TD COLSPAN="2"><TEXTAREA COLS="60" ROWS="10" NAME="description" STYLE="WIDTH: 700px"><?echo htmlentities($description);?></TEXTAREA>
				</TD>
			</TR>
			<TR>
				<TD COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD COLSPAN="2">
					<TABLE CELLPADDING="3" CELLSPACING="0" WIDTH="100%">
						<TR>
							<TD><B>Moderation Options:</B></TD>
						</TR>
						<TR>
							<TD>Moderator: &nbsp;&nbsp;
								<SELECT NAME="moderatorID">
									<OPTION VALUE="<?echo $moderatorID;?>" SELECTED><?echo $moderatorName;?></OPTION>
									<?for ($i=0; $i < count($adminIdList); $i++){
										if ($adminIdList!=$moderatorID){?>
											 <OPTION VALUE="<?echo $adminIdList[$i];?>"><?echo $adminNameList[$i];?></OPTION>
										<?}
									}?>
								</SELECT>	
							</TD>
						</TR>
						<TR>
							<?if ($emailModerator==1){?>
								<TD COLSPAN=2><INPUT TYPE="checkbox" NAME="emailModerator" VALUE="1" Checked>&nbsp;&nbsp;Receive Email Notification</TD>
							<?}else{?>
								<TD COLSPAN=2><INPUT TYPE="checkbox" NAME="emailModerator" VALUE="1">&nbsp;&nbsp;Receive Email Notification</TD>
							<?}?>
						</TR>
						<TR>
							<TD><?if ($moderateNothing==1){?>
									<INPUT TYPE="radio" NAME="moderate" VALUE="nothing" CHECKED>Do Not Moderate Anything &nbsp;&nbsp;
								<?}else{?>
									<INPUT TYPE="radio" NAME="moderate" VALUE="nothing">Do Not Moderate Anything &nbsp;&nbsp;
								<?}
								
								if ($moderateTopic==1){?>
									<INPUT TYPE="radio" NAME="moderate" VALUE="TOPICS" CHECKED>Moderate Topics Only  &nbsp;&nbsp;&nbsp;
								<?}else{?>
									<INPUT TYPE="radio" NAME="moderate" VALUE="TOPICS">Moderate Topics Only  &nbsp;&nbsp;&nbsp;
								<?}
								
								if ($moderateTopicReply== 1){?>
									<INPUT TYPE="radio" NAME="moderate" VALUE="TOPICSREPLIES" CHECKED>Moderate Topics And Replies &nbsp;
								<?}else{?>
									<INPUT TYPE="radio" NAME="moderate" VALUE="TOPICSREPLIES">Moderate Topics And Replies &nbsp;
								<?}?>
							</TD>
						</TR>
						<TR>
							<?if ($language==0){?>
								<TD><INPUT TYPE="checkbox" NAME="language" VALUE="1">Do Not Allow Offensive Language</TD>
							<?}else{?>
								<TD><INPUT TYPE="checkbox" NAME="language" VALUE="1" CHECKED>Do Not Allow Offensive Language</TD>
							<?}?>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD COLSPAN="2">&nbsp;</TD>
			</TR>
		</TABLE>
		<INPUT TYPE="hidden" NAME="task" VALUE="">
		<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option;?>">
		<INPUT TYPE="hidden" NAME="uid" VALUE="<? echo $uid;?>">
		</FORM>
	<?}
	}
?>
