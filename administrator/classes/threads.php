<?
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
	 *	File Name: threads.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/

class threads {
	function showthreads($option, $threadshtml, $database, $forum, $act, $mpre){

		$query1="select id, forumname from " . $mpre . "forum";
		$result1=$database->openConnectionWithReturn($query1);
		$i=0;
		while (list($forumid, $forumname)=mysql_fetch_array($result1)){
			$ForumIdList[$i]=$forumid;
			$ForumNameList[$i]=$forumname;
			$i++;
		}

		if ($forum!=""){
			if ($forum=="all"){
				$query="SELECT id, replytoid, subject, message, forumid, level, newmessage, editor, published, archive FROM " . $mpre . "messages ORDER BY forumid, id";
			}elseif ($forum=="new"){
				$query="SELECT id, replytoid, subject, message, forumid, level, newmessage, editor, published, archive FROM " . $mpre . "messages WHERE newmessage=1 ORDER BY forumid, id";
			}else{
				$query="SELECT id, replytoid, subject, message, forumid, level, newmessage, editor, published, archive FROM " . $mpre . "messages WHERE forumid='$forum' ORDER BY id";
			}

			if ($forum!="new"){
				$result=$database->openConnectionWithReturn($query);
				$num=mysql_num_rows($result);
  				$rec=mysql_fetch_array($result);

				while(is_array($rec)){
					$REPLYTOID=$rec["replytoid"];
					$headers[]=$rec;
					$threads[]=$rec;
					$rec=mysql_fetch_array($result);
				}

				@reset($headers);
				$row=@current($headers);

				if(is_array($row)){
					if(!$read){
    					reset($threads);
	     				$rec=current($threads);
					}else{
				  		$threadtotal[$thread]=count($headers);
    				}

		   			while(is_array($row)){
						$x="".$row["id"]."";
	    	  			$p="".$row["replytoid"]."";
						//puts the values of each record into an array
						$messages["$x"]=$row;
						$messages["$p"]["replies"]["$x"]="$x";
						$row=next($headers);
			   		}
		 		}
				$threadshtml->showThreadsList($option, $editor, $act, $forum, $ForumIdList, $ForumNameList);
				if ($counter!=0){
					$counter=0;
				}
				$this->arrange_thread(0, $threadshtml, $messages, $counter, $database, $forum, $mpre);
	  		}else{
				$threadshtml->showThreadsList($option, $editor, $act, $forum, $ForumIdList, $ForumNameList);
				$result=$database->openConnectionWithReturn($query);
				$num=mysql_num_rows($result);
				$counter=0;
  				while ($topic=mysql_fetch_array($result)){
					$displayType="new";
					$threadshtml->echo_data($topic, $counter, $database, $forum, $mpre);
					$counter++;
				}
			}
		}else{
			$threadshtml->showThreadsList($option, $editor, $act, $forum, $ForumIdList, $ForumNameList);
		}
		$threadshtml->endThreadsList($option, $editor, $act, $forum);
	}

	function arrange_thread($seed=0, $threadshtml, $messages, $counter, $database, $forum, $mpre){
 		GLOBAL $counter;
		if($seed!="0"){
			$threadshtml->echo_data($messages[$seed], $counter, $database, $forum, $mpre);
			$counter++;
    	}//end of: if($seed!="0")

		$test=$messages[$seed]["replies"];
		if(@is_array($messages[$seed]["replies"])){
			$count=count($messages[$seed]["replies"]);

			for($x=1;$x<=$count;$x++){
				$key=key($messages[$seed]["replies"]);
				$this->arrange_thread($key, $threadshtml, $messages, $counter, $database, $forum, $mpre);
				next($messages[$seed]["replies"]);
      		}
    	}
 	}

	function editThread($threadshtml, $database, $option, $tid, $myname, $forum, $act, $text_editor, $mpre){
		$query = "SELECT subject, replytoid, checked_out, editor FROM " . $mpre . "messages WHERE id='$tid'";
		$result = $database->openConnectionWithReturn($query);

		while ($row = mysql_fetch_object($result)){
			$checked = $row->checked_out;
			$title = $row->subject;
			$editor = $row->editor;
		}

		$stringcmp = strcmp($editor,$myname);
		if (($checked == 1) && ($stringcmp <> 0)){
			print "<SCRIPT>alert('The message $title is currently being edited by $editor'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
			exit(0);
		}

		$date = date("H:i:s");
		$query = "UPDATE " . $mpre . "messages SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE id='$tid'";
		$database->openConnectionNoReturn($query);

		$query="select id, forumname from " . $mpre . "forum";
		$result=$database->openConnectionWithReturn($query);
		$i=0;
		while (list($forumid, $forumname)=mysql_fetch_array($result)){
			$ForumIdList[$i]=$forumid;
			$ForumNameList[$i]=$forumname;
			$i++;
		}

		/*$query="SELECT messages.author, messages.subject, messages.date, messages.time, messages.replytoid, messages.level, messages.message, messages.forumid, forum.forumname, users.username
			FROM messages, forum, users WHERE messages.forumid=forum.id AND messages.author=users.id AND messages.id='$tid'";
		$result=$database->openConnectionWithReturn($query);
		list($authorid, $subject, $date, $time, $replytoid, $level, $message, $forumid, $forumname, $author)=mysql_fetch_array($result);

		$query="SELECT messages.author, messages.subject, messages.date, messages.time, messages.replytoid, messages.level, messages.message, messages.forumid, users.username
		FROM messages, users WHERE messages.author=users.id AND messages.id='$replytoid'";
		$result=$database->openConnectionWithReturn($query);
		list($replyauthorid, $replysubject, $replydate, $replytime, $replyreplytoid, $replylevel, $replymessage, $replyforumid, $replyauthor)=mysql_fetch_array($result);*/

		$query="SELECT " . $mpre . "messages.author, " . $mpre . "messages.subject, " . $mpre . "messages.date, " . $mpre . "messages.time, " . $mpre . "messages.replytoid, " . $mpre . "messages.level, " . $mpre . "messages.message, " . $mpre . "messages.forumid, " . $mpre . "forum.forumname FROM " . $mpre . "messages, " . $mpre . "forum WHERE " . $mpre . "messages.forumid=" . $mpre . "forum.id AND " . $mpre . "messages.id='$tid'";
		$result=$database->openConnectionWithReturn($query);
		list($author, $subject, $date, $time, $replytoid, $level, $message, $forumid, $forumname)=mysql_fetch_array($result);

		$query="SELECT author, subject, date, time, replytoid, level, message, forumid FROM " . $mpre . "messages WHERE id='$replytoid'";
		$result=$database->openConnectionWithReturn($query);
		list($replyauthor, $replysubject, $replydate, $replytime, $replyreplytoid, $replylevel, $replymessage, $replyforumid)=mysql_fetch_array($result);


		$threadshtml->editThread($forumid, $forumname, $tid, $author, $authorid, $subject, $date, $time, $replytoid, $level, $message, $option, $act, $forum, $replyauthor, $replyauthorid, $replysubject, $replydate, $replytime, $replyreplytoid, $replylevel, $replymessage, $replyforumid, $ForumIdList, $ForumNameList, $text_editor);
	}

	function saveEditThread($database, $option, $subject, $tid, $message, $author, $act, $forum, $myname, $replytoid, $forumid, $origforumid, $authorid, $replyauthorid, $mpre){
		if (($forumid!=$origforumid) && ($replytoid==0)){
			$query="select id from " . $mpre . "messages where replytoid='$tid'";
			$result=$database->openConnectionWithReturn($query);
			$i=0;
			$changeArray[$i]=$tid;
			while (list($id)=mysql_fetch_array($result)){
				$i++;
				$changeArray[$i]=$id;
				$stillitems=1;
				while ($stillitems==1){
					if ($counter > 1){
						for ($b=0; $b < $counter; $b++){
							$c=$i-$b;
							$query1="select id from " . $mpre . "messages where replytoid='$changeArray[$c]'";
							$result1=$database->openConnectionWithReturn($query1);
							if (mysql_num_rows($result1)==0){
								$stillitems=0;
							}else{
								$stillitems=1;
								$counter=0;
								while (list($id1)=mysql_fetch_array($result1)){
									$i++;
									$changeArray[$i]=$id1;
									$counter++;
								}
							}
						}
					}else{
						$query1="select id from " . $mpre . "messages where replytoid='$changeArray[$i]'";
						$result1=$database->openConnectionWithReturn($query1);
						if (mysql_num_rows($result1)==0){
							$stillitems=0;
						}else{
							$stillitems=1;
							$counter=0;
							while (list($id1)=mysql_fetch_array($result1)){
								$i++;
								$changeArray[$i]=$id1;
								$counter++;
							}
						}
					}
				}
			}
			$displayCounter=count($changeArray);
			for ($a=$displayCounter-1; $a >= 0; $a--){
				$query="UPDATE " . $mpre . "messages SET forumid='$forumid' WHERE id='$changeArray[$a]'";
				$database->openConnectionNoReturn($query);
			}
		}

		$query = "UPDATE " . $mpre . "messages SET subject='$subject', message='$message', author='$author', checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE id='$tid'";
		$database->openConnectionNoReturn($query);

		print "<SCRIPT>document.location.href='index2.php?option=$option&forum=$forum&act=$act&task=edit&cid%5B%5D=$tid'</SCRIPT>\n";
	}

		function addThread($database, $option, $act, $threadshtml, $forum, $myname, $text_editor, $adminid, $mpre){
			if ($forum!=""){
				$query="select forumname from " . $mpre . "forum where id='$forum'";
				$result=$database->openConnectionWithReturn($query);
				list ($forumName)=mysql_fetch_array($result);
			}
			$query = "SELECT forumname, id FROM " . $mpre . "forum WHERE published=1 AND archive=0";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$forumIDList[$i] = $row->id;
				$forumNameList[$i] = $row->forumname;
				$i++;
			}

			$threadshtml->addThread($forumIDList, $forumNameList, $option, $act, $forum, $forumName, $myname, $text_editor, $adminid);
		}

		function savenewThread($database, $option, $act, $forum, $subject, $message, $forumID, $author, $authorid, $mpre){
			$date=date("Y-m-d");
			$time = strftime ("%r");
			$query = "INSERT INTO " . $mpre . "messages SET subject='$subject', message='$message', forumid='$forumID', date='$date', time='$time', level=0, published=0, author='$author'";
			$database->openConnectionNoReturn($query);

			print "<SCRIPT>document.location.href='index2.php?option=$option&act=$act&forum=$forum'</SCRIPT>\n";
		}

		function removeThread($database, $option, $cid, $forum, $act, $mpre){
			for ($d = 0; $d < count($cid); $d++){
				$query="select id from " . $mpre . "messages where replytoid='$cid[$d]'";
				$result=$database->openConnectionWithReturn($query);
				$i=0;
				$deleteArray[$i]=$cid[$d];
				while (list($id)=mysql_fetch_array($result)){
					$i++;
					$deleteArray[$i]=$id;
					$stillitems=1;
					while ($stillitems==1){
						if ($counter > 1){
							for ($b=0; $b < $counter; $b++){
								$c=$i-$b;
								$query1="select id from messages where replytoid='$deleteArray[$c]'";
								$result1=$database->openConnectionWithReturn($query1);
								if (mysql_num_rows($result1)==0){
									$stillitems=0;
								}else{
									$stillitems=1;
									$counter=0;
									while (list($id1)=mysql_fetch_array($result1)){
										$i++;
										$deleteArray[$i]=$id1;
										$counter++;
									}
								}
							}
						}else{
							$query1="select id from messages where replytoid='$deleteArray[$i]'";
							$result1=$database->openConnectionWithReturn($query1);
							if (mysql_num_rows($result1)==0){
								$stillitems=0;
							}else{
								$stillitems=1;
								$counter=0;
								while (list($id1)=mysql_fetch_array($result1)){
									$i++;
									$deleteArray[$i]=$id1;
									$counter++;
								}
							}
						}
					}
				}
				$displayCounter=count($deleteArray);
				for ($a=$displayCounter-1; $a >= 0; $a--){
					$query="delete from messages where id='$deleteArray[$a]'";
					$database->openConnectionNoReturn($query);
				}
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option&forum=$forum&act=$act'</SCRIPT>\n";
		}

		function publishThread($database, $option, $cid, $tid, $myname, $forum, $act, $live_site){
			if (count($cid) > 0){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT checked_out FROM messages WHERE id='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
					}

					if ($checked == 1){
						print "<SCRIPT>alert('This message cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&forum=$forum&act=$act';</SCRIPT>\n";
						exit(0);
					}

					//check to see if the message is a reply, and if so send an email to the original message author to inform them
					//that the reply has been posted
					$query = "SELECT replytoid, subject, forumid FROM messages WHERE id='$cid[$i]'";
					$result=$database->openConnectionWithReturn($query);
					list($replytoid, $subject, $forumid)=mysql_fetch_array($result);

					$query="SELECT forumname FROM forum WHERE id='$forumid'";
					$result=$database->openConnectionWithReturn($query);
					list($forumName)=mysql_fetch_array($result);

					if ((trim($replytoid)=="") || ($replytoid!=0)){
						$query2="SELECT messages.author, users.name, users.email, messages.published, messages.archive, messages.newmessage FROM messages, users WHERE messages.author=users.id AND messages.id='$replytoid'";
						$result2=$database->openConnectionWithReturn($query2);
						list($origUserId, $origUserName, $origUserEmail, $published, $archived, $newmessage)=mysql_fetch_array($result2);
						if (($origUserId!="") && ($published==1) && ($archived==0) && ($newmessage==0)){
							$date = date("Y-m-d");
							$time = strftime ("%T");	//24hr format
							$message = "Hi $origUserName,\n\n";
							$message.="A new reply '$subject' has been posted by '$myname' to your message in the '$forumName' forum at $time $date\n\n";
							$message.="Please go to $live_site and check the response.\n\n";

							$message.="This is an auto-generated email for information purposes only. Please do not reply to this email.\n";
							$recipient = $origUserEmail;
							$subject = "Reply Posted To Your Message";
							$headers .= "From: Forum\n";
							$headers .= "X-Mailer: PHP\n"; // mailer
							mail($recipient, $subject, $message, $headers);
						}
					}

					$query = "UPDATE messages SET published='1', newmessage=0, editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE id='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}elseif (isset($tid)){
				$query = "SELECT checked_out, editor FROM messages WHERE id='$tid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$editor = $row->editor;
				}

				if (($checked == 1) && ($myname <> $editor)){
					print "<SCRIPT>alert('This message cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&forum=$forum&act=$act';</SCRIPT>\n";
					exit(0);
				}

				//check to see if the message is a reply, and if so send an email to the original message author to inform them
				//that the reply has been posted
				$query = "SELECT replytoid, subject, forumid FROM messages WHERE id='$tid'";
				$result=$database->openConnectionWithReturn($query);
				list($replytoid, $subject, $forumid)=mysql_fetch_array($result);

				$query="SELECT forumname FROM forum WHERE id='$forumid'";
				$result=$database->openConnectionWithReturn($query);
				list($forumName)=mysql_fetch_array($result);

				if ((trim($replytoid)=="") || ($replytoid!=0)){
					$query2="SELECT messages.author, users.name, users.email, messages.published, messages.archive, messages.newmessage FROM messages, users WHERE messages.author=users.id AND messages.id='$replytoid'";
					$result2=$database->openConnectionWithReturn($query2);
					list($origUserId, $origUserName, $origUserEmail, $published, $archived, $newmessage)=mysql_fetch_array($result2);
					if (($origUserId!="") && ($published==1) && ($archived==0) && ($newmessage==0)){
						$date = date("Y-m-d");
						$time = strftime ("%T");	//24hr format
						$message = "Hi $origUserName,\n\n";
						$message.="A new reply '$subject' has been posted by '$myname' to your message in the '$forumName' forum at $time $date\n\n";
						$message.="Please go to $live_site and check the response.\n\n";

						$message.="This is an auto-generated email for information purposes only. Please do not reply to this email.\n";
						$recipient = $origUserEmail;
						$subject = "Reply Posted To Your Message";
						$headers .= "From: Forum\n";
						$headers .= "X-Mailer: PHP\n"; // mailer
						mail($recipient, $subject, $message, $headers);
					}
				}

				$query = "UPDATE messages SET published='1',  newmessage=0, editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE id='$tid'";
				$database->openConnectionNoReturn($query);
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option&act=$act&forum=$forum';</SCRIPT>\n";
		}

		function unpublishThread($database, $option, $cid, $tid, $myname, $forum, $act){
			if (count($cid) > 0){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT checked_out FROM messages WHERE id='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
					}

					if ($checked == 1){
						print "<SCRIPT>alert('This message cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&forum=$forum&act=$act';</SCRIPT>\n";
						exit(0);
					}

					$query = "UPDATE messages SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE id='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}elseif (isset($tid)){
				$query = "SELECT checked_out, editor FROM messages WHERE id='$tid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$editor = $row->editor;
				}

				if (($checked == 1) && ($myname <> $editor)){
					print "<SCRIPT>alert('This message cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&forum=$forum&act=$act';</SCRIPT>\n";
					exit(0);
				}

				$query = "UPDATE messages SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE id='$tid'";
				$database->openConnectionNoReturn($query);
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option&act=$act&forum=$forum';</SCRIPT>\n";
		}

		function archiveThread($database, $option, $cid, $forum, $act){
			for ($d = 0; $d < count($cid); $d++){
				$query="select id from messages where replytoid='$cid[$d]'";
				$result=$database->openConnectionWithReturn($query);
				$i=0;
				$archiveArray[$i]=$cid[$d];
				while (list($id)=mysql_fetch_array($result)){
					$i++;
					$archiveArray[$i]=$id;
					$stillitems=1;
					while ($stillitems==1){
						if ($counter > 1){
							for ($b=0; $b < $counter; $b++){
								$c=$i-$b;
								$query1="select id from messages where replytoid='$archiveArray[$c]'";
								$result1=$database->openConnectionWithReturn($query1);
								if (mysql_num_rows($result1)==0){
									$stillitems=0;
								}else{
									$stillitems=1;
									$counter=0;
									while (list($id1)=mysql_fetch_array($result1)){
										$i++;
										$archiveArray[$i]=$id1;
										$counter++;
									}
								}
							}
						}else{
							$query1="select id from messages where replytoid='$archiveArray[$i]'";
							$result1=$database->openConnectionWithReturn($query1);
							if (mysql_num_rows($result1)==0){
								$stillitems=0;
							}else{
								$stillitems=1;
								$counter=0;
								while (list($id1)=mysql_fetch_array($result1)){
									$i++;
									$archiveArray[$i]=$id1;
									$counter++;
								}
							}
						}
					}
				}
				$displayCounter=count($archiveArray);
				for ($a=$displayCounter-1; $a >= 0; $a--){
					$query="update messages set archive=1, newmessage=0 where id='$archiveArray[$a]'";
					$database->openConnectionNoReturn($query);
				}
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option&forum=$forum&act=$act';</SCRIPT>\n";
		}

		function unarchiveThread($database, $option, $cid, $forum, $act){
			for ($d = 0; $d < count($cid); $d++){
				$query="select id from messages where replytoid='$cid[$d]'";
				$result=$database->openConnectionWithReturn($query);
				$i=0;
				$unarchiveArray[$i]=$cid[$d];
				while (list($id)=mysql_fetch_array($result)){
					$i++;
					$unarchiveArray[$i]=$id;
					$stillitems=1;
					while ($stillitems==1){
						if ($counter > 1){
							for ($b=0; $b < $counter; $b++){
								$c=$i-$b;
								$query1="select id from messages where replytoid='$unarchiveArray[$c]'";
								$result1=$database->openConnectionWithReturn($query1);
								if (mysql_num_rows($result1)==0){
									$stillitems=0;
								}else{
									$stillitems=1;
									$counter=0;
									while (list($id1)=mysql_fetch_array($result1)){
										$i++;
										$unarchiveArray[$i]=$id1;
										$counter++;
									}
								}
							}
						}else{
							$query1="select id from messages where replytoid='$unarchiveArray[$i]'";
							$result1=$database->openConnectionWithReturn($query1);
							if (mysql_num_rows($result1)==0){
								$stillitems=0;
							}else{
								$stillitems=1;
								$counter=0;
								while (list($id1)=mysql_fetch_array($result1)){
									$i++;
									$unarchiveArray[$i]=$id1;
									$counter++;
								}
							}
						}
					}
				}
				$displayCounter=count($unarchiveArray);
				for ($a=$displayCounter-1; $a >= 0; $a--){
					$query="update messages set archive=0 where id='$unarchiveArray[$a]'";
					$database->openConnectionNoReturn($query);
				}
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option&forum=$forum&act=$act';</SCRIPT>\n";
		}

	function newReply($database, $option, $act, $threadshtml, $forum, $myname, $cid, $text_editor){
		$cid=$cid[0];
		$repID=$cid;

		$query="SELECT author, subject, date, time, level, message, forumid, archive, published topMessageID FROM messages WHERE id='$cid'";
		/*$query="SELECT messages.author, messages.subject, messages.date, messages.time, messages.level, messages.message, messages.forumid, messages.archive, messages.published, messages.topMessageID, users.username
		FROM messages, users WHERE messages.author=users.id AND messages.id='$cid'";*/
		$result=$database->openConnectionWithReturn($query);
		list ($repAuthor, $repSubject, $repDate, $repTime, $repLevel, $repMessage, $repForumID, $repArchive, $repPublished)=mysql_fetch_array($result);
		//list ($repAuthorid, $repSubject, $repDate, $repTime, $repLevel, $repMessage, $repForumID, $repArchive, $repPublished, $topMessageID, $repAuthor)=mysql_fetch_array($result);

		$newSubject="RE: ".$repSubject;
		//$threadshtml->newReply($option, $act, $forum, $myname, $newSubject, $repAuthor, $repAuthorid, $repSubject, $repDate, $repTime, $repMessage, $repForumID, $repArchive, $repPublished, $repID, $repLevel, $text_editor, $topMessageID);
		$threadshtml->newReply($option, $act, $forum, $myname, $newSubject, $repAuthor, $repSubject, $repDate, $repTime, $repMessage, $repForumID, $repArchive, $repPublished, $repID, $repLevel, $text_editor);
	}

	function savenewReply($database, $option, $act, $forum, $subject, $content, $forumID, $author, $authorid, $published, $archive, $repLevel, $repID, $topMessageID){
		$date=date("Y-m-d");
		$time = strftime ("%r");
		$level=$repLevel+1;

		if ($topMessageID==0){
			$topMessageID=$repID;
		}

		//$query = "INSERT INTO messages SET subject='$subject', message='$content', forumid='$forumID', date='$date', time='$time', level=$level, published=0, archive=$archive, author='$author', replytoid=$repID";

		$query = "INSERT INTO messages SET subject='$subject', message='$content', forumid='$forumID', date='$date', time='$time', level=$level, published=0, archive=$archive, author='$author', replytoid=$repID";
		$database->openConnectionNoReturn($query);
		$id=mysql_insert_id();

		echo "<SCRIPT>document.location.href='index2.php?option=$option&forum=$forum&act=$act&task=edit&cid%5B%5D=$id'</SCRIPT>\n";
	}
}?>