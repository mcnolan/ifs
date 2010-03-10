<?
	class HTML_systemInfo {
		function showsystemInfo($sitename, $cur_theme, $col_main){?>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" Width="100%">
			<TR BGCOLOR="#999999">
				<TD COLSPAN="4" CLASS="heading" HEIGHT="20">&nbsp;&nbsp;Theme Manager</TD>
			</TR>
			<TR>
				<TD COLSPAN="4" CLASS="heading" HEIGHT="20">&nbsp;</TD>
			</TR>
			<TR>
                <TD valign="top"><b>Theme Preview:</b></TD>
                <TD WIDTH="710">
                
                             <IMG border="0" SRC='../images/themes/<? echo $cur_theme.".jpg"; ?>' NAME='imagelib'>
                           </TD>
                        </TR>
                        <TR>
                            <TD>&nbsp;</TD>
                        </TR>
                        <TR>
		<?
		if ($handle=opendir("../themes/")){
                	$i=0;
                	while (false !==($file = readdir($handle))) {
                		if ($file != "." && $file != ".."
					&& $file !="footer.php"
					&& $file !="header.php"
					&& $file !="mainbody.php"
					&& $file !="site_search.php"){
                			$nfile = substr($file,0,-4);
                        		$theme_name[$i]=$nfile;
                			$i++;
                		}
			}
		}
?>
                           <TD WIDTH="125"><b>Select Theme:</b></TD>
                           <TD width="710">
                              <SELECT NAME='cur_theme' onChange="document.forms[0].imagelib.src='../images/themes/' + document.forms[0].cur_theme.options[selectedIndex].value + '.jpg'">
                                 <?
                                        $i = 0;
                        for ($i = 0; $i < count($theme_name); $i++){
                              if ($theme_name[$i] == $cur_theme){?>
                                         <OPTION VALUE='<? echo $theme_name[$i]; ?>' SELECTED><? echo $theme_name[$i]; ?></OPTION>
                               <?} else {?>
                                         <OPTION VALUE='<? echo $theme_name[$i]; ?>'><? echo $theme_name[$i]; ?></OPTION>
                               <?}
                                     }?>
                              </SELECT>
                         </TD>
			</TR>
			<TR>
				<TD COLSPAN='3' VALIGN='top'><br><b>No. of Columns</b></TD>
			</TR>
			<TR>
			<TR>
				<TD VALIGN='top'>Home Page:</TD>
			<? 	if ($col_main == "1"){ ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="col_main" VALUE="1" CHECKED>1&nbsp;&nbsp;<INPUT TYPE="radio" NAME="col_main" VALUE="2">2</TD>
			<? 	} else { ?>
				<TD COLSPAN='2'><INPUT TYPE="radio" NAME="col_main" VALUE="1">1&nbsp;&nbsp;<INPUT TYPE="radio" NAME="col_main" VALUE="2" CHECKED>2</TD>
			<?	} ?>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="4" HEIGHT="20">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="4" HEIGHT="20">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="option" VALUE="systemInfo">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
		<? }
		}
?>
