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
  * Date:	4/12/04
  * Comments: Processes crew applications
  *
 ***/

if (!defined("IFS"))
{
	echo "Hacking attempt";
    $quit = "1";
}


/*-------------------------------------------------------*/
/* Check to make sure all fields are filled out, and	 */
/* if not, give them an error screen and exit		 */
/*-------------------------------------------------------*/

$ip = getenv("REMOTE_ADDR");

if ($reason = check_ban($database, $mpre, $spre, $Email, $ip, 'command'))
{
	echo "You have been banned!<br /><br />";
    echo $reason;
	$quit = "1";
}

if (strstr ($Email, '@'))
{
	$emaildomain = strstr ($Email, '@');
	if (!strstr($emaildomain, "."))
    {
	    echo "Please enter a valid email address.<br /><br />\n";
	    $quit = "1";
    }
}
else
{
    echo "Please enter a valid email address.<br /><br />\n";
    $quit = "1";
}

$recentdate = time() - 5*60;
$qry = "SELECT id FROM {$spre}apps WHERE ip='$ip' AND date>'$recentdate'";
$result = $database->openConnectionWithReturn($qry);
$qry2 = "SELECT a.id FROM {$spre}apps a, {$spre}characters c, {$mpre}users u
		 WHERE u.email='$Email' AND c.player=u.id AND c.app=a.id AND a.date>'$recentdate'";
$result2 = $database->openConnectionWithReturn($qry2);
if (mysql_num_rows($result) || mysql_num_rows($result2))
{
	echo "Please wait at least five minutes between submitting applications.<br /><br />";
    $quit = "1";
}

$qry = "SELECT c.id FROM {$spre}characters c, {$mpre}users u
		WHERE u.email='$Email' AND c.player=u.id AND
        c.ship!='" . DELETED_SHIP . "' && c.ship!='" . FSS_SHIP . "'";
$result = $database->openConnectionWithReturn($qry);
if ( (mysql_num_rows($result) > max-chars) && max-chars > "0" )
{
	echo "You may only have a maximum of " . max-chars . " characters.<br /><br />";
    $quit = "1";
}

$qry = "SELECT c.id FROM {$spre}characters c, {$mpre}users u
		WHERE u.email='$Email' AND c.player=u.id AND
        c.ship!='" . DELETED_SHIP . "' && c.ship!='" . FSS_SHIP . "' &&
        c.ship!='" . UNASSIGNED_SHIP . "' && c.pos='Commanding Officer'";
$result = $database->openConnectionWithReturn($qry);
if (mysql_num_rows($result))
{
	echo "You may only command one ship.<br /><br />";
    $quit = "1";
}

if ($Email == "")
{
    echo "Please enter your email address.<br /><br />";
    $quit = "1";
}


if ($Follow_OF_Rules != "")
{
    echo "Sorry, but you must agree to follow the rules.<br /><br />";
    $quit = "1";
}


if ($Characters_Name == "")
{
    echo "Please select a character name.<br /><br />";
    $quit = "1";
}


if ($Characters_Race == "")
{
    echo "Please select a character race.<br /><br />";
    $quit = "1";
}


if ($Characters_Gender == "")
{
    echo "Please select a character gender.<br /><br />";
    $quit = "1";
}


if ($Character_Bio == "")
{
    echo "Please enter a brief biography for your character.<br /><br />";
    $quit = "1";
}

if ($quit != "1")
{

	/* Find out who to send this thing to... */
	if ($ship != "Any")
    {
	    $qry = "SELECT tf, tg FROM {$spre}ships WHERE name='$ship'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tf,$tg) = mysql_fetch_array($result);

	    $qry = "SELECT co FROM {$spre}taskforces WHERE tf='$tf' AND tg='0'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tfco) = mysql_fetch_array($result);

	    $qry = "SELECT player FROM {$spre}characters WHERE id='$tfco'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tfuid) = mysql_fetch_array($result);

	    $qry = "SELECT email FROM {$mpre}users WHERE id='$tfuid'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tfcoemail) = mysql_fetch_array($result);


	    $qry = "SELECT co FROM {$spre}taskforces WHERE tf='$tf' AND tg='$tg'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tgco) = mysql_fetch_array($result);

	    $qry = "SELECT player FROM {$spre}characters WHERE id='$tgco'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tguid) = mysql_fetch_array($result);

	    $qry = "SELECT email FROM {$mpre}users WHERE id='$tguid'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($tgcoemail) = mysql_fetch_array($result);
	}


	/*-------------------------------------------------------*/
	/* Add the applicant to the IFS database                 */
	/*-------------------------------------------------------*/

	// find out if this person already has a UID
	$qry = "SELECT id FROM {$mpre}users WHERE email='$Email'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uid) = mysql_fetch_array($result);

	// if they don't have a UID, create one
	if (!$uid)
    {
	    list($username, $pass, $uid) = make_uid ($database, $mpre, $Name, $Characters_Name, $Email);
	    $message = "Our records indicate that you do not currently have a character in {$fleetname} (based on your email address).  Here is your login information for the Fleet site: {$live_site}\n\n";
	    $message .= "Username - $username\n";
	    $message .= "Password - $pass\n\n";
	    $message .= "If you already have a login, and wish to consolidate your logins, please email " . webmasteremail . "\n\n";

	    $neednewuser = "1";
	    $details = "UID created: " . $uid . "<br />\n";
	} else
	    $details = "UID found: " . $uid . "<br />\n";

	// Insert character into db
	$date = date("F j, Y, g:i a", time());
	$ptime = time();

	$qry = "INSERT INTO {$spre}characters SET name='$Characters_Name',
	        race='$Characters_Race', gender='$Characters_Gender', rank='" . PENDING_RANK . "',
	        ship='" . UNASSIGNED_SHIP . "', pos='Commanding Officer',
	        player='$uid', bio='$Character_Bio', other='Applied on $date',
	        pending='1', ptime='$ptime'";
	$result=$database->openConnectionWithReturn($qry);

	// Service Record
	$details .= "Ship: " . $Ship . "<br />\n";
	$details .= "CO App<br />\n";
	$time = time();
	$qry = "INSERT INTO {$spre}record
    		SET pid='$uid', cid=LAST_INSERT_ID(), level='Out-of-Character', date='$time',
            	entry='Application Received: $Characters_Name', details='$details',
                name='IFS'";
	$database->openConnectionNoReturn($qry);

	$qry = "SELECT cid FROM {$spre}record WHERE id=LAST_INSERT_ID();";
	$result = $database->openConnectionWithReturn($qry);
	list ($cid) = mysql_fetch_array($result);


	$subject = "CO Application";
  	$headers = "From: " . emailfrom . "\nX-Mailer:PHP\nip: $ip";

	$body = "Requested Ship: $ship\n";
	$body .= "Requested Class: $desiredclass\n";
	$body .= "Alternate Class: $altclass\n\n";

	$body .= "Email Address: $Email\n\n";
	$body .= "Real Name: $Name\n";
	$body .= "Age: $Age\n";

	$body .= "Character Name: $Characters_Name\n";
	$body .= "Character Race: $Characters_Race\n";
	$body .= "Character Gender: $Characters_Gender\n\n";

	$body .= "Bio:\n";
	$body .= "$Character_Bio\n\n";

	$body .= "Sample Post:\n";
	$body .= "$Sample_Post\n\n";

	$body .= "Experience:\n";
	$body .= "$RPG_Experience\n";
	$body .= "Simming for $Time_In_Other_RPGs\n\n";

	$body .= "Reference:\n";
	$body .= "$Reference\n";
	$body .= "$Reference_Other\n\n";

	$body .= "AOL IM: $AOLIM\n";
	$body .= "ICQ: $ICQ\n";
	$body .= "Yahoo: $Yahoo\n\n";

	$body .= "Questionnaire:\n";
	$body .= "~~~~~~~~~~~~~~\n";
	$body .= "What do you think are the duties of a ship's Commanding Officer, both in-character and out-of-character?\n\n";
	$body .= "$q1\n\n";
	$body .= "What role do you think XOs and department heads should play in helping run the ship / simm?\n\n";
	$body .= "$q2\n\n";
	$body .= "How do you plan to recruit?\n\n";
	$body .= "$q3\n\n";
	$body .= "Posting has dropped to an all-time low, there are only 1 or 2 posts a week.  What will you do to motive your crew into posting again?\n\n";
	$body .= "$q4\n\n";
	$body .= "A crewmember has come to you, complaining about someone else and accusing them of being control-freaks. How do you handle it?\n\n";
	$body .= "$q5\n\n";
	$body .= "You disagree with a decision made by the Admiralty and other CO's of the fleet. What do you do?\n\n";
	$body .= "$q6\n\n";

	$body = stripslashes($body);

	// This one goes to the applicant:
	$realbody = "Thank you for submitting an application!  Your application will be reviewed, and you will be contacted shortly.\n";

	if ($neednewuser)
	    $realbody .= $message;

	$realbody .= "Here is a copy of your application:\n\n";
	$realbody .= $body;
	$realbody .= "\nYou are being sent this email because you requested to become CO of a simm.\n";
	$realbody .= "If this is in error, please notify " . webmasteremail . "\n";

	$realbody = stripslashes($realbody);
	$subject = stripslashes($subject);

	mail ($Email, $subject, $realbody, $headers);
	$allemails = $Email;

	// This one goes to the TF Staff:
	if ($ship != "Any")
    {
	    $recip = "$tfcoemail, $tgcoemail";
	    mail ($recip, $subject, $body, $headers);
		$allemails .= ", " . $recip;
	}
    else
    {
	    $realbody = "Please forward this app.\n\n";
	    $realbody .= $body;
	    $subject = "CO App";
		mail (webmasteremail, $subject, $realbody, $headers);
		$allemails .= ", " . webmasteremail;
	}

	// Save it in the db
	$body = addslashes($body);
	$nowtime = time();
	$body = htmlspecialchars($body);
	$qry = "INSERT INTO {$spre}apps
    		SET type='co', date='$nowtime', app='$body', forward='$allemails', ip='$ip'";
	$database->openConnectionNoReturn($qry);

	$qry = "UPDATE {$spre}characters SET app=LAST_INSERT_ID() WHERE id='$cid'";
	$database->openConnectionNoReturn($qry);


	// thank-you page
	?>
	<font size="+1"><p align="center">Form received.  Thank you! </p></font>

	<?php
}
?>