<?PHP
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
	 *	File Name: subsections.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/

	class subsections {
		function viewSubItems($database, $subsectionshtml, $option, $sections, $mpre){
			$topquery="select Max(sublevel) as numlevels from " . $mpre . "menu where menutype='mainmenu'";
			$topresult=$database->openConnectionWithReturn($topquery);
			list ($numlevels)=mysql_fetch_array($topresult);
			$counter=0;
			for ($count=0; $count <= $numlevels; $count++){
				$query="select id, name, componentid from " . $mpre . "menu where menutype='mainmenu' and sublevel='$count' and contenttype!='mambo' order by name";
				$result=$database->openConnectionWithReturn($query);
				$numItems=mysql_num_rows($result);
				for ($i=0; $i < $numItems; $i++){
					$row=mysql_fetch_object($result);
					$componentid[$counter]=$row->componentid;
					$ItemIdList[$counter]=$row->id;
					if ($componentid[$counter]==0){
						$ItemNameList[$counter]=$row->name;
					}else{
						$ItemName=$row->name;
						$nextID=$componentid[$counter];
						$stillitems=1;
						while ($stillitems==1){
							$query2="select name, componentid from " . $mpre . "menu where id='$nextID'";
							$result2=$database->openConnectionWithReturn($query2);
							list($nextName, $nextID)=mysql_fetch_array($result2);
							if ($nextNameList!=""){
								$nextNameList="$nextName/$nextNameList";
							}else{
								$nextNameList="$nextName";
							}
							if ($nextID!=0){
								$stillitems=1;
							}else{
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

			if (($sections == "") || ($sections == "all")){
				$query="select id, name, link, inuse, componentid, contenttype from " . $mpre . "menu where menutype='mainmenu' and componentid!='0' order by ordering, id";
				$result= $database->openConnectionWithReturn($query);
				$i=0;

				while ($row=mysql_fetch_object($result)){
					$itemid[$i]=$row->id;
					$itemName[$i]=$row->name;
					$link[$i]=$row->link;
					$showmenu[$i]=$row->inuse;
					$componentid[$i]=$row->componentid;
					$contenttype[$i]=$row->contenttype;
					$editor[$i]=$row->editor;
					if ($componentid[$i]!=0){
						$query2="select name, componentid from " . $mpre . "menu where id=$componentid[$i]";
						$result2=$database->openConnectionWithReturn($query2);
						list ($pathname, $pathComponentid)=mysql_fetch_array($result2);
						mysql_free_result($result2);
						$path[$i]=$pathname;
						if ($pathComponentid==0){
							$pathstop=1;
						}else{
							$pathstop=0;
						}
						while ($pathstop == 0){
							$query3="select name, componentid from " . $mpre . "menu where id=$pathComponentid";
							$result3=$database->openConnectionWithReturn($query3);
							list ($pathname, $pathComponentid)=mysql_fetch_array($result3);
							$path[$i]="$pathname/ $path[$i]";
							if ($pathComponentid==0){
								$pathstop=1;
							}else{
								$pathstop=0;
							}
						}
					}

					if ($showmenu[$i]=="1"){
						$published[$i]="yes";
					}else{
						$published[$i]="no";
					}

					if ($contenttype[$i]=="mambo"){
						$type[$i]="Mambo Component";
					}else if ($contenttype[$i]=="file"){
						$type[$i]="File";
					}else if ($contenttype[$i]=="typed"){
						$type[$i]="Typed";
					}else if ($contenttype[$i]=="web"){
						$type[$i]="Web Link";
					}
					$i++;
				}
			} else {
				$query="select id, name, link, inuse, componentid, contenttype from " . $mpre . "menu where menutype='mainmenu' and componentid='$sections' order by ordering, id";
				$result= $database->openConnectionWithReturn($query);
				$i=0;

				while ($row=mysql_fetch_object($result)){
					$itemid[$i]=$row->id;
					$itemName[$i]=$row->name;
					$link[$i]=$row->link;
					$showmenu[$i]=$row->inuse;
					$componentid[$i]=$row->componentid;
					$contenttype[$i]=$row->contenttype;
					$editor[$i]=$row->editor;

					if ($showmenu[$i]=="1"){
						$published[$i]="yes";
					}else{
						$published[$i]="no";
					}

					if ($contenttype[$i]=="mambo"){
						$type[$i]="Mambo Component";
					}else if ($contenttype[$i]=="file"){
						$type[$i]="File";
					}else if ($contenttype[$i]=="typed"){
						$type[$i]="Typed";
					}else if ($contenttype[$i]=="web"){
						$type[$i]="Web Link";
					}

					$i++;
				}
		}
			//get whether they have subs or not
				$numItems=count($itemid);
				for ($a=0; $a<$numItems; $a++){
					$query="select id from " . $mpre . "menu where componentid='$itemid[$a]'";
					$result=$database->openConnectionWithReturn($query);
					if (mysql_num_rows($result)!=0){
						$subs[$a]=1;
					}else{
						$subs[$a]=0;
					}
				}
			$subsectionshtml->showSubsections($itemid, $itemName, $type, $published, $path, $option, $editor, $sections, $ItemIdList, $ItemNameList, $subs);
		}

		function addSubsection($database, $subsectionshtml, $option, $sections, $mpre){
			$topquery="select Max(sublevel) as numlevels from " . $mpre . "menu where menutype='mainmenu'";
			$topresult=$database->openConnectionWithReturn($topquery);
			list ($numlevels)=mysql_fetch_array($topresult);
			$counter=0;
			for ($count=0; $count <= $numlevels; $count++){
				$query="select id, name, componentid from " . $mpre . "menu where menutype='mainmenu' and sublevel='$count' and contenttype!='mambo' and contenttype!='web'";
				$result=$database->openConnectionWithReturn($query);
				$numItems=mysql_num_rows($result);
				for ($i=0; $i < $numItems; $i++){
					$row=mysql_fetch_object($result);
					$componentid[$counter]=$row->componentid;
					$ItemIdList[$counter]=$row->id;
					if ($componentid[$counter]==0){
						$ItemNameList[$counter]=$row->name;
					}else{
						$ItemName=$row->name;
						$nextID=$componentid[$counter];
						$stillitems=1;
						while ($stillitems==1){
							$query2="select name, componentid from " . $mpre . "menu where id='$nextID'";
							$result2=$database->openConnectionWithReturn($query2);
							list($nextName, $nextID)=mysql_fetch_array($result2);
							if ($nextNameList!=""){
								$nextNameList="$nextName/$nextNameList";
							}else{
								$nextNameList="$nextName";
							}
							if ($nextID!=0){
								$stillitems=1;
							}else{
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

			$subsectionshtml->addSubsection($option, $ItemIdList, $ItemNameList, $sections);
		}

		function addStep2($database, $subsectionshtml, $option, $ItemName, $ItemType, $SectionID, $sections, $mpre){
			$query="select id from " . $mpre . "menu where menutype='mainmenu' and name='$ItemName' and componentid='$SectionID'";
			$result=$database->openConnectionWithReturn($query);
			if (mysql_num_rows($result)> 0){
					print "<SCRIPT> alert('This item name is already in use, please enter another'); document.location.href='index2.php?option=$option&task=new'; </SCRIPT>\n";
			}else{
				if ($ItemType=="Mambo"){
					$query="select moduleid, modulename from " . $mpre . "mambo_modules where menuid=0";
					$result=$database->openConnectionWithReturn($query);
					$i=0;
					if (mysql_num_rows($result)==0){
						print "<SCRIPT> alert('Cannot add this item as there are no mambo components left to add'); document.location.href='index2.php?option=$option&task=new'; </SCRIPT>\n";
						exit(0);
					}
					while (list($moduleid[$i], $modulename[$i])=mysql_fetch_array($result)){
						$i++;
					}
					$subsectionshtml->addMamboStep2($option, $ItemName, $moduleid, $modulename, $SectionID, $sections);
				}else if ($ItemType=="Own"){
					$subsectionshtml->addOwnStep2($option, $ItemName, $SectionID, $sections);
				}else if ($ItemType=="Web"){
					$subsectionshtml->addWebStep2($option, $ItemName, $SectionID, $sections);
				}
			}
		}

		function addStep3($database, $subsectionshtml, $option, $ItemName, $PageSource, $SectionID, $sections, $mpre){
			if ($PageSource=="Type"){
				$subsectionshtml->addTypeStep3($option, $ItemName, $SectionID, $sections);
			}else if ($PageSource=="Link"){

				$query1="select sublevel from " . $mpre . "menu where id='$SectionID'";
				$result1=$database->openConnectionWithReturn($query1);
				list ($sublevel)=mysql_fetch_array($result1);
				$sublevel=$sublevel + 1;

				$query="select Max(ordering) As LastOrder from " . $mpre . "menu where menutype='mainmenu' and componentid='$SectionID'";
				$result=$database->openConnectionWithReturn($query);
				list ($lastOrder)=mysql_fetch_array($result);
				mysql_free_result($result);
				$nextOrder=$lastOrder+1;

				$query="insert into " . $mpre . "menu (menutype, name, inuse, componentid, ordering, contenttype, sublevel) values ('mainmenu', '$ItemName', 0, '$SectionID', $nextOrder, 'typed', $sublevel)";
				$database->openConnectionNoReturn($query);
				$query="select id from " . $mpre . "menu where menutype='mainmenu' and name='$ItemName' and componentid='$SectionID'";
				$result=$database->openConnectionWithReturn($query);
				list ($Itemid)=mysql_fetch_array($result);
				$subsectionshtml->addLinkStep3($option, $ItemName, $Itemid, $sections);
			}
		}

		function saveSubsection($database, $ItemName, $pagecontent, $Weblink, $moduleID, $option, $SectionID, $heading, $sections, $browserNav, $mpre){
			if ((trim($moduleID)=="") && (trim($pagecontent)=="") && (trim($Weblink)=="")){
					print "<SCRIPT> alert('Please enter some content'); window.history.go(-1); </SCRIPT>\n";
			}else{
				if (trim($Weblink)!=""){
					$link=$Weblink;
					$contenttype="web";
				}
				if (trim($moduleID)!=""){
					$query="select modulelink from " . $mpre . "mambo_modules where moduleid='$moduleID'";
					$result=$database->openConnectionWithReturn($query);
					list($link)=mysql_fetch_array($result);
					$contenttype="mambo";
				}
				if (trim($pagecontent)!=""){
					$contenttype="typed";
				}

				$query1="select sublevel from " . $mpre . "menu where id='$SectionID'";
				$result1=$database->openConnectionWithReturn($query1);
				list ($sublevel)=mysql_fetch_array($result1);
				$sublevel=$sublevel + 1;

				$query="select Max(ordering) As LastOrder from " . $mpre . "menu where menutype='mainmenu' and componentid='$SectionID'";
				$result=$database->openConnectionWithReturn($query);
				list ($lastOrder)=mysql_fetch_array($result);
				mysql_free_result($result);
				$nextOrder=$lastOrder+1;

				if ($browserNav==""){
					$browserNav=0;
				}

				$query="insert into " . $mpre . "menu (menutype, name, link, inuse, componentid, ordering, contenttype, sublevel, browserNav) values ('mainmenu', '$ItemName', '$link', 0, '$SectionID', $nextOrder, '$contenttype', '$sublevel', $browserNav)";
				$database->openConnectionNoReturn($query);
				if ($contenttype=="typed"){
					$query="select id from " . $mpre . "menu where menutype='mainmenu' and name='$ItemName' and componentid='$SectionID'";
					$result=$database->openConnectionWithReturn($query);
					list ($menuid)=mysql_fetch_array($result);
					$query="insert into " . $mpre . "menucontent (menuid, content, heading) values ('$menuid', '$pagecontent', '$heading')";
					$database->openConnectionNoReturn($query);
				}
				if ($contenttype=="mambo"){
					$query="select id from " . $mpre . "menu where menutype='mainmenu' and name='$ItemName' and componentid='$SectionID'";
					$result=$database->openConnectionWithReturn($query);
					list ($menuid)=mysql_fetch_array($result);
					$query="update " . $mpre . "mambo_modules set menuid='$menuid' where moduleid='$moduleID'";
					$database->openConnectionNoReturn($query);
				}
				echo "<SCRIPT>document.location.href='index2.php?option=$option&sections=$sections'</SCRIPT>";
			}
		}

		function editSubsection($database, $subsectionshtml, $option, $Itemid, $checkedID, $myname, $sections, $mpre){
			if ($checkedID!=""){
				$Itemid=$checkedID;
			}else{
				if ($Itemid == ""){
					print "<SCRIPT> alert('Select a menu item to edit'); window.history.go(-1);</SCRIPT>\n";
				}
			}

			//get an array of how many sub-sections are in each section for display order stuff
			$query= "select name, id from " . $mpre . "menu where menutype='mainmenu'";
			$result=$database->openConnectionWithReturn($query);
			$i=0;
			while($row=mysql_fetch_object($result)){
				$orderSectionid[$i]=$row->id;
				$orderSectionName[$i]=$row->name;
				$query2= "select id from " . $mpre . "menu where componentid='$orderSectionid[$i]'";
				$result2=$database->openConnectionWithReturn($query2);
				$count=mysql_num_rows($result2);
				mysql_free_result($result2);
				$orderingSection["$orderSectionid[$i]"]=$count;
				$i++;
			}
			mysql_free_result($result);


			$topquery="select Max(sublevel) as numlevels from " . $mpre . "menu where menutype='mainmenu'";
			$topresult=$database->openConnectionWithReturn($topquery);
			list ($numlevels)=mysql_fetch_array($topresult);
			mysql_free_result($topresult);
			$counter=0;
			for ($count=0; $count <= $numlevels; $count++){
				$query="select id, name, componentid from " . $mpre . "menu where menutype='mainmenu' and sublevel='$count' and contenttype!='mambo' and contenttype!='web'";
				$result=$database->openConnectionWithReturn($query);
				$numItems=mysql_num_rows($result);
				for ($i=0; $i < $numItems; $i++){
					$row=mysql_fetch_object($result);
					$componentid[$counter]=$row->componentid;
					$ItemIdList[$counter]=$row->id;
					if ($componentid[$counter]==0){
						$ItemNameList[$counter]=$row->name;
					}else{
						$ItemName=$row->name;
						$nextID=$componentid[$counter];
						$stillitems=1;
						while ($stillitems==1){
							$query2="select name, componentid from " . $mpre . "menu where id='$nextID'";
							$result2=$database->openConnectionWithReturn($query2);
							list($nextName, $nextID)=mysql_fetch_array($result2);
							mysql_free_result($result2);
							if ($nextNameList!=""){
								$nextNameList="$nextName/$nextNameList";
							}else{
								$nextNameList="$nextName";
							}
							if ($nextID!=0){
								$stillitems=1;
							}else{
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

			$query="select name, link, inuse, componentid, contenttype, ordering, checked_out, editor, browserNav from " . $mpre . "menu where id='$Itemid'";
			$result= $database->openConnectionWithReturn($query);
			list($ItemName, $link, $inuse, $SectionID, $contenttype, $order, $checked, $editor, $browserNav)=mysql_fetch_array($result);
			mysql_free_result($result);
			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The section $name is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				exit(0);
			}

			$date = date("H:i:s");
			$query = "UPDATE " . $mpre . "menu SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE id='$Itemid'";
			$database->openConnectionNoReturn($query);

			$query="select Max(ordering) As maxOrder from " . $mpre . "menu where menutype='mainmenu' and componentid='$SectionID'";
			$result=$database->openConnectionWithReturn($query);
			list ($maxOrder)=mysql_fetch_array($result);
			mysql_free_result($result);

			if ($SectionID!=0){
				$nextID=$SectionID;
				$stillitems=1;
				while ($stillitems==1){
					$query2="select name, componentid from " . $mpre . "menu where id='$nextID'";
					$result2=$database->openConnectionWithReturn($query2);
					list($nextName, $nextID)=mysql_fetch_array($result2);
					mysql_free_result($result2);
					if ($nextNameList!=""){
						$nextNameList="$nextName/$nextNameList";
					}else{
						$nextNameList="$nextName";
					}
					if ($nextID!=0){
						$stillitems=1;
					}else{
						$SectionName="$nextNameList";
						$nextNameList="";
						$stillitems=0;
					}
				}
			}

			if ($contenttype=="typed"){
				$query="select content, heading from " . $mpre . "menucontent where menuid='$Itemid'";
				$result=$database->openConnectionWithReturn($query);
				if (mysql_num_rows($result)!=0){
					list($pagecontent, $heading)=mysql_fetch_array($result);
				}
			}else if ($contenttype=="file"){
					$fileEdit="1";
					$file=file("../$link");
					$filecontent=implode("\n",$file);
					$filecontent=str_replace("\\'", "'",$filecontent);
					$filecontent=str_replace("\\\"", "\"",$filecontent);
					$mamboEdit="0";
			}else if ($contenttype=="mambo"){
					$mamboEdit="1";
					$query="select moduleid, modulename from " . $mpre . "mambo_modules where menuid='$Itemid'";
					$result=$database->openConnectionWithReturn($query);
					list($moduleid, $modulename)=mysql_fetch_array($result);
					$query="select moduleid, modulename from " . $mpre . "mambo_modules where menuid=0";
					$result=$database->openConnectionWithReturn($query);
					$i=0;
					while (list($moduleidlist[$i], $modulenamelist[$i])=mysql_fetch_array($result)){
						$i++;
					}
					$fileEdit="0";
					$filecontent="";
			}
			if ($inuse=="1"){
				$status="published";
			}else{
				$status="awaiting publishing";
			}
			$subsectionshtml->editSubsection($Itemid, $ItemName, $pagecontent, $status, $link, $fileEdit, $filecontent, $mamboEdit, $moduleid, $modulename, $moduleidlist, $modulenamelist, $option, $SectionID, $SectionName, $ItemIdList, $ItemNameList, $order, $maxOrder, $myname, $orderSectionid, $orderSectionName, $orderingSection, $sections, $heading, $browserNav);
		}

		function saveEditSubsection($database, $menusectionshtml, $option, $ItemName, $link2, $pagecontent, $filecontent, $Itemid, $SectionID, $order, $origOrder, $myname, $origSecID, $Weblink, $heading, $browserNav, $mpre){
			if ($ItemName == ""){
				print "<SCRIPT> alert('Please enter a page name'); window.history.go(-1); </SCRIPT>\n";
			}else{
				$query="select contenttype from " . $mpre . "menu where id='$Itemid'";
				$result=$database->openConnectionWithReturn($query);
				list ($type)=mysql_fetch_array($result);
				if ($type=="file"){
					if (trim($filecontent)!=""){
						$filecontent=str_replace("\n","",$filecontent);
						$pat= "<IMG SRC=\\\\\"";
						$replace= "<IMG SRC=\"uploadfiles/$Itemid/";
						$filecontent=eregi_replace($pat, $replace, $filecontent);
						$pat2=$replace."uploadfiles/$Itemid/";
						$filecontent= eregi_replace($pat2, $replace, $filecontent);
						$basedir= "../uploadfiles/$Itemid/";

						//if the directory does not exist to hold the file, create it
						if (!file_exists("../$link2")) mkdir("../$link2", 0777);
						//open the file for writing
						$fp = fopen("../$link2","w");
						//write the edited information back to the file
						fwrite ($fp, $filecontent);
						//close the file
						fclose($fp);
					}
				}else if ($type=="web"){
					if (trim($Weblink)==""){
						print "<SCRIPT> alert('Please enter a web link'); window.history.go(-1); </SCRIPT>\n";
					}else{
						$query="update " . $mpre . "menu set link='$Weblink', browserNav=$browserNav where id='$Itemid'";
						$database->openConnectionNoReturn($query);
					}
				}

				if ($origSecID!=$SectionID){
					$query2="select id from " . $mpre . "menu where componentid='$Itemid'";
					$result2=$database->openConnectionWithReturn($query2);
					$checkComponentID=mysql_num_rows($result2);
				}else{
					$checkComponentID=0;
				}

				if ($checkComponentID!=0){
					print "<SCRIPT> alert('The path for this section cannot be changed as it contains sub-sections'); document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$Itemid'; </SCRIPT>\n";
				}else{

					$query="select id from " . $mpre . "menu where menutype='mainmenu' and name='$ItemName' and componentid='$SectionID' and id!='$Itemid'";
					$result=$database->openConnectionWithReturn($query);

					if (mysql_num_rows($result)> 0){
						print "<SCRIPT> alert('This item name is already in use, please enter another'); document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$Itemid'; </SCRIPT>\n";
					}else{
						if ($origSecID!=$SectionID){
							$query="select id from " . $mpre . "menu where menutype='mainmenu' and componentid='$SectionID'";
							$result=$database->openConnectionWithReturn($query);
							$numres=mysql_num_rows($result)+1;
							$origOrder2=$numres;

							if ($order > $origOrder){
								$query = "SELECT id FROM " . $mpre . "menu WHERE ordering <= $order AND ordering > $origOrder2 AND menutype='mainmenu' AND componentid='$SectionID' ORDER BY ordering";
								$result = $database->openConnectionWithReturn($query);
								while ($row = mysql_fetch_object($result)){
									$changeid = $row->id;
									$query = "UPDATE " . $mpre . "menu SET ordering=ordering - 1 WHERE id=$changeid";
									$database->openConnectionNoReturn($query);
								}
							}else if ($order < $origOrder){
								$query = "SELECT id FROM " . $mpre . "menu WHERE ordering >= $order AND ordering < $origOrder2 AND menutype='mainmenu' and componentid='$SectionID' ORDER BY ordering";
								$result = $database->openConnectionWithReturn($query);

								while ($row = mysql_fetch_object($result)){
									$changeid = $row->id;
									$query = "UPDATE " . $mpre . "menu SET ordering=ordering+1 WHERE id=$changeid";
									$database->openConnectionNoReturn($query);
								}
							}

							$query = "SELECT id FROM " . $mpre . "menu WHERE id='$Itemid' AND checked_out=1 AND editor='$myname'";
							$result = $database->openConnectionWithReturn($query);
							if (mysql_num_rows($result) > 0){
								$query="update " . $mpre . "menu set ordering=$order, checked_out=0, checked_out_time='00:00:00', editor=NULL where id='$Itemid'";
								$database->openConnectionNoReturn($query);
							}
						}else{
							if ($order > $origOrder){
								$query = "SELECT id FROM " . $mpre . "menu WHERE ordering <= $order AND ordering > $origOrder AND menutype='mainmenu' AND componentid='$SectionID' ORDER BY ordering";
								$result = $database->openConnectionWithReturn($query);
								while ($row = mysql_fetch_object($result)){
									$changeid = $row->id;
									$query = "UPDATE " . $mpre . "menu SET ordering=ordering - 1 WHERE id=$changeid";
									$database->openConnectionNoReturn($query);
								}
							}else if ($order < $origOrder){
								$query = "SELECT id FROM " . $mpre . "menu WHERE ordering >= $order AND ordering < $origOrder AND menutype='mainmenu' and componentid='$SectionID' ORDER BY ordering";
								$result = $database->openConnectionWithReturn($query);

								while ($row = mysql_fetch_object($result)){
									$changeid = $row->id;
									$query = "UPDATE " . $mpre . "menu SET ordering=ordering+1 WHERE id=$changeid";
									$database->openConnectionNoReturn($query);
								}
							}

							$query = "SELECT id FROM " . $mpre . "menu WHERE id='$Itemid' AND checked_out=1 AND editor='$myname'";
							$result = $database->openConnectionWithReturn($query);
							if (mysql_num_rows($result) > 0){
								$query="update " . $mpre . "menu set ordering=$order, checked_out=0, checked_out_time='00:00:00', editor=NULL where id='$Itemid'";
								$database->openConnectionNoReturn($query);
							}
						}


						if ($Itemid==$SectionID){
							print "<SCRIPT> alert('You cannot add a section to itself'); document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$Itemid'; </SCRIPT>\n";
						}else{
							$query1="select sublevel from " . $mpre . "menu where id='$SectionID'";
							$result1=$database->openConnectionWithReturn($query1);
							list ($sublevel)=mysql_fetch_array($result1);
							$sublevel=$sublevel + 1;

							$query= "update " . $mpre . "menu set name='$ItemName', componentid='$SectionID', sublevel='$sublevel' where id='$Itemid'";
							$database->openConnectionNoReturn($query);
							$query="select mcid from " . $mpre . "menucontent where menuid='$Itemid'";
							$result=$database->openConnectionWithReturn($query);
							if (mysql_num_rows($result)==0){
								$query="insert into " . $mpre . "menucontent (menuid, content) values ('$Itemid', '$pagecontent')";
								$database->openConnectionNoReturn($query);
							}else{
								$query= "update " . $mpre . "menucontent set content='$pagecontent', heading='$heading' where menuid='$Itemid'";
								$database->openConnectionNoReturn($query);
							}

							$query2 = "SELECT id FROM " . $mpre . "menu where componentid='$origSecID' and menutype='mainmenu'  ORDER BY ordering";
							$result2 = $database->openConnectionWithReturn($query2);
							$i = 1;
							while ($row = mysql_fetch_object($result2)){
								$changeid = $row->id;
								$query = "UPDATE " . $mpre . "menu SET ordering=$i WHERE id=$changeid";
								$database->openConnectionNoReturn($query);
								$i++;
							}

							echo "<SCRIPT>document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$Itemid'</SCRIPT>";
						}
					}
				}
			}
		}

		function saveFileUpload($database, $option, $userfile, $userfile_name, $Itemid, $mpre){
			if (eregi(".htm", $userfile_name)){
				$base_Dir = "../uploadfiles/$Itemid/";
				if (!file_exists($base_Dir)) mkdir($base_Dir, 0777);
				if (!copy($userfile, $base_Dir.$userfile_name)){
					echo "Failed to copy $userfile_name";
				}else{
					$file=file($base_Dir.$userfile_name);
					$file=implode("\n",$file);
					$file=str_replace("\n","",$file);
					$file = strip_tags($file, "<TITLE>,<td>,<tr>,<table>,<a>,<area>,<blockquote>,<br>,<button>,<center>,<select>,<option>,<div>,<font>,<form>,<HR>,<img>,<input>,<layer>,<li>,<map>,<SCRIPT>,<aspL>,<object>,<ol>,<pre>,<span>,<strong>,<sup>,<sub>,<tbody>,<teaxtarea>,<tfoot>,<th>,<thead>,<tt>,<ul>,<p>,<H1>,<H2>,<H3>,<B>,<I>");
					$fp = fopen($base_Dir.$userfile_name,"w");
					fwrite ($fp, $file);
					fclose($fp);

					$query="update " . $mpre . "menu set link='uploadfiles/$Itemid/$userfile_name', contenttype='file' where id='$Itemid'";
					$database->openConnectionNoReturn($query);
					echo "<SCRIPT>document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$Itemid'</SCRIPT>";
				}
			}else{
				echo "<SCRIPT> alert('Cannot upload a file that is not html'); window.history.go(-1);</SCRIPT>\n";
			}
		}

		function publishSubsection($database, $option, $Itemid, $cid, $sections, $mpre){
			if (trim($Itemid)!=""){
				$query="update " . $mpre . "menu set inuse='1' where id='$Itemid'";
				$database->openConnectionNoReturn($query);
			}else{
				if (count($cid)!=0){
					for ($i=0; $i < count($cid); $i++){
						$query="update " . $mpre . "menu set inuse='1' where id='$cid[$i]'";
						$database->openConnectionNoReturn($query);
					}
				}else{
					echo "<SCRIPT> alert('Select a menu item to publish'); window.history.go(-1);</SCRIPT>\n";
				}
			}
			$query="update " . $mpre . "menu set checked_out=0, checked_out_time='00:00:00', editor=NULL where id='$Itemid'";
			$database->openConnectionNoReturn($query);
			echo "<SCRIPT>document.location.href='index2.php?option=$option&categories=$sections'</SCRIPT>";
		}

		function unpublishSubsection($database, $option, $Itemid, $cid, $sections, $mpre){
			if (trim($Itemid)!=""){
				$query="update " . $mpre . "menu set inuse='0' where id='$Itemid'";
				$database->openConnectionNoReturn($query);
			}else{
				if (count($cid)!=0){
					for ($i=0; $i < count($cid); $i++){
						$query="update " . $mpre . "menu set inuse='0' where id='$cid[$i]'";
						$database->openConnectionNoReturn($query);
					}
				}else{
					echo "<SCRIPT> alert('Select a menu item to unpublish'); window.history.go(-1);</SCRIPT>\n";
				}
			}
			$query="update " . $mpre . "menu set checked_out=0, checked_out_time='00:00:00', editor=NULL where id='$Itemid'";
			$database->openConnectionNoReturn($query);
			echo "<SCRIPT>document.location.href='index2.php?option=$option&categories=$sections'</SCRIPT>";
		}

		function removeSubsection($database, $option, $cid, $sections, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT> alert('Select a menu item to delete'); window.history.go(-1);</SCRIPT>\n";
			}

			for ($d = 0; $d < count($cid); $d++){

				$query="select id from " . $mpre . "menu where componentid='$cid[$d]'";
				$result=$database->openConnectionWithReturn($query);
				$i=0;
				$deleteArray[$i]=$cid[$d];
				while (list($id)=mysql_fetch_array($result)){
					$i++;
					$deleteArray[$i]=$id;
					$stillitems=1;
					while ($stillitems==1){
						if ($counter > 1){
							for ($b=0; $b < $counter; $b++){
								$c=$i-$b;
								$query1="select id from " . $mpre . "menu where componentid='$deleteArray[$c]'";
								$result1=$database->openConnectionWithReturn($query1);
								if (mysql_num_rows($result1)==0){
									$stillitems=0;
								}else{
									$stillitems=1;
									$counter=0;
									while (list($id1)=mysql_fetch_array($result1)){
										$i++;
										$deleteArray[$i]=$id1;
										$counter++;
									}
								}
							}
						}else{
							$query1="select id from " . $mpre . "menu where componentid='$deleteArray[$i]'";
							$result1=$database->openConnectionWithReturn($query1);
							if (mysql_num_rows($result1)==0){
								$stillitems=0;
							}else{
								$stillitems=1;
								$counter=0;
								while (list($id1)=mysql_fetch_array($result1)){
									$i++;
									$deleteArray[$i]=$id1;
									$counter++;
								}
							}
						}
					}
				}

				$displayCounter=count($deleteArray);
				for ($a=$displayCounter-1; $a >= 0; $a--){
					$query="select link, contenttype from " . $mpre . "menu where id='$deleteArray[$a]'";
					$result=$database->openConnectionWithReturn($query);
					list($link, $contenttype)=mysql_fetch_array($result);
					if ($contenttype=="file"){
						$checkfile= eregi("uploadfiles/$deleteArray[$a]/", $link);
						if ($checkfile){
							if (file_exists("../$link")) {
								$basedir="../uploadfiles/$deleteArray[$a]/";
								$filepath= "../$link";
								//delete the linked file from the directory
								unlink($filepath);
								$basedir2="../uploadfiles/$deleteArray[$a]";
								$dir= opendir("$basedir");
								//also delete any other files in the same directory
								while ($file= readdir($dir)) {
									$file= (trim($file));
									if (($file != ".") && ($file !="..")) {
										$filepath=$basedir.$file;
										unlink($filepath);
									}
								}
								closedir($dir);
								//finally delete the directory itself
								rmdir($basedir2);
							}
						}
					}else if ($contenttype=="mambo"){
						$query="update " . $mpre . "mambo_modules set menuid='0' where menuid='$deleteArray[$a]'";
						$database->openConnectionNoReturn($query);
					}else if ($contenttype=="typed"){
						$query="delete from " . $mpre . "menucontent where menuid='$deleteArray[$a]'";
						$database->openConnectionWithReturn($query);
					}

					$query1="select " . $mpre . "componentid from menu where id='$deleteArray[$a]'";
					$result1=$database->openConnectionWithReturn($query1);
					list ($orderComponentid)=mysql_fetch_array($result1);

					$query="delete from " . $mpre . "menu where id='$deleteArray[$a]'";
					$database->openConnectionNoReturn($query);

					$query2 = "SELECT id FROM " . $mpre . "menu where componentid='$orderComponentid' and menutype='mainmenu'  ORDER BY ordering";
					$result2 = $database->openConnectionWithReturn($query2);
					$i = 1;
					while ($row = mysql_fetch_object($result2)){
						$changeid = $row->id;
						$query = "UPDATE " . $mpre . "menu SET ordering=$i WHERE id=$changeid";
						$database->openConnectionNoReturn($query);
						$i++;
					}
				}

				}
				print "<SCRIPT>document.location.href='index2.php?option=$option&sections=$sections';</SCRIPT>\n";
			}

		function saveUploadImage($database, $option, $userfile1, $userfile1_name, $userfile2, $userfile2_name, $userfile3, $userfile3_name, $userfile4, $userfile4_name, $userfile5, $userfile5_name, $sectionid, $mpre){
			if ($sectionid!=""){
				$base_Dir = "../uploadfiles/$sectionid/";
			}else{
				$base_Dir = "../images/";
			}
			if (isset($userfile1)){
				if ($userfile1 != none){
					if (!copy($userfile1, $base_Dir.$userfile1_name)){
						echo "Failed to copy $userfile1";
						break;
					}
				}

			if (isset($userfile2)){
				if ($userfile2 != none){
					if (!copy($userfile2, $base_Dir.$userfile2_name)){
						echo "Failed to copy $userfile2";
						break;
					}
				}
			}

			if (isset($userfile3)){
				if ($userfile3 != none){
					if (!copy($userfile3, $base_Dir.$userfile3_name)){
						echo "Failed to copy $userfile3";
						break;
					}
				}
			}

			if (isset($userfile4)){
				if ($userfile4 != none){
					if (!copy($userfile4, $base_Dir.$userfile4_name)){
						echo "Failed to copy $userfile4";
						break;
					}
				}
			}

			if (isset($userfile5)){
				if ($userfile5 != none){
					if (!copy($userfile5, $base_Dir.$userfile5_name)){
						echo "Failed to copy $userfile5";
						break;
					}
				}
			}

			echo "<SCRIPT>window.opener.focus;</SCRIPT>";
			echo "<SCRIPT>window.close(); </SCRIPT>";
			}
		}

}?>