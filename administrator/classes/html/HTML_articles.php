<?php
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
	 *	File Name: HTML_articles.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/
	
	class HTML_articles {
		function showArticles($artid, $title, $approved, $author, $usertype, $option, $published, $checkedout, $editor, $archived, $categoryid, $categoryname, $categories){ ?>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD COLSPAN = "7" align=right>
					<SELECT NAME="categories" onChange="document.location.href='index2.php?option=Articles&categories=' + document.adminForm.categories.options[selectedIndex].value">
						<OPTION VALUE="">Select a category</OPTION>
						<?if ($categories =="all"){?>
							<OPTION VALUE="all" selected>Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
						<?}elseif ($categories == "new"){?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new"selected>Select NEW</OPTION>
						<?}else{?>
							<OPTION VALUE="all">Select All</OPTION>
							<OPTION VALUE="new">Select NEW</OPTION>
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
				<TD COLSPAN="2" WIDTH="60%" CLASS="heading">Articles Manager</TD>
				<TD WIDTH="15%" ALIGN="center" CLASS="heading">Submitted By</TD>
				<TD WIDTH="5%" ALIGN="center" CLASS="heading">Published</TD>
				<TD WIDTH="5%" ALIGN="center" CLASS="heading">Archived</TD>
				<TD WIDTH="15%" ALIGN="center" CLASS="heading">Checked Out</TD>
				<TD WIDTH="5%" ALIGN="center" CLASS="heading">Approved</TD>
			</TR>
			<? 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($artid); $i++){?>
			<TR BGCOLOR="<? echo $color[$k]; ?>">
				<TD WIDTH=2><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $artid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
			<?	if ($approved[$i] == 0){?>
					<TD WIDTH="60%"><A HREF="index2.php?option=<? echo $option; ?>&task=edit&artid=<? echo $artid[$i]; ?>&categories=<? echo $categories; ?>"><? echo $title[$i]; ?></A></TD>
			<?	}
				else {?>
					<TD WIDTH="60%"><? echo $title[$i]; ?></A></TD>
			<?	}?>
			
			<?	if ($author[$i] == ""){?>
					<TD WIDTH="15%" ALIGN="center">&nbsp;</TD>
			<?		}
				else {?>
					<TD WIDTH="15%" ALIGN="center"><?echo $author[$i];?></TD>
			<?		}?>
					
			<? 	if ($published[$i] == 1){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
			<?			}
					}
				else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?			}
					}?>
				
			<?	if ($archived[$i] == 1){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
			<?			}
					}
				else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?			}
					}?>
			
			<?	if ($checkedout[$i] == 1){?>
					<TD WIDTH="15%" ALIGN="center"><? echo $editor[$i]; ?></TD>
			<?		}
				else {?>
					<TD WIDTH="15%" ALIGN="center">&nbsp;</TD>
			<?		}?>
				
				<?if ($approved[$i]==1){
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/greytic.gif"></TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center"><IMG SRC="../images/admin/whttic.gif"></TD>
			<?			}
				}else {
					if ($color[$k] == "#FFFFFF"){?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?		} else {?>
						<TD WIDTH="5%" ALIGN="center">&nbsp;</TD>
			<?			}
				}?>
				
				<? if ($k == 1){
						$k = 0;
						}
				   else {
				   		$k++;
						}?>
				<?
				}?>
			</TR>
			<INPUT TYPE='hidden' NAME='option' VALUE='<? echo $option; ?>'>
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="cat" VALUE="<? echo $categories; ?>">
			<INPUT TYPE="hidden" NAME="boxchecked" VALUE="0">
			</FORM>
			</TABLE>
			<?}
			
		function editarticle($secid, $artid, $title, $content, $secname, $secsecid, $sectionsecid, $sectionname, $sectionimage, $option, $task, $ordering, $maxnum, $categorycid, $categorytitle, $orderingarticles, $categories, $author, $text_editor){?>
			<SCRIPT LANGUAGE="Javascript">
			<!--
					categories = new Array();
			<? 	for ($i = 0; $i < count($categorytitle); $i++){?>
			<?		$var = split(" ", $categorytitle[$i]);
					$count = count($var);
					for ($j = 0; $j < $count; $j++)
						$newvar .= $var[$j];?>
					categories["<? echo $newvar; ?>"] = <? echo $ordering["$categorytitle[$i]"]; ?>;
			<?		unset($newvar); ?>
			<?		}?>
			
			//-->
			</SCRIPT>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">Edit Articles</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Title:</TD>
				<TD><INPUT TYPE='text' NAME='mytitle' SIZE='70' VALUE="<? echo htmlspecialchars($title,ENT_QUOTES); ?>"></TD>
			</TR>
			<TR>
				<TD>Section:</TD>
				<TD>
					<SELECT NAME='category' >
						<? for ($i = 0; $i < count($sectionsecid); $i++){
							if ($secsecid == $sectionsecid[$i]){?>
								<OPTION VALUE='<? echo $sectionsecid[$i]; ?>' SELECTED><? echo $sectionname[$i]; ?></OPTION>
							<? }
							else {?>
								<OPTION VALUE='<? echo $sectionsecid[$i]; ?>'><? echo $sectionname[$i]; ?></OPTION>
						<?		}
							}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>Author</TD>
				<TD><INPUT TYPE='text' NAME='author' VALUE='<?echo $author;?>'></TD>
			</TR>
			<TR>
				<TD VALIGN="top">Content:</TD>
				<TD VALIGN='top'><TEXTAREA COLS='70' ROWS='15' NAME='content'><? echo htmlentities($content); ?></TEXTAREA></TD>
			</TR>
			<? if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?	}?>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='artid' VALUE="<? echo $artid; ?>">
			<INPUT TYPE='hidden' NAME='option' VALUE="<? echo $option; ?>">
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE="hidden" NAME="porder" VALUE="<? echo $orderingarticles; ?>">
			<INPUT TYPE="hidden" NAME="pcategory" VALUE="<? echo $secsecid; ?>">
			<INPUT TYPE="hidden" NAME="categories" VALUE="<? echo $categories; ?>">
			</FORM>
		<?	}
		
		function addArticle($categorycid, $categorytitle, $option, $ordering, $categories, $text_editor){?>
			<SCRIPT LANGUAGE="Javascript">
			<!--
					categories = new Array();
			<? 	for ($i = 0; $i < count($categorytitle); $i++){?>
			<?		$var = split(" ", $categorytitle[$i]);
					$count = count($var);
					for ($j = 0; $j < $count; $j++)
						$newvar .= $var[$j];?>
					categories["<? echo $newvar; ?>"] = <? echo $ordering["$categorytitle[$i]"]; ?>;
			<?		unset($newvar); ?>
			<?		}?>
			
			//-->
			</SCRIPT>
			<FORM ACTION='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">Add Article</TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH='100'>Title:</TD>
				<TD><INPUT TYPE='text' NAME='mytitle' SIZE='70' VALUE="<? echo $title; ?>"></TD>
			</TR>
			<TR>
				<TD>Section:</TD>
				<TD COLSPAN='3'>
					<SELECT NAME='category'>
						<? for ($i = 0; $i < count($categorycid); $i++){?>
								<OPTION VALUE='<? echo $categorycid[$i]; ?>'><? echo $categorytitle[$i]; ?></OPTION>
						<?	}?>
					</SELECT>
				</TD>
			</TR>
			<TR>
				<TD>Author</TD>
				<TD><INPUT TYPE='text' NAME='author'></TD>
			</TR>
			<TR>
				<TD VALIGN="top">Content:</TD>
				<TD VALIGN='top'><TEXTAREA COLS='70' ROWS='15' NAME='content'><? echo htmlentities($content); ?></TEXTAREA></TD>
			</TR>
			<? if ($text_editor == true){?>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN="top"><A HREF="#" onClick="window.open('inline_editor/editor.htm', 'win1', 'width=650, height=450, resizable=yes');">Edit Text In Editor</A></TD>
				</TR>
			<?	}?>
			<TR>
				<TD ALIGN="center" COLSPAN="2">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="2">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE='hidden' NAME='option' VALUE="<? echo $option; ?>">
			<INPUT TYPE='hidden' NAME='task' VALUE="">
			<INPUT TYPE='hidden' NAME='categories' VALUE="<? echo $categories; ?>">
			</FORM>
		<?	}
		
		}
?>
