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
	 *	File Name: forum.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class forum{
		function showforum($database, $option, $forumhtml, $act){
			$query = "SELECT  id, forumname, published, archive, editor, checked_out FROM forum ORDER BY forumname";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$fid[$i] = $row->id;
				$fname[$i] = $row->forumname;
				$published[$i] = $row->published;
				$archive[$i] =$row->archive;
				$checkedout[$i]=$row->checked_out;
				$editor[$i]=$row->editor;
				
				$query2 = "SELECT COUNT(forumid) AS numofmessages FROM messages WHERE forumid=$fid[$i] AND replytoid=0 AND usertype='$usertype'";
				$result2 = $database->openConnectionWithReturn($query2);
				$row2 = mysql_fetch_object($result2);
				$messagesNum[$i] = $row2->numofmessages;
				$i++;
			}
			mysql_free_result($result);
			
			$forumhtml->showforum($fid, $fname, $count, $publish, $checkedout, $editor, $messagesNum, $option, $published, $archive);
		}
		
		function newforum($database, $option, $act, $forumhtml){
			$query="select id, name from users where usertype='administrator' OR usertype='superadministrator'";
			$result=$database->openConnectionWithReturn($query);
			$i=0;
			while ($row=mysql_fetch_object($result)){
				$adminIdList[$i]=$row->id;
				$adminNameList[$i]=$row->name;
				$i++;
			}
			$forumhtml->newforum($option, $adminIdList, $adminNameList);
		}
		
		function savenewforum($option, $database, $forumName, $description, $moderate, $language, $moderatorID, $emailModerator){
			$query = "SELECT id FROM forum WHERE forumname='$forumName'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				print "<SCRIPT>alert('There is already a forum with that name, please try again!'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
			}else{
				if ($moderate == "TOPICS"){
					$moderateTopics = 1;
					$moderateTopicsReplies = 0;
					$moderateNothing = 0;
				}elseif ($moderate == "TOPICSREPLIES") {
					$moderateTopics = 0;
					$moderateTopicsReplies = 1;
					$moderateNothing = 0;
				}else {
					$moderateTopics = 0;
					$moderateTopicsReplies = 0;
					$moderateNothing = 1;
				}
				
				if ($emailModerator==""){
					$emailModerator=0;
				}
				
				$query = "INSERT INTO forum SET forumname='$forumName', description='$description', moderate_topics='$moderateTopics', moderate_top_rep='$moderateTopicsReplies', moderatorid='$moderatorID', language='$language', moderate_nothing='$moderateNothing', emailModerator='$emailModerator'";
				$database->openConnectionNoReturn($query);
				print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
			}
		}
		
		
		function editforum($forumhtml, $database, $option, $uid, $act, $myname){
			$query = "SELECT forumname, description, moderate_topics, moderate_top_rep, moderate_nothing, moderatorid, language, checked_out, editor, emailModerator FROM forum WHERE id='$uid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$forumName = $row->forumname;
				$description = $row->description;
				$moderateTopic = $row->moderate_topics;
				$moderateTopicReply = $row->moderate_top_rep;
				$moderateNothing = $row->moderate_nothing; 
				$language = $row->language;
				$editor = $row->editor;
				$moderatorID=$row->moderatorid;
				$emailModerator=$row->emailModerator;
			}
			$query="select name from users where id='$moderatorID'";
			$result=$database->openConnectionWithReturn($query);
			list($moderatorName)=mysql_fetch_array($result);
			
			$query="select id, name from users where usertype='administrator' OR usertype='superadministrator'";
			$result=$database->openConnectionWithReturn($query);
			$i=0;
			while ($row=mysql_fetch_object($result)){
				$adminIdList[$i]=$row->id;
				$adminNameList[$i]=$row->name;
				$i++;
			}
						
			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The category $title is currently being edited by another administrator'); document.location.href='index2.php?option=$option&act=categories'</SCRIPT>\n";
				exit();
				} 
			
			$date = date("H:i:s");
			$query = "UPDATE forum SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE id='$uid'";
			$database->openConnectionNoReturn($query);
			mysql_free_result($result);
			
			$forumhtml->editforum($option, $forumName, $description, $moderateTopic, $moderateTopicReply, $moderateNothing, $uid, $language, $moderatorID, $moderatorName, $adminIdList, $adminNameList, $emailModerator);
		}
			
		function saveforum($forumhtml, $database, $option, $forumName, $description, $moderate, $language, $uid, $moderatorID, $emailModerator){
			$query = "SELECT id FROM forum WHERE forumname='$forumName' AND id!='$uid'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				print "<SCRIPT>alert('There is already a forum with that name, please try again!'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
			}else{
				
				if ($moderate == "TOPICS"){
					$moderateTopics = 1;
					$moderateTopicsReplies = 0;
					$moderateNothing = 0;
				}elseif ($moderate == "TOPICSREPLIES") {
					$moderateTopics = 0;
					$moderateTopicsReplies = 1;
					$moderateNothing = 0;
				}else {
					$moderateTopics = 0;
					$moderateTopicsReplies = 0;
					$moderateNothing = 1;
				}
				
				if ($emailModerator==""){
					$emailModerator=0;
				}
				
				$query = "UPDATE forum SET forumname='$forumName', description='$description', moderate_topics='$moderateTopics', moderate_top_rep='$moderateTopicsReplies', moderate_nothing='$moderateNothing', moderatorid='$moderatorID', language='$language', checked_out=0, checked_out_time = '00:00:00', editor=NULL, emailModerator='$emailModerator' WHERE id='$uid'";
				$database->openConnectionNoReturn($query);
				print "<SCRIPT>document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$uid'</SCRIPT>\n";
			}
		}
			
		function removeforum($database, $option, $cid){
			for ($i = 0; $i < count($cid); $i++){
				$query="DELETE FROM messages WHERE forumid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				$query = "DELETE FROM forum WHERE id='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
		}
			
		function publishforum($option, $database, $uid, $cid, $image, $categoryname, $position){
			if (count($cid) > 0){
				$count = count($cid);
				for ($i = 0; $i < $count; $i++){
					$query = "SELECT checked_out FROM forum WHERE id='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
					}
							
					if ($checked == 1){
						print "<SCRIPT>alert('This forum cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
					}
							
					$query = "UPDATE forum SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE id='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}elseif (isset($uid)){
					$query = "UPDATE forum SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE id='$uid'";
					$database->openConnectionNoReturn($query);
			}else {
				print "<SCRIPT> alert('Select a forum to publish'); window.history.go(-1);</SCRIPT>\n";
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
		}
			
		function unpublishforum($option, $database, $uid, $cid){
			if (count($cid) > 0){
				$query = "SELECT checked_out FROM forum WHERE id='$cid[0]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
				}
					
				if ($checked == 1){
					print "<SCRIPT>alert('This forum cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
					exit(0);
				}
					
				for ($i = 0; $i < count($cid); $i++){
					$query = "UPDATE forum SET published='0' WHERE id='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}elseif (isset($uid)){
				$query = "UPDATE forum SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE id='$uid'";
				$database->openConnectionNoReturn($query);
			}else {
				print "<SCRIPT> alert('Select a forum to unpublish'); window.history.go(-1);</SCRIPT>\n";
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
		}
		
		function archiveForum($database, $option, $cid){
			for ($i = 0; $i < count($cid); $i++){
				$query="update messages set archive=1 WHERE forumid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				$query="update forum set archive=1 WHERE id='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
		}
		
		function unarchiveForum($database, $option, $cid){
			for ($i = 0; $i < count($cid); $i++){
				$query="update messages set archive=0 WHERE forumid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				$query="update forum set archive=0 WHERE id='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
		}
		
		
}?>
			