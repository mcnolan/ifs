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
	 *	File Name: newswindow.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	
	
	function database(){
		include ("../../configuration.php");
		mysql_connect($host, $user, $password);
		}
			
	function openConnectionWithReturn($query){
		include ("../../configuration.php");
        $result = mysql_db_query($db, $query) or die("Did not execute query");
        return $result;
        }

    function openConnectionNoReturn($query){
		include ("../../configuration.php");
        mysql_db_query($db, $query) or die("Did not execute query");
        }
	
	database();
	

	if ($print == "print"){
		$query = "SELECT title, introtext, fultext, newsimage, image_position FROM stories WHERE sid=$id";
		$result = openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$title = $row->title;
			$introtext = $row->introtext;
			$fultext = $row->fultext;
			$image = $row->newsimage;
			$position = $row->image_position;
		}
		
		$pat= "SRC=images";
		$replace= "SRC=../../images";
		$introtext=eregi_replace($pat, $replace, $introtext);
		$fultext=eregi_replace($pat, $replace, $fultext);
		$title=eregi_replace($pat, $replace, $title);
		
		
		$pat2= "SRC=\"images";
		$replace2= "SRC=\"../../images";
		$introtext=eregi_replace($pat2, $replace2, $introtext);
		$fultext=eregi_replace($pat2, $replace2, $fultext);
		$title=eregi_replace($pat2, $replace2, $title);
		
		$pat3="\\\\'";
		$replace3="'";
		$introtext=eregi_replace($pat3, $replace3, $introtext);
		$title=eregi_replace($pat3, $replace3, $title);
		$fultext=eregi_replace($pat3, $replace3, $fultext);
		
		?>
		<html>
		<head>
			<title>News Preview</title>
			<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
			<!--
		 		 Mambo Site Server Open Source Edition
				 Dynamic portal server and Content managment engine
				 27-11-2002
 
				 Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
				 Distributed under the terms of the GNU General Public License
				 Available at http://sourceforge.net/projects/mambo
			//-->
		</head>
		<body bgcolor="#FFFFFF">
		<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
		<TR>
	    	<TD CLASS="componentHeading" COLSPAN="2"><?echo $title;?></TD>
		</TR>
		<TR>
			<?if ($image !=""){?>
				<TD VALIGN="top" HEIGHT="90%" COLSPAN="2"> <IMG SRC="../../images/stories/<?echo $image;?>" VSPACE=5 ALIGN="<?echo $position;?>"><?echo "$introtext $fultext";?></TD>
			<?}else {?>
				<TD VALIGN="top" HEIGHT="90%" COLSPAN="2"><?echo "$introtext $fultext";?></TD>
			<?}?>
		</TR>
		<TR>
		    <TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
			<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
		</TR>
		</TABLE>
			
	<?}else{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>News Preview</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
	<!--
		 Mambo Site Server Open Source Edition
		 Dynamic portal server and Content managment engine
		 27-11-2002
 
		 Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
		 Distributed under the terms of the GNU General Public License
		 Available at http://sourceforge.net/projects/mambo
	//-->
	
	<SCRIPT>
		
		var title=window.opener.document.adminForm.mytitle.value;
		var introtext= window.opener.document.adminForm.introtext.value;
		var fultext= window.opener.document.adminForm.fultext.value;
		
		var image = window.opener.document.imagelib.src;
		
		var myregexp = /SRC=images/g;
		var myregexp2 = /src=images/g;
		var myregexp3 = /SRC="images/g;
		var myregexp4 = /src="images/g;
		
		fultext = fultext.replace('#', '');
		introtext = introtext.replace('#', '');
		fultext = fultext.replace(myregexp, 'SRC=../../images');
		introtext = introtext.replace(myregexp, 'SRC=../../images');
		fultext = fultext.replace(myregexp2, 'src=../../images');
		introtext = introtext.replace(myregexp2, 'src=../../images');
		fultext = fultext.replace(myregexp3, 'SRC=\"../../images');
		introtext = introtext.replace(myregexp3, 'SRC=\"../../images');
		fultext = fultext.replace(myregexp4, 'src=\"../../images');
		introtext = introtext.replace(myregexp4, 'src=\"../../images');
		
	</SCRIPT>
</head>

<body bgcolor="#FFFFFF">
	<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
	<TR>
	    <TD CLASS="componentHeading" COLSPAN="2"><SCRIPT>document.write(title);</SCRIPT></TD>
		
	</TR>
	<TR>
	<?if ($image !=""){?>
		<SCRIPT>document.write(" <TD VALIGN='top' HEIGHT='90%' COLSPAN='2'> <IMG SRC='" + image +"' VSPACE=5 ALIGN='<?echo $position;?>'>" + introtext + " " + fultext + "</TD>");</SCRIPT>
	<?}else {?>
		<SCRIPT>document.write("<TD VALIGN='top' HEIGHT='90%' COLSPAN='2'>" + introtext + " " + fultext + "</TD>");</SCRIPT>
	<?}?>
	
	
	</TR>
	<TR>
	    <TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
		<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
	</TR>
	</TABLE>
<?}?>


</body>
</html>
