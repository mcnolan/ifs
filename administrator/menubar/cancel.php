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
	 *	File Name: cancel.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	 *
	 * Modified December 2009 by Nolan (john.pbem@gmail.com) to work with register_globals off
	**/
	
	function database(){
		global $mpre;
		include ("../../configuration.php");
		mysql_connect($host, $user, $password);
		}
			
	function openConnectionNoReturn($query){
		include ("../../configuration.php");
        mysql_db_query($db, $query) or die("Did not execute query $query");
        }
	
	database();
	global $mpre;
	$id = $_GET['id'];
	$option = $_GET['option'];
	if ($option == "Components"){
		$query = "UPDATE components SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE id=$id";
		}
	elseif (($option == "News")  && ($act <> "categories")){
		$query = "UPDATE " . $mpre . "stories SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE sid=$id";
		}
	elseif (($option == "Articles")  && ($act <> "categories")){
		$query = "UPDATE " . $mpre . "articles SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE artid=$id";
		}
	elseif (($option == "Faq")  && ($act <> "categories")){
		$query = "UPDATE " . $mpre . "faqcont SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE artid=$id";
		}
	elseif (($option == "Weblinks")  && ($act <> "categories")){
		$query = "UPDATE " . $mpre . "links SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE lid=$id";
		}
	elseif (($option == "MenuSections") || ($option == "SubSections")){
		$query= "UPDATE " . $mpre . "menu SET checked_out=0, checked_out_time='00:00:00', editor=NULL where id=$id";
		}
	elseif ($option == "Current"){
		$query= "UPDATE " . $mpre . "banner SET checked_out=0, checked_out_time='00:00:00', editor=NULL where bid=$id";
		}
	elseif ($option == "Clients"){
		$query= "UPDATE " . $mpre . "bannerclient SET checked_out=0, checked_out_time='00:00:00', editor=NULL where cid=$id";
		}
	elseif ($option == "Newsflash"){
		$query= "UPDATE " . $mpre . "newsflash SET checked_out=0, checked_out_time='00:00:00', editor=NULL where newsflashID=$id";
		}
	elseif ($act == "categories"){
		$query = "UPDATE " . $mpre . "categories SET checked_out=0, checked_out_time='00:00:00', editor=NULL where categoryid=$id";
		}
	elseif ($option == "Survey"){
		$query = "UPDATE " . $mpre . "poll_desc SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE pollID='$id'";
		}
	elseif ($option == "Forums"){
		if ($act=="threads"){
			$query = "UPDATE " . $mpre . "messages SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE ID=$id";
		}else{
			$query = "UPDATE " . $mpre . "forum SET checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE ID=$id";
		}
	}
	openConnectionNoReturn($query);
	
	if ($act == "categories"){
		print "<SCRIPT>document.location.href='../index2.php?option=$option&act=$act'</SCRIPT>\n";
		}
	else if ($act=="threads"){
		print "<SCRIPT>document.location.href='../index2.php?option=$option&act=$act&forum=$forum'</SCRIPT>\n";
	}else{
		if ($sections!=""){
			print "<SCRIPT>document.location.href='../index2.php?option=$option&sections=$sections'</SCRIPT>\n";
		}else{
			print "<SCRIPT>document.location.href='../index2.php?option=$option&categories=$categories'</SCRIPT>\n";
		}
	}
?>
