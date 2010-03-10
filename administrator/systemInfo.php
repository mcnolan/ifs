<?
	require ("classes/html/HTML_systemInfo.php");
	$systemInfohtml = new HTML_systemInfo();

	switch ($task){
		case "save":
			savesystemInfo($database, $sitename, $cur_theme, $col_main, $mpre);
			break;
		default:
			showsystemInfo($systemInfohtml, $database, $mpre);
		}


	function showsystemInfo($systemInfohtml, $database, $mpre){
		$query = "SELECT * FROM " . $mpre . "system";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$sitename = $row->sitename;
			$cur_theme = $row->cur_theme;
			$col_main = $row->col_main;
			}


		$systemInfohtml->showsystemInfo($sitename, $cur_theme, $col_main);
		}

	function savesystemInfo($database, $sitename, $cur_theme, $col_main, $mpre){
		$query = "DELETE FROM " . $mpre . "system";
		$database->openConnectionNoReturn($query);
		$query = "INSERT INTO " . $mpre . "system SET sitename='$sitename', cur_theme='$cur_theme', col_main='$col_main'";
        $database->openConnectionNoReturn($query);

		print "<SCRIPT>document.location.href='index2.php?option=systemInfo'</SCRIPT>\n";
		}
?>