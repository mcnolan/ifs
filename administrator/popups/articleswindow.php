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
	 *	File Name: articleswindow.php
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
		$query = "SELECT title, content FROM articles WHERE artid=$id";
		$result = openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$title = $row->title;
			$content = $row->content;
			}
		$pat= "SRC=images";
		$replace= "SRC=../../images";
		$content=eregi_replace($pat, $replace, $content);
	
		$pat2="\\\\'";
		$replace2="'";
		$content=eregi_replace($pat2, $replace2, $content);
		$title=eregi_replace($pat2, $replace2, $title);
		$author=eregi_replace($pat2, $replace2, $author);
		
		
		$pat3="SRC=\"images";
		$replace3= "SRC=\"../../images";
		$content=eregi_replace($pat3, $replace3, $content);
		
		?>
		
		<html>
		<head>
		<title>Article Preview</title>
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
		<?if ($author != ""){?>
				<TR><TD CLASS="small" COLSPAN="2">By <?echo $author;?></TD></TR>
		<?}?>
		<TR>
	    	<TD VALIGN="top" HEIGHT="90%" COLSPAN="2"><?echo $content;?></TD>
		</TR>
		<TR>
	  	  	<TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
			<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
		</TR>
		</TABLE>
	
	<?}else{?>
		<html>
		<head>
		<title>Article Preview</title>
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
		<!--
		var contents = window.opener.document.adminForm.content.value;
		contents = contents.replace('#', '');
		
		var author = window.opener.document.adminForm.author.value;
		author = author.replace('#', '');
		
		var titles = window.opener.document.adminForm.mytitle.value; 
		titles = titles.replace('#', '');
		
		var myregexp = /SRC=images/g;
		var myregexp2 = /src=images/g;
		var myregexp3 = /SRC="images/g;
		var myregexp4 = /src="images/g;
		
		contents = contents.replace('#', '');
		titles = titles.replace('#', '');
		contents=contents.replace(myregexp, 'SRC=../../images');
		contents= contents.replace(myregexp2, 'src=../../images');
		contents= contents.replace(myregexp3, 'SRC=\"../../images');
		contents= contents.replace(myregexp4, 'src=\"../../images');
		contents = contents.replace('\\\\', '');
		titles = titles.replace('\\\\', '');
		//-->
		</SCRIPT>

		</head>

		<body BGCOLOR="#FFFFFF">
		<TABLE ALIGN="center" WIDTH="90%" CELLSPACING="2" CELLPADDING="2" BORDER="0" HEIGHT="100%">
		<TR>
	    	<TD CLASS="componentHeading" COLSPAN="2"><SCRIPT>document.write(titles);</SCRIPT></TD>
		</TR>
		<SCRIPT>
			if (author != ""){
				document.write("<TR><TD CLASS='small' COLSPAN='2'>By " + author + "</TD></TR>");
				}
		</SCRIPT>
		<TR>
	    	<TD VALIGN='top' HEIGHT='90%' COLSPAN="2"><SCRIPT>document.write(contents);</SCRIPT></TD>
		</TR>
		<TR>
	  	  	<TD ALIGN='right'><A HREF="#" onClick="window.close()">Close</A></TD>
			<TD ALIGN="left"><A HREF="javascript:;" onClick="window.print(); return false">Print</A></TD>
		</TR>
		</TABLE>
<?}?>


</body>
</html>
