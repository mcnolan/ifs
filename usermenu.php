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
  * Version:	1.16n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.16n: March 2014
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * See CHANGELOG for patch details
  *
  * Date:	1/11/03
  * Comments: Display usermenu once logged in
 ***/

require_once("includes/addslash.php");

if ($usermenuhtml=="")
{
	require ("classes/html/usermenu.php");
	$usermenuhtml = new HTML_usermenu();
}

if ($database=="")
{
	require("classes/database.php");
	$database = new database();
}

switch($op2)
{
    case "login":
        checkLogin($op2, $username, $passwd, $database, $usermenuhtml, $option, $mpre, $spre, $remember);
        break;
    case "CorrectLogin":
        showMenu($usermenuhtml, $database, $uid, $option, $mpre);
        break;
    case "showMenuComponent":
        showMenuComponent($usermenuhtml, $database, $uid, $uflag, $option, $mpre, $spre, $REQUEST_URI);
        break;
}

function checkLogin($op2, $username, $passwd, $database, $usermenuhtml, $option, $mpre, $spre, $remember)
{
    if ((trim($username)=="") || (trim($passwd)==""))
        echo "<SCRIPT> alert('Please complete the username and password fields.'); window.history.go(-1); </SCRIPT>\n";
    else
    {
        $passwd=md5($passwd);

        $qry="SELECT id, block FROM {$mpre}users WHERE username='$username' AND password='$passwd'";
        $result=$database->openConnectionWithReturn($qry);
        if (mysql_num_rows($result)!=0)
        {
            list($uid, $block)=mysql_fetch_array($result);
            if ($block==1)
                echo "<SCRIPT>alert('Your login has been blocked. Please contact the administrator.'); window.history.go(-1); </SCRIPT>\n";
            else
            {
                if ($_COOKIE["session"]!="")
                {
                    $sessionID=$_COOKIE["session"];
                    $cryptSessionID=md5($sessionID);
                    if ($remember == "on")
                        $qry="UPDATE {$mpre}session
                         	  SET guest=0, username='$username', userid='$uid',
                              	remember='1', active='1'
                              WHERE session_id='$cryptSessionID'";
                    else
                        $qry="UPDATE {$mpre}session
                        	  SET guest=0, username='$username', userid='$uid',
                              	active='1'
                              WHERE session_id='$cryptSessionID'";
                    $database->openConnectionWithReturn($qry);
                }
                else
                {
                    $existSessionID=0;
                    while ($existSessionID==0)
                    {
                        $sessionID=getSessionID();
                        if ($sessionID!="")
                        {
                            $cryptSessionID=md5($sessionID);
                            $qry="SELECT session_id FROM {$mpre}session
                            	  WHERE session_id='$cryptSessionID'";
                            $result=$database->openConnectionWithReturn($qry);
                            if (mysql_num_rows($result)==0)
                                $existSessionID=1;
                        }
                    }
                    if ($existSessionID==1)
                    {
                        $userip = getenv("REMOTE_ADDR");
                        $qry="INSERT INTO {$mpre}session
                        	  SET session_id='$cryptSessionID', guest='', userid='$uid',
                              	username='$username', ip='$userip'";
                        $database->openConnectionNoReturn($qry);

                        $lifetime= (time() + 60*60*24*365);
                        setcookie("obsidian", "$sessionID", $lifetime, "/");
                        $sessioncookie=$sessionID;
                    }
                }

                $lifetime= (time() + 43200);
                if (!$option)
                    $option = "?login=true";
                else
                    $option .= "&login=true";

                if (substr(dirname($_SERVER['PHP_SELF']), -1) == "/")
                    $headerpath = substr(dirname($_SERVER['PHP_SELF']), 0, -1);
                else
                    $headerpath = dirname($_SERVER['PHP_SELF']);
                header("Location: http://" . $_SERVER['HTTP_HOST'] . $headerpath . "/index.php{$option}");
                exit;
            }
        }
        else
            echo "<SCRIPT>alert('Incorrect username or password. Please try again'); window.history.go(-1); </SCRIPT>\n";
    }
}

function showMenu($usermenuhtml, $database, $option, $mpre)
{
    if (substr(dirname($_SERVER['PHP_SELF']), -1) == "/")
        $headerpath = substr(dirname($_SERVER['PHP_SELF']), 0, -1);
    else
        $headerpath = dirname($_SERVER['PHP_SELF']);
    header("Location: http://" . $_SERVER['HTTP_HOST'] . $headerpath . "/index.php?option=$option");
    exit;
}

function showMenuComponent($usermenuhtml, $database, $uid, $uflag, $option, $mpre, $spre, $REQUEST_URI)
{
    $qry="SELECT name FROM {$mpre}users WHERE id='$uid'";
    $result=$database->openConnectionWithReturn($qry);
    list($uName)=mysql_fetch_array($result);

    // show user menu
    $qry2="SELECT id, name, link FROM {$mpre}menu WHERE menutype='usermenu' ORDER BY ordering";
    $result2=$database->openConnectionWithReturn($qry2);
    $i=0;
    $logoutoption = preg_replace("/login=true/", '', preg_replace("/~login=true/", '', preg_replace("/&/", "~", substr(strstr($REQUEST_URI, '?'), 1))));
    while (list($id[$i], $name[$i], $link[$i])=mysql_fetch_array($result2))
    {
        if ($name[$i] == "Logout")
            $link[$i] .= "&option2={$logoutoption}";
        $i++;
    }
    $usermenuhtml->showMenuComponent($uName, $uid, "User", $id, $name, $link, $option);

    // show all flag'ed menus
    $qry2 = "SELECT flag, name FROM {$spre}flags ORDER BY ordering, flag";
    $result2 = $database->openConnectionWithReturn($qry2);
    list ($fid, $fname) = mysql_fetch_array($result2);

    while ($fid)
    {
        if ($uflag[$fid] > 0)
        {
            echo "<br />\n";
            $qry3="SELECT id, name, link
            	   FROM {$mpre}menu
                   WHERE menutype='$fname' ORDER BY ordering";
            $result3=$database->openConnectionWithReturn($qry3);
            unset($id);
            unset($name);
            unset($link);
            $i=0;
            while (list ($id[$i], $name[$i], $link[$i]) = mysql_fetch_array($result3) )
                $i++;
            $usermenuhtml->showMenuComponent($uName, $uid, $fname, $id, $name, $link, $option);
        }
        list ($fid, $fname) = mysql_fetch_array($result2);
    }
}

function getSessionID()
{
    mt_srand ((double) microtime() * 1000000);
    $pass_len = mt_rand (20,40);
    $allchar = "abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ0123456789";
    $str = "" ;
    for ( $i = 0; $i<$pass_len ; $i++ )
        $str .= substr( $allchar, mt_rand (0,62), 1 ) ;
    $timestamp= time();
    $str=$str.$timestamp;
    return($str);
}
?>
