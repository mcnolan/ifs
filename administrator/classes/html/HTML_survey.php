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
	 *	File Name: HTML_survey.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class HTML_survey {
		function showSurvey($option, $pollid, $polltitle, $published, $editor){ ?>
			<FORM ACTION='index2.php' METHOD='GET' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD COLSPAN="2" CLASS="heading">Poll/Survey Manager</TD>
				<TD WIDTH="10%" CLASS="heading" ALIGN="center">Published</TD>
				<TD WIDTH="15%" CLASS="heading" ALIGN="center">Checked Out</TD>
			</TR>
			<? 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($pollid); $i++){?>
			<TR BGCOLOR="<? echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $pollid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<TD WIDTH="85%"><? echo $polltitle[$i]; ?></TD>
				<? 	if ($published[$i] == 1){
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
				<?		} else {?>
							<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
				<?			}
						}
					else {
						if ($color[$k] == "#FFFFFF"){?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?		} else {?>
							<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?			}
						}?>
						
				<?	if ($editor[$i] <> ""){?>
						<TD WIDTH="10%" ALIGN="center"><? echo $editor[$i]; ?></TD>
				<?		}
					else { ?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
				<?		} ?>
				<? if ($k == 1){
						$k = 0;
						}
				   else {
				   		$k++;
						}?>
				<?
				}?>
			</TR>
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
			<?}
			
		function editSurvey($pollTitle, $optionText, $optionCount, $option, $pollid, $menuid, $id, $menu){?>
			<FORM ACTION="index2.php" METHOD="GET" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD VALIGN="top">Page:</TD>
				<!--<TD WIDTH="100%">
					<SELECT NAME="menu" SIZE="10" MULTIPLE >
				<? 		//$k = 0;
						//while ($k < count($menuid)){
							//for ($i = 0; $i < count($id); $i++){
								//if ($id[$i] == $menuid[$k]){
									//$k++;?>
									<OPTION VALUE="<? echo $id[$i]; ?>" SELECTED><? echo $menu[$i]; ?></OPTION>
						<?			//}
								//else {?>
									<OPTION VALUE="<? echo $id[$i]; ?>"><? echo $menu[$i]; ?></OPTION>
						<?			//}
								//}
							//}?>
					</SELECT>
				</TD>-->
				<TD WIDTH="100%">
					<SELECT NAME="menu" SIZE="10" MULTIPLE >
						<?$k = 0;
						while ($k < count($id)){
							$selected="";
							for ($i = 0; $i < count($menuid); $i++){
								if ($menuid[$i] == $id[$k]){
									$selected="selected";
								}
							}?>
							<OPTION VALUE="<? echo $id[$k]; ?>" <?echo $selected;?>><? echo $menu[$k]; ?></OPTION>
							<?$k++;
						}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>Title:</TD>
				<TD><INPUT TYPE="text" NAME="mytitle" SIZE="75" VALUE="<? echo htmlspecialchars($pollTitle,ENT_QUOTES); ?>"></TD>
			</TR>
			<?for ($i = 0; $i < count($optionText); $i++){ ?>
				<TR>
				<? $s = $i + 1;?>
				<TD><? echo "$s."; ?></TD>
				<TD><INPUT TYPE="text" NAME="polloption[]" VALUE="<? echo $optionText[$i]; ?>" SIZE="75"></TD>
				<INPUT TYPE="hidden" NAME="pollorder[]" VALUE="<? echo $s; ?>">
				<INPUT TYPE="hidden" NAME="optionCount[]" VALUE="<? echo $optionCount[$i]; ?>"></TD>
				</TR>
			<?}
			$t = 12 - $i;
			for ($j = 0; $j < $t; $j++){?>
				<TR>
					<? $s++;?>
					<TD><? echo "$s."; ?></TD>
					<TD><INPUT TYPE="text" NAME="polloption[]" VALUE="" SIZE="75"></TD>
					<INPUT TYPE="hidden" NAME="pollorder[]" VALUE="<? echo "$s."; ?>">
					<INPUT TYPE="hidden" NAME="optionCount[]" VALUE="0">
				</TR>
			<?}?>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="pollid" VALUE="<? echo $pollid; ?>">
			<INPUT TYPE="hidden" NAME="textfieldcheck" VALUE="<? echo $k+1; ?>">
			</TABLE>
			</FORM>
			<?}
			
		function addSurvey($id, $name, $option){?>
			<SCRIPT LANGUAGE="Javascript">
			<!--
				function checktextfield(textfield){
					if (textfield == ""){
						if (document.adminForm.textfieldcheck.value != 0)
							document.adminForm.textfieldcheck.value--;
						}
					else {
						document.adminForm.textfieldcheck.value++;
						}
					}
			//-->
			</SCRIPT>
			<FORM ACTION='index2.php' METHOD='GET' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">Add Survey</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD VALIGN="top">Page:</TD>
				<TD WIDTH="100%">
					<SELECT NAME="menu" SIZE="10" MULTIPLE>
					<? 	for ($i = 0; $i < count($id); $i++){?>
							<OPTION VALUE="<? echo $id[$i]; ?>"><? echo $name[$i]; ?></OPTION>
					<?		}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>Title:</TD>
				<TD><INPUT TYPE='text' NAME='mytitle' SIZE='75'></TD>
			</TR>
			<?for ($i = 0; $i < 12; $i++){
				$s = $i + 1;?>
				<TR>
					<TD><? echo "$s."; ?></TD>
					<TD><INPUT TYPE='text' NAME='polloption[]' SIZE='75' onChange="checktextfield(this.value);"></TD>
					<INPUT TYPE='hidden' NAME='pollorder[]' VALUE="<? echo $s; ?>">
				</TR>
			<?	}?>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='textfieldcheck' VALUE="0">
			<INPUT TYPE='hidden' NAME='option' VALUE="<? echo $option; ?>">
			</FORM>
			</TABLE>
			<?}
		}
?>
