<?php
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
	 *	File Name: HTML_news.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class HTML_news {
		function showNews($id, $title, $option, $published, $checkedout, $editor, $archived, $categoryid, $categoryname, $categories, $frontpage, $approved){ ?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function isChecked(isitchecked){
					if (isitchecked == false){
						document.adminForm.boxchecked.value--;
						}
					else {
						document.adminForm.boxchecked.value++;
						}
					}
			//-->
			</SCRIPT>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN="7" align=right>Select A Category:&nbsp;&nbsp;
					<SELECT NAME="categories" onChange="document.location.href='index2.php?option=News&categories=' + document.adminForm.categories.options[selectedIndex].value">
						<OPTION VALUE="">Select a category</OPTION>
						<?if ($categories =="all"){?>
							<OPTION VALUE="all" selected>Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
							<OPTION VALUE="home">Select Home</OPTION>
						<?}elseif ($categories == "new"){?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new"selected>Select NEW</OPTION>
							<OPTION VALUE="home">Select Home</OPTION>
						<?}elseif ($categories == "home"){?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
							<OPTION VALUE="home" selected>Select Home</OPTION>
						<?}else{?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
							<OPTION VALUE="home">Select Home</OPTION>
						 <?}
						for ($i = 0; $i < count($categoryid); $i++){
							if ($categories == $categoryid[$i]){?>
								<OPTION VALUE="<? echo $categoryid[$i]; ?>" SELECTED><? echo $categoryname[$i]; ?></OPTION>
					<?		} else {?>
								<OPTION VALUE="<? echo $categoryid[$i]; ?>"><? echo $categoryname[$i]; ?></OPTION>
					<?			}
							}?>
					</SELECT>
				</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD COLSPAN="2" WIDTH="60%" CLASS="heading">News Manager</TD>
				<TD WIDTH="5%" ALIGN="center" CLASS="heading">Home</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Published</TD>
				<TD WIDTH="5%" ALIGN="center" CLASS="heading">Archived</TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Checked Out</TD>
			</TR>
			<?
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($id); $i++){?>
			<TR BGCOLOR="<? echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $id[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<?	if ($approved[$i] == 0){?>
						<TD WIDTH="60%"><A HREF="index2.php?option=<? echo $option; ?>&task=edit&id=<? echo $id[$i]; ?>&categories=<? echo $categories; ?>"><? echo $title[$i]; ?></A></TD>
					<?}else {
						echo "<TD WIDTH=60%>$title[$i]&nbsp;</TD>";
					}?>
			<?	if ($frontpage[$i] == "1"){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?			}
					}
				else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?			}
					}

				if ($published[$i] == "1"){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?		} else {?>
						<TD WIDTH="10%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?			}
					}
				else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
			<?		} else {?>
						<TD WIDTH="10%" ALIGN="center">&nbsp;</TD>
			<?			}
					}

				if ($archived[$i] == 1){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif" WIDTH="12" HEIGHT="12" BORDER="0"></TD>
			<?			}
					}
				else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?			}
					}

				if ($editor[$i] == ""){?>
					<TD WIDTH="15%" ALIGN="center">&nbsp;</TD>
			<?		}
				else {?>
					<TD WIDTH="15%" ALIGN="center"><? echo $editor[$i]; ?></TD>
			<?		}?>

				<? if ($k == 1){
						$k = 0;
						}
				   else {
				   		$k++;
						}?>
				<?	}?>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<? echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" Name="delete" VALUE="">
			<INPUT TYPE="hidden" Name="cat" VALUE="<? echo $categories; ?>">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
			<?}

		function editNews($imageid, $imagename, $categoryid, $categoryname, $sid, $introtext, $fultext, $topicid, $title, $position, $newsimage, $ordering, $option, $restcount, $storyid, $categories, $frontpage, $frontpagecount, $text_editor){?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function chooseOrdering(){
					var frontpage = <? echo $frontpagecount; ?>;
					var restcount = <? echo $restcount; ?>;
					var chosen = <? echo $frontpage; ?>;
					var orders = <? echo $ordering; ?>;

					if (document.adminForm.frontpage.checked){
						for (var x = 0; x < restcount; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						if (chosen == 1)
							var order = 0;
						else
							var order = 1;

						for (var x = 0; x < frontpage + order; x++){
							document.adminForm.ordering.options[x] = new Option(x+1, x+1);
				   		 	}

						if (chosen == 1)
							document.adminForm.ordering.options[orders-1].selected = true;
						}
					else {
						for (var x = 0; x < frontpage; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						if (chosen == 0)
							var order = 1;
						else
							var order = 0;

						for (var x = 0; x < restcount+order; x++){
							document.adminForm.ordering.options[x] = new Option(x+order, x+order);
				   		 	}
						if (chosen == 0)
							document.adminForm.ordering.options[orders-1].selected = true;
						}
					}
			//-->
			</SCRIPT>

			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="4" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN='3' CLASS='heading' BGCOLOR="#999999">Edit News</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='15%' VALIGN="top">Title:</TD>
				<TD WIDTH=70 VALIGN="top"><INPUT TYPE='text' NAME='mytitle' SIZE='70' VALUE="<? echo htmlspecialchars($title,ENT_QUOTES); ?>"></TD>
				<TD ROWSPAN='2' WIDTH='50%' VALIGN="top">
					<?if ($newsimage!=""){?>
						<IMG SRC="../images/stories/<? echo $newsimage; ?>" NAME="imagelib" WIDTH='69' HEIGHT='77'>
					<?} else {?>
						<IMG SRC="../images/stories/noimage.jpg" NAME="imagelib" WIDTH='69' HEIGHT='77'>
					<?}?>
				</TD>
			</TR>
			<TR>
				<TD VALIGN="top">Topic:</TD>
				<TD VALIGN="top">
			<SELECT NAME='newstopic'>
			<?if ($topicid==""){?>
				<OPTION VALUE='' SELECTED>Select a Topic</OPTION>
			<?}?>
			<? for ($i = 0; $i < count($categoryid); $i++){
					if ($categoryid[$i] == $topicid){?>
						<OPTION VALUE='<? echo $categoryid[$i]; ?>' SELECTED><? echo $categoryname[$i]; ?></OPTION>
			<? 			}
					else {?>
						<OPTION VALUE='<? echo $categoryid[$i]; ?>'><? echo $categoryname[$i]; ?></OPTION>
			<?			}
				} ?>
			</SELECT>
			</TD>
			</TR>

			<TR>
				<TD VALIGN='top'>Introduction:</TD>
				<TD COLSPAN='2'>
      <TEXTAREA COLS='70' ROWS='7' NAME='introtext' wrap="VIRTUAL"><? echo htmlentities ($introtext); ?></TEXTAREA>
    </TD>
			</TR>
			<? if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=introtext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?	}?>
			<TR>
				<TD VALIGN='top'>Extended Text:</TD>
				<TD COLSPAN='2'>
      <TEXTAREA COLS='70' ROWS='7' NAME='fultext' wrap="VIRTUAL"><? echo htmlentities($fultext); ?></TEXTAREA>
    </TD>
			</TR>
			<? if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=fultext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?	}?>

			<TR>
				<TD>Image:</TD>
				<TD COLSPAN="2">
				<SELECT NAME='image' onChange="document.imagelib.src='../images/stories/' + document.forms[0].image.options[selectedIndex].text">
					<OPTION VALUE=''>Select image</OPTION>
					<? for ($i = 0; $i < count($imagename); $i++){
							if (!eregi(".swf", $imagename[$i])){
								if ($imagename[$i] == $newsimage){?>
									<OPTION VALUE='<? echo $imagename[$i]; ?>' SELECTED><? echo $imagename[$i]; ?></OPTION>
								<?}
							else {?>
								<OPTION VALUE='<? echo $imagename[$i]; ?>'><? echo $imagename[$i]; ?></OPTION>
								<?}
							}
						}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD VALIGN='top'>Image Position:</TD>
			<? 	if ($position == "left"){ ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="position" VALUE="left" CHECKED>Left&nbsp;&nbsp;<INPUT TYPE="radio" NAME="position" VALUE="right">Right</TD>
			<? 	} else { ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="position" VALUE="left">Left&nbsp;&nbsp;<INPUT TYPE="radio" NAME="position" VALUE="right" CHECKED>Right</TD>
			<?	} ?>
			</TR>
			<TR>
				<TD>Story ordering</TD>
				<TD COLSPAN="2">
					<SELECT NAME="ordering">
					<? if ($frontpage == 1){
						 	for ($i = 1; $i < $frontpagecount+1; $i++){
								if ($ordering == $i){?>
									<OPTION VALUE="<? echo $i; ?>" SELECTED><? echo $i; ?></OPTION>
								<?	}
								else {?>
									<OPTION VALUE="<? echo $i; ?>"><? echo $i; ?></OPTION>
								<?	}
								}
							}
						else {
							 for ($i = 1; $i < $restcount+1; $i++){
								if ($ordering == $i){?>
									<OPTION VALUE="<? echo $i; ?>" SELECTED><? echo $i; ?></OPTION>
								<?	}
								else {?>
									<OPTION VALUE="<? echo $i; ?>"><? echo $i; ?></OPTION>
								<?	}
								}
							}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
			<?	if ($frontpage == 0){?>
					<TD COLSPAN='2'><INPUT TYPE="checkbox" NAME="frontpage" VALUE="1" onClick="chooseOrdering();">Shows News on Front Page</TD>
			<?		}
				else {?>
					<TD COLSPAN='2'><INPUT TYPE="checkbox" NAME="frontpage" VALUE="1" CHECKED onClick="chooseOrdering();">Shows News on Front Page</TD>
			<?		}?>
			</TR>
			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' CLASS='heading' BGCOLOR="#999999">&nbsp;</TD>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<? echo $option; ?>'>
			<INPUT TYPE='hidden' NAME='sid' VALUE='<? echo $storyid; ?>'>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='porder' VALUE="<? echo $ordering; ?>">
			<INPUT TYPE='hidden' NAME='categories' VALUE="<? echo $categories; ?>">
			</FORM>
			</TABLE>
			<?}

		function addNews($option, $topictext, $topicid, $id, $imagename, $restcount, $frontpagecount, $text_editor, $categories){?>
			<SCRIPT LANGUAGE="javascript">
			<!--
				function chooseOrdering(){
					var frontpage = <? echo $frontpagecount; ?>;
					var restcount = <? echo $restcount; ?>;

					if (document.adminForm.frontpage.checked){
						for (var x = 0; x < restcount+2; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						for (var x = 0; x < frontpage+1; x++){
							document.adminForm.ordering.options[x] = new Option(x+1, x+1);
				   		 	}
						}
					else {
						for (var x = 0; x < frontpage+2; x++){
				   			document.adminForm.ordering.options[x] = null;
				    		}

						for (var x = 0; x < restcount+1; x++){
							document.adminForm.ordering.options[x] = new Option(x+1, x+1);
				   		 	}
						}
					}
			//-->
			</SCRIPT>

			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN='3' CLASS='heading' BGCOLOR="#999999">New News</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
				<TR>
				<TD WIDTH='15%'>Title:</TD>
				<TD WIDTH=70><INPUT TYPE='text' NAME='mytitle' SIZE='70' VALUE="<? echo $title; ?>"></TD>
				<TD ROWSPAN='2' WIDTH='50%'><IMG SRC="../images/M_images/6977transparent.gif" NAME="imagelib" WIDTH='69' HEIGHT='77'></TD>
			</TR>
			<TR>
				<TD>Topic:</TD>
				<TD>
			<SELECT NAME='newstopic'>
				<OPTION VALUE=''>Select Category</OPTION>
				<? for ($i = 0; $i < count($topicid); $i++){ ?>
					<OPTION VALUE='<? echo $topicid[$i]; ?>'><? echo $topictext[$i]; ?></OPTION>
				<?} ?>
			</SELECT>
			</TD>
			</TR>
			<TR>
				<TD VALIGN='top'>Introduction:</TD>
				<TD COLSPAN='2'><TEXTAREA COLS='70' ROWS='7' NAME='introtext'><? echo htmlentities($introtext); ?></TEXTAREA></TD>
			</TR>
			<? if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=introtext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?	}?>
			<TR>
				<TD VALIGN='top'>Extended Text:</TD>
				<TD COLSPAN='2'><TEXTAREA COLS='70' ROWS='7' NAME='fultext'><? echo htmlentities($fultext); ?></TEXTAREA></TD>
			</TR>
			<? if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm?content=fultext', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?	}?>
			<TR>
				<TD>Image:</TD>
				<TD>
					<SELECT NAME='image' onChange="document.imagelib.src=null; document.imagelib.src='../images/stories/' + document.forms[0].image.options[selectedIndex].text">
						<OPTION VALUE=''>Select image</OPTION>
						<? for ($i = 0; $i < count($imagename); $i++){
								if (!eregi(".swf", $imagename[$i])){?>
							<OPTION VALUE='<? echo $imagename[$i]; ?>'><? echo $imagename[$i]; ?></OPTION>
							<?		}
								}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD VALIGN='top'>Image Position:</TD>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="position" VALUE="left" CHECKED>Left&nbsp;&nbsp;<INPUT TYPE="radio" NAME="position" VALUE="right">Right</TD>
			</TR>
			<TR>
				<TD>Story ordering</TD>
				<TD COLSPAN="2">
					<SELECT NAME="ordering">
						<? for ($i = 1; $i < $restcount+2; $i++){?>
								<OPTION VALUE="<? echo $i; ?>"><? echo $i; ?></OPTION>
						<?	}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>&nbsp;</TD>
				<TD COLSPAN='2'><INPUT TYPE="checkbox" NAME="frontpage" VALUE="1" onClick="chooseOrdering();">Shows News on Front Page</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' HEIGHT="40">&nbsp;</TD>
			</TR>
			<TR>
				<TD COLSPAN='3' CLASS='heading' BGCOLOR="#999999">&nbsp;</TD>
			</TR>

			<INPUT TYPE='hidden' NAME='option' VALUE='<? echo $option; ?>'>
			<INPUT TYPE='hidden' NAME='sid' VALUE='<? echo $sid; ?>'>
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='categories' VALUE="<? echo $categories; ?>">
			</FORM>
			</TABLE>
			<?}
		}
?>
