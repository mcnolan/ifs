<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Version:	1.11
  * Release Date: June 3, 2004
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * Date:	1/6/04
  * Comments: Displays ship listing, by TF and TG
 ***/

if ($database=="")

	require("../includes/header.php?pop=y");
else
{
	$relpath = "";

    echo "<br><center><font size=\"+1\"><u>Ship Listing</u></font></center><br /><br />\n";

	$qry = "SELECT name, co FROM {$spre}taskforces
    		WHERE tf='$tf' AND tg='$tg'";
	$result=$database->openConnectionWithReturn($qry);
	list($tgname,$tfco)=mysql_fetch_array($result);

	if (((!$tgname) && ($tf)) && $tf != "all")
    {
		echo "<br /><center>Invalid Task Force / Task Group.</center>\n";
		$tf = '0';
	}

	if ($tf == '0' || $tf == '')
    {
		/************************\
		|*	SELECT TASK FORCE	*|
		\************************/
		echo "<center>Please choose a Task Force:<br />\n";
		if ($option)
        {
			echo "<form action=\"{$relpath}index.php\" method=\"get\">\n";
	        echo "<input type=\"hidden\" name=\"option\" value=\"ships\">\n";
		}
        else
			echo "<form action=\"{$relpath}tf/ships.php\" method=\"get\">\n";

		echo "<SELECT NAME=\"tf\">\n";
	        $qry = "SELECT tf,name FROM {$spre}taskforces WHERE tg='0' ORDER BY tf";
	        $result=$database->openConnectionWithReturn($qry);

	        while ( list($tfid,$tfname)=mysql_fetch_array($result) )
	            if ($tfid != '99')
	                echo "<option value=\"$tfid\">Task Force $tfid -- $tfname</option>\n";
	        echo "<option value=\"all\">(show all)</option>\n";
		echo "</select><br /><br />";
        echo "<input type=\"checkbox\" name=\"textonly\" />Text Only<br /><br />";
        echo "<input type=\"submit\" value=\"Submit\" />";
		echo "</form></center><br /><br /><br />";

	}
    elseif (($tg == '0' || $tg == '') && $tf != "all")
    {
		/************************\
		|*	SELECT TASK GROUP	*|
		\************************/
		$qry = "SELECT tg,name FROM {$spre}taskforces
        		WHERE tf='$tf' AND tg<>'0' ORDER BY tg";
		$result=$database->openConnectionWithReturn($qry);

    	if (mysql_num_rows($result) == 1)
        {
        	list ($tgid) = mysql_fetch_array($result);
			if ($option)
				if ($textonly)
					redirect("index.php?option=ships&tf={$tf}&tg={$tgid}&textonly=on");
				else
					redirect("index.php?option=ships&tf={$tf}&tg={$tgid}");
			else
				if ($textonly)
					redirect("tf/ships.php?tf={$tf}&tg={$tgid}&textonly=on");
				else
					redirect("tf/ships.php?tf={$tf}&tg={$tgid}");
        }

		echo "<center>Please choose a Task Group:<br />";
		if ($option)
        {
			echo "<form action=\"{$relpath}index.php\" method=\"get\">\n";
	        echo "<input type=\"hidden\" name=\"option\" value=\"ships\">\n";
		}
        else
			echo "<form action=\"{$relpath}tf/ships.php\" method=\"get\">\n";

		echo "<input type=\"hidden\" name=\"tf\" value=\"{$tf}\">\n";
		echo "<select name=\"tg\">\n";

		while ( list($tgid,$tgname)=mysql_fetch_array($result) )
			echo "<option value=\"$tgid\">$tgname</option>\n";
        echo "<option value=\"all\">(show all)</option>\n";
		echo "</select><br /><br />";

        if ($textonly == "on")
	        echo "<input type=\"checkbox\" name=\"textonly\" checked=\"checked\">Text Only<br /><br />\n";
        else
	        echo "<input type=\"checkbox\" name=\"textonly\">Text Only<br /><br />";
		echo "<input type=\"submit\" value=\"Submit\">\n";
   		echo "</form></center><br /><br /><br />";
	}
    else
    {
		$seltf = $tf;
        $seltg = $tg;

	    switch ($sort)
	    {
	        case "class":
	            $sort = "class, ";
	            break;
	        case "tf":
	            $sort = "tf, tg, ";
	            break;
	        case "status":
	            $sort = "status, ";
	            break;
	    }

		if ($tf != "all")
        {
			$qry = "SELECT name,co FROM {$spre}taskforces WHERE tf='$tf' AND tg='0'";
			$result=$database->openConnectionWithReturn($qry);
			list($tfname,$tfco)=mysql_fetch_array($result);
        }
        else
        {
        	$tfname = "Ships of Obsidian Fleet";
            $tfco = "Triad";
        }

		if ($tf == "all")
	   		$qry = "SELECT * FROM {$spre}ships WHERE tf<>'99' order by sorder, {$sort}name asc";
        elseif ($tg == "all")
	   		$qry = "SELECT * FROM {$spre}ships WHERE tf='$tf' order by sorder, {$sort}name asc";
        else
    		$qry = "SELECT * FROM {$spre}ships WHERE tf='$tf' AND tg='$tg' order by sorder, {$sort}name asc";
		$result=$database->openConnectionWithReturn($qry);

	    ?>
	    <br>
	    <center>
	    <table border="0" cellpadding="0" cellspacing="0" width="100%">
	        <tr>
	            <td width="100" valign="top"></td>

	            <td width="100%" valign="top">
	            <?php
                if ($seltf != "all")
                {
	                echo "<center><b>Task Force $tf -- $tfname</b><br />\n";
	                if (!$textonly)
	                    echo "<img src=\"{$relpath}images/tfbanners/tf{$tf}.jpg\" alt=\"Task Force $tf -- $tfname\" /><br /><br />\n";

 	                if ($tf != '1' && $seltf != "all" && $seltg != "all")
                    {
		                echo "<b>Task Group $tg -- $tgname</b><br />\n";
		                if (!$textonly)
		                    echo "<img src=\"{$relpath}images/tfbanners/tg{$tf}-{$tg}.jpg\" alt=\"Task Group $tg -- $tgname\" /><br />\n";
		            }
	            }
	            echo "</b></center><br>\n";

	            if (defined("IFS"))
				{
	                echo "<center>Sort by:";
	                if ($sort != "")
                    {
	                    if ($textonly)
	                        echo "<a href=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg&amp;textonly=on\">";
	                    else
	                        echo "<a href=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg\">";
	                    echo "name</a> | ";
	                }
                    else
	                    echo "name | ";

	               if ($sort != "class, ")
                   {
	                    if ($textonly)
	                        echo "<a href=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg&amp;sort=class&amp;textonly=on\">";
	                    else
	                        echo "<a href=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg&amp;sort=class\">";
	                    echo "class</a> | ";
	               }
                   else
	                    echo "class | ";

	               if ($sort != "tf, tg, ")
                   {
	                    if ($textonly)
	                        echo "<a href=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg&amp;sort=tf&amp;textonly=on\">";
	                    else
	                        echo "<A HREF=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg&amp;sort=tf\">";
	                    echo "TF/TG</a> | ";
	               }
                   else
	               		echo "TF/TG | ";

	               if ($sort != "status, ")
                   {
	                    if ($textonly)
	                        echo "<a href=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg&amp;sort=status&amp;textonly=on\">";
	                    else
	                        echo "<A HREF=\"index.php?option=ships&amp;tf=$seltf&amp;tg=$seltg&amp;sort=status\">";
	                    echo "status</a>";
	               }
                   else
	                    echo "status";

	               echo "</center><br />";
	           	}

	            while( list($sid,$sname,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,,,$desc,$format)=mysql_fetch_array($result) )
	                ship_list ($database, $mpre, $spre, $sdb, $uflag, $textonly, $relpath, $sid, $sname, $reg, $site, $image, $co, $xo, $status, $class, $format, $tf, $tg, $desc);
                ?>
  			    </td>
	            <td>&nbsp;</td>
		    </tr>
	    </table></center>
		<?php
    }
}
?>