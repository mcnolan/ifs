<?PHP
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
	 *	File Name: bannerClient.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class bannerClient {
		function viewBannerClients($database, $bannerClienthtml, $option, $mpre){
			$query="select cid, name, editor from " . $mpre . "bannerclient";
			$result= $database->openConnectionWithReturn($query);
			$i=0;
			while ($row=mysql_fetch_object($result)){
				$clientid[$i]=$row->cid;
				$cname[$i]=$row->name;
				$editor[$i]=$row->editor;
				$query2="select bid from " . $mpre . "banner where cid='$clientid[$i]'";
				$result2=$database->openConnectionWithReturn($query2);
				$numBanners[$i]=mysql_num_rows($result2);
				$i++;
			}
			$bannerClienthtml->showClients($clientid, $cname, $option, $numBanners, $editor);
		}

		function addBannerClient($database, $bannerClienthtml, $option, $mpre){
			$bannerClienthtml->addBannerClient($option);
		}

		function saveBannerClient($database, $cname, $contact, $email, $extrainfo, $mpre){
			if ((trim($cname) == "") || (trim($contact) == "") || (trim($email) =="")){
				echo "<SCRIPT> alert('Please complete name, contact, & email fields'); window.history.go(-1); </SCRIPT>\n";
			}else{
				$query="insert into " . $mpre . "bannerclient (name, contact, email, extrainfo) values ('$cname', '$contact', '$email', '$extrainfo')";
				$database->openConnectionNoReturn($query);
			}
			echo "<SCRIPT>document.location.href='index2.php?option=Clients'</SCRIPT>";
		}

		function editBannerClient($bannerClienthtml, $database, $option, $clientid, $myname, $mpre){
			if ($clientid == ""){
				print "<SCRIPT> alert('Select a client to edit'); window.history.go(-1);</SCRIPT>\n";
			}

			$query = "SELECT checked_out, editor, name FROM " . $mpre . "bannerclient WHERE cid='$clientid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$editor = $row->editor;
				$name=$row->name;
				}
			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The banner client $name is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				exit(0);
			}

			$date = date("H:i:s");
			$query = "UPDATE " . $mpre . "bannerclient SET checked_out='1', checked_out_time='$date', editor='$myname'  WHERE cid='$clientid'";
			$database->openConnectionNoReturn($query);

			$query="select name, contact, email, extrainfo from " . $mpre . "bannerclient where cid='$clientid'";
			$result= $database->openConnectionWithReturn($query);

			list($cname, $contact, $email, $extrainfo)=mysql_fetch_array($result);
			mysql_free_result($result);
			$bannerClienthtml->editBannerClient($clientid, $cname, $contact, $email, $extrainfo, $option, $myname);
		}

		function saveEditBannerClient($bannerClienthtml, $database, $clientid, $cname, $contact, $email, $extrainfo, $myname, $mpre){
			if ((trim($cname) == "") || (trim($contact) == "") || (trim($email) =="")){
				echo "<SCRIPT> alert('Please complete name, contact, & email fields'); window.history.go(-1); </SCRIPT>\n";
			}else{
				$query = "SELECT cid FROM " . $mpre . "bannerclient WHERE cid='$clientid' AND checked_out=1 AND editor='$myname'";
				$result = $database->openConnectionWithReturn($query);
				if (mysql_num_rows($result) > 0){
					$query= "update " . $mpre . "bannerclient set name='$cname', contact='$contact', email='$email', extrainfo='$extrainfo', checked_out=0, checked_out_time='00:00:00', editor=NULL where cid='$clientid'";
					$database->openConnectionNoReturn($query);
					echo "<SCRIPT>document.location.href='index2.php?option=Clients&task=edit&cid%5B%5D=$clientid'</SCRIPT>";
				}
			}
		}

		function removeBannerClient($database, $option, $cid, $mpre){
			if (count($cid) == 0){
				echo "<SCRIPT> alert('Select a client to delete'); window.history.go(-1);</SCRIPT>\n";
			}

			for ($i = 0; $i < count($cid); $i++){
				$query="select bid from " . $mpre . "banner where cid='$cid[$i]'";
				$result=$database->openConnectionWithReturn($query);
				if (mysql_num_rows($result)!=0){
					echo "<SCRIPT> alert('Cannot delete client at this time as they have a banner still running'); window.history.go(-1);</SCRIPT>\n";
				}else{
					$query="delete from " . $mpre . "bannerfinish where cid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					$query="delete from " . $mpre . "bannerclient where cid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
				}
				mysql_free_result($result);
			}
				print "<SCRIPT>document.location.href='index2.php?option=Clients';</SCRIPT>\n";
			 }
		}
?>