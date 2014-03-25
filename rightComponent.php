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
  * Patch 1.13n:  December 2009
  * Patch 1.16n: March 2014
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	12/9/03
  * Comments: Displays right modules
  *
  * See CHANGELOG for patch details
  *
 ***/

$qry = "SELECT id, title, module
		FROM {$mpre}components
        WHERE publish='1' AND position='right'
        ORDER BY ordering";
$result = $database->openConnectionWithReturn($qry);

$logintop = "images/login.jpg";

while ( list($id1, $title, $module) = mysql_fetch_array($result) )
{
    if ($module == "survey")
    {
        if ($Itemid == "")
            $Itemid = 1;
        $qry2="SELECT {$mpre}poll_menu.pollid AS pollID
         	   FROM {$mpre}poll_menu, {$mpre}poll_desc
               WHERE {$mpre}poll_menu.menuid='$Itemid'
               		AND {$mpre}poll_desc.pollID={$mpre}poll_menu.pollid
                    AND {$mpre}poll_desc.published=1";
        $result2=$database->openConnectionWithReturn($qry2);

        while ( list($pollID)=mysql_fetch_array($result2) )
        {
            if (trim($pollID)!="0")
            {
                $qry3 = "SELECT pollTitle
                		 FROM {$mpre}poll_desc
                         WHERE pollID='$pollID' and published=1";
                $result3 = $database->openConnectionWithReturn($qry3);
                list ($pollTitle) = mysql_fetch_array($result3);

                if (trim($pollTitle)!="")
                {
                    $qry4 = "SELECT voteid, optionText
                    		 FROM {$mpre}poll_data
                             WHERE pollid='$pollID' AND optionText <> ''
                             ORDER BY voteid";
                    $result4 = $database->openConnectionWithReturn($qry4);
                    for ($j = 0;
                    	 list ($voters[$j], $optionText[$j]) = mysql_fetch_array($result4);
                         $j++);
                    $components->survey($pollTitle, $optionText, $pollID, $voters, $title);
                    $optionText="";
                }
            }
        }
    }
    elseif ($module == "newsarchive")
    {
        $content="<a href=\"index.php?option=archiveNews&type=News\">" .
        		 "Click here to find all our past news</a><br />";
        $components->component($title, $content);
    }
    elseif ($module == "articlearchive")
    {
        $content="<a href=\"index.php?option=archiveNews&type=Articles\">" .
        		 "Click here to find all our past articles</a><br />";
        $components->component($title, $content);
    }
    else if ($module == "login")
    {
        $cryptSessionID=md5($_COOKIE["obsidian"]);
        $qry6="SELECT userid FROM {$mpre}session WHERE session_ID='$cryptSessionID'";
        $result6=$database->openConnectionWithReturn($qry6);
        if (mysql_num_rows($result6)!=0)
        	list ($uid)=mysql_fetch_array($result6);
        if ($uid == '' || $uid == 0)
        {
            $option = strstr($REQUEST_URI, '?');
            $components->AuthorLogin($title, $option, $logintop);
        }
        echo "<br />";
    }
    else if ($module == "usermenu")
    {
        $cryptSessionID=md5($_COOKIE["obsidian"]);
        $qry6="SELECT userid FROM {$mpre}session WHERE session_ID='$cryptSessionID'";
        $result6=$database->openConnectionWithReturn($qry6);
        if (mysql_num_rows($result6)!=0)
        	list($uid)=mysql_fetch_array($result6);
        if ($uid != '' && $uid !=0)
        {
            $op2="showMenuComponent";
            include ("usermenu.php");
        }
        echo "<br />";
    }
    elseif ($module == "search")
    {
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td>
                <form action="index.php" method="post">
                    <p>
                    <?php
                    if ($searchtop)
                        echo "<img src=\"{$searchtop}\" width=\"122\" height=\"20\"  alt=\"Search the Site\" />";
                    ?><br />
                    <input type="text" name="searchword" size="12" />
                    <input type="hidden" name="option" value="search" /><br />
                    <input type="Submit" name="Submit" value="Submit" class="button" />
	                </p>
                </form>
            </td>
            </tr>
        </table>
        <br />
        <?php
    }
    else if ($module == "newsfeeds")
    {
        echo "<div class=\"componentHeading\">$title</div>\n";
        include("newsfeeds.php");
        echo "<br />";
    }
    elseif ($module == "whos_online")
    {
        include ("whosOnline.php");
        $components->component($title, $content);
        echo "<br />";
    }
    elseif ($module == "spotlight")
    {
        include ("spotlight.php");
        $components->component($title, $content);
        echo "<br />";
    }
    else
    {
        $qry5 = "SELECT content FROM {$mpre}component_module WHERE componentid=$id1";
        $result5 = $database->openConnectionWithReturn($qry5);
        list ($content, $components) = mysql_fetch_array($result5);
    }
}
?>
