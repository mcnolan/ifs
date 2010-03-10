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
  * Comments: Ship application
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

if ($reason2 = check_ban($database, $mpre, $spre, $Email, $ip, 'ship'))
{
	echo "You have been banned!<br /><br />";
    echo $reason2;
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
	echo "Please wait at least five minutes between submitting applications.<br />";
    $quit = "1";
}

if ($Email == "")
{
    echo "Please enter your email address.<br /><br />";
    $quit = "1";
}

if ($Follow_OF_Rules != "")
{
    echo "Sorry, but you must agree to follow OF rules.<br /><br />";
    $quit = "1";
}

if ($ship == "")
{
    echo "Please enter the name of your ship.<br /><br />";
    $quit = "1";
}

if ($shipclass == "")
{
    echo "Please enter the class of your ship.<br /><br />";
    $quit = "1";
}

if ($website == "")
{
    echo "Please enter your ship's webpage.<br /><br />";
    $quit = "1";
}

if ($active == "")
{
    echo "How long have you been active?.<br /><br />";
    $quit = "1";
}

if ($reason == "")
{
    echo "Please state your reasons for wanting to join the Borg collective.<br /><br />";
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
	$to = webmasteremail . ", $Email";
	$subject = "Ship Application";
	$headers = "From: " . emailfrom . "\nX-Mailer:PHP\nip: $ip";

	$body = "Simm application received -- thank you!\n";
	$body .= "Please note that this is not an acceptance letter.  After reviewing the application, we will email you our decision.\n\n";

	$body .= "Ship Name: $ship\n";
	$body .= "Ship Class: $shipclass\n";
	$body .= "Website: $website\n";
	$body .= "Time Active: $active\n";
	$body .= "Reasons for joining:\n";
	$body .= "$reason\n\n";

	$body .= "Real Name: $Name\n";
	$body .= "Email Address: $Email\n\n";

	$body .= "Age: $Age\n";
	$body .= "Location: $Location\n";
	$body .= "ISP: $ISP\n\n";

	$body .= "Character Name: $Characters_Name\n";
	$body .= "Character Race: $Characters_Race\n";
	$body .= "Character Gender: $Characters_Gender\n\n";

	$body .= "Bio:\n";
	$body .= "$Character_Bio\n\n";

	$body .= "Sample Post:\n";
	$body .= "$Sample_Post\n\n";

	$body .= "RPG experience:\n";
	$body .= "$RPG_Experience\n";
	$body .= "Simming for $Time_In_Other_RPGs\n\n";

	$body .= "Reference:\n";
	$body .= "$Reference\n";
	$body .= "$Reference_Other\n\n";

	$body .= "AOL IM: $AOLIM\n";
	$body .= "ICQ: $ICQ\n";
	$body .= "Yahoo: $Yahoo\n\n";

	$body .= "Extra Comments:\n";
	$body .= "~~~~~~~~~~~~~~~\n";
	$body .= "$extra_comments\n\n";

	$body = stripslashes($body);

	mail ($to, $subject, $body, $headers);


	// Save it in the db
	$body = addslashes($body);
	$date = time();
	$body = htmlspecialchars($body);
	$qry = "INSERT INTO {$spre}apps
    		SET type='ship', date='$date', app='$body', forward='$to', ip='$ip'";
	$database->openConnectionNoReturn($qry);


	// Thank-you page
	?>
	<font size="+1"><p align="center">Form received.  Thank you! </p></font>

	<?php
}
?>