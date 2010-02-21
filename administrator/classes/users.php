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
	 *	File Name: users.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *				Emir Sakic - saka@hotmail.com
	 *	Date: 17/11/2002
	 * 	Version #: 4.0
	 *	Comments:
	**/

	class users {
		function showUsers($database, $option, $usershtml, $offset, $mpre){
			$rows_per_page=10;		// set how many rows per page you want displayed
			if (empty($offset)) $offset=1;
			$from = ($offset-1) * $rows_per_page;
			$query = "SELECT id FROM " . $mpre . "users";
			$result = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result);
			$query2 = "SELECT id, name, username, email, block FROM " . $mpre . "users WHERE usertype='user' LIMIT $from, $rows_per_page";
			$result2 = $database->openConnectionWithReturn($query2);
			$i = 0;
			while ($row = mysql_fetch_object($result2)){
				$uid[$i] = $row->id;
				$name[$i] = $row->name;
				$username[$i] = $row->username;
				$email[$i] = $row->email;
				$block[$i] = $row->block;
				$i++;
				}
			$usershtml->showUsers($option, $uid, $name, $username, $email, $block, $count, $offset, $rows_per_page);
			}


		function edituser($usershtml, $database, $option, $uid, $mpre){
			if ($uid == ""){
				print "<SCRIPT> alert('Please select a user to edit.'); window.history.go(-1); </SCRIPT>\n";
				}

			$query = "SELECT name, username, email, block FROM " . $mpre . "users WHERE id='$uid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$name = $row->name;
				$email = $row->email;
				$block = $row->block;
				$username = $row->username;
				}

			$usershtml->edituser($option, $uid, $username, $name, $email, $block);
			}

		function saveedituser($usershtml, $database, $option, $pname, $pemail, $puname, $uid, $block, $mpre){
			if ($block == "true"){
				$query = "UPDATE " . $mpre . "users SET block=1 WHERE id='$uid'";
				$database->openConnectionNoReturn($query);
			}else{
				$query = "UPDATE " . $mpre . "users SET block=0 WHERE id='$uid'";
				$database->openConnectionNoReturn($query);
			}

			print "<SCRIPT>document.location.href='index2.php?option=Users'</SCRIPT>\n";
			}

		function removeuser($database, $option, $cid, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT> alert('Please select a user to delete.'); window.history.go(-1); </SCRIPT>\n";
				}

			for ($i = 0; $i < count($cid); $i++){
				$query = "DELETE FROM " . $mpre . "users WHERE id='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				}

			print "<SCRIPT>document.location.href='index2.php?option=Users'</SCRIPT>\n";
			}

		function savenewuser($option, $database, $realname, $username, $email, $live_site, $mpre){
			mt_srand((double)microtime()*1000000);
			$randnum= mt_rand(1, mt_getrandmax());
			$upass=md5($randnum);

			$query = "SELECT id FROM " . $mpre . "users WHERE usertype='user' AND (username='$username' OR password='$upass')";
			$result = $database->openConnectionWithReturn($query);
			$count = mysql_num_rows($result);

			if ($count > 0){
				print "<SCRIPT> alert('Those details have already been taken, please try again!'); window.history.go(-1); </SCRIPT>\n";
				exit(0);
				}

			 $query2="select name, email from " . $mpre . "users where usertype='superadministrator'";
                        $result2=$database->openConnectionWithReturn($query2);
			if (mysql_num_rows($result2)!=0){
                             list($adminName, $adminEmail)=mysql_fetch_array($result2);}

			$query = "INSERT INTO " . $mpre . "users SET name='$realname', email='$email', username='$username', password='$upass', usertype='user'";
			$database->openConnectionNoReturn($query);

			$recipient = "$realname <$email>";
			$subject = "New User Details";
			$message .= "Hello $realname,\n\n";
			$message .= "You have been added as a user to by the '$live_site' administrator.\n";
			$message .= "This email contains your username and password to log into the '$live_site' site:\n\n";
			$message .= "Username - $username\n";
			$message .= "Password - $randnum\n\n\n";
			$message .= "Please do not respond to this message as it is automatically generated and is for information purposes only\n";

			$headers .= "From: Administrator <$adminEmail>\n";
			$headers .= "X-Sender:<$adminEmail> \n";
			$headers .= "X-Mailer: PHP\n"; // mailer
			$headers .= "Return-Path: <$email>\n";  // Return path for errors
			mail($recipient, $subject, $message, $headers);

			print "<SCRIPT>document.location.href='index2.php?option=Users'</SCRIPT>\n";
			}
		}
?>