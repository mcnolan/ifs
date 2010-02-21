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
/* if not, give them an error screen and exit			 */
/*-------------------------------------------------------*/

$ip = getenv("REMOTE_ADDR");
if ($reason = check_ban($database, $mpre, $spre, $Email, $ip, 'crew'))
{
	echo "You have been banned!<br /><br />\n";
    echo $reason . "<br /><br />\n\n";
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
	echo "Please wait at least five minutes between submitting applications.<br /><br />\n\n";
    $quit = "1";
}

$qry = "SELECT c.id FROM {$spre}characters c, {$mpre}users u
		WHERE u.email='$Email' AND c.player=u.id AND
        c.ship!='" . DELETED_SHIP . "' && c.ship!='" . FSS_SHIP . "'";
$result = $database->openConnectionWithReturn($qry);
if ( (mysql_num_rows($result) >= maxchars) && maxchars > "0" )
{
	echo "You may only have a maximum of " . maxchars . " characters.<br /><br />\n\n";
    $quit = "1";
}

$qry = "SELECT id FROM {$spre}ships WHERE name='$Ship'";
$result = $database->openConnectionWithReturn($qry);
list ($sid) = mysql_fetch_array($result);
$qry = "SELECT r.rankdesc, c.name FROM {$spre}characters c, {$mpre}users u, {$spre}rank r
		WHERE u.email='$Email' AND c.player=u.id AND c.ship='$sid' AND c.rank=r.rankid";
$result = $database->openConnectionWithReturn($qry);
if (mysql_num_rows($result))
{
	list ($rank, $cname) = mysql_fetch_array($result);
	echo "You may only have one character per ship.<br />\n";
    echo "Our records indicate that you already have a character on $Ship - $rank $cname.<br /><br />\n\n";
    $quit = "1";
}

if ($Email == "")
{
    echo "Please enter your email address.<br /><br />\n\n";
    $quit = "1";
}

if ($Follow_OF_Rules != "Yes")
{
    echo "Sorry, but you must agree to follow the rules.<br /><br />\n\n";
    $quit = "1";
}


if ($Characters_Name == "")
{
    echo "Please select a character name.<br /><br />\n\n";
    $quit = "1";
}


if ($Characters_Race == "")
{
    echo "Please select a character race.<br /><br />\n\n";
    $quit = "1";
}


if ($Characters_Gender == "")
{
    echo "Please select a character gender.<br /><br />\n\n";
    $quit = "1";
}


if ($Character_Bio == "")
{
    echo "Please enter a brief biography for your character.<br /><br />\n\n";
    $quit = "1";
}

if ($Sample_Post=="")
{
	echo "Please provide a sample post (see the example for a guideline if you need).<br /><br />\n\n";
    $quit = "1";
}

if ($First_Desired_Position == "-----Select Position----")
{
    echo "Please choose a first choice position.<br /><br />\n\n";
    $quit = "1";
}


if ($Second_Desired_Position == "-----Select Position----")
{
    echo "Please choose a second choice position.<br /><br />\n\n";
    $quit = "1";
}


if ($Officer_or_Enlisted == "<option selected>----- Enlisted Personnel or Officer ----</option>")
{
    echo "Please choose your rank type -- officer, warrent, or enlisted.<br /><br />\n\n";
    $quit = "1";
}

if ($quit != "1")
{

	if (($First_Desired_Position == "Other") || ($First_Desired_Position == "other"))
	    $First_Desired_Position = $otherpos1;

	if (($Second_Desired_Position == "Other") || ($Second_Desired_Position == "other"))
	    $Second_Desired_Position = $otherpos2;

	/* Find out who to send this thing to... */
	if ($Ship != "Any")
    {
	    $qry = "SELECT id, co FROM {$spre}ships WHERE name='$Ship'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($sid,$coid) = mysql_fetch_array($result);

	    $qry = "SELECT player FROM {$spre}characters WHERE id='$coid'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($uid) = mysql_fetch_array($result);

	    $qry = "SELECT email FROM {$mpre}users WHERE id='$uid'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($coemail) = mysql_fetch_array($result);
	}
    else
	    $sid = UNASSIGNED_SHIP;

	/*-------------------------------------------------------*/
	/* Add the applicant to the IFS database                 */
	/*-------------------------------------------------------*/

	// find out if this person already has a UID
	$qry = "SELECT id, password FROM {$mpre}users WHERE email='$Email'";
	$result = $database->openConnectionWithReturn($qry);
	list ($uid, $pass) = mysql_fetch_array($result);

	// if they don't have a UID, create one
	if (!$uid)
    {
	    list($username, $pass, $uid) = make_uid ($database, $mpre, $Name, $Characters_Name, $Email);
	    $message = "Our records indicate that you do not currently have a character (based on your email address).  Here is your login information for the {$fleetname} site: {$live_site}\n\n";
	    $message .= "Username - $username\n";
	    $message .= "Password - $pass\n\n";
	    $message .= "If you already have a login, and wish to consolidate your logins, please email " . webmasteremail . "\n\n";

	    $neednewuser = "1";
	    $details = "UID created: " . $uid . "<br />\n";
	}
    else
	    $details = "UID found: " . $uid . "<br />\n";

	// Insert character into db
	$date = date("F j, Y, g:i a", time());
	$ptime = time();
	$enterpos = $First_Desired_Position . " / " . $Second_Desired_Position;

	$qry = "INSERT INTO {$spre}characters
    		SET name='$Characters_Name', race='$Characters_Race', gender='$Characters_Gender',
            	rank='" . PENDING_RANK . "', ship='$sid', pos='$enterpos', player='$uid', bio='$Character_Bio',
		        other='Applied on $date', pending='1', ptime='$ptime'";
	$result=$database->openConnectionWithReturn($qry);

	// Service record entry
	$details .= "Ship: " . $Ship . "<br />\n";
	$time = time();
	$qry = "INSERT INTO {$spre}record
    		SET pid='$uid', cid=LAST_INSERT_ID(), level='Out-of-Character', date='$time',
            	entry='Application Received: $Characters_Name', details='$details',
                name='IFS'";
	$database->openConnectionNoReturn($qry);

	$qry = "SELECT cid FROM {$spre}record WHERE id=LAST_INSERT_ID();";
	$result = $database->openConnectionWithReturn($qry);
	list ($cid) = mysql_fetch_array($result);

	$subject = fleetname . " Application";
	$headers = "From: " . emailfrom . "\nX-Mailer:PHP\nip: $ip\n";

	$body = "Requested Ship: $Ship\n";
	$body .= "Requested Class: $desiredclass\n";
	$body .= "Alternate Class: $altclass\n\n";

	$body .= "Email Address: $Email\n";
	$body .= "Real Name: $Name\n";
	$body .= "Age: $Age\n\n";

	$body .= "Character Name: $Characters_Name\n";
	$body .= "Character Race: $Characters_Race\n";
	$body .= "Character Gender: $Characters_Gender\n\n";

	$body .= "Desired Position: $First_Desired_Position\n";
	$body .= "Alternate Position: $Second_Desired_Position\n";
	if ($Officer_or_Enslisted == "Officer")
    {
	    $body .= "[x] Officer\n";
	    $body .= "[ ] Enlisted\n\n";
	}
    elseif ($Officer_or_Enlisted == "Enlisted")
    {
	    $body .= "[ ] Officer\n";
	    $body .= "[x] Enlisted\n\n";
	}

	$body .= "Bio:\n";
	$body .= "$Character_Bio\n\n";

	$body .= "Sample Post:\n";
	$body .= "$Sample_Post\n\n";

	$body .= "Experience:\n";
	$body .= "$RPG_Experience\n\n";

	$body .= "Reference:\n";
	$body .= "$Reference\n";
	$body .= "$Reference_Other\n\n";

	$body .= "AOL IM: $AOLIM\n";
	$body .= "ICQ: $ICQ\n";
	$body .= "Yahoo: $Yahoo\n\n";

	$body = stripslashes($body);
	$subject = stripslashes($subject);

	// This one goes to the applicant:
	$realbody = "Thank you for submitting an application!  Your application will be reviewed, and you will be contacted shortly.\n";

	if ($neednewuser)
	    $realbody .= $message;

	$realbody .= "Here is a copy of your application:\n\n";
	$realbody .= $body;
	$realbody .= "\nYou are being sent this email because you requested to join the crew of a simm.\n";
	$realbody .= "If this is in error, please notify " . webmasteremail . "\n";
	mail ($Email, $subject, $realbody, $headers);
	$allemails = $Email;

	// This one goes to the CO:
	if ($Ship != "Any")
    {
	    $realbody = "This character has been automatically added to your ship's manifest.\n";
	    $realbody .= "Please login to update the character's rank and position.\n\n";

	    $realbody .= $body;
	    mail ($coemail, $subject, $realbody, $headers);
	    $allemails .= ", " . $coemail;
	}
    else
    {
	    $realbody = "This character is currently pending, waiting to be assigned.\n";

	    $realbody .= $body;
	    mail (webmasteremail, $subject, $realbody, $headers);
	    $allemails .= ", " . $coemail;
	}

	// Save it in the db
	$body = addslashes($body);
	$nowtime = time();
	$body = htmlspecialchars($body);
	$qry = "INSERT INTO {$spre}apps
    		SET type='crew', date='$nowtime', app='$body', forward='$allemails', ip='$ip'";
	$database->openConnectionNoReturn($qry);

	$qry = "UPDATE {$spre}characters SET app=LAST_INSERT_ID() WHERE id='$cid'";
	$database->openConnectionNoReturn($qry);


	/*-------------------------------------------------------*/
	/* Display a Thank-You page                              */
	/*-------------------------------------------------------*/
	?>

	<font size="+1"><p align="center">Form received.  Thank you! </p></font>

	<?php
}
?>