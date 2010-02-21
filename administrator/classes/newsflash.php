<?PHP
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
	 *	File Name: newsflash.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 3.0.5
	 *	Comments:
	**/

	class newsflash {
		function viewNewsflash($database, $newsflashhtml, $option, $mpre){
			$query="select newsflashID, flashtitle, showflash, editor from " . $mpre . "newsflash order by newsflashID desc";
			$result= $database->openConnectionWithReturn($query);
			$i=0;
			while ($row=mysql_fetch_object($result)){
				$nfid[$i]=$row->newsflashID;
				$flashtitle[$i]=$row->flashtitle;
				$showflash[$i]=$row->showflash;
				$editor[$i]=$row->editor;
				if ($showflash[$i]==1){
					$status[$i]="yes";
				}else{
					$status[$i]="no";
				}
				$i++;
			}
			$newsflashhtml->showNewsflash($nfid, $flashtitle, $status, $option, $editor);
		}

		function addNewsflash($database, $newsflashhtml, $option, $text_editor, $mpre){
			$newsflashhtml->addNewsflash($option, $text_editor);
		}

		function saveNewsflash($database, $flashtitle, $content, $option, $mpre){
			//$content = ereg_replace("\x0D\x0A", "<BR>", $content);
			$query="insert into " . $mpre . "newsflash (flashtitle, flashcontent) values ('$flashtitle', '$content')";
			$database->openConnectionNoReturn($query);
			echo "<SCRIPT>document.location.href='index2.php?option=Newsflash'</SCRIPT>";
		}

		function editNewsflash($newsflashhtml, $database, $option, $newsflashid, $myname, $text_editor, $mpre){
			$query = "SELECT checked_out, editor, flashtitle FROM " . $mpre . "newsflash WHERE newsflashID='$newsflashid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$editor = $row->editor;
				$name=$row->flashtitle;
				}
			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The newsflash $name is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				exit(0);
			}

			$date = date("H:i:s");
			$query = "UPDATE " . $mpre . "newsflash SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE newsflashID='$newsflashid'";
			$database->openConnectionNoReturn($query);

			$query="select flashtitle, flashcontent, showflash from " . $mpre . "newsflash where newsflashID='$newsflashid'";
			$result= $database->openConnectionWithReturn($query);
			list($flashtitle, $flashcontent, $showflash)=mysql_fetch_array($result);
			mysql_free_result($result);

			$newsflashhtml->editNewsflash($newsflashid, $flashtitle, $flashcontent, $option, $myname, $text_editor);
		}

		function saveEditNewsflash($newsflashhtml, $database, $flashtitle, $content, $newsflashid, $option, $myname, $mpre){
			// $content = ereg_replace("\x0D\x0A", "<BR>", $content);
			$query = "SELECT newsflashID FROM " . $mpre . "newsflash WHERE newsflashID='$newsflashid' AND checked_out=1 AND editor='$myname'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				$query= "update " . $mpre . "newsflash set flashtitle='$flashtitle', flashcontent='$content', checked_out=0, checked_out_time='00:00:00', editor=NULL where newsflashID='$newsflashid'";
				$database->openConnectionNoReturn($query);
				echo "<SCRIPT>document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$newsflashid'</SCRIPT>";
			}
		}

		function publishNewsflash($database, $option, $newsflashid, $cid, $mpre){
			if (trim($newsflashid)!=""){
				$query="update " . $mpre . "newsflash set showflash=1 where newsflashid='$newsflashid'";
				$database->openConnectionNoReturn($query);
			}else{
				if (count($cid)!=0){
					for ($i=0; $i < count($cid); $i++){
						$query="update " . $mpre . "newsflash set showflash=1 where newsflashid='$cid[$i]'";
						$database->openConnectionNoReturn($query);
					}
				}else{
					echo "<SCRIPT> alert('Select a newsflash item to publish'); window.history.go(-1);</SCRIPT>\n";
				}
			}
			$query="update " . $mpre . "newsflash set checked_out=0, checked_out_time='00:00:00', editor=NULL where newsflashid='$newsflashid'";
			$database->openConnectionNoReturn($query);
			echo "<SCRIPT>document.location.href='index2.php?option=Newsflash'</SCRIPT>";
		}

		function unpublishNewsflash($database, $option, $newsflashid, $cid, $mpre){
			if (trim($newsflashid)!=""){
				$query="update " . $mpre . "newsflash set showflash=0 where newsflashid='$newsflashid'";
				$database->openConnectionNoReturn($query);
			}else{
				if (count($cid)!=0){
					for ($i=0; $i < count($cid); $i++){
						$query="update " . $mpre . "newsflash set showflash=0 where newsflashid='$cid[$i]'";
						$database->openConnectionNoReturn($query);
					}
				}else{
					echo "<SCRIPT> alert('Select a newsflash item to unpublish'); window.history.go(-1);</SCRIPT>\n";
				}
			}
			$query="update " . $mpre . "newsflash set checked_out=0, checked_out_time='00:00:00', editor=NULL where newsflashid='$newsflashid'";
			$database->openConnectionNoReturn($query);

			echo "<SCRIPT>document.location.href='index2.php?option=Newsflash'</SCRIPT>";
		}

		function removeNewsflash($database, $option, $cid, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT> alert('Select a newsflash item to delete'); window.history.go(-1);</SCRIPT>\n";
			}

			for ($i = 0; $i < count($cid); $i++){
				$query="delete from " . $mpre . "newsflash where newsflashID='$cid[$i]'";
				$database->openConnectionNoReturn($query);
			}
				print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
			 }
		}
?>