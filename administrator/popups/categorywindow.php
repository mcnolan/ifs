<?// Mambo Site Server Open Source Edition Version 4.0.11 
	// Dynamic portal server and Content managment engine
	// 27-11-2002
 
	// Copyright (C) 2000 - 2002 Miro Contruct Pty Ltd
	// Distributed under the terms of the GNU General Public License
	// This software may be used without warrany provided these statements are left 
	// intact and a "Powered By Mambo" appears at the bottom of each HTML page.
	// This code is Available at http://sourceforge.net/projects/mambo
	
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
	
	if ($id <> ""){
		if ($option == "News"){
			$query = "SELECT * FROM stories WHERE topic=$id";
			}
		elseif ($option == "Faq"){
			$query = "SELECT * FROM faqcont WHERE faqid=$id and published=1";
			}
		elseif ($option == "Articles"){
			$query = "SELECT * FROM articles WHERE secid=$id";
			}
		elseif ($option == "Weblinks"){
			$query = "SELECT * FROM links_links WHERE cid=$id";
			}
		
		$result =openConnectionWithReturn($query);
		$i = 0;
		while ($row = mysql_fetch_object($result)){
			$title[$i] = $row->title;
			$i++;
			$pat="\\\\'";
			$replace="'";
			$title[$i]=eregi_replace($pat, $replace, $title[$i]);
		}
		mysql_free_result($result);
		}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Category Preview</title>
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
<TABLE CELLSPACING="2" CELLPADDING="2" BORDER="0" WIDTH="100%" HEIGHT="100%">
<? if ($position == "left"){ ?>
	<TR>
    <? 	if ($categoryimage <> ""){
			$pat="\\\\'";
			$replace="'";
			$categoryname=eregi_replace($pat, $replace, $categoryname);?>
			<TD ROWSPAN="2" VALIGN="top"><IMG SRC="../../images/stories/<? echo $categoryimage; ?>" HSPACE="5"></TD>
	<?		}?>
	    <TD VALIGN="top"><B><? echo $categoryname; ?></B></TD>
	</TR>
<?	} 
   else { ?>
	<TR>
	    <TD VALIGN="top"><B><? echo $categoryname; ?></B></TD>
	<? 	if ($categoryimage <> ""){?>
			<TD ROWSPAN="2" VALIGN="top"><IMG SRC="../../images/stories/<? echo $categoryimage; ?>" HSPACE="5"></TD>
	<?		}?>
	</TR>
<?	} ?>

<? if ($position == "left"){
	if (count($title) == 0){?>
		<TR>
		    <TD COLSPAN="2" WIDTH="100%" HEIGHT="100%" VALIGN="top">
				There are no <? echo $option; ?>.
			</TD>
		</TR>
		
	<?}else {?>
		<TR>
			<TD VALIGN="top">
				<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%">
				 <?for ($i = 0; $i < count($title); $i++){?>
			 	<TR>
			 		<TD><LI></TD>
					<TD>
				  <? echo $title[$i]."<BR>"; 
				  }?>
					</TD>
				</TR>
				</TABLE>
			</TD>
			<TD>&nbsp;</TD>
		</TR>
			 <? }?>
			  		
				
<?	} 
   elseif ($position == "right") { 
  	if (count($title) == 0){?>
		<TR>
		    <TD WIDTH="100%" HEIGHT="100%" VALIGN="top">There are no <? echo $option; ?>.</TD>
		</TR>
		
		<? } 
		else {?>
		<TR>
			<TD VALIGN="top" HEIGHT="100%">
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="100%">
				
					
			 <? for ($i = 0; $i < count($title); $i++){?>
			 	<TR>
			 		<TD><LI></TD>
					<TD>
				  <? echo $title[$i]."<BR>"; ?>
				  	</TD>
				</TR>
				<?  }?>
				  	
				</TABLE>
			</TD>
			
		</TR>
			<?  }?>
<?		} ?>
<TR>
	<TD COLSPAN="2"  ALIGN="center"><A HREF="#" onClick="self.close();">Close</A></TD>
</TR>
</TABLE>
</body>
</html>
