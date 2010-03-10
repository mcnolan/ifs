<?
 /**
   *  Mambo Site Server Open Source Project Version 4.0
   *  Dynamic portal server and Content managment engine
   *  27-11-2002
   *
   *  Copyright (C) 2000 - 2002 Miro International Pty Ltd
   *  Distributed under the terms of the GNU General Public License
   *  This software may be used without warrany provided these statements are left
   *  intact and a "Powered By Mambo" appears at the bottom of each HTML page.
   *  This code is available at http://sourceforge.net/projects/mambo
   *
   *  Site Name: Mambo Site Server Open Source Project Version 4.0
   *  File Name: index.php
   *  Original Developers: Danny Younes - danny@miro.com.au
   *                       Nicole Anderson - nicole@miro.com.au
   *  Date: 31/10/2001
   *  Version #: 4.0
   *  Comments:
   *
   * Modified December 2009 by Nolan (john.pbem@gmail.com) to work with register_globals off
  **/

	$relpath = "../";
	require("../classes/database.php");
	require("../includes/addslash.php");
	$database = new database();

	include ("../includes/rand.php");

	if (isset($submit)){
		$query  = "SELECT id, password, name FROM " . $mpre . "users WHERE username='$myname' AND (usertype='administrator' OR usertype='superadministrator')";
		$result = $database->openConnectionWithReturn($query);
		if (mysql_num_rows($result)!= 0){
			list($user_id, $dbpass, $fullname) = mysql_fetch_array($result);
			$random_string = rand_string();
			$current_time = time();
			$query2 = "INSERT INTO " . $mpre . "session SET time='$current_time', session_id='$random_string', userid='$user_id', usertype='administrator'";
			$database->openConnectionNoReturn($query2);
			if ($passwordcookie==""){
				//if the cookie has not been set then crypt the password entered
				if (trim($pass)!=""){
					$pass = md5($pass);
					if ($remember=="on"){
						//if the user wants the password remembered then set the cookie
						$lifetime= (time() + 1036800000);
				    	setcookie("passwordcookie", "$pass", $lifetime);
						$passwordcookie=$pass;
						}
					}
				else {
					//if the user didn't enter a password send them back
					print "<SCRIPT>alert('Please enter a password'); document.location.href='index.php';</SCRIPT>\n";
					}
				}
			else {
				if ($remember=="on"){
					//if the cookie has been set then get the value and put it in the pass variable
					$pass=$passwordcookie;
					}
				}

			if (strcmp($dbpass,$pass)) {
				//if the password entered does not match the database record ask user to login again
				print "<SCRIPT>alert('Incorrect Username and Password, please try again'); document.location.href='index.php';</SCRIPT>\n";
				}
			else {
				//if the password matches the database
				if ($remember!="on"){
					//if the user does not want the password remembered and the cookie is set, delete the cookie
					if ($passwordcookie!=""){
						setcookie("passwordcookie");
						$passwordcookie="";
						}
					}
				//set up the admin session then take the user into the admin section of the site
					session_start();
					session_register("myname");
					$_SESSION['myname'] = $fullname;
					session_register("userid");
					$_SESSION['userid'] = $user_id;
					session_register("session_id");
					$_SESSION['session_id'] = $random_string;
					session_write_close();
					print "<SCRIPT>document.location.href='index2.php'</SCRIPT>\n";
					}
				}
			else {
				print "<SCRIPT>alert('Incorrect Username and Password, please try again'); document.location.href='index.php';</SCRIPT>\n";
				}
			}
		else {?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

		<html>
		<head>
		<title>Mambo Site Server Administration Login</title>
		<!--
	 	Mambo Site Server Open Source Edition
		Dynamic portal server and Content managment engine
	 	01-11-2002
		Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd

		Distributed under the terms of the GNU General Public License
		Available at http://sourceforge.net/projects/mambo
		//-->
<link rel="stylesheet" href="../themes/admin.css" type="text/css">
</head>


<body bgcolor="#000000">
<FORM name="form" ACTION="index.php" METHOD="POST">

  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

  <TABLE WIDTH="419" BORDER="1" ALIGN="center" CELLPADDING="2" CELLSPACING="0" bordercolor="#DFDFDF" >
    <tr>
      <td bgcolor="#FFFFFF" width="415">
        <TABLE WIDTH="75%" BORDER="0" ALIGN="center" CELLPADDING="1" CELLSPACING="0" bgcolor="#FFFFFF">
          <TR>
            <TD COLSPAN="2" ALIGN="right" valign="top"> <span class="smalldark"><img src="../images/admin/admin2.jpg" width="134" height="105" border="1">
              </span></TD>
            <TD width="136" valign="top"><img src="../images/admin/admin3.jpg" width="134" height="105" border="1"></TD>
            <TD width="137" valign="top"><span class="smalldark"><img src="../images/admin/admin.jpg" border="1"></span></TD>
          </TR>
          <TR>
            <TD ALIGN="right" width="73">&nbsp;</TD>
            <TD ALIGN="left" width="67">&nbsp;</TD>
            <TD align="center">&nbsp;</TD>
            <TD>&nbsp;</TD>
          </TR>
          <TR>
            <TD ALIGN="right" width="73"><font color="#000000" face="Arial, Helvetica, sans-serif" size="2"><b>.::</b></font></TD>
            <TD ALIGN="left" width="67"><font color="#000000" face="Arial, Helvetica, sans-serif" size="2"><b><i>Username</i></b></font></TD>
            <TD colspan=2 align="left">
              <INPUT NAME="myname" TYPE="text" class="inputbox" SIZE="20">
            </TD>
          </TR>
          <TR>
            <TD ALIGN="right" width="73"><font color="#000000" face="Arial, Helvetica, sans-serif" size="2"><b>.::</b></font></TD>
            <TD ALIGN="left" width="67"><font color="#000000" face="Arial, Helvetica, sans-serif" size="2"><b><i>Password</i></b></font></TD>
            <TD colspan=2 align="left">
              <INPUT NAME="pass" TYPE="password" class="inputbox" value="<?echo $passwordcookie;?>" SIZE="20">
            </TD>
          </TR>
          <TR>
            <TD ALIGN="right" width="73">&nbsp;</TD>
            <TD ALIGN="right" width="67">&nbsp; </TD>
            <TD colspan=2><span class="smalldark">
              <?if ($passwordcookie!=""){?>
              <input name="remember" type="checkbox" checked>
              <?}else{?>
              <input name="remember" type="checkbox">
              <?}?>
              Remember password</span></TD>
          </TR>
          <TR valign="top">
            <TD width="73">&nbsp;</TD>
            <TD width="67">&nbsp;</TD>
            <TD colspan=2>
              <INPUT NAME="submit" TYPE="submit" class="button" VALUE="Login">
              <INPUT NAME="submit" TYPE="reset" class="button" VALUE="Reset">
            </TD>
          </TR>
          <TR valign="top">
            <TD width="73" height="23">&nbsp;</TD>
            <TD width="67" height="23">&nbsp;</TD>
            <TD colspan="2" align="left" height="23" valign="bottom"><font face="Arial, Helvetica, sans-serif" size="1"><b><font size="-2" face="Verdana, Arial, Helvetica, sans-serif" color="#666666">Mambo
              SiteServer 4.0.11</font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
              - <font color="#FF9900">Stable</font></font></b></font></TD>
          </TR>
          <TR valign="bottom">
            <TD colspan="4" align="center" height="43"><font color="#999999">
              <font face="Verdana, Arial, Helvetica, sans-serif" color="#666666">
              <font size="1"> <font face="Arial, Helvetica, sans-serif">
              <? echo $version; ?>
              running on</font></font></font></font> <font face="Arial, Helvetica, sans-serif" color="#666666" size="1">
              <?
		echo ("PHP&nbsp;");
		echo phpversion();
              	echo ("&nbsp;on&nbsp;");
			if (phpversion() <= "4.2.1") {
				echo getenv("SERVER_SOFTWARE");
			} else {
			  	echo $_SERVER['SERVER_SOFTWARE'];
			}
		?>
              </font><font face="Verdana, Arial, Helvetica, sans-serif" color="#666666" size="1">
              </font> </TD>
          </TR>
        </TABLE>
  </table>

			</FORM>
<SCRIPT LANGUAGE="JavaScript">
<!--
document.form.myname.select();
document.form.myname.focus();
//-->
</SCRIPT>

</body>
		</html>
  <?}?>
