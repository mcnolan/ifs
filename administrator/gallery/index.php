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
	 *	File Name: index.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/
	session_start();
	if (!session_is_registered("session_id"))
		{
		print "<script> document.location.href='../index.php'</script>";
		exit();
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<HTML>
<HEAD>
<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
<?

if (isset($option)){
	if (!isset($directory)){
		$directory = "";
		unlink("../../images/stories/$filename");
	}else{
		if (trim($directory)!=""){
			unlink("../../uploadfiles/$Itemid/$filename");
		}else{
			unlink("../../images/stories/$filename");
		}
	}
}
	
//INCLUDE "conf.php";
include "../../configuration.php";
if ((!isset($gal))||(!isset($title[$gal]))){
print "<TITLE>Categories</TITLE>";
$i=0;
while (isset($title[$i])){
$gal = $i;
$i++;
}
?>
</head>
<body bgcolor="#FFFFFF">
<?
}else{
?>
<TITLE><? print $title[$gal] ?></TITLE>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<center>
<br><h1><? print $title[$gal] ?></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?
if (!isset($pg)){
	$pg=0;
	}

$handle=opendir($dir[$gal]);
$i=0;
while ($file = readdir($handle)) {
	if ((eregi("gif$",$file)) && ($image == "gif")){
		$swf = "";
		$folder[$i]=$file;
		$i=$i+1;
		}

	if ((eregi("jpg$",$file)) && ($image == "jpg")){
		$swf = "";
		$folder[$i]=$file;
		$i=$i+1;
		}

	if ((eregi("png$",$file)) && ($image == "png")){
        $swf = "";
        $folder[$i]=$file;
        $i=$i+1;
        }

	if ((eregi("swf$",$file)) && ($image == "swf")){
		$swf = "swf";
		$folder[$i]=$file;
		$i=$i+1;
		}
	}
closedir($handle);
if (isset($folder)){
	sort($folder);
	$a=0;
	$count=$row*$col*$pg;
	for ($r=1; $r<=$row; $r++) {
		print "<tr>";
		if ($count>$i-1) {break;}
			for ($c=1; $c<=$col; $c++) {
				$tnpath=$tndir[$gal].$folder[$count];
				if ($directory!="uploadfiles"){
					$size = getimagesize("../../images/stories/$folder[$count]");
					$width = $size[0];
					$height = $size[1];
					if ($size[0] > 120 && $size[1] > 120){
						$size[0] /= 2;
						$size[1] /= 2;
						$size[0] = round($size[0]);
						$size[1] = round($size[1]);
						}
				}else{
					$size = getimagesize("../../uploadfiles/$Itemid/$folder[$count]");
				}
				if ($directory!="uploadfiles"){
					if ($swf <> "swf"){
						print "<td valign=\"top\" align=\"center\"><TABLE BORDER='0' WIDTH='100%' HEIGHT='100%'><TR><TD ALIGN='center'><img src=\"$tnpath\" width=$size[0] height=$size[1] BORDER=0 VSPACE='4'></TD></TR><TR><TD ALIGN='center' VALIGN='bottom'>Image name:$folder[$count]<BR>Width: $width px<BR>Height: $height px<BR><A HREF=\"#\" onClick=\"top.window.imagecode.document.codeimage.imagecode.value='<IMG SRC=images/stories/$folder[$count] ALIGN=left HSPACE=6>'; top.window.imagecode.document.codeimage.position[0].checked = top.window.imagecode.document.codeimage.position[0].defaultChecked\">Code</A>&nbsp;&nbsp;<A HREF=\"javascript:if (confirm('Are you sure you want to delete the image $folder[$count]')){ document.location.href='index.php?option=delete&filename=$folder[$count]&pg=$pg&gal=$gal&image=$image&directory=$directory'}\">Delete Image</A></TD></TR></TABLE></TD>"; 
						}
					else {
						print "<td valign=\"top\" align=\"center\"><TABLE BORDER='0' WIDTH='100%' HEIGHT='100%'><TR>
						<TD ALIGN='center'><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\">
						<param name=\"LOOP\" value=\"false\"><param name=\"SRC\" value=\"$tnpath\"><embed src=\"$tnpath\" loop=\"false\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave- flash\"></embed></object></TD></TR><TR><TD ALIGN='center' VALIGN='bottom'>Image name:$folder[$count]<BR>Width: $size[0]px<BR>Height: $size[1]px<BR><A HREF=\"#\" onClick=\"top.window.imagecode.document.codeimage.imagecode.value='<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 ALIGN=left VSPACE=6 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0><param name=LOOP value=false><param name=SRC value=images/stories/$folder[$count]><embed src=images/stories/$folder[$count] loop=false pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash type=application/x-shockwave- flash></embed></object>'; top.window.imagecode.document.codeimage.position[0].checked = top.window.imagecode.document.codeimage.position[0].defaultChecked\">Code</A>&nbsp;&nbsp;<A HREF=\"javascript:if (confirm('Are you sure you want to delete the image $folder[$count]')){ document.location.href='index.php?option=delete&filename=$folder[$count]&pg=$pg&gal=$gal&image=$image&directory=$directory'}\">Delete Image</A></TD></TR></TABLE></TD>\n";
						}
				}else{
					if ($swf <> "swf"){
						print "<td valign=\"top\" align=\"center\"><TABLE BORDER='0' WIDTH='100%' HEIGHT='100%'><TR><TD ALIGN='center'><img src=\"$tnpath\" BORDER=0 VSPACE='4'></TD></TR><TR><TD ALIGN='center' VALIGN='bottom'>Image name:$folder[$count]<BR>Width: $size[0]px<BR>Height: $size[1]px<BR><A HREF=\"#\" onClick=\"top.window.imagecode.document.codeimage.imagecode.value='<IMG SRC=uploadfiles/$Itemid/$folder[$count] ALIGN=left HSPACE=6>'; top.window.imagecode.document.codeimage.position[0].checked = top.window.imagecode.document.codeimage.position[0].defaultChecked\">Code</A>&nbsp;&nbsp;<A HREF=\"javascript:if (confirm('Are you sure you want to delete the image $folder[$count]')){ document.location.href='index.php?option=delete&filename=$folder[$count]&pg=$pg&gal=$gal&image=$image&directory=$directory&Itemid=$Itemid'}\">Delete Image</A></TD></TR></TABLE></TD>"; 
						}
					else {
						print "<td valign=\"top\" align=\"center\"><TABLE BORDER='0' WIDTH='100%' HEIGHT='100%'><TR>
						<TD ALIGN='center'><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0\">
						<param name=\"LOOP\" value=\"false\"><param name=\"SRC\" value=\"$tnpath\"><embed src=\"$tnpath\" loop=\"false\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\" type=\"application/x-shockwave- flash\"></embed></object></TD></TR><TR><TD ALIGN='center' VALIGN='bottom'>Image name:$folder[$count]<BR>Width: $size[0]px<BR>Height: $size[1]px<BR><A HREF=\"#\" onClick=\"top.window.imagecode.document.codeimage.imagecode.value='<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 ALIGN=left VSPACE=6 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0><param name=LOOP value=false><param name=SRC value=images/stories/$folder[$count]><embed src=uploadfiles/$Itemid/$folder[$count] loop=false pluginspage=http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash type=application/x-shockwave- flash></embed></object>'; top.window.imagecode.document.codeimage.position[0].checked = top.window.imagecode.document.codeimage.position[0].defaultChecked\">Code</A>&nbsp;&nbsp;<A HREF=\"javascript:if (confirm('Are you sure you want to delete the image $folder[$count]')){ document.location.href='index.php?option=delete&filename=$folder[$count]&pg=$pg&gal=$gal&image=$image&directory=$directory&Itemid=$Itemid'}\">Delete Image</A></TD></TR></TABLE></TD>\n";
						}
					}
				$count++;
				if ($count>$i-1) 
					{break;};
		} 
		print "</tr>";
	}  
	print "</table><h2>";
	if ($pg>0) {
		$tmp=$pg-1;;
		print "<a href=\"$PHP_SELF?pg=$tmp&gal=$gal&directory=$directory&image=$image\"><img src=\"prev.gif\" alt=\"prev\" width=\"30\" height=\"20\" border=\"0\"></a>" ;
		}
	$tmp=$pg+1;
	print "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
	if ($tmp*$row*$col<$i) {
		$tmp=$pg+1;
		print "<a href=\"$PHP_SELF?pg=$tmp&gal=$gal&directory=$directory&image=$image\"><img src=\"next.gif\" alt=\"prev\" width=\"30\" height=\"20\" border=\"0\"></a>" ;
		}
	print "</h2>";
}else{
	echo "<font face='Arial, Helvetica, sans-serif' size='2' color='#FF0000'><b>There are no images to display</b></font>";
}
}
?>
<center> 
</BODY>

</HTML>
