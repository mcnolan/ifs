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
	 *	File Name: menunewsflash.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class menunewsflash {
		function NEW_MENU_Newsflash(){ ?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
				<TR>
					<TD WIDTH="47%" VALIGN="top"><img name="menu" src="../images/admin/menu.gif" width="100%" height="28" border="0"></TD>
					<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
					<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
						<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
						<TR>
							    <TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('savenew', 'newsflash');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Save New" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="5" VPSACE="0"></A></TD>
								<TD WIDTH="50" ><A HREF="index2.php?option=Newsflash" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VPSACE="0"></A></TD>
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

		function EDIT_MENU_Newsflash($comcid, $option, $database, $mpre){
			if (trim($comcid) ==""){
				print "<SCRIPT> alert('Select a newsflash item to edit'); window.history.go(-1);</SCRIPT>\n";
			}else{
				$query="select showflash from " . $mpre . "newsflash where newsflashID=$comcid";
				$result=$database->openConnectionWithReturn($query);
				list($published)=mysql_fetch_array($result);?>
				<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
					<TR>
						<TD WIDTH="47%" VALIGN="top"><img name="menu" src="../images/admin/menu.gif" width="100%" height="28" border="0"></TD>
						<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
						<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
							<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
							<TR>
								<?if ($published==0){?>
								    <TD WIDTH="50" ALIGN='center'><A HREF="javascript:submitbutton('publish', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('Publish','','../images/admin/publish_f2.gif',1);"><IMG SRC="../images/admin/publish.gif" NAME="Publish" ALT="Publish" WIDTH="32" HEIGHT="47" BORDER="0" HSPACE="5" VSPACE="0"></A></TD>
								<?}else{?>
									<TD WIDTH="50" ALIGN='center'><A HREF="javascript:submitbutton('unpublish', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('Unpublish','','../images/admin/Unpublish_f2.gif',1);"><IMG SRC="../images/admin/Unpublish.gif" NAME="Unpublish" ALT="Unpublish" WIDTH="45" HEIGHT="47" BORDER="0" HSPACE="5" VSPACE="0"></A></TD>
								<?}?>
									<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:submitbutton('saveedit', 'newsflash');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('save','','../images/admin/save_f2.gif',1);"><IMG SRC="../images/admin/save.gif" ALT="Save Edit" WIDTH="36" HEIGHT="47" BORDER="0" NAME="save" HSPACE="5" VPSACE="0"></A></TD>
				    				<TD WIDTH="50" VALIGN='bottom' BGCOLOR="#999999"><A HREF="javascript:document.location.href='menubar/cancel.php?id=<? echo $comcid; ?>&option=<? echo $option; ?>'" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('cancel','','../images/admin/cancel_f2.gif',1);"><IMG SRC="../images/admin/cancel.gif" ALT="Cancel" WIDTH="34" HEIGHT="47" BORDER="0" NAME="cancel" HSPACE="5" VPSACE="0"></A></TD>
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
			<?}
		}
}?>