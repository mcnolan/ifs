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
	 *	File Name: HTML_contact.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class HTML_contact {
		function showcontact($companyname, $acn, $address, $suburb, $state, $postcode, $telephone, $facsimile, $email, $country){?>
			<FORM ACTON='index2.php' METHOD='POST' NAME="adminForm">
			<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" Width="100%">
			<TR BGCOLOR="#999999">
				
      <TD COLSPAN="4" CLASS="heading" HEIGHT="20">&nbsp;Contact Details</TD>
			</TR>
			<TR>
				<TD COLSPAN="4" CLASS="heading" HEIGHT="20">&nbsp;</TD>
			</TR>
			<TR>
				<TD WIDTH="100">Company Name:</TD>
				<TD COLSPAN="3" WIDTH="85%"><INPUT TYPE="text" NAME="companyname" SIZE="25" VALUE="<? echo $companyname; ?>"></TD>	
			</TR>
			<TR>
				<TD WIDTH="120">Company Number:</TD>
				<TD COLSPAN="3"><INPUT TYPE="text" NAME="acn" SIZE="15" VALUE="<? echo $acn; ?>"></TD>
			</TR>
			<TR>
				<TD WIDTH="100">Address:</TD>
				<TD COLSPAN="3"><INPUT TYPE="text" NAME="address" SIZE="25" VALUE="<? echo $address; ?>"></TD>
			</TR>
			<TR>
				<TD WIDTH="100">Town/City:</TD>
				<TD COLSPAN="3"><INPUT TYPE="text" NAME="suburb" SIZE="25" VALUE="<? echo $suburb; ?>"></TD>
			</TR>
			<TR>
				<TD WIDTH="120">State:</TD>
				<TD WIDTH="100"><INPUT TYPE="text" NAME="state" SIZE="15" VALUE="<? echo $state; ?>"></TD>
			</TR>
			<TR>
				<TD WIDTH="120">Country:</TD>
				<TD WIDTH="100"><INPUT TYPE="text" NAME="country" SIZE="15" VALUE="<? echo $country; ?>"></TD>
			</TR>
			<TR>
				<TD WIDTH="100">Postcode/ZIP:</TD>
				<TD WIDTH="100"><INPUT TYPE="text" NAME="postcode" VALUE="<? echo $postcode; ?>" SIZE="10"></TD>
			</TR>
			<TR>
				<TD WIDTH="100">Telephone:</TD>
				<TD COLSPAN="3"><INPUT TYPE="text" NAME="telephone" SIZE="15" VALUE="<? echo $telephone; ?>"></TD>
			</TR>
			<TR>
				<TD WIDTH="100">Facsimile</TD>
				<TD COLSPAN="3"><INPUT TYPE="text" NAME="facsimile" SIZE="15" VALUE="<? echo $facsimile; ?>"></TD>
			</TR>
			<TR>
				<TD WIDTH="100">Email To:</TD>
				<TD COLSPAN="3"><INPUT TYPE="text" NAME="email" SIZE="25" VALUE="<? echo $email; ?>"></TD>
			</TR>
			<TR>
				<TD ALIGN="center" COLSPAN="4" HEIGHT="20">&nbsp;</TD>
			</TR>
			<TR BGCOLOR="#999999">
				<TD ALIGN="left" CLASS="heading" COLSPAN="4" HEIGHT="20">&nbsp;</TD>
			</TR>
			</TABLE>
			<INPUT TYPE="hidden" NAME="option" VALUE="contact">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
		<? }
		}
?>
			
