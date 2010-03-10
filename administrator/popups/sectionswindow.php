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
	 *	File Name: sectionswindow.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

?>
<html>
<head>
	<title>Sections Preview</title>
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

<body>
	<?
	if ($type=="typed"){?>
		<SCRIPT>
			var myregexp = /SRC=images/g;
			var myregexp2 = /src=images/g;
			var myregexp3 = /SRC="images/g;
			var myregexp4 = /src="images/g;
			
			var content=window.opener.document.adminForm.pagecontent.value;
			var heading=window.opener.document.adminForm.heading.value;
			content = content.replace('\\\\', '');
			content= content.replace(myregexp, 'SRC=../../images');
			content= content.replace(myregexp2, 'src=../../images');
			content= content.replace(myregexp3, 'SRC=\"../../images');
			content= content.replace(myregexp4, 'src=\"../../images');
		</SCRIPT>
		<?
	}else if ($type=="file"){?>
		<SCRIPT>
			var content=window.opener.document.adminForm.filecontent.value;
			content = content.replace('\\\\', '');
			content = content.replace('SRC=\"uploadfiles', 'SRC=\"../../uploadfiles');
			content = content.replace('SRC=uploadfiles', 'SRC=../../uploadfiles');
			content = content.replace('src=\"uploadfiles', 'src=\"../../uploadfiles');
			content = content.replace('src=uploadfiles', 'src=../../uploadfiles');
			var heading='';
		</SCRIPT>
	
		<?}?>
	<SCRIPT>
		if (content!=""){
			document.write ("<TABLE ALIGN='center' WIDTH='90%' CELLSPACING='2' CELLPADDING='2' BORDER='0' HEIGHT='100%'>");
			if (heading!=""){
				document.write ("<TR><TD class=articlehead>" + heading + "</TD></TR>");
			}
			document.write ("<TR><TD VALIGN='top' HEIGHT='90%'>" + content + "</TD></TR>");
			document.write ("<TR><TD ALIGN='center'><A HREF='#' onClick=window.close()>Close</A></TD></TR></TABLE>");
		}
	</SCRIPT>
	
	<?
		if ($type=="web"){
			if ($link!=""){
				$correctLink=eregi("http://", $link);
				if ($correctLink){
					echo "<SCRIPT>document.location.href='$link';</SCRIPT>";
				}else{
					echo "<SCRIPT>document.location.href='http://$link';</SCRIPT>";
				}
			}
		}?>
</body>
</html>
