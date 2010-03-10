<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Version:	1.11
  * Release Date: June 3, 2004
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file based on code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	12/9/03
  *	Comments: Retrieve and display poll information.
 ***/

require ("configuration.php");
require ("classes/html/poll.php");
$poll = new poll();
$cookiename="voted".$_POST['polls'];
$cook = $HTTP_COOKIE_VARS["$cookiename"];

$sessioncookie = $HTTP_COOKIE_VARS["session"];

if(isset($_GET['task'])) {
		$task = $_GET['task'];
} else {
		$task = $_POST['task'];
}

switch ($task)
{
    case "Vote":
        addvote($_POST['voteID'], $cook, $_POST['polls'], $sessioncookie, $mpre, $spre);
        break;
    case "Results":
        pollresult($database, $poll, $_POST['view'], $_GET['polls'], $_GET['month'], $mpre);
        break;
}

function addvote($voteID, $cook, $pollID, $sessioncookie, $mpre, $spre)
{
    require ("classes/database.php");
    $database = new database();

    if (!$sessioncookie)
        print "<SCRIPT>alert('Cookies must be enabled'); window.history.go(-1);</SCRIPT>\n";
    else
    {
        // check if cookie exists
        if($cook == "1")
            // cookie exists, invalidate this vote
            print "<SCRIPT> alert('You already voted for this survey!'); window.history.go(-1);</SCRIPT>\n";
        else
        {
            if ($voteID == 0)
                print "<SCRIPT>alert('No selection has been made, please try again'); window.history.go(-1);</SCRIPT>\n";

            // cookie does not exist yet, set one now
            $cvalue = "1";
            $cookiename="voted".$pollID;
            setcookie("$cookiename", $cvalue, time()+60*60*24*365);
        }

        // check if this IP has voted
        $ip = getenv("REMOTE_ADDR");
        $qry = "SELECT id
        		FROM {$mpre}poll_date
                WHERE vote_id='$voteID' AND poll_id='$pollID' AND ip='$ip'";
        $result = $database->openConnectionWithReturn($qry);
        list ($pdateid) = mysql_fetch_array($result);

        if ($pdateid)
            // cookie exists, invalidate this vote
            print "<SCRIPT> alert('You already voted for this survey!'); window.history.go(-1);</SCRIPT>\n";

        // update database if the vote is valid and if not an empty vote
        if((!$cook) && (!$pdateid) && ($voteID > 0) )
        {
            $qry = "UPDATE {$mpre}poll_data
                    SET optionCount=optionCount + 1
                    WHERE pollID='$pollID' AND voteID='$voteID'";
            $database->openConnectionNoReturn($qry);
            $voters = $voters + 1;
            $qry = "UPDATE {$mpre}poll_desc SET voters=voters + 1 WHERE pollID='$pollID'";
            $database->openConnectionNoReturn($qry);

            $today = date("Y-m-d G:i:s");
            $query = "INSERT INTO {$mpre}poll_date
            		  SET date='$today', vote_id='$voteID', poll_id='$pollID', ip='$ip'";
            $database->openConnectionNoReturn($qry);

            $qry = "INSERT INTO {$spre}logs
            		(date, user, action, comments)
                    VALUES (now(), '$uid $uname', 'Vote', 'poll $pollID (voted $voteID) from $ip')";
            $database->openConnectionNoReturn($qry);

            echo "<SCRIPT> alert('Thanks for your vote. To view poll results click the \'Results\' button'); window.history.go(-1);</SCRIPT>";
        }
    }
}

function pollresult($database, $poll, $view, $pollID, $month, $mpre)
{
    $year = date("Y");
    $number_of_days = @date("t",mktime(0,0,0,1,$month,$year));

    $qry = "SELECT pollID, pollTitle, voters FROM {$mpre}poll_desc WHERE pollID='$pollID'";
    $result = $database->openConnectionWithReturn($qry);
    list ($pollID, $pollTitle, $voters) = mysql_fetch_array($result);

    $qry = "SELECT pollID, optionText, voteid
    		FROM {$mpre}poll_data
            WHERE pollID='$pollID' AND optionText <> '' ORDER BY voteid";
    $result = $database->openConnectionWithReturn($qry);
    for ($i=0;
    	 list($pollid[$i], $optionText[$i], $voteid[$i]) = mysql_fetch_array($result);
         $i++);

    $qry = "SELECT MIN(date), MAX(date) FROM {$mpre}poll_date WHERE poll_id='$pollID'";
    $result = $database->openConnectionWithReturn($qry);
    list ($mindate_time, $maxdate_time) = mysql_fetch_array($result);

    if ($mindate_time <> "")
    {
        $split_mindate_time = split(" ", $mindate_time);
        $mindate = split("-", $split_mindate_time[0]);
        $mintime = split(":", $split_mindate_time[1]);
        $first_vote = date("d/m/Y @ g:ia",mktime($mintime[0],$mintime[1],$mintime[2],$mindate[1],$mindate[2],$mindate[0]));
    }

    if ($maxdate_time <> "")
    {
        $split_maxdate_time = split(" ", $maxdate_time);
        $maxdate = split("-", $split_maxdate_time[0]);
        $maxtime = split(":", $split_maxdate_time[1]);
        $last_vote = date("d/m/Y @ g:ia",mktime($maxtime[0],$maxtime[1],$maxtime[2],$maxdate[1],$maxdate[2],$maxdate[0]));
    }

    $sum = 0;
    if ($month == "")
    {
        $qry = "SELECT optionText, optionCount
        		FROM {$mpre}poll_data
                WHERE pollid=$pollID AND optionText <> ''
                ORDER BY voteid";
        $result = $database->openConnectionWithReturn($qry);
		for ($i = 0;
        	 list($optionText[$i], $count[$i]) = mysql_fetch_array($result);
             $i++)
            $sum += $count[$i];
    }
    else
    {
        for ($i = 0; $i < count($voteid); $i++)
        {
            $qry2 = "SELECT * FROM {$mpre}poll_date
            		 WHERE date >= '$year-$month-01 00:00:00'
                     	AND date <= '$year-$month-$number_of_days 23:59:59'
                        AND vote_id='$voteid[$i]' AND poll_id='$pollID'";
            $result2 = $database->openConnectionWithReturn($qry2);
            $count[$i] = mysql_num_rows($result2);
            $sum += $count[$i];
        }
    }

    if ($sum < 50)
        $BarScale = 1;
    elseif ($sum > 50 && $sum < 200)
        $BarScale = 2;
    elseif ($sum > 200 && $sum < 500)
        $BarScale = 3;
    elseif ($sum > 500 && $sum < 1000)
        $BarScale = 4;
    elseif ($sum > 1000 && $sum < 5000)
        $BarScale = 5;
    elseif ($sum > 5000 && $sum < 10000)
        $BarScale = 6;

    if ($sum <> 0)
        for ($t = 0; $t < count($count); $t++)
        {
            $percent = 100*$count[$t]/$sum;
            $percentInt[$t] = (int)$percent * 4 * $BarScale;
        }

    $poll->pollresult($pollTitle, $last_vote, $first_vote, $voters, $percentInt, $optionText, $count, $sum, $month, $pollID);
}
?>