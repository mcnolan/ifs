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
	 *	File Name: HTML_top10.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	class HTML_top10 {
		function showtop10($storytitle, $storycounter, $sectitle, $seccounter, $task){
			$color = array("#FFFFFF", "#CCCCCC");
			$s = 0;
		?>
			<TABLE CELLPADDING="5" CELLSPACING="0" BORDER="0" WIDTH="100%">
			<TR BGCOLOR="#999999">
				<? $item = ucfirst($task);?>
				<TD WIDTH="50%" CLASS="heading">Top 10 <? echo $item; ?></TD>
				<TD WIDTH="10%" ALIGN="center" CLASS="heading">Number of times read</TD>
			</TR>
			<? if ($task == "news"){?>
			<?for ($i = 0; $i < count($storytitle); $i++){
				$k = $i + 1;?>
				<TR BGCOLOR="<? echo $color[$s]; ?>">
					<TD WIDTH='50%'><B><? echo "$k."; ?></B> <? echo $storytitle[$i]; ?></TD>
					<TD WIDTH="10%" ALIGN="center"><B><? echo $storycounter[$i]; ?></B></TD>
				</TR>
				<?if ($s == 1){
					$s = 0;
					}
			   else {
			   		$s++;
					}
				}
			} else if ($task == "articles") {
			?>
		<?	for ($i = 0; $i < count($sectitle); $i++){
				$k = $i + 1;?>
				<TR BGCOLOR="<? echo $color[$s]; ?>">
					<TD WIDTH='50%'><B><? echo "$k."; ?></B> <? echo $sectitle[$i]; ?></B></TD>
					<TD WIDTH="10%" ALIGN="center"><B><? echo $seccounter[$i]; ?></TD>
				</TR>
			<?	
				 if ($s == 1){
					$s = 0;
					}
			   else {
			   		$s++;
					}
				} 
			}
			?>
			</TABLE>
		<?	}
		
		}
?>
