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
	 *	File Name: menudefault.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class MENU_Default {
		function MENU_Default($act, $option){?>
			<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="100%">
			<TR>
				<TD WIDTH="47%" VALIGN="top"><? include ("menubar/mainmenu.php"); ?></TD>
				<TD VALIGN="top" ROWSPAN="3" WIDTH="32" ALIGN="right"><img name="endcap" src="../images/admin/endcap.gif" width="32" height="63" border="0" VSPACE="0" HSPACE="0"></TD>
				<TD VALIGN="bottom" BGCOLOR="#999999" WIDTH="51%">
					<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="99%" BGCOLOR="#999999">
					<TR>
    					<td width="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item to publish'); } else {submitbutton('publish', '');}" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('publish','','../images/admin/publish_f2.gif',1);"><img name="publish" src="../images/admin/publish.gif" width="32" HEIGHT="47" border="0" HSPACE="5" VPSACE="0"></a></td>
						<td width="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><a href="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item to publish'); } else {submitbutton('unpublish', '');}" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('Unpublish','','../images/admin/Unpublish_f2.gif',1);" ><img name="Unpublish" src="../images/admin/Unpublish.gif" width="45" HEIGHT="47" border="0" HSPACE="5 VPSACE="0"></a></td>
						<TD WIDTH="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><A HREF="javascript:submitbutton('new', '');" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('new','','../images/admin/new_f2.gif',1);"><IMG SRC="../images/admin/new.gif"  WIDTH="31" HEIGHT="47" VALUE="new" BORDER="0" NAME="new" HSPACE="5" VPSACE="0"></A></TD>
						<TD WIDTH="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><A HREF="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item to edit'); } else {submitbutton('edit', '');}" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('edit','','../images/admin/edit_f2.gif',1);"><IMG SRC="../images/admin/edit.gif" NAME="edit" ALT="Edit" WIDTH="34" HEIGHT="47" BORDER="0" HSPACE="5" VPSACE="0"></A></TD>			    
						<?if (($option=="SubSections")||($option=="MenuSections")){?>
							<TD WIDTH="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><A HREF="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item to delete'); } else if (confirm('Are you sure you want to delete selected items. This will also delete any related sub-sections')){ submitbutton('remove');}" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('delete','','../images/admin/delete_f2.gif',1);"><IMG SRC="../images/admin/delete.gif" ALT="Delete" WIDTH="34" HEIGHT="47" BORDER="0" NAME="delete" HSPACE="5" VPSACE="0"></TD>
						<?}else{?>
							<TD WIDTH="50" BGCOLOR="#999999" VALIGN="bottom" ALIGN="center"><A HREF="javascript:if (document.adminForm.boxchecked.value == 0){ alert('Please select an item to delete'); } else if (confirm('Are you sure you want to delete selected items')){ submitbutton('remove', '');}" onMouseOut="MM_swapImgRestore();"  onMouseOver="MM_swapImage('delete','','../images/admin/delete_f2.gif',1);"><IMG SRC="../images/admin/delete.gif" ALT="Delete" WIDTH="34" HEIGHT="47" BORDER="0" NAME="delete" HSPACE="5" VPSACE="0"></TD>
						<?}?>
						<TD WIDTH="270">&nbsp;</TD>
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
