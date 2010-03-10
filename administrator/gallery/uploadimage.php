<?php
// Mambo Site Server Open Source Edition Version 3.0.7
	// Dynamic portal server and Content managment engine
	// 04-05-2001

	// Copyright (C) 2000 - 2001 Miro Contruct Pty Ltd
	// Distributed under the terms of the GNU General Public License
	// This software may be used without warrany provided these statements are left
	// intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	// This code is Available at http://sourceforge.net/projects/mambo

	include ("../../configuration.php");

	if (isset($fileupload)){
		if ($directory!="uploadfiles"){
			$base_Dir = "../../images/stories/";
		}else{
			$base_Dir = "../../uploadfiles/$Itemid/";
		}

		$filename = split("\.", $userfile_name);
		if (eregi("[^0-9a-zA-Z_]", $filename[0])){
			print "<SCRIPT> alert('File must only contain alphanumeric characters and no spaces please.'); window.history.go(-1);</SCRIPT>\n";
			exit();
			}

		if (file_exists($base_Dir.$userfile_name)){
			print "<SCRIPT> alert('Image $userfile_name already exists.'); window.history.go(-1);</SCRIPT>\n";
			exit();
			}

			if ((strcasecmp(substr($userfile_name,-4),".gif")) && (strcasecmp(substr($userfile_name,-4),".jpg")) && (strcasecmp(substr($userfile_name,-4),".png")) && (strcasecmp(substr($userfile_name,-4),".doc")) && (strcasecmp(substr($userfile_name,-4),".xls")) && (strcasecmp(substr($userfile_name,-4),".swf")) && (strcasecmp(substr($userfile_name,-4),".pdf"))){
		print "<SCRIPT>alert('The file must be pdf, gif, png, jpg, doc, xls or swf'); window.history.go(-1);</SCRIPT>\n";
		exit();
	}

		if (eregi(".pdf", $userfile_name)){
			if (!copy($userfile, $pdf_path.$userfile_name)){
				echo "Failed to copy $userfile_name";
				}
			}
		elseif (!copy($userfile, $base_Dir.$userfile_name)){
			echo "Failed to copy $userfile_name";
			}

		if (eregi(".jpg", $userfile_name)){
			print "<SCRIPT>top.window.images.document.location.href=\"index.php?gal=0&image=jpg&directory=$directory&Itemid=$Itemid\"</SCRIPT>\n";
			}
		elseif (eregi(".pdf", $userfile_name)){
			print "<SCRIPT>top.window.images.document.location.href='pdf.php'</SCRIPT>\n";
			}
		else {
			print "<SCRIPT>top.window.images.document.location.href=\"index.php?gal=0&image=gif&directory=$directory&Itemid=$Itemid\"</SCRIPT>\n";
			}
		}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Upload a file</title>
</head>

<body bgcolor="#FFFFFF">
<FORM ENCTYPE="multipart/form-data" ACTION="uploadimage.php" METHOD=POST NAME="filename">

  <table border=0 bgcolor=FFFFFF cellpadding=4 cellspacing=0 width=100% ALIGN='center'>
    <TR>
      <TD align="center" HEIGHT="50"><font face="Arial, Helvetica, sans-serif" size="2"><b><font color="#999999" size="3">Upload
        A File</font></b></font></TD>
    </TR>
    <TR>
      <TD ALIGN="center"><font face="Arial, Helvetica, sans-serif" size="2">
        <INPUT NAME="userfile" TYPE="file">
        &nbsp;
        <input type="submit" value="Upload File" name="fileupload">
        </font></TD>
    </TR>
    <TR>
      <TD>
        <INPUT TYPE="hidden" NAME="directory" VALUE="<?echo $directory;?>">
        <INPUT TYPE="hidden" NAME="Itemid" VALUE="<?echo $Itemid;?>">
      </TD>
    </TR>
  </TABLE>
</FORM>


</body>
</html>