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
	 *	File Name: HTML_statistics.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class HTML_statistics {
		function show_browser_stats($percentInt, $count, $ChartLabel, $sum, $task){?>
			<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0" WIDTH="100%" ALIGN="center">
			<TR>
			<?	if ($task == "browser"){?>
				<TD ALIGN="center" CLASS="articlehead">Browser Statistics</TD>
			<?  } else {?>
				<TD ALIGN="center" CLASS="articlehead">Operating System Statistics</TD>
			<?	}?>
			</TR>
			<TR>
				<TR>
				<TD COLSPAN="3" ALIGN="center">
					<TABLE CELLPADDING="1" CELLSPACING="0" BGCOLOR="#000000" BORDER="0" >
					<TR>
						<TD>
							<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" BGCOLOR="#FFFFFF" >
				<?	if (count($percentInt) <> 0){
						for ($i = 0; $i < count($ChartLabel); $i++){
							if ($percentInt[$i] <> ""){
								$percentage = $count[$i]/$sum * 100;
								$percentage = round($percentage, 2);
								?>
								<TR>
									<TD VALIGN="middle" HEIGHT="40"><IMG SRC="../images/polls/Col<? echo $i+1; ?>M.gif" WIDTH="<? echo $percentInt[$i]/2; ?>" HEIGHT="15" VSPACE="2" HSPACE="0"><IMG SRC="../images/polls/Col<? echo $i+1; ?>R.gif" WIDTH="10" HEIGHT="15" VSPACE="2" HSPACE="0"><BR><? echo "$ChartLabel[$i] - $count[$i] ($percentage%)"; ?></TD>
								</TR>
						<?	} else {?>
								<TR>
									<TD VALIGN="middle" HEIGHT="40"><IMG SRC="../images/polls/Col<? echo $i+1; ?>M.gif" WIDTH="1" HEIGHT="15" VSPACE="2" HSPACE="0"><IMG SRC="../images/polls/Col<? echo $i+1; ?>R.gif" WIDTH="10" HIGHT="15" VSPACE="2" HSPACE="0"><BR><? echo "$ChartLabel[$i] - $count[$i] (0%)"; ?></TD>
								</TR>
					<? 			}
							unset($percentage);
							}
						}
					else {?>
							<TR>
								<TD VALIGN="bottom">There are no results for this month.</TD>
							</TR>
					<?		
						}?>
							</TABLE>
						</TD>
					</TR>
					</TABLE>
				</TD>
			</TR>
			</TABLE>
		<?	}
		}
?>
			
