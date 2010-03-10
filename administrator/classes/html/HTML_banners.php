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
	 *	File Name: HTML_banners.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/
	
	class HTML_banners {
		function showBanners_current($bid, $bname, $option, $impleft, $clicks, $percentClicks, $impmade, $status, $editor){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="heading"><?echo $option;?> Banners</TD>
				<TD ALIGN="CENTER" CLASS="heading">Impressions Made</TD>
				<TD ALIGN="CENTER" CLASS="heading">Impressions Left</TD>
				<TD ALIGN="CENTER" CLASS="heading">Clicks</TD>
				<TD ALIGN="CENTER" CLASS="heading">% Clicks</TD>
				<TD ALIGN="CENTER" CLASS="heading">Published</TD>
				<TD ALIGN="CENTER" CLASS="heading">Checked Out</TD>
			</TR>
			<? 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($bid); $i++){?>
			<TR BGCOLOR="<? echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $bid[$i]; ?>" onClick="isChecked(this.checked);"></TD>
				<TD WIDTH="42%"><? echo $bname[$i]; ?></TD>
				<TD WIDTH="11%" ALIGN="CENTER"><? echo $impmade[$i];?></TD>
				<TD WIDTH="11%" ALIGN="CENTER"><? echo $impleft[$i];?></TD>
				<TD WIDTH="8%" ALIGN="CENTER"><? echo $clicks[$i];?></TD>
				<TD WIDTH="8%" ALIGN="CENTER"><? echo $percentClicks[$i];?></TD>
				<?if ($status[$i] == "yes"){
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
				<!--<TD WIDTH="8%" ALIGN="CENTER"><? echo $status[$i];?></TD>-->
				<TD WIDTH="12%" ALIGN="CENTER"><?echo $editor[$i];?>&nbsp;</TD>
				<? if ($k == 1){
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
			
		function showBanners_finished($bid, $bname, $option, $clicks, $percentClicks, $impmade){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="2" CLASS="heading"><?echo $option;?> Banners</TD>
				<TD ALIGN=CENTER CLASS="heading">Impressions Made</TD>
				<TD ALIGN=CENTER CLASS="heading">Clicks</TD>
				<TD ALIGN=CENTER CLASS="heading">% Clicks</TD>
			</TR>
			<? 
			$color = array("#FFFFFF", "#CCCCCC");
			$k = 0;
			for ($i = 0; $i < count($bid); $i++){?>
			<TR BGCOLOR="<? echo $color[$k]; ?>">
				<TD WIDTH="20"><INPUT TYPE="checkbox" NAME="cid[]" VALUE="<? echo $bid[$i]; ?>"></TD>
				<TD WIDTH="70%" ALIGN=LEFT><? echo $bname[$i]; ?></TD>
				<TD WIDTH="14%" align=center><? echo $impmade[$i];?></TD>
				<TD WIDTH="8%" align=center><? echo $clicks[$i];?></TD>
				<TD WIDTH="8%" align=center><? echo $percentClicks[$i];?></TD> 
				<? if ($k == 1){
						$k = 0;
					}else {
				   		$k++;
					}
			}?>
			</TR>
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
			</TABLE>
			<?}
			
		function addBanner_current($clientNames, $clientIDs, $imageList, $option){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="3" CLASS="heading">Add New Banner</TD>
			</TR>
			<tr>
				<td colspan=3>&nbsp;</td>
			</tr>
			<TR>
				<TD width=20%>Banner Name:</TD>
				<TD width=35%><input type=text name=bname></TD>
				<TD rowspan=5 valign=top><IMG SRC="../images/admin/spacer.gif" NAME="imagelib"></TD>
			</TR>
			<tr>
				<td>Client Name:</td>
				<td align=left><select name=clientid>
								<?for ($i=0; $i < count($clientIDs); $i++){?>
									<option value=<?echo $clientIDs[$i];?>><?echo $clientNames[$i];?></option>
								<?}?>
								</select></td>
			</tr>
			<tr>
				<td>Impressions Purchased:</td>
				<td><input type=text name=imptotal size=12 maxlength=11> &nbsp;&nbsp;Unlimited <input type="checkbox" name="unlimited"></td>
			</tr>
			<tr>
				<td>Banner URL:</td>
				<td align=left><select name="imageurl" onChange="document.imagelib.src='../images/banners/' + document.forms[0].imageurl.options[selectedIndex].text">
								<option value="" selected>Please Select</option>
								<?for ($i=0; $i < count($imageList); $i++){?>
									<option value=<?echo $imageList[$i];?>><?echo $imageList[$i];?></option>
								<?}?>
								</select>
				</td>
			</tr>
			<tr>
				<td>Click URL:</td>
				<td><input type=text name=clickurl size=50 maxlength=200></td>
			</tr>
			<tr>
				<td colspan=3>&nbsp;</td>
			</tr>
			<tr BGCOLOR=#999999>
				<td colspan=3>&nbsp;</td>
			</tr>
				
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
			</TABLE>
			<?}
		
			
		function editBanner_current($bannerid, $bname, $cname, $clientid, $imptotal, $imageurl, $clickurl, $clientNames, $clientIDs, $imageList, $option, $myname){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="3" CLASS="heading">Edit Banner</TD>
			</TR>
			<tr>
				<td colspan=3>&nbsp;</td>
			</tr>
			<TR>
				<TD width=20%>Banner Name:</TD>
				<TD width=35%><input type=text name=bname value="<?echo $bname;?>"></TD>
				<td rowspan=5 valign=top><IMG SRC="../images/banners/<? echo $imageurl; ?>" NAME="imagelib"></TD>
			</TR>
			<tr>
				<td>Client Name:</td>
				<td align=left><select name=clientid>
								
								<?for ($i=0; $i < count($clientIDs); $i++){
									if ($clientid == $clientIDs[$i]){?>
										<option value="<?echo $clientid;?>" selected><?echo $cname;?></option>
									<?} else {?>
										<option value=<?echo $clientIDs[$i];?>><?echo $clientNames[$i];?></option>
								<?		}
									}?>
								</select>
				</td>
			</tr>
			<tr>
				<td>Impressions Purchased:</td>
				<?if ($imptotal=="0"){
					$unlimited="checked";
					$imptotal="";
				}?> 
				<td><input type=text name=imptotal size=12 maxlength=11 value="<?echo $imptotal;?>">&nbsp;Unlimited <input type="checkbox" name="unlimited" <?echo $unlimited;?>></td>
			</tr>
			<tr>
				<td>Banner URL:</td>
				<td align=left><select name="imageurl" onChange="document.imagelib.src='../images/banners/' + document.forms[0].imageurl.options[selectedIndex].text">
								
								<?for ($i=0; $i < count($imageList); $i++){
									if ($imageList[$i] == $imageurl){?>
										<option value="<?echo $imageurl;?>" selected><?echo $imageurl;?></option>
									<?}else{?>
										<option value=<?echo $imageList[$i];?>><?echo $imageList[$i];?></option>
								<?		}
									}?>
								</select>
				</td>
			</tr>
			<tr>
				<td>Click URL:</td>
				<td><input type=text name=clickurl size=50 maxlength=200 value="<?echo $clickurl;?>"></td>
				
			</tr>
			<tr>
				<td colspan=3>&nbsp;</td>
			</tr>
			<tr BGCOLOR=#999999>
				<td colspan=3>&nbsp;</td>
			</tr>
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="bannerid" VALUE="<? echo $bannerid; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			<INPUT TYPE="hidden" NAME="myname" VALUE="<?echo $myname;?>">
			</FORM>
			</TABLE>
			<?}


		function editBanner_finished($bannerid, $bname, $cname, $clientid, $impressions, $clicks, $datestart, $dateend, $imageurl, $option){?>
			<FORM ACTION="index2.php" METHOD="POST" NAME="adminForm">
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR=#999999>
				<TD COLSPAN="3" CLASS="heading">View Finished Banner</TD>
			</TR>
			<tr>
				<td colspan=3>&nbsp;</td>
			</tr>
			<TR>
				<TD width=20%>Banner Name:</TD>
				<TD width=35%><input type=text name=bname value="<?echo $bname;?>" disabled></TD>
				<td rowspan=6 valign=top><IMG SRC="../images/banners/<? echo $imageurl; ?>" NAME="imagelib"></TD>
			</TR>
			<tr>
				<td>Client Name:</td>
				<td align=left><input type=text name=cname value="<?echo $cname;?>" disabled></td>
			</tr>
			<tr>
				<td>Impressions Purchased:</td>
				<td><input type=text name=imptotal size=12 maxlength=11 value="<?echo $impressions;?>" disabled> 0 = Unlimited</td>
			</tr>
			<tr>
				<td>Number of Clicks:</td>
				<td><input type=text name=imageurl size=50 maxlength=100 value="<?echo $clicks;?>" disabled></td>
			</tr>
			<tr>
				<td>Date Start:</td>
				<td><input type=text name=clickurl size=50 maxlength=200 value="<?echo $datestart;?>" disabled></td>
			</tr>
			<tr>
				<td>Date End:</td>
				<td><input type=text name=clickurl size=50 maxlength=200 value="<?echo $dateend;?>" disabled></td>
			</tr>
			<tr>
				<td colspan=3>&nbsp;</td>
			</tr>
			<tr BGCOLOR=#999999>
				<td colspan=3>&nbsp;</td>
			</tr>
			<INPUT TYPE="hidden" NAME="option" VALUE="<? echo $option; ?>">
			<INPUT TYPE="hidden" NAME="bannerid" VALUE="<? echo $bannerid; ?>">
			<INPUT TYPE="hidden" NAME="task" VALUE="">
			</FORM>
			
			</TABLE>
			<?}
	}
?>
