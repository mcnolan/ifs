<?
session_start();
	if (!session_is_registered("session_id")) {
		print "<script> document.location.href='../index.php'</script>";
		exit();
		}

include ("../configuration.php");

if ($install == "Install Modules"){
	mysql_connect($host, $user, $password) or die ("Could not connect to database.<BR>Please check your configuration and try again.");
	mysql_select_db($db) or die ("Could not select database.<br>Please check your configuration and try again.");
	for ($s = 0; $s < count($install_mod); $s++){
		$readfile = file("../modules/$install_mod[$s].php");
		if (!($readfile)) {
			return 0;
			die;
			}
		$mod_name = split("//",$readfile[1]);
		$mod_name[1] = trim($mod_name[1]);
		//print "$mod_name[1]<br>\n";
		$query="SELECT id FROM components WHERE module='$install_mod[$s]'";
		$result = mysql_query($query);
		$num_of_rows = mysql_num_rows($result);
		if ($num_of_rows==0) {
			$query2="INSERT INTO components VALUES ('', '$mod_name[1]', 4, 'left', 0, '00:00:00', 1, NULL, '$install_mod[$s]', 0);";
			$result = mysql_query($query2);
		}
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Custom Page Module Installer</title>
<link rel="stylesheet" href="../css/admin.css" type="text/css">
</head>

<body bgcolor="#dddddd">
<center>
<table width="351" border="0" cellspacing="1" cellpadding="0" bgcolor="#666666738CB5">
  <tr colspan=2>
    <td bgcolor="#666666" align="center" height="39"><font color="#ccff00"><b><font face="Arial, Helvetica, sans-serif" size="2">Custom Page
      Module Installer</font></b><br>This will only install modules found in the modules directory</font></td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="350" border="0" cellspacing="0" cellpadding="3" bgcolor="#FFFFFF">
        <tr>
          <td colspan=2>
            <?
mysql_connect($host, $user, $password) or die ("Could not connect");
mysql_select_db($db) or die ("Could not select database");
$query = "SELECT title, module FROM components WHERE module LIKE 'mod_%' ORDER BY module";
$result = mysql_query($query);
$num_of_rows = mysql_num_rows($result);
?>
        <tr>
	<td colspan=2 height="26" class="articlehead">Installed modules:&nbsp;
        <font color="red"><?print "<b>$num_of_rows</b>"; ?></font>
	</td>
        </tr>
        <tr>
          <td width="168">
          <td width="169"></td>
        <tr colspan=2>
          <TD class="bold">Page Module Name</TD>
          <TD class="bold">Page Module File</TD>
        </tr>
        <tr colspan=2>
          <?
	$j=0;
	if ($num_of_rows=="0") {
		print ("<TD><span class=bold>No custom modules installed</span></TD>");
		} else {
		while ($row = mysql_fetch_array($result)) {
			$list[$j]=$row[module]; ?>
      			<TD><span class="small"><? print ("$row[title]"); ?></span></TD>
          		<TD><span class="small"><? print ("$row[module]"); ?></span></TD>
        		</TR>
        		<?
			$j++;
			}
		}

if ($handle=opendir("../modules/")) {
	$i=0;
	while ($file = readdir($handle)) {
		if ($file <> "." && $file <> "..") {
			$available[$i]=substr($file,0,-4);
			$i++;
		}
	}
}
?>
        <FORM action='module_installer.php'>
          <tr>
            <td colspan=2 height="26" class="articlehead">Available modules:</td>
          </tr>
            <?
$no_available = 1;
$k=0;
while ($available[$k]) {
	if (!in_array_key($available[$k],$list)) {
		$readfile = file("../modules/$available[$k].php");
		if (!($readfile)) {
			return 0;
			die;
		}
		$mod_name = split("//",$readfile[1]);
		$mod_name[1] = trim($mod_name[1]);
		//print "$mod_name[1]<br>\n";
		print "<tr><td colspan=2><INPUT TYPE='checkbox' NAME='install_mod[]' VALUE='$available[$k]'><span class='bold'>$mod_name[1] - $available[$k]</span></td></tr>";
		$no_available = 0;
	}
	$k++;
}
if ($no_available) print "<tr><td colspan=2><span class='bold'>No custom modules to install</span></td></tr>";
?>
            <td>
            <td></td>
          </tr>
          <tr>
            <td colspan=2 height="32" align="right">
              <?
print "<INPUT class='button' TYPE='submit' NAME='install' VALUE='Install Modules'>";
?>
            </td>
        </FORM>
<?
function in_array_key($key, $array) {
	$i=0;
	while ($array[$i]) {
		if ($array[$i] == $key)
			return true;
	$i++;
	}
	return false;
}
?>
      </table>
    </td>
  </tr>
</table>
<a href="javascript: window.opener.focus; window.close();">Close</a>
</center>
</BODY>
</HTML>
