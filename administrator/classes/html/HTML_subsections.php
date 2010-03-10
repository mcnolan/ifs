<?
	/**	
	 *	Mambo Site Server Open Source Edition Version 4.0.11
	 *	Dynamic portal server and Content managment engine
	 *	27-11-2002
 	 *
	 *	Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	 *	Distributed under the terms of the GNU General Public License
	 *	This software may be used without warrany provided these statements are left 
	 *	intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	 *	This code is Available at http://sourceforge.net/projects/mambo
	 *
	 *	Site Name: Mambo Site Server Open Source Edition Version 4.0.11
	 *	File Name: HTML_subsections.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class HTML_subsections {
		function showSubsections($itemid, $itemName, $type, $published, $path, $option, $editor, $sections, $ItemIdList, $ItemNameList, $subs){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR>
					<TD COLSPAN="6" align=right>Select A Section:&nbsp;&nbsp;
						<SELECT NAME="sections" onChange="document.location.href='index2.php?option=SubSections&sections=' + document.adminForm.sections.options[selectedIndex].value">
							<OPTION VALUE="all">Select All</OPTION>
						<?	for ($i = 0; $i < count($ItemIdList); $i++){
								if ($sections == $ItemIdList[$i]){?>
									<OPTION VALUE="<? echo $ItemIdList[$i]; ?>" SELECTED><? echo $ItemNameList[$i]; ?></OPTION>
						<?		} else {?>
									<OPTION VALUE="<? echo $ItemIdList[$i]; ?>"><? echo $ItemNameList[$i]; ?></OPTION>
						<?			}
								}?>
						</SELECT>
					</TD>
				</TR>
			
				<TR BGCOLOR="#999999">
					<TD COLSPAN="2" CLASS="heading">Sub Level Menu Items</TD>
					<TD ALIGN="CENTER" CLASS="heading">Published</TD>
					<TD ALIGN="CENTER" CLASS="heading">Sub-Sections</TD>
					<TD ALIGN="CENTER" CLASS="heading">Content Type</TD>
					<TD ALIGN="CENTER" CLASS="heading">Checked Out</TD>
				</TR>
				<?$color = array("#FFFFFF", "#CCCCCC");
				$k = 0;
				for ($i = 0; $i < count($itemid); $i++){?>
				<TR BGCOLOR="<? echo $color[$k]; ?>">
					<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<?echo "$itemid[$i]";?>" onClick="isChecked(this.checked);"></TD>
					<?if ($path[$i]!=""){?>
						<TD WIDTH="53%"><? echo "$path[$i]/ <a href=index2.php?option=SubSections&task=edit&checkedID=$itemid[$i]&categories=$sections>$itemName[$i]</a>" ?></TD>
					<?}else{?>
						<TD WIDTH="53%"><? echo "<a href=index2.php?option=SubSections&task=edit&checkedID=$itemid[$i]&categories=$sections>$itemName[$i]</a>" ?></TD>
					<?}?>
					
					<?if ($published[$i] == "yes"){
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
						<?} else {?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
						<?}
					}else {
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?} else {?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?}
					}?>
										
					<?if ($subs[$i] == "1"){
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
						<?} else {?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
						<?}
					}else {
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?} else {?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
						<?}
					}?>
					
					<TD WIDTH="15%" ALIGN="CENTER"><? echo $type[$i];?></TD>
					
					<?	if ($editor[$i] <> ""){?>
							<TD WIDTH="10%" ALIGN=CENTER><? echo $editor[$i];?></TD>
					<?		}
						else {?>
							<TD WIDTH="10%" ALIGN=CENTER>&nbsp;</TD>
						<? 	}
						
					 if ($k == 1){
							$k = 0;
						}else {
				   			$k++;
						}
				}?>
				</TR>
				<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
				<INPUT TYPE="hidden" NAME="task" VALUE="">
				<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
				</FORM>
			</TABLE>
		<?}
		
		function addSubsection($option, $ItemIdList, $ItemNameList, $sections){?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function checkstep1(form){
					if ((document.adminForm.ItemName.value == "") || (document.adminForm.SectionID.options.value == "")){
						alert('Page must have a section and name');
						}
					else {
						document.adminForm.action = 'index2.php';
						document.adminForm.submit(form);
						}
					}
			//-->
			</SCRIPT>
			<FORM action="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR BGCOLOR=#999999>
					<TD COLSPAN="2" CLASS="heading">Add Menu Sub-section</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD>Section Name</TD>
					<TD><select name="SectionID">
							<?for ($i = 0; $i < count($ItemIdList); $i++){?>
								<OPTION VALUE='<? echo $ItemIdList[$i]; ?>'><? echo $ItemNameList[$i]; ?></OPTION>
							<?}?>
						</select>
					</TD>
				</TR>
				<TR>
					<TD>Item Name:</TD>
					<TD WIDTH=85%><input type=text name="ItemName"></TD>
				</TR>
				<TR>
					<TD>Item Type:</TD>
					<TD><select name=ItemType>
							<option value="Own">Own Content</option>
							<option value="Mambo">Mambo Component</option>
							<option value="Web">Web Link</option>
						</select>
					</TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
					<TD><INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
						<INPUT TYPE="hidden" NAME="task" VALUE="AddStep2">
						<INPUT TYPE="hidden" NAME="sections" VALUE="<?echo $sections;?>">
						<INPUT TYPE="button" value="Next" onClick="checkstep1(this.form);">
					</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR BGCOLOR=#999999>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
			</TABLE>
			</FORM>
		<?}
			
		function addMamboStep2($option, $ItemName, $moduleid, $modulename, $SectionID, $sections){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR BGCOLOR=#999999>
					<TD COLSPAN="2" CLASS="heading">Page Content Entry</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD>Page Name:</TD>
					<TD WIDTH=85%><?echo $ItemName;?></TD>
				</TR>
				<TR>
					<TD>Remaining Mambo Modules:</TD>
					<TD><select name="moduleID">
							<?for ($i = 0; $i < count($moduleid); $i++){
								if ($moduleid[$i]!=""){?>
									<OPTION VALUE='<? echo $moduleid[$i]; ?>'><? echo $modulename[$i]; ?></OPTION>
								<?}
							  }?>
						</select>
					</TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
					<TD><INPUT TYPE="hidden" NAME="ItemName" VALUE="<? echo $ItemName;?>">
						<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
						<INPUT TYPE="hidden" NAME="task" VALUE="">
						<INPUT TYPE="hidden" NAME="SectionID" VALUE="<? echo $SectionID;?>">
						<INPUT TYPE="hidden" NAME="sections" VALUE="<?echo $sections;?>">
					</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR BGCOLOR=#999999>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
			</TABLE>
			</FORM>	
		<?}
		
		function addOwnStep2($option, $ItemName, $SectionID, $sections){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR BGCOLOR=#999999>
					<TD COLSPAN="2" CLASS="heading">Page Content Entry</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD>Page Name:</TD>
					<TD WIDTH=85%><?echo $ItemName;?></TD>
				</TR>
				<TR>
					<TD>Page Content Source:</TD>
					<TD><select name="PageSource">
							<option value="Type">Type In</option>
							<option value="Link">Upload Page</option>
						</select>
					</TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
					<TD><INPUT TYPE="hidden" NAME="ItemName" VALUE="<? echo $ItemName;?>">
						<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
						<INPUT TYPE="hidden" NAME="task" VALUE="AddStep3">
						<INPUT TYPE="hidden" NAME="SectionID" VALUE="<? echo $SectionID;?>">
						<INPUT TYPE="hidden" NAME="sections" VALUE="<?echo $sections;?>">
						<INPUT TYPE="submit" NAME="submit" value="Next">
					</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR BGCOLOR=#999999>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
			</TABLE>
			</FORM>	
		<?}
		
		function  addWebStep2($option, $ItemName, $SectionID, $sections){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR BGCOLOR=#999999>
					<TD COLSPAN="2" CLASS="heading">Page Content Entry</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD>Page Name:</TD>
					<TD WIDTH=85%><?echo $ItemName;?></TD>
				</TR>
				<TR>
					<TD>Web Link:</TD>
					<TD><input type=text name="Weblink" size=50></TD>
				</TR>
				<TR>
					<TD colspan=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD colspan=2><input type="radio" NAME="browserNav" VALUE=1 checked>Open with Browser Navigation&nbsp;&nbsp;&nbsp;
								<input type="radio" NAME="browserNav" VALUE=0>Open Without Browser Navigation</TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
					<TD><INPUT TYPE="hidden" NAME="ItemName" VALUE="<? echo $ItemName; ?>">
						<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
						<INPUT TYPE="hidden" NAME="task" VALUE="">
						<INPUT TYPE="hidden" NAME="SectionID" VALUE="<? echo $SectionID; ?>">
						<INPUT TYPE="hidden" NAME="sections" VALUE="<?echo $sections;?>">
					</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR BGCOLOR=#999999>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
			</TABLE>
			</FORM>	
		<?}
		
		function  addTypeStep3($option, $ItemName, $SectionID, $sections){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR BGCOLOR=#999999>
					<TD COLSPAN="2" CLASS="heading">Page Content Entry</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD>Page Name:</TD>
					<TD WIDTH=85%><?echo $ItemName;?> </TD>
				</TR>
				<TR>
					<TD>Page Heading</TD>
					<TD><INPUT TYPE="text" NAME="heading"></TD>
				</TR>
				<TR>
					<TD VALIGN=top>Page Content:</TD>
					<TD><textarea name="pagecontent" cols=60 rows=5><? echo htmlentities($pagecontent); ?></textarea>
						<BR>
						<A HREF="#" onClick="window.open('inline_editor/editor.htm?pagecontent', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A>
					</TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
					<TD><INPUT TYPE="hidden" NAME="ItemName" VALUE="<? echo $ItemName;?>">
						<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
						<INPUT TYPE="hidden" NAME="task" VALUE="">
						<INPUT TYPE="hidden" NAME="SectionID" VALUE="<? echo $SectionID; ?>">
						<INPUT TYPE="hidden" NAME="sections" VALUE="<?echo $sections;?>">
					</TD>
				</TR>	
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR BGCOLOR=#999999>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
  		  </TABLE>
		  </FORM>	
		<?}
		
		function  addLinkStep3($option, $ItemName, $Itemid, $sections){?>
		<SCRIPT LANGUAGE="javascript">
			<!--
				function checkstep1(form){
					var chosenfile = document.filename.userfile.value;
					
					if (chosenfile == ""){
						alert('Please select a file to upload');
						}
					else {
						var searchresult= chosenfile.search("htm");
						if (searchresult == -1){
							alert('Upload file must be html');
						}else{
							document.filename.submit(form);
						}
					}
				}
			//-->
			</SCRIPT>
		
			<FORM ENCTYPE="multipart/form-data" METHOD="POST" NAME="filename" ACTION="index2.php">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR BGCOLOR=#999999>
					<TD COLSPAN="2" CLASS="heading">Page Content Entry</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD>Page Name:</TD>
					<TD WIDTH=85%><?echo $ItemName;?></TD>
				</TR>
				<TR> 
					<TD>Select file:</TD>
					<TD WIDTH='85%'><INPUT NAME="userfile" TYPE="file"></TD>
				</TR>
				<TR>
					<TD COLSPAN='2'><input type=hidden name="Itemid" value="<?echo $Itemid;?>">
									<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
									<INPUT TYPE="hidden" NAME="task" VALUE="Upload">
									<INPUT TYPE="hidden" NAME="sections" VALUE="<?echo $sections;?>">
									<input type="button" value="Upload File" onClick="checkstep1(this.form);"></TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR BGCOLOR=#999999>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
			</TABLE>
			</FORM>
		<?}
			
		function editSubsection($Itemid, $ItemName, $pagecontent, $status, $link, $fileEdit, $filecontent, $mamboEdit, $moduleid, $modulename, $moduleidlist, $modulenamelist, $option, $SectionID, $SectionName, $ItemIdList, $ItemNameList, $order, $maxOrder, $myname, $orderSectionid, $orderSectionName, $orderingSection, $sections, $heading, $browserNav){?>
			<SCRIPT LANGUAGE="Javascript">
			<!--
					sections = new Array();
				<? 	for ($i = 0; $i < count($orderSectionid); $i++){?>
						sections["<? echo $orderSectionid[$i]; ?>"] = <? echo $orderingSection["$orderSectionid[$i]"]; ?>;
			<?		if ($orderSectionid[$i] == $Itemid){?>
						var originalSection = "<? echo $$orderSectionid[$i]; ?>";
			<?		}?>
			<?		unset($newvar); ?>
			<?	}?>
				
				function changeOrder(section){
					var newsection = section.split(" ");
					var newsec = "";
					for (var j = 0; j < newsection.length; j++){
						newsec = newsec.concat(newsection[j]);
						}
					
					var orderlength = document.adminForm.order.options.length;
					for (var k = 0; k < orderlength; k++){
						document.adminForm.order.options[k] = null;
						}
					document.adminForm.order.options.length = 0;
					var numsec = sections[newsec];
					if (originalSection.indexOf(newsec) == -1){
						numsec++;
						}
						
					for (var i = 0; i < numsec; i++){
						var num = i + 1;
						document.adminForm.order.options[i] = new Option(num);	
						}
					document.adminForm.order.length = i;
				 	document.adminForm.order.options[0].selected = true;  //selects the first option in the second dropdown
					}
			//-->
			</SCRIPT>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
				<TR BGCOLOR=#999999>
					<TD COLSPAN="2" CLASS="heading">Edit Menu Sub SectionItem</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR>
					<TD VALIGN="top">Item Name:</TD>
					<TD WIDTH="85%"><INPUT TYPE="text" NAME="ItemName" SIZE="25" VALUE="<? echo $ItemName; ?>"></TD>
				</TR>
				<TR>
					<TD>Section Name</TD>
					<TD><select name='SectionID' onChange='changeOrder(document.adminForm.SectionID.options[selectedIndex].value)'>
						<?	for ($i = 0; $i < count($ItemIdList); $i++){
								if ($SectionID == $ItemIdList[$i]){?>
									<OPTION VALUE="<?echo $SectionID;?>" SELECTED><?echo $SectionName;?></OPTION>
								<?} else {?>
								<OPTION VALUE='<? echo $ItemIdList[$i]; ?>'><? echo $ItemNameList[$i]; ?></OPTION>
							<?		}
								}?>
						</select>
					</TD>
				</TR>
				<?if (trim($link)!=""){
					if ($fileEdit==1){?>
						<TR>
							<TD VALIGN=top>File content</TD>
							<TD><TEXTAREA COLS="70" ROWS="10" NAME="filecontent" STYLE="WIDTH=500px" WIDTH=500><? echo $filecontent; ?></TEXTAREA>
								<INPUT TYPE="hidden" NAME="link2" VALUE="<? echo $link; ?>">
								<BR>
								<A HREF="#" onClick="window.open('inline_editor/editor.htm?filecontent', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A>
							</TD>
						</TR>
					<?}else if ($mamboEdit==1){?>
						<TR>
							<TD>Mambo Module:</TD>
							<TD><select name="moduleID">
									<option value="<?echo $moduleid;?>" selected><?echo $modulename;?></option>
									<?for ($i = 1; $i < count($moduleidlist); $i++){?>
										<OPTION VALUE='<? echo $moduleidlist[$i]; ?>'><? echo $modulenamelist[$i]; ?></OPTION>
									<?}?>
								</select>
							</TD>
						</TR>
					<?}else{?>
						<TR>
							<TD VALIGN="top">Link:</TD>
							<TD><INPUT TYPE="text" NAME="Weblink" SIZE="25" VALUE="<? echo $link; ?>"></TD>
						</TR>
						<?if ($browserNav==1){?>
							<tr>
								<td colspan=2><input type="radio" NAME="browserNav" VALUE=1 checked>Open with Browser Navigation&nbsp;&nbsp;&nbsp;
											<input type="radio" NAME="browserNav" VALUE=0>Open Without Browser Navigation</td>
							</tr>
						<?}else{?>
							<tr>
								<td colspan=2><input type="radio" NAME="browserNav" VALUE=1>Open with Browser Navigation&nbsp;&nbsp;&nbsp;
											<input type="radio" NAME="browserNav" VALUE=0 checked>Open Without Browser Navigation</td>
							</tr>
						<?}
					}
				}else{?>
					<TR>
						<TD>Page Heading:</TD>
						<TD><INPUT TYPE="text" NAME="heading" VALUE="<?echo $heading;?>"></TD>
					</TR>
					<TR>
						<TD VALIGN="top">Content:</TD>
						<TD><TEXTAREA COLS="70" ROWS="10" NAME="pagecontent" STYLE="WIDTH=500px" WIDTH=500><? echo htmlentities($pagecontent); ?></TEXTAREA>
							<BR>
							<A HREF="#" onClick="window.open('inline_editor/editor.htm?pagecontent', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A>
						</TD>
					</TR>
				<?}?>
				<TR>
					<TD>Display Order:</TD>
					<TD><SELECT NAME="order">
						<?for ($i = 1; $i < $maxOrder + 1; $i++){
							if ($i == $order){?>
								<OPTION VALUE="<? echo $order; ?>" SELECTED><? echo $order; ?></OPTION>
							<?}else {?>
								<OPTION VALUE="<? echo $i; ?>"><? echo $i; ?></OPTION>
							<?}
						}?>
						</SELECT>
					</TD>
				</TR>
				<TR>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<TR BGCOLOR=#999999>
					<TD COLSPAN=2>&nbsp;</TD>
				</TR>
				<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
				<INPUT TYPE="hidden" NAME="Itemid" VALUE="<? echo $Itemid; ?>">
				<INPUT TYPE="hidden" NAME="task" VALUE="">
				<INPUT TYPE="hidden" NAME="sections" VALUE="<?echo $sections;?>">
				<INPUT TYPE="hidden" NAME="origOrder" VALUE="<?echo $order;?>">
				<INPUT TYPE="hidden" NAME="myname" VALUE="<?echo $myname;?>">
				<INPUT TYPE="hidden" NAME="origSecID" VALUE="<?echo $SectionID;?>">
			</FORM>
			</TABLE>
			<?}
		}
?>

