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
	 *	File Name: menusurvey.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class menusurvey {
		function NEW_MENU_Survey(){ ?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD WIDTH="47%" VALIGN="top"><img name="menu" src="../images/admin/menu.gif" width="100%" height="28" border="0"></TD>
				<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
				<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
					<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
					<TR>
						<TD WIDTH="50" ALIGN='center'><A HREF="javascript:submitbutton('savenew', 'survey');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Save" NAME="save" WIDTH="32" HEIGHT="47" BORDER="0" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="50" ALIGN='center'><A HREF="javascript:window.history.go(-1);" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" NAME="cancel" WIDTH="34" HEIGHT="47" BORDER="0" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="470">&nbsp;</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD WIDTH="470">&nbsp;</TD>
				<TD VALIGN="bottom" ALIGN="left" BGCOLOR="#999999"><img name="shadow" src="../images/admin/shadow.gif" width="100%" height="10" border="0" VSPACE="0" HSPACE="0"></TD>
			</TR>
			</TABLE>

		<?	}

		function EDIT_MENU_Survey($comcid, $database, $mpre){
			$query = "SELECT published FROM " . $mpre . "poll_desc WHERE pollID='$comcid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$publish = $row->published;
				}
			print $published;
			mysql_free_result($result);?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD WIDTH="47%" VALIGN="top"><img name="menu" src="../images/admin/menu.gif" width="100%" height="28" border="0"></TD>
				<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
				<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
					<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
					<TR>
					<?	if ($publish == "1"){?>
								<TD WIDTH="50" ALIGN='center' BGCOLOR="#999999" VALIGN="bottom"><A HREF="javascript:submitbutton('unpublish', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('Unpublish','','../images/admin/Unpublish_f2.gif',1);"><IMG SRC="../images/admin/Unpublish.gif" ALT="Unpublish" WIDTH="45" HEIGHT="47" BORDER="0" NAME="Unpublish" HSPACE="5" VSPACE="0"></A></TD>
							<?}else{?>
								<TD WIDTH="50" ALIGN='center' BGCOLOR="#999999" VALIGN="bottom"><A HREF="javascript:submitbutton('publish', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('publish','','../images/admin/publish_f2.gif',1);"><IMG SRC="../images/admin/publish.gif" ALT="Publish" WIDTH="32" HEIGHT="47" BORDER="0" NAME="publish" HSPACE="5" VSPACE="0"></A></TD>
							<?}?>

						<TD WIDTH="50" ALIGN='center'><A HREF="#" onclick="javascript:window.open('popups/surveywindow.php?id=<? echo $comcid; ?>', 'win1', 'status=no,toolbar=no,scrollbars=auto,titlebar=no,menubar=no,resizable=yes,width=200,height=400,directories=no,location=no');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('preview','','../images/admin/preview_f2.gif',1);"><IMG SRC="../images/admin/preview.gif" ALT="Preview" WIDTH="35" HEIGHT="47" BORDER="0" NAME="preview" HSPACE="5" VSPACE="0"></A></TD>
						<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('saveedit', 'survey');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Save" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="5" VPSACE="0"></A></TD>
			    		<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:document.location.href='menubar/cancel.php?id=<? echo $comcid; ?>&option=Survey'" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VPSACE="0"></A></TD>
						<TD WIDTH="370">&nbsp;</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			<TR>
				<TD WIDTH="370">&nbsp;</TD>
				<TD VALIGN="bottom" ALIGN="left" BGCOLOR="#999999"><img name="shadow" src="../images/admin/shadow.gif" width="100%" height="10" border="0" VSPACE="0" HSPACE="0"></TD>
			</TR>
			</TABLE>
		<?	}
		}
?>