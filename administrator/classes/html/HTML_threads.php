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
	 *	File Name: HTML_threads.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class HTML_threads {
		function showThreadsList($option, $editor, $act, $forum, $ForumIdList, $ForumNameList){?>
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
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR>
					<TD COLSPAN="5" align=right>Select A Forum:&nbsp;&nbsp;
						<SELECT NAME="forum" onChange="document.location.href='index2.php?act=<?echo $act;?>&option=<?echo $option;?>&forum=' + this.options[selectedIndex].value">
							
							<?if ($forum=="all"){?>
								<OPTION VALUE="">Select Forum</OPTION>
								<OPTION VALUE="all" SELECTED>Select All</OPTION>
								<OPTION VALUE="new">Select NEW</OPTION>
							 <?}elseif ($forum == "new"){?>
							 	<OPTION VALUE="">Select Forum</OPTION>
								<OPTION VALUE="all">Select All</OPTION>
								<OPTION VALUE="new" SELECTED>Select NEW</OPTION>
							 <?}else{?>
							 	<OPTION VALUE="" SELECTED>Select Forum</OPTION>
								<OPTION VALUE="all" >Select All</OPTION>
								<OPTION VALUE="new">Select NEW</OPTION>
							 <?}
							   for ($i = 0; $i < count($ForumIdList); $i++){
									if ($forum == $ForumIdList[$i]){?>
										<OPTION VALUE="<? echo $ForumIdList[$i]; ?>" SELECTED><? echo $ForumNameList[$i]; ?></OPTION>
									<?}else {?>
										<OPTION VALUE="<? echo $ForumIdList[$i]; ?>"><? echo $ForumNameList[$i]; ?></OPTION>
									<?}
							   }?>
						</SELECT>
					</TD>
				</TR>
			
				<TR BGCOLOR="#999999">
					<?if (($forum=="all") || ($forum=="new")){?>
						<TD CLASS="heading" WIDTH="55%">Thread</TD>
						<TD CLASS="heading" WIDTH="15%">Forum</TD>
					<?}else{?>
						<TD CLASS="heading" WIDTH="70%">Thread</TD>
					<?}?>
						<TD ALIGN=CENTER WIDTH=10% CLASS="heading">Published</TD>
						<TD ALIGN=CENTER WIDTH=10% CLASS="heading">Archived</TD>
						<TD ALIGN="CENTER" WIDTH="10%" CLASS="heading">Checked Out</TD>
				</TR>
		<?}
		
	function echo_data($topic, $counter, $database, $forum){
		$checkint = ($counter) / 2;
		if (is_integer($checkint)){
			$colourchoice="#FFFFFF";
		}else{
			$colourchoice="#CCCCCC";
		}
		
		$subject = $topic["subject"];
    	$author = $topic["author"];
    	$datestamp = $topic["date"];
    	$timestamp = $topic["time"];
		$ID = $topic["id"];
		$forumid= $topic["forumid"];
		$replyid= $topic["replytoid"];
		$level= $topic["level"];
		$editor= $topic["editor"];
		$newMessage=$topic["newmessage"];
		$published=$topic["published"];
		$archived=$topic["archive"];
		
		if ($forum!="new"){
			if ($level==0){
				$subject="<B>".$subject."</B>";
			}elseif ($level==1){
				$spaces="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}elseif ($level > 0){
				$spaces="&nbsp;&nbsp;&nbsp;";
				for ($i=0; $i < $level; $i++){
					$spaces.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			}
		}else{
			$spaces="";
		}
		$spaces.="<INPUT TYPE='checkbox' NAME='cid[]' VALUE='$ID' onClick=\"isChecked(this.checked);\">";
		
		if ($newMessage==1){
			if ($colourchoice=="#FFFFFF"){
				$images="<IMG SRC=../images/admin/new_white.gif>";
			}else{
				$images="<IMG SRC=../images/admin/new_grey.gif>";
			}
		}?>
		
		<TR bgcolor=<?echo $colourchoice;?>>
			<?if (($forum=="all")|| ($forum=="new")){
				$query="select forumname from forum where id='$forumid'";
				$result=$database->openConnectionWithReturn($query);
				list ($forumname)=mysql_fetch_array($result);
				if ($newMessage == 1){?>
					<TD align=left width="70%"><?echo $spaces;?>&nbsp;<A HREF="index2.php?option=Forums&act=threads&task=edit&tid=<?echo $ID;?>&forum=<? echo $forum; ?>"><?echo $subject;?></A>&nbsp;&nbsp;<?echo $images;?></TD>
				<?}else {?>
					<TD align=left width="70%"><?echo $spaces;?>&nbsp;<?echo $subject;?>&nbsp;&nbsp;<?echo $images;?></TD>	
				<?}
				if ($level==0){?> 
					<TD WIDTH=15%><?echo $forumname;?></TD>
				<?}else{?>
					<TD WIDTH=15%>&nbsp;</TD>
				<?}
			}else{
				if ($newMessage == 1){?>
					<TD align=left width="70%"><?echo $spaces;?>&nbsp;<A HREF="index2.php?option=Forums&act=threads&task=edit&tid=<?echo $ID;?>&forum=<? echo $forum; ?>"><?echo $subject;?></A>&nbsp;&nbsp;<?echo $images;?></TD>
				<?}else {?>
					<TD align=left width="70%"><?echo $spaces;?>&nbsp;<?echo $subject;?>&nbsp;&nbsp;<?echo $images;?></TD>	
				<?}
			}
			
			if ($published==1){?>
				<TD width=10% align=center>
					<?if ($colourchoice=="#FFFFFF"){?>
						<IMG SRC="../images/admin/greytic.gif">
					<?}else{?>
						<IMG SRC="../images/admin/whttic.gif">
					<?}?>
				</TD>
			<?}else{?>
				<TD width=10% align=center>&nbsp;</TD>
			<?}
		
			if ($archived==1){?>
				<TD width=10% align=center>
					<?if ($colourchoice=="#FFFFFF"){?>
						<IMG SRC="../images/admin/greytic.gif">
					<?}else{?>
						<IMG SRC="../images/admin/whttic.gif">
					<?}?>
				</TD>
			<?}else{?>
				<TD width=10% align=center>&nbsp;</TD>
			<?}
			
			if ($editor!=""){?>
				<TD width="10%" align=center><?echo $editor;?></TD>
			<?}else{?>
				<TD width="10%" align=center>&nbsp;</TD>
			<?}?>
		</TR>
	<?}
	
	function endThreadsList($option, $editor, $act, $forum){?>
		<INPUT TYPE="hidden" NAME="forum" VALUE="<? echo $forum;?>">
		<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option;?>">
		<INPUT TYPE="hidden" NAME="task" VALUE="">
		<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
		<INPUT TYPE="hidden" NAME="act" VALUE="<? echo $act;?>">
		</FORM>
		</TABLE>
	<?}
	
			
		function editThread($forumid, $forumname, $tid, $author, $authorid, $subject, $date, $time, $replytoid, $level, $message, $option, $act, $forum, $replyauthor, $replyauthorid, $replysubject, $replydate, $replytime, $replyreplytoid, $replylevel, $replymessage, $replyforumid, $ForumIdList, $ForumNameList, $text_editor){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<?if ($replytoid==0){
					$type="Thread";
				}else{
					$type="Reply";
				}?>
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">Edit <?echo $type;?></TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<?if ($replytoid!=0){?>
				<TR>
					<TD colspan=2>
						<TABLE width=100%>
							<TR>
								<TD WIDTH=15%><B>Author:</B><?echo $replyauthor;?><BR>
											  <B>Date:</B><?echo $replydate;?><BR>
											  <B>Time:</B><?echo $replytime;?>
											  </TD>
								<TD Valign=top><B><?echo $replysubject;?></B><BR>
												<?echo $replymessage;?></TD>
							</TR>
							<TR>
								<TD WIDTH=15%>&nbsp;</TD>
								<TD valign=top></TD>
							</TR>
						</TABLE>	
					</TD>
				</TR>
				<TR>
					<TD COLSPAN="2"><HR></TD>
				</TR>
			<?}else{?>
				<TR>
					<TD WIDTH='100'>Forum: </TD>
					<TD><SELECT NAME="forumid">
							<OPTION VALUE="<?echo $forumid;?>" SELECTED><?echo $forumname;?></OPTION>
							<?for ($i=0; $i < count($ForumIdList); $i++){
								if ($ForumIdList[$i]!=$forumid){?>
									<OPTION VALUE="<?echo $ForumIdList[$i];?>"><?echo $ForumNameList[$i];?></OPTION>
								<?}
							}?>
						</SELECT>
					</TD>
				</TR>
			<?}?>
			<TR>
				<TD WIDTH="100">Title: </TD>
				<TD><INPUT TYPE="text" NAME="subject" SIZE="70" VALUE="<? echo $subject; ?>"></TD>
			</TR>
			<TR>
				<TD>Author: </TD>
				<TD><INPUT TYPE="text" NAME="Dispauthor" VALUE="<?echo $author;?>" DISABLED></TD>
			</TR>
			<TR>
				<TD>Submitted: </TD>
				<TD><?echo "$date $time";?></TD>
			</TR>
			<TR>
				<TD VALIGN="top">Message:</TD>
				<TD VALIGN="top"><TEXTAREA COLS="70" ROWS="15" NAME="content"><? echo htmlentities($message); ?></TEXTAREA></TD>
			</TR>
			<?if ($text_editor!=""){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm', 'win1', 'width=650,height=450,resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?}?>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="author" VALUE="<? echo $author;?>">
			<INPUT TYPE="hidden" NAME="tid" VALUE="<? echo $tid;?>">
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option;?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="forum" VALUE="<? echo $forum;?>">
			<INPUT TYPE="hidden" NAME="act" VALUE="<?echo $act;?>">
			<INPUT TYPE="hidden" NAME="origforumid" VALUE="<?echo $forumid;?>">
			<INPUT TYPE="hidden" NAME="replytoid" VALUE="<?echo $replytoid;?>">
			<INPUT TYPE="hidden" NAME="authorid" VALUE="<?echo $authorid;?>">
			<INPUT TYPE="hidden" NAME="replyauthorid" VALUE="<?echo $replyauthorid;?>">
			</FORM>
		<?	}
		
		function addThread($forumIDList, $forumNameList, $option, $act, $forum, $forumName, $myname, $text_editor){
		//function addThread($forumIDList, $forumNameList, $option, $act, $forum, $forumName, $myname, $text_editor, $adminid){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">Add New Thread</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD>Forum:</TD>
				<TD COLSPAN="3">
					<SELECT NAME="forumID">
						<? if (($forum!="") && ($forum!="all")){?>
								<OPTION VALUE=<?echo $forum;?> SELECTED><?echo $forumName;?></OPTION>
						   <?}
						   for ($i = 0; $i < count($forumIDList); $i++){
						   		if ($forum!=$forumIDList[$i]){?>
									<OPTION VALUE="<? echo $forumIDList[$i]; ?>"><? echo $forumNameList[$i]; ?></OPTION>
								<?}
							}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD WIDTH="100">Subject:</TD>
				<TD><INPUT TYPE="text" NAME="subject" SIZE="70"></TD>
			</TR>
			<TR>
				<TD>Author: </TD>
				<TD><INPUT TYPE="text" NAME="Dispauthor" VALUE="<?echo $myname;?>" DISABLED></TD>
			</TR>
			<TR>
				<TD VALIGN="top">Message:</TD>
				<TD VALIGN="top"><TEXTAREA COLS="70" ROWS="15" NAME="content"><?echo htmlentities($message);?></TEXTAREA></TD>
			</TR>
			<?if ($text_editor!=""){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm', 'win1', 'width=650,height=450,resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?}?>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="author" VALUE="<?echo $myname;?>">
			<INPUT TYPE="hidden" NAME="authorid" VALUE="<?echo$adminid;?>">
			<INPUT TYPE="hidden" NAME="option" VALUE="<?echo $option; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="forum" VALUE="<?echo $forum; ?>">
			<INPUT TYPE="hidden" NAME="act" VALUE="<?echo $act; ?>">
			</FORM>
		<?	}
	
	function newReply($option, $act, $forum, $myname, $newSubject, $repAuthor, $repSubject, $repDate, $repTime, $repMessage, $repForumID, $repArchive, $repPublished, $repID, $repLevel, $text_editor){
	//function newReply($option, $act, $forum, $myname, $newSubject, $repAuthor, $repAuthorid, $repSubject, $repDate, $repTime, $repMessage, $repForumID, $repArchive, $repPublished, $repID, $repLevel, $text_editor, $topMessageID){?>
		<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">Add Reply</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD colspan=2>
					<TABLE width=100%>
						<TR>
							<TD WIDTH=15%><B>Author:</B><?echo $repAuthor;?><BR>
										  <B>Date:</B><?echo $repDate;?><BR>
										  <B>Time:</B><?echo $repTime;?>
										  </TD>
							<TD Valign=top><B><?echo $repSubject;?></B><BR>
											<?echo $repMessage;?></TD>
						</TR>
						<TR>
							<TD WIDTH=15%>&nbsp;</TD>
							<TD valign=top></TD>
						</TR>
					</TABLE>	
				</TD>
			</TR>
			<TR>
				<TD COLSPAN="2"><HR></TD>
			</TR>
			<TR>
				<TD WIDTH="100">Subject: </TD>
				<TD><INPUT TYPE="text" NAME="subject" SIZE="70" VALUE="<?echo $newSubject; ?>"></TD>
			</TR>
			<TR>
				<TD>Author: </TD>
				<TD><INPUT TYPE="text" NAME="Dispauthor" VALUE="<?echo $myname;?>" DISABLED></TD>
			</TR>
			<TR>
				<TD VALIGN="top">Message:</TD>
				<TD VALIGN="top"><TEXTAREA COLS="70" ROWS="15" NAME="content"><?echo htmlentities($message);?></TEXTAREA></TD>
			</TR>
			<?if ($text_editor!=""){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm', 'win1', 'width=650,height=450,resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?}?>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="author" VALUE="<? echo $myname;?>">
			<INPUT TYPE="hidden" NAME="authorid" VALUE="<?echo $repAuthorid;?>">
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="forum" VALUE="<? echo $forum; ?>">
			<INPUT TYPE="hidden" NAME="act" VALUE="<? echo $act; ?>">
			<INPUT TYPE="hidden" NAME="published" VALUE="<?echo $repPublished;?>">
			<INPUT TYPE="hidden" NAME="archive" VALUE="<?echo $repArchive;?>">
			<INPUT TYPE="hidden" NAME="forumID" VALUE="<?echo $repForumID;?>">
			<INPUT TYPE="hidden" NAME="repLevel" VALUE="<?echo $repLevel;?>">
			<INPUT TYPE="hidden" NAME="repID" VALUE="<?echo $repID;?>">
			</FORM>
	<?}	
}?>
