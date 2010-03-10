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
	 *	File Name: survey.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/

	class survey {
		function showSurvey($option, $surveyhtml, $database, $mpre){
			$query = "SELECT pollID, pollTitle, published, editor FROM " . $mpre . "poll_desc";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$pollid[$i] = $row->pollID;
				$polltitle[$i] = $row->pollTitle;
				$published[$i] = $row->published;
				$editor[$i] = $row->editor;
				$i++;
				}
			mysql_free_result($result);
			$surveyhtml->showSurvey($option, $pollid, $polltitle, $published, $editor);
			}

		function editsurvey($surveyhtml, $database, $option, $pollid, $myname, $mpre){
			if ($pollid == ""){
				print "<SCRIPT> alert('Must choose a Poll to edit'); window.history.go(-1); </SCRIPT>\n";
				}

			$query = "SELECT pollTitle, checked_out, editor FROM " . $mpre . "poll_desc WHERE pollID='$pollid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$title = $row->pollTitle;
				$editor = $row->editor;
				}

			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The Survey $title is currently being edited by $editor'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				exit(0);
				}

			$date = date("H:i:s");
			$query = "UPDATE " . $mpre . "poll_desc SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE pollID='$pollid'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT pollTitle FROM " . $mpre . "poll_desc WHERE pollID='$pollid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$pollTitle = $row->pollTitle;
				}
			mysql_free_result($result);

			$query = "SELECT optionText, optionCount FROM " . $mpre . "poll_data WHERE pollID='$pollid' ORDER BY voteID";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$optionText[$i] = $row->optionText;
				$optionCount[$i] = $row->optionCount;
				$i++;
				}
			mysql_free_result($result);

			$query="select menuid from " . $mpre . "poll_menu where pollid='$pollid'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$menuid[$i] = $row->menuid;
				$i++;
				}

			mysql_free_result($result);

			$topquery="select Max(sublevel) as numlevels from " . $mpre . "menu where menutype='mainmenu'";
			$topresult=$database->openConnectionWithReturn($topquery);
			list ($numlevels)=mysql_fetch_array($topresult);
			$counter=0;
			for ($count=0; $count <= $numlevels; $count++){
				$query="select id, name, componentid from " . $mpre . "menu where menutype='mainmenu' and sublevel='$count' and contenttype!='web'";
				$result=$database->openConnectionWithReturn($query);
				$numItems=mysql_num_rows($result);
				for ($i=0; $i < $numItems; $i++){
					$row=mysql_fetch_object($result);
					$componentid[$counter]=$row->componentid;
					$ItemIdList[$counter]=$row->id;
					if ($componentid[$counter]==0){
						$ItemNameList[$counter]=$row->name;
						}
					else {
						$ItemName=$row->name;
						$nextID=$componentid[$counter];
						$stillitems=1;
						while ($stillitems==1){
							$query2="select name, componentid from " . $mpre . "menu where id='$nextID'";
							$result2=$database->openConnectionWithReturn($query2);
							list($nextName, $nextID)=mysql_fetch_array($result2);
							if ($nextNameList!=""){
								$nextNameList="$nextName/$nextNameList";
								}
							else {
								$nextNameList="$nextName";
								}

							if ($nextID!=0){
								$stillitems=1;
								}
							else {
								$ItemNameList[$counter]="$nextNameList/$ItemName";
								$nextNameList="";
								$stillitems=0;
								}
							}
						}
					$counter++;
					}
				mysql_free_result($result);
				}

			$surveyhtml->editSurvey($pollTitle, $optionText, $optionCount, $option, $pollid, $menuid, $ItemIdList, $ItemNameList);
			}

		function saveeditsurvey($database, $option, $pollid, $polloption, $optionCount, $pollorder, $title, $selections, $mpre){
			for ($i = 0; $i < count($polloption); $i++){
				$query = "UPDATE " . $mpre . "poll_data SET optionText='$polloption[$i]', optionCount='$optionCount[$i]' WHERE pollID='$pollid' AND voteID='$pollorder[$i]'";
				$database->openConnectionNoReturn($query);
				}

			$query = "UPDATE " . $mpre . "poll_desc SET pollTitle='$title', checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE pollID='$pollid'";
			$database->openConnectionNoReturn($query);

			$query="DELETE from " . $mpre . "poll_menu where pollid='$pollid'";
			$database->openConnectionNoReturn($query);

			for ($i = 0; $i < count($selections); $i++){
				$query2="INSERT into " . $mpre . "poll_menu set pollid='$pollid', menuid='$selections[$i]'";
				$database->openConnectionNoReturn($query2);
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
			}

		function savenewsurvey($database, $option, $title, $pollorder, $polloption, $selections, $mpre){
			$query = "INSERT INTO " . $mpre . "poll_desc SET pollTitle='$title'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT pollID FROM " . $mpre . "poll_desc WHERE pollTitle='$title'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$pollID = $row->pollID;
				}

			mysql_free_result($result);
			for ($i = 0; $i < 12; $i++){
				$j = $i + 1;
				$query = "INSERT INTO " . $mpre . "poll_data SET optionText='$polloption[$i]', optionCount=0, voteID='$pollorder[$i]', pollid='$pollID'";
				$database->openConnectionNoReturn($query);
				}

			for ($i = 0; $i < count($selections); $i++){
				$query2="INSERT into " . $mpre . "poll_menu set pollid='$pollID', menuid='$selections[$i]'";
				$database->openConnectionNoReturn($query2);
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
			}

		function removesurvey($database, $option, $cid, $mpre){
			for ($i = 0; $i < count($cid); $i++){
				$query = "DELETE FROM " . $mpre . "poll_data WHERE pollID=$cid[$i]";
				$database->openConnectionNoReturn($query);
				$query1 = "DELETE FROM " . $mpre . "poll_desc WHERE pollID=$cid[$i]";
				$database->openConnectionNoReturn($query1);
				$query="DELETE from " . $mpre . "poll_menu where pollid=$cid[$i]";
				$database->openConnectionNoReturn($query);
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
			}

		function publishsurvey($option, $database, $cid, $pollid, $mpre){
			if (count($cid)){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT checked_out FROM " . $mpre . "poll_desc WHERE pollID='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
						}

					if ($checked == 1){
						print "<SCRIPT>alert('This Survey cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
						}

					$query = "UPDATE " . $mpre . "poll_desc SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE pollID='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($pollid)) {
				$query = "UPDATE " . $mpre . "poll_desc SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE pollID='$pollid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				print "<SCRIPT>alert('Select a survey to publish'); window.history.go(-1);;</SCRIPT>\n";
				exit(0);
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
			}

		function unpublishsurvey($option, $database, $cid, $pollid, $mpre){
			if (count($cid)){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT checked_out FROM " . $mpre . "poll_desc WHERE pollID='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
						}

					if ($checked == 1){
						print "<SCRIPT>alert('This Survey cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
						}

					$query = "UPDATE " . $mpre . "poll_desc SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE pollID='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($pollid)) {
				$query = "UPDATE " . $mpre . "poll_desc SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE pollID='$pollid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				print "<SCRIPT>alert('Select a survey to unpublish'); window.history.go(-1);;</SCRIPT>\n";
				exit(0);
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
			}

		function addsurvey($option, $database, $surveyhtml, $mpre){
			$topquery="select Max(sublevel) as numlevels from " . $mpre . "menu where menutype='mainmenu'";
			$topresult=$database->openConnectionWithReturn($topquery);
			list ($numlevels)=mysql_fetch_array($topresult);
			$counter=0;
			for ($count=0; $count <= $numlevels; $count++){
				$query="select id, name, componentid from " . $mpre . "menu where menutype='mainmenu' and sublevel='$count' and contenttype!='web'";
				$result=$database->openConnectionWithReturn($query);
				$numItems=mysql_num_rows($result);
				for ($i=0; $i < $numItems; $i++){
					$row=mysql_fetch_object($result);
					$componentid[$counter]=$row->componentid;
					$ItemIdList[$counter]=$row->id;
					if ($componentid[$counter]==0){
						$ItemNameList[$counter]=$row->name;
						}
					else {
						$ItemName=$row->name;
						$nextID=$componentid[$counter];
						$stillitems=1;
						while ($stillitems==1){
							$query2="select name, componentid from " . $mpre . "menu where id='$nextID'";
							$result2=$database->openConnectionWithReturn($query2);
							list($nextName, $nextID)=mysql_fetch_array($result2);
							if ($nextNameList!=""){
								$nextNameList="$nextName/$nextNameList";
								}
							else {
								$nextNameList="$nextName";
								}

							if ($nextID!=0){
								$stillitems=1;
								}
							else {
								$ItemNameList[$counter]="$nextNameList/$ItemName";
								$nextNameList="";
								$stillitems=0;
								}
							}
						}
					$counter++;
					}
				mysql_free_result($result);
				}
			$surveyhtml->addsurvey($ItemIdList, $ItemNameList, $option);
			}
		}
?>