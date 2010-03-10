<?
	/**
	 *	Mambo Site Server Open Source Edition Version 3.0.5
	 *	Dynamic portal server and Content managment engine
	 *	27-11-2002
 	 *
	 *	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 3.0.5
	 *	File Name: statistics.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/

	class statistics {
		function browser_stats($database, $statisticshtml, $task, $mpre){
			$query = "SELECT name, count FROM " . $mpre . "counter WHERE type='browser' ORDER BY count DESC";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			$sum = 0;
			while ($row = mysql_fetch_object($result)){
				$count[$i] = $row->count;
				$ChartLabel[$i] = $row->name;
				$sum += $count[$i];
				$i++;
				}
			mysql_free_result($result);

			if ($sum < 50){
				$BarScale = 1;
				}
			elseif ($sum > 50 && $sum < 200){
				$BarScale = 2;
				}
			elseif ($sum > 200 && $sum < 500){
				$BarScale = 3;
				}
			elseif ($sum > 500 && $sum < 1000){
				$BarScale = 4;
				}
			elseif ($sum > 1000 && $sum < 5000){
				$BarScale = 5;
				}
			elseif ($sum > 5000 && $sum < 10000){
				$BarScale = 6;
				}

			if ($sum <> 0){
				for ($t = 0; $t < count($count); $t++){
					$percent = 100*$count[$t]/$sum;
					$percentInt[$t] = (int)$percent * 4 * $BarScale;
					}
				}
			$statisticshtml->show_browser_stats($percentInt, $count, $ChartLabel, $sum, $task);
			}

		function os_stats($database, $statisticshtml, $task, $mpre){
			$query = "SELECT name, count FROM " . $mpre . "counter WHERE type='os' ORDER BY count DESC";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			$sum = 0;
			while ($row = mysql_fetch_object($result)){
				$count[$i] = $row->count;
				$ChartLabel[$i] = $row->name;
				$sum += $count[$i];
				$i++;
				}
			mysql_free_result($result);

			if ($sum < 50){
				$BarScale = 1;
				}
			elseif ($sum > 50 && $sum < 200){
				$BarScale = 2;
				}
			elseif ($sum > 200 && $sum < 500){
				$BarScale = 3;
				}
			elseif ($sum > 500 && $sum < 1000){
				$BarScale = 4;
				}
			elseif ($sum > 1000 && $sum < 5000){
				$BarScale = 5;
				}
			elseif ($sum > 5000 && $sum < 10000){
				$BarScale = 6;
				}

			if ($sum <> 0){
				for ($t = 0; $t < count($count); $t++){
					$percent = 100*$count[$t]/$sum;
					$percentInt[$t] = (int)$percent * 4 * $BarScale;
					}
				}
			$statisticshtml->show_browser_stats($percentInt, $count, $ChartLabel, $sum, $task);
			}
		}
?>