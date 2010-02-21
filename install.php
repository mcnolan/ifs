<?php
//IFS 1.13n Custom Installer
//Possible Options: ($_POST['action'])
//action=<empty> : Default, shows Database login options
//action=one : Detect path settings, Show basic options
//action=two : Install Core Scripts, Ask for default tf/tg's
//action=final : Show success screen

define(CONFIG_FILE, "configuration.php");
?>
<html>
	<head><title>IFS Install</title>
	<style>
	body {
	background-color: #000000;
	color: #ffffff;
	}
	table {
	border: 1px solid #ffffff;
	}
	</style>
	</head>
<body>

<?
switch($_GET['action']) {

case "one":
//Check Database connection
if($link = mysql_connect($_POST['hostname'],$_POST['username'],$_POST['password'])) {
	//Connection Success!
	$query = "SHOW DATABASES";
	$result = mysql_query($query,$link);
	?>
	<form action="?action=two" method="POST">
	<input type="hidden" name="username" value="<? echo $_POST['username']; ?>">
	<input type="hidden" name="password" value="<? echo $_POST['password']; ?>">
	<input type="hidden" name="hostname" value="<? echo $_POST['hostname']; ?>">
	<table align="center" width="700">
	<tr>
		<td><h2>IFS Installation</h2></td>
	</tr>
	<tr>
		<td colspan="2">Please Select the database you wish to install IFS to</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<select name="Database">
			<?
			while($db = mysql_fetch_array($result)) {
			?>
			<option value="<? echo $db[0]; ?>"><? echo $db[0]; ?></option>
			<?
			}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td><br><b>Table Prefixes</b></td>
	</tr>
	<tr>
		<td>IFS Tables</td>
		<td><input type="text" name="ifs_pre" value="ifs_"></td>
	</tr>
	<tr>
		<td>Mambo Tables</td>
		<td><input type="text" name="www_pre" value="www_"></td>
	</tr>
	<tr>
		<td>Ship Database Tables</td>
		<td><input type="text" name="sdb_pre" value="sdb_"></td>
	</tr>
	<tr>
		<td><br><b>Fleet Settings</b></td>
	</tr>
	<tr>
		<td>Fleet Name</td>
		<td><input type="text" name="fleetname" width="40"></td>
	</tr>
	<tr>
		<td>Fleet Description</td>
		<td><textarea name="fleetdesc" rows="4" cols="40">This text will appear in the bottom section of your front page, and is generally used to describe your fleet.</textarea></td>
	</tr>
	<tr>
		<td>Fleet Banner</td>
		<td><input type="text" name="fleetbanner" value="images/example-banner.jpg" size="30"></td>
	</tr>
	<tr>
		<td>Maximum Characters Per Player</td>
		<td><input type="text" name="maxchars" value="5" size="10"></td>
	</tr>
	<tr>
		<td><br><b>Email Settings</b></td>
	</tr>
	<tr>
		<td>Webmaster Email</td>
		<td><input type="text" name="webemail" value="user@domain.com" size="30"></td>
	</tr>
	<tr>
		<td>Site Email</td>
		<td><input type="text" name="frommail" value="IFS Mail <user@domain.com>" size="30"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value=" Next Step "></td>
	</tr>
	</table>
	</form>
	<?
} else {
	echo "Could not establish a connection. Please go <a href=\"#\" onclick=\"history.back();\">Back</a> and check your connection settings";
}

break;

case "two":
//Build Config File
$output = "<?php
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
  * Version:	1.13n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	6/03/04
  * Comments: Configuration variables
  *
  * See CHANGELOG for patch details
  *
 ***/

/********************
 * mySQL settings	*
 ********************/
\$host = '".$_POST['hostname']."';				// mySQL server

/* 	Feel free to change the following prefixes.  The install script reads this
    config file, so you don't need to worry about the defaults.			*/
\$mpre = '".$_POST['www_pre']."';						// prefix for webpage-related tables
\$spre = '".$_POST['ifs_pre']."';						// prefix for simm-related tables
\$sdb = '".$_POST['sdb_pre']."';						// prefix for shipdb tables

\$user = '".$_POST['username']."';						// mySQL username
\$password = '".$_POST['password']."';					// mySQL password
\$db = '".$_POST['Database']."';						// mySQL database

/********************
 * Email config		*
 ********************/
// The \"from\" address of IFS-generated email
\$emailfrom = \"".$_POST['frommail']."\";
// The webmaster's email address
\$webmasteremail = \"".$_POST['webemail']."\";

/********************
 * Misc Settings	*
 ********************/
\$maxchars = \"".$_POST['maxchars']."\";            		// Max. number of characters per player
\$fleetname = '".$_POST['fleetname']."';			// Name of the fleet
\$live_site = 'http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."';	// URL to your site
\$fleetdesc = '".$_POST['fleetdesc']."';
\$fleetbanner = '".$_POST['fleetbanner']."';	//

// Legacy settings from the Mambo config file.  Dunno how important they are
// Path settings
\$base_path = '".$_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['PHP_SELF'])."';
\$pdf_path = \$base_path + 'pdf/';
\$image_path = \$base_path + 'images/stories';
\$sitename = \$fleetname;
\$col = 3;
\$row = 3;

if (\$directory !='uploadfiles'){
	\$title[0] = 'Story Images';
	\$dir[0]=\$base_path + 'images/stories'; 
	\$picurl[0]=\$live_site + '/images/stories/';
	\$tndir[0]=\$live_site + '/images/stories/';
} else {
	\$title[0]='Uploaded File Images';
	\$dir[0]=\$base_path + 'uploadfiles/\$Itemid';
	\$picurl[0]=\$live_site + '/uploadfiles/\$Itemid';
	\$tndir[0]=\$live_site + '/uploadfiles/\$Itemid';
}

/********************
 * Various IDs		*
 ********************/
// you shouldn't need to touch this unless you've been playing with the db
define (\"UNASSIGNED_SHIP\", \"1\");
define (\"TRANSFER_SHIP\", \"2\");
define (\"DELETED_SHIP\", \"3\");
define (\"FSS_SHIP\", \"4\");
define (\"PENDING_RANK\", \"1\");

/********************
 * Constants	    *
 ********************/
// you shouldn't need to touch these, either.  In fact, don't.  =)
define (\"email-from\", \$emailfrom);
define (\"fleetname\", \$fleetname);
define (\"webmasteremail\", \$webmasteremail);
define (\"live_site\", \$live_site);
?>";

$handle = fopen(CONFIG_FILE, "wb");

	if(fwrite($handle,$output)) {
		//Success!
		include "manual_install.php";
		//If Linux, chmod settings file back to 755
		@chmod(CONFIG_FILE,0755);
		?>
		<table align="center" width="700">
		<tr>
			<td><h2>IFS Has been successfully installed!</h2></td>
		</tr>
		<tr>
			<td><br>Click <a href="index.php">here</a> to go to your installation, and login using admin/admin to get started.</td>
		</tr>
		</table>
		<?
	} else {
		//Failure.
		echo "Error occured during writing. Check configuration file is writeable";
	}
	fclose($handle);

break;

default:
//Check if settings file is writeable
if(file_exists(CONFIG_FILE) && is_writeable(CONFIG_FILE)) {
?>
<form action="?action=one" method="POST">
<table align="center" width="700">
<tr>
	<td colspan="2"><h2>Welcome to the IFS Installer</h2></td>
</tr>
<tr>
	<td colspan="2">Please Input Your MySQL Username and Password</td>
</tr>
<tr>
	<td>Username</td>
	<td><input type="text" size="20" name="username"></td>
</tr>
<tr>
	<td>Password</td>
	<td><input type="password" size="20" name="password"></td>
</tr>
<tr>
	<td>Hostname</td>
	<td><input type="text" size="20" name="hostname" value="localhost"></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value=" Next Step "></td>
</tr>
</table>
</form>
<?
} else {
	echo "Cannot write to file, please make sure File exists and has write permissions";
}
break;
}
?>
</body>
</html>
