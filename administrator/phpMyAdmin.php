<?
include ("../configuration.php");
	if ($phpmyadmin!='') {
	echo "Click <a href='#' onClick=\"javascript:window.open('$phpmyadmin');\">here</a> to launch phpMyAdmin";
	exit();
	} else {
	echo "<center>";
	echo "<img src='../images/admin/warning.gif'><br>";
	echo "<b>phpMyAdmin is not installed or not configured<br></b>";
	echo "<b>in configuration.php!<br></b>";
	echo "<b><p>Edit your configuration.php file and enter a<br></b>";
	echo "<b>valid URL for phpMyAdmin.<br></b></center>";
	}
?>
