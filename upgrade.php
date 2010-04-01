<?php
include "configuration.php";

if(isset($_POST['ok'])) {
	$query = "INSERT INTO `".$mpre."menu` (`menutype`, `name`, `link`, `contenttype`, `inuse`, `componentid`, `sublevel`, `ordering`, `checked_out`, `checked_out_time`, `editor`, `pollid`, `browserNav`) VALUES('Academy', 'Reassign Students', 'index.php?option=ifs&amp;task=academy&amp;action=reassign', NULL, 0, NULL, 0, 0, NULL, NULL, NULL, 0, 0);";
	mysql_connect($host,$user,$password) or die(mysql_error());
	mysql_select_db($db);
	mysql_query($query) or die(mysql_error());
	mysql_close();
	echo "Menu Item added. Delete this file after use";
} else {
?>
<h2>IFS 1.14n Upgrade</h2>This script will add the correct link for the student transfer utility to your menu. Do you wish to proceed?<br><br><center>
<form action="#" method="POST">

	<input type="submit" name="ok" value=" Yes ">
</form>
</center>
<?
}
?>
