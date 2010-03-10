<?
	include ("../../configuration.php");
	if ($delete == "Delete Files"){
		for ($i = 0; $i < count($deletepdf); $i++){
			unlink($pdf_path.$deletepdf[$i]);
			}
		}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Navigation</title>
	<link rel="stylesheet" href="../../css/ie5.css" type="text/css">
	<SCRIPT>
	<!--
		function pdfcode(pdf){
			top.window.imagecode.document.codeimage.imagecode.value = '<A HREF=\"<? echo $live_site; ?>pdf/' + pdf + '\" TARGET=\"new\">Place text here</A>';
			}
	//-->
	</SCRIPT>

</head>

<body bgcolor="#FFFFFF">

<?
	$handle=opendir($pdf_path);
	$i=0;
	while ($file = readdir($handle)) {
		if ($file <> "." && $file <> "..")
			$pdffile[$i]=$file;
		$i++;
		}
	
	print "<FORM action='pdf.php'><TABLE WIDTH='100%'>";
	print "<TR><TD ALIGN='center' colspan='3'><B>Document Library</B></TD></TR>\n";
	if ($pdffile==0) {
		print "<TD><B><FONT COLOR=##FF0000>There are no files available</B></TD>";
		} else {
	sort ($pdffile);
	$k = 0;
	while ($k < count($pdffile)){
		print "<TR>";
		for ($r = 0; $r < 3; $r++){
			if (($pdffile[$k] <> "") && (eregi("doc$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='doc_16.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
				}
			else if (($pdffile[$k] <> "") && (eregi("pdf$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='pdf_16.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
				}
			else if (($pdffile[$k] <> "") && (eregi("xls$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='xls_16.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
				}
			else if (($pdffile[$k] <> "") && (eregi("ppt$",$pdffile[$k]))) {
				print "<TD><INPUT TYPE='checkbox' NAME='deletepdf[]' VALUE='$pdffile[$k]'><IMG SRC='ppt_16.gif' WIDTH='16' HEIGHT='16' VSPACE='0' HSPACE='4'><A HREF='#' onClick=\"pdfcode('$pdffile[$k]')\">$pdffile[$k]</A></TD>";
				}
			$k++;
			}}
		print "</TR>";
		}
	print "<TR><TD ALIGN='center' colspan='3' height='40' valign='bottom'><INPUT TYPE='submit' NAME='delete' VALUE='Delete Files'></TD></TR>\n";
	print "</TABLE></FORM>\n";
?>

</BODY>
</HTML>
