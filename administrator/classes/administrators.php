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
	 *	File Name: administrator.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class administrators {
		function showadministrators($database, $option, $administratorshtml, $userid, $mpre){
			$query = "SELECT id, name, usertype FROM " . $mpre . "users WHERE usertype='administrator' OR usertype='superadministrator'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$uid[$i] = $row->id;
				$name[$i] = $row->name;
				$usertype[$i] =$row->usertype;
				$i++;
			}

			$administratorshtml->showadministrators($option, $uid, $name, $usertype);
		}

		function editadministrator($administratorshtml, $database, $option, $uid, $mpre){
			if ($uid == ""){
				print "<SCRIPT> alert('Please select a administrator to edit.'); window.history.go(-1); </SCRIPT>\n";
				}

			$query = "SELECT name, username, email, password, usertype, sendEmail FROM " . $mpre . "users WHERE id='$uid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$name = $row->name;
				$email = $row->email;
				$uname = $row->username;
				$password = $row->password;
				$usertype = $row->usertype;
				$sendEmail = $row->sendEmail;
				}

			$administratorshtml->editadministrator($option, $uid, $name, $email, $uname, $password, $usertype, $sendEmail);
			}

		function saveeditadministrator($administratorshtml, $database, $option, $realname, $email, $username, $uid, $new_password, $pname, $pemail, $puname, $live_site, $npassword, $vpassword, $ppassword, $emailAdmin, $mpre){
			if (($pname <> $realname) || ($puname <> $username) || (($password <> $ppassword) && ($password <> ""))){
				$hashnpassword=md5($npassword);
				$query = "SELECT id FROM " . $mpre . "users WHERE usertype='administrator' AND (username='$username' AND name='$realname' AND password='$hashnpassword') AND id!=$uid";
				$result = $database->openConnectionWithReturn($query);
				$count = mysql_num_rows($result);
				if ($count > 0){
					print "<SCRIPT> alert('Those details have already been taken, please try again!'); window.history.go(-1); </SCRIPT>\n";
					exit(0);
					}
				}
			if ($emailAdmin==""){
				$emailAdmin=0;
			}

			if ($npassword){
				$hashnpassword=md5($npassword);
				$query = "UPDATE " . $mpre . "users SET name='$realname', email='$email', username='$username', password='$hashnpassword', sendEmail='$emailAdmin' WHERE id='$uid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				$query = "UPDATE " . $mpre . "users SET name='$realname', email='$email', username='$username', sendEmail='$emailAdmin' WHERE id='$uid'";
				$database->openConnectionNoReturn($query);
				}

			if ($password <> $npassword){
				$recipient = "$realname <$email>";
				$subject = "New Admin Details";
				$message .= "Hello $realname,\n\n";
				$message .= "You have requested a new password for the '$live_site' website.\n";
				$message .= "The following are your new login details for '$live_site':\n\n";
				$message .= "Username - $username\n";
				$message .= "Password - $npassword\n\n\n";
				$message .= "Please do not respond to this message as it is automatically generated and is for information purposes only\n";

				$headers .= "From: Administrator <$email>\n";
				$headers .= "X-Sender: <$email> \n";
				$headers .= "X-Mailer: PHP\n"; // mailer
				$headers .= "Return-Path: <$email>\n";  // Return path for errors
				mail($recipient, $subject, $message, $headers);
			}

			print "<SCRIPT>document.location.href='index2.php?option=Administrators'</SCRIPT>\n";
			}

		function removeadministrator($database, $option, $cid, $userid, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT> alert('Please select a administrator to delete.'); window.history.go(-1); </SCRIPT>\n";
				}

			for ($i = 0; $i < count($cid); $i++){
				if ($userid==$cid[$i]){
					print "<SCRIPT>alert('You cannot delete your current login'); document.location.href='index2.php?option=Administrators';</SCRIPT>\n";
					exit();
				}
				$query="select usertype from " . $mpre . "users where id='$cid[$i]'";
				$result=$database->openConnectionWithReturn($query);
				list($usertype)=mysql_fetch_array($result);

				if ($usertype=="superadministrator"){
					print "<SCRIPT>alert('You cannot delete the superadministrator.'); document.location.href='index2.php?option=Administrators';</SCRIPT>\n";
					exit();
				}else{
					$query = "DELETE FROM " . $mpre . "users WHERE id='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}
			print "<SCRIPT>document.location.href='index2.php?option=Administrators'</SCRIPT>\n";
		}

		function savenewadministrator($option, $database, $realname, $username, $email, $live_site, $mpre){
			mt_srand((double)microtime()*1000000);
			$randnum= mt_rand(1000, mt_getrandmax());
			$upass=md5($randnum);
			$query = "SELECT id FROM " . $mpre . "users WHERE (usertype='administrator' OR usertype='superadministrator') AND (username='$username' OR password='$upass')";
			$result = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result);
			if ($count > 0){
				print "<SCRIPT> alert('Those details have already been taken, please try again!'); window.history.go(-1); </SCRIPT>\n";
				exit(0);
			}

			$query = "INSERT INTO " . $mpre . "users SET name='$realname', email='$email', username='$username', password='$upass', usertype='administrator'";
			$database->openConnectionNoReturn($query);

			$recipient = "$realname <$email>";
			$subject = "New Admin Details";
			$message .= "Hello $realname,\n\n";
			$message .= "You have been added as an administrator to by the '$live_site' administrator.\n";
			$message .= "This email contains your username and password to log into the '$live_site' site:\n\n";
			$message .= "Username - $username\n";
			$message .= "Password - $randnum\n\n\n";
			$message .= "Please do not respond to this message as it is automatically generated and is for information purposes only\n";

			$headers .= "From: Administrator <$email>\n";
			$headers .= "X-Sender:<$email> \n";
			$headers .= "X-Mailer: PHP\n"; // mailer
			$headers .= "Return-Path: <$email>\n";  // Return path for errors
			mail($recipient, $subject, $message, $headers);

			print "<SCRIPT>document.location.href='index2.php?option=Administrators'</SCRIPT>\n";
			}
		}
?>