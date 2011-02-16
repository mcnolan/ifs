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
  * Version:	1.14n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This program contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	1/6/04
  * Comments: Stuff that the user can submit
 ***/

if ($userhtml=="")
{
	require ("classes/html/userpage.php");
	$userhtml = new HTML_user();
}

if ($database=="")
{
	require("classes/database.php");
	$database = new database();
}


if ($_COOKIE["session"]!="")
{
	$cryptSessionID=md5($session);
	$qry="SELECT userid FROM {$mpre}session WHERE session_ID='$cryptSessionID'";
	$result=$database->openConnectionWithReturn($qry);
	if (mysql_num_rows($result)!=0)
    {
		list($uid)=mysql_fetch_array($result);

		$browse = getenv("HTTP_USER_AGENT");
		if (preg_match("/MSIE/i", "$browse"))
			if (preg_match("/Mac/i", $browse))
				$text_editor = false;
			elseif (preg_match("/Windows/i", $browse))
				$text_editor = true;
		elseif (preg_match("/Mozilla/i", "$browse"))
			if (preg_match("/Mac/i", $browse))
				$text_editor = false;
			elseif (preg_match("/Windows/i", $browse))
				$text_editor = false;

		include ("configuration.php");

		if ($uid == "0")
			echo "You are not logged in!";
		else
        {
			switch($op)
            {
				case "UserArticle":
					articleForm($userhtml, $database, $uid, $option, $ImageName, $text_editor, $mpre);
					break;
				case "SaveNewArticle":
					saveNewArticle($userhtml, $database, $uid, $option, $arttitle, $artsection, $pagecontent, $ImageName2, $anonymous, $live_site, $sitename, $mpre);
					break;
				case "saveUpload":
					saveUpload($userhtml, $database, $uid, $option, $userfile, $userfile_name, $type, $existingImage, $mpre);
					break;
				case "UserDetails":
					userEdit($userhtml, $database, $uid, $option, $mpre, $spre);
					break;
				case "saveUserEdit":
					saveUserEdit($database, $uid, $option, $name2, $username2, $pass2, $email2, $verifyPass, $mpre, $spre, $bdaymon, $bdayday);
					break;
				case "UserFAQ":
					FAQForm($userhtml, $database, $uid, $option, $text_editor, $mpre);
					break;
				case "SaveNewFAQ":
					saveNewFAQ($userhtml, $database, $uid, $option, $faqtitle, $faqsection, $pagecontent, $live_site, $sitename, $mpre);
					break;
				case "UserLink":
					linkForm($userhtml, $database, $uid, $option, $mpre);
					break;
				case "SaveNewLink":
					saveNewLink($userhtml, $database, $uid, $option, $linktitle, $linksection, $linkUrl, $live_site, $sitename, $mpre);
					break;
				case "UserNews":
					newsForm($userhtml, $database, $uid, $option, $ImageName, $text_editor, $mpre);
					break;
				case "SaveNewNews":
					saveNewNews($userhtml, $database, $uid, $option, $newstitle, $newssection, $introtext, $fultext, $ImageName2, $position, $live_site, $sitename, $mpre);
					break;
	            case "ServiceRecord":
	            	ServiceRecord($database, $mpre, $spre, $cid, $op, $uflag);
	                break;
	            case "RecordDetails":
	            	RecordDetails($database, $mpre, $spre, $rid, $op, $uflag);
	                break;
				default:
					$userhtml->frontpage();
					break;
			}
		}
	}
}
else
{
	if (substr(dirname($_SERVER['PHP_SELF']), -1) == "/")
		$headerpath = substr(dirname($_SERVER['PHP_SELF']), 0, -1);
    else
		$headerpath = dirname($_SERVER['PHP_SELF']);
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $headerpath . "/index.php");
    exit;
}

function newsForm($userhtml, $database, $uid, $option, $ImageName, $text_editor, $mpre)
{
    $qry = "SELECT categoryid, categoryname
    		FROM {$mpre}categories
            WHERE section='News' AND published=1 AND categoryname<>'Spotlight'";
    $result = $database->openConnectionWithReturn($qry);
    $i = 0;
    while ( list($secid[$i], $secname[$i]) = mysql_fetch_array($result) )
        $i++;
    $userhtml->newsForm($secid, $secname, $uid, $option, $ImageName, $text_editor);
}

function articleForm($userhtml, $database, $uid, $option, $ImageName, $text_editor, $mpre)
{
    $qry = "SELECT categoryid, categoryname
    		FROM {$mpre}categories
            WHERE section='Articles' AND published=1";
    $result = $database->openConnectionWithReturn($qry);
    $i = 0;
    while ( list($secid[$i], $secname[$i]) = mysql_fetch_array($result) )
        $i++;
    $userhtml->articleForm($secid, $secname, $uid, $option, $ImageName, $text_editor);
}

function FAQForm($userhtml, $database, $uid, $option, $text_editor, $mpre)
{
    $qry = "SELECT categoryid, categoryname
    		FROM {$mpre}categories
            WHERE section='Faq' AND published=1";
    $result = $database->openConnectionWithReturn($qry);
    $i = 0;
    while ( list($secid[$i], $secname[$i]) = mysql_fetch_array($result) )
        $i++;
    $userhtml->FAQForm($secid, $secname, $uid, $option, $text_editor);
}

function linkForm($userhtml, $database, $uid, $option, $mpre)
{
    $qry = "SELECT categoryid, categoryname
    		FROM {$mpre}categories WHERE section='Weblinks' AND published=1";
    $result = $database->openConnectionWithReturn($qry);
    $i = 0;
    while ( list($secid[$i], $secname[$i]) = mysql_fetch_array($result) )
        $i++;
    $userhtml->linkForm($secid, $secname, $uid, $option);
}

function saveNewNews($userhtml, $database, $uid, $option, $newstitle, $newssection, $introtext, $fultext, $ImageName2, $position, $live_site, $sitename, $mpre)
{
    if ((trim($newstitle)=="") || (trim($newssection)=="") || (trim($introtext)==""))
        print "<SCRIPT> alert('Please complete all the fields'); window.history.go(-1); </SCRIPT>\n";
    else
    {
        $date=date("Y-m-d");
        $time=date("H:i:s");
        $date="$date $time";
        $ip = getenv("REMOTE_ADDR");

        $qry = "INSERT INTO {$mpre}stories
        		SET title='$newstitle', introtext='$introtext', fultext='$fultext',
                	topic='$newssection', time='$date' , newsimage='$ImageName2',
                    image_position='$position', approved=0, ip='$ip'";
        $database->openConnectionNoReturn($qry);

        $qry="SELECT email FROM {$mpre}users WHERE sendemail='1' AND flags LIKE '%a%'";
        $result=$database->openConnectionWithReturn($qry);
        list ($adminEmail)=mysql_fetch_array($result);
        $qry2="SELECT name FROM {$mpre}users WHERE id='$uid'";
        $result2=$database->openConnectionWithReturn($qry2);
        list ($author)=mysql_fetch_array($result2);

        if ($adminEmail)
        {
            $recip = $adminEmail;
            while ( list($adminEmail) = mysql_fetch_array($result) )
                $recip .= ", " . $adminEmail;

            $newstitle = stripslashes($newstitle);
            $author = stripslashes($author);
            require_once "includes/mail/news_submit.mail.php";
        }
        echo "<SCRIPT> alert('Thanks for your submission. Your news story will now be reviewed by \\nan administrator before being posted to the site'); document.location.href='index.php?option=$option';</SCRIPT>";
    }
}


function saveNewArticle($userhtml, $database, $uid, $option, $arttitle, $artsection, $pagecontent, $ImageName2, $anonymous, $live_site, $sitename, $mpre)
{
    if ((trim($arttitle)=="") || (trim($artsection)=="") || (trim($pagecontent)==""))
        print "<SCRIPT> alert('Please complete all the fields'); window.history.go(-1); </SCRIPT>\n";
    else
    {
        $qry="SELECT Max(ordering) AS MaxOrder
        	  FROM {$mpre}articles WHERE secid='$artsection'";
        $result=$database->openConnectionWithReturn($qry);
        list($MaxOrder)=mysql_fetch_array($result);
        $MaxOrder++;
        $date=date("Y-m-d");
        if (trim($ImageName2)!="")
        {
            $ImageLink="images/stories/$ImageName2";
            $pagecontent= "<img src=$ImageLink align=right> $pagecontent";
        }
        $qry="SELECT name FROM {$mpre}users WHERE id='$uid'";
        $result=$database->openConnectionWithReturn($qry);
        list($author)=mysql_fetch_array($result);
        if (isset($anonymous))
            $SeeAuthor="";
        else
            $SeeAuthor=$author;

        $qry = "INSERT INTO {$mpre}articles
        		SET title='$arttitle', content='$pagecontent', secid='$artsection',
                	date='$date' , userID='$uid', ordering='$MaxOrder', author='$SeeAuthor'";
        $database->openConnectionNoReturn($qry);

        $qry="SELECT email FROM {$mpre}users WHERE sendEmail='1' AND flags LIKE '%a%'";
        $result=$database->openConnectionWithReturn($qry);

        if ( list($adminEmail) = mysql_fetch_array($result) )
        {
            $recipient = $adminEmail;
            while ( list($adminEmail) = mysql_fetch_array($result) )
            	$recipient .= ", " . $adminEmail;

            require_once "includes/mail/article.submit.mail.php";
        }

        echo "<SCRIPT> alert('Thanks for your submission. Your article will now be reviewed by \\nan administrator before being posted to the site'); document.location.href='index.php?option=$option';</SCRIPT>";
    }
}

function saveNewFAQ($userhtml, $database, $uid, $option, $faqtitle, $faqsection, $pagecontent, $live_site, $sitename, $mpre)
{
    if ((trim($faqtitle)=="") || (trim($faqsection)=="") || (trim($pagecontent)==""))
        print "<SCRIPT> alert('Please complete all the fields'); window.history.go(-1); </SCRIPT>\n";
    else
    {
        $qry="SELECT Max(ordering) AS MaxOrder
        	  FROM {$mpre}faqcont WHERE faqid='$artsection'";
        $result=$database->openConnectionWithReturn($qry);
        list($MaxOrder)=mysql_fetch_array($result);
        $MaxOrder++;
        $date=date("Y-m-d");

        $qry = "INSERT INTO {$mpre}faqcont
        		SET title='$faqtitle', content='$pagecontent', faqid='$faqsection',
                	ordering='$MaxOrder', approved=0";
        $database->openConnectionNoReturn($qry);

        $qry="SELECT sendEmail FROM {$mpre}users WHERE sendEmail='1' AND flags LIKE '%a%'";
        $result=$database->openConnectionWithReturn($qry);

        $qry2="select name from " . $mpre . "users where id='$uid'";
        $result2=$database->openConnectionWithReturn($qry2);
        list ($author)=mysql_fetch_array($result2);

        $pat="\\\'";
        $replace="'";

        $faqtitle=eregi_replace($pat, $replace, $faqtitle);

        if ( list($adminEmail) = mysql_fetch_array($result) )
        {
            $recipient = $adminEmail;
            while ( list($adminEmail) = mysql_fetch_array($result) )
            	$recipient .= ", " . $adminEmail;

            require_once "includes/mail/faq_submit.mail.php";
        }
        echo "<SCRIPT> alert('Thanks for your submission. Your FAQ will now be reviewed by \\nan administrator before being posted to the site'); document.location.href='index.php?option=$option';</SCRIPT>";
    }
}

function saveNewLink($userhtml, $database, $uid, $option, $linktitle, $linksection, $linkUrl, $live_site, $sitename, $mpre)
{
    if ((trim($linktitle)=="") || (trim($linksection)=="") || (trim($linkUrl)==""))
        print "<SCRIPT> alert('Please complete all the fields'); window.history.go(-1); </SCRIPT>\n";
    else
    {
        $checkLink=eregi("http://", $linkUrl);
        if (!$checkLink)
            $linkUrl="http://".$linkUrl;

        $qry="SELECT Max(ordering) AS MaxOrder FROM links WHERE cid='$linksection'";
        $result=$database->openConnectionWithReturn($qry);
        list($MaxOrder)=mysql_fetch_array($result);
        $MaxOrder++;
        $date=date("Y-m-d");
        $ip = getenv("REMOTE_ADDR");

        $qry = "INSERT INTO {$mpre}links
        		SET title='$linktitle', url='$linkUrl', cid='$linksection', ordering='$MaxOrder',
                	approved=0, date='$date', ip='$ip'";
        $database->openConnectionNoReturn($qry);

        $qry="SELECT email FROM {$mpre}users WHERE sendEmail='1' AND flags  LIKE '%a%'";
        $result=$database->openConnectionWithReturn($qry);

        $qry2="SELECT name FROM {$mpre}users WHERE id='$uid'";
        $result2=$database->openConnectionWithReturn($qry2);
        list ($author)=mysql_fetch_array($result2);

        if ( list($adminEmail) = mysql_fetch_array($result) )
        {
            $recipient = $adminEmail;
            while ( list($adminEmail) = mysql_fetch_array($result) )
            	$recipient .= ", " . $adminEmail;

		require_once "includes/mail/link_submit.mail.php";
        }
        echo "<SCRIPT> alert('Thanks for your submission. Your web link will now be reviewed by \\nan administrator before being posted to the site'); document.location.href='index.php?option=$option';</SCRIPT>";
    }
}

// Not beautified - since uploads are disabled.  -Anon, 12/9/03
function saveUpload($userhtml, $database, $uid, $option, $userfile, $userfile_name, $type, $existingImage, $mpre)
{
    $base_Dir = "images/stories/";

    $checksize=filesize($userfile);
    if ($checksize > 15000){
        echo "<SCRIPT> alert('You cannot upload files greater than 15kb in size'); window.history.go(-1); </SCRIPT>\n";
    }else{
        if (file_exists($base_Dir.$userfile_name)){
            print "<SCRIPT> alert('Image $userfile_name already exists. Please rename the file and try again'); window.history.go(-1);</SCRIPT>\n";
        }else{
            if ((eregi(".gif", $userfile_name)) || (eregi(".jpg", $userfile_name))){
                if (!copy($userfile, $base_Dir.$userfile_name)){
                    echo "Failed to copy $userfile_name";
                }else{
                    echo "<SCRIPT>window.opener.focus;</SCRIPT>";
                    if ($type=="news"){
                        $op="UserNews";
                    }elseif ($type=="articles"){
                        $op="UserArticle";
                    }

                    if ($existingImage!=""){
                        if (file_exists($base_Dir.$existingImage)) {
                            //delete the exisiting file
                            unlink($base_Dir.$existingImage);
                        }
                    }
                    echo "<SCRIPT>window.opener.document.adminForm.ImageName.value='$userfile_name';</SCRIPT>";
                    echo "<SCRIPT>window.opener.document.adminForm.ImageName2.value='$userfile_name';</SCRIPT>";
                    echo "<SCRIPT>window.opener.document.adminForm.imagelib.src=null;</SCRIPT>";
                    echo "<SCRIPT>window.opener.document.adminForm.imagelib.src='images/stories/$userfile_name';</SCRIPT>";
                    echo "<SCRIPT>window.close(); </SCRIPT>";
                }
            }else{
                echo "<SCRIPT> alert('You may only upload a gif, or jpg image'); window.history.go(-1); </SCRIPT>\n";
            }
        }
    }
}

function userEdit($userhtml, $database, $uid, $option, $mpre, $spre)
{
    $qry = "SELECT name, username, email, bday FROM {$mpre}users where id='$uid'";
    $result = $database->openConnectionWithReturn($qry);
    $i = 0;
    list($name, $username, $email, $bday)=mysql_fetch_array($result);

    $bday2['month'] = substr($bday, 0, 2);
    if (!$bday2['month'])
        $bday2['month'] = "00";
    if (!$bday2['day'])
        $bday2['day'] = "00";
    $bday2['day'] = substr($bday, 2);

    $qry2 = "SELECT id, name, ship FROM {$spre}characters WHERE player='$uid' AND ship<>'74'";
    $result2 = $database->openConnectionWithReturn($qry2);
    list($cid,$cname,$sid)=mysql_fetch_array($result2);

    $shiplist = "";
    while ($cname)
    {
        $qry3 = "SELECT name FROM {$spre}ships WHERE id='$sid'";
        $result3=$database->openConnectionWithReturn($qry3);
        list($ship)=mysql_fetch_array($result3);

        $shiplist .= "($cid) $cname on $ship <br />";
        $shiplist .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?option=user&amp;op=ServiceRecord" .
        			 "&amp;cid={$cid}\">View Service Record</a><br /><br />";
        list($cid,$cname,$sid)=mysql_fetch_array($result2);
    }
    $userhtml->userEdit($uid, $name, $username, $email, $option, $result2, $shiplist, $bday2);
}

function saveUserEdit($database, $uid, $option, $name2, $username2, $pass2, $email2, $verifyPass, $mpre, $spre, $bdaymon, $bdayday)
{
    echo "&nbsp;";
    if ((trim($name2)=="") || (trim($username2)=="") || (trim($email2)==""))
        print "<SCRIPT> alert('Please complete all the fields'); window.history.go(-1); </SCRIPT>\n";
    else
    {
        if ((trim($pass2)!="") && (trim($verifyPass)==""))
            print "<SCRIPT> alert('If changing your password please enter the password again to verify'); window.history.go(-1); </SCRIPT>\n";
        elseif ((trim($pass2)!="") && (trim($verifyPass)!=""))
            if ($pass2 != $verifyPass)
                print "<SCRIPT> alert('If changing your password please make sure the password and verification match'); window.history.go(-1); </SCRIPT>\n";

        $qry="SELECT id FROM {$mpre}users
        	  WHERE (username='$username2' || email='$email2') AND id!='$uid'";
        $result=$database->openConnectionWithReturn($qry);
        if (mysql_num_rows($result)!=0)
            print "<SCRIPT> alert('This username and/or email is already in use'); window.history.go(-1); </SCRIPT>\n";
        else
        {
            if ($pass2!="")
            {
                $pass2=md5($pass2);
                $qry = "UPDATE {$mpre}users
                		SET name='$name2', username='$username2', email='$email2',
                        	password='$pass2' where id=$uid";
                $database->openConnectionNoReturn($qry);

                $qry = "SELECT id, ship FROM {$spre}characters WHERE player='$uid'";
                $result=$database->openConnectionWithReturn($qry);
                list ($cid, $sid) = mysql_fetch_array($result);

                while ($sid)
                {
                    $qry2 = "SELECT format FROM {$spre}ships WHERE id='$sid'";
                    $result2 = $database->openConnectionWithReturn($qry2);
                    list ($format) = mysql_fetch_array($result2);

                    if ($format == "Play by Bulletin Board")
                    {
                        $qry2 = "UPDATE pbb_users SET user_password='$pass2' WHERE user_char='$cid'";
                        $result2 = $database->openPBBWithConnection($qry2);
                    }

                    list ($cid, $sid) = mysql_fetch_array($result);
                }
            }
            else
            {
                $bday2 = $bdaymon . $bdayday;
                $qry="UPDATE {$mpre}users
                	  SET name='$name2', username='$username2', email='$email2',
                      	bday='$bday2' where id=$uid";
                $database->openConnectionNoReturn($qry);
            }

            if (substr(dirname($_SERVER['PHP_SELF']), -1) == "/")
                $headerpath = substr(dirname($_SERVER['PHP_SELF']), 0, -1);
            else
                $headerpath = dirname($_SERVER['PHP_SELF']);
            header("Location: http://" . $_SERVER['HTTP_HOST'] . $headerpath . "/index.php?option=user");
            exit;
        }
    }
}

function ServiceRecord ($database, $mpre, $spre, $cid, $op, $uflag)
{
    $qry = "SELECT id FROM {$spre}characters WHERE id='$cid' AND player='" . uid . "'";
    $result = $database->openConnectionWithReturn($qry);

    if (defined("admin") || mysql_num_rows($result) || ($uflag['c'] == 1 && $sid == $usership))
        record_view ($database, $spre, $mpre, $cid, $op, $uflag);
    else
        echo "You do not have access.";
    echo "<br /><br />";
}

function RecordDetails ($database, $mpre, $spre, $rid, $op, $uflag)
{
    $qry = "SELECT id FROM {$spre}characters WHERE id='$cid' AND player='" . uid . "'";
    $result = $database->openConnectionWithReturn($qry);

    if (defined("admin") || mysql_num_rows($result) || ($uflag['c'] == 1 && $sid == $usership))
        record_details ($database, $spre, $mpre, $rid, $op, $uflag);
    else
        echo "You do not have access.";
    echo "<br /><br />";
}
?>
