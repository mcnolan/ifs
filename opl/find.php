<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Updated By: Nolan
  *		john.pbem@gmail.com
  *
  * Version:	1.15n (Nolan Ed.)
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  * Patch 1.15n:  April 2010
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file based on code from Open Positions List
  * Copyright (C) 2002, 2003 Frank Anon
  *
  * Date:	4/13/04
  * Comments: Finds & displays stuff in the OPL
  *
  * See CHANGELOG for further details
 ***/

// if we're searching by class:
//if ($srClass || $srName)
if($class != "All" || $ship != "All")
{
	/* find ships that match the info entered on form
	if ($class == "All")
		$qry = "SELECT * FROM {$spre}ships WHERE tf<>'99' ORDER BY name";
    elseif ($class)
		$qry = "SELECT * FROM {$spre}ships WHERE class='$class' AND tf<>'99' ORDER BY name";
    elseif ($ship == "All")
		$qry = "SELECT * FROM {$spre}ships WHERE tf<>'99' ORDER BY name";
	else
		$qry = "SELECT * FROM {$spre}ships WHERE name = '$ship' AND tf<>'99' ORDER BY name";
	*/
	$qry = "SELECT * FROM {$spre}ships WHERE tf <> '99'";
	if($class != "All") {
		$qry .= " AND class = '$class'";
	}
	if($ship != "All") {
		$qry .= " AND name = '$ship'";
	}
	if(isset($_POST['format']) && sizeof($_POST['format']) > 0) {
		$qry .= " AND Format in ('" . implode("','",$_POST['format'])."')";
	}
	$qry .= " ORDER BY name";
	//echo $qry;	
	$result = $database->openConnectionWithReturn($qry);

	// For each ship, list info and available positions
	while ( list($sid,$name,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,,,$desc,$format)=mysql_fetch_array($result) )
    {
		$searchres = "1";
		ship_list ($database, $mpre, $spre, $sdb, $uflag, $textonly, "", $sid, $name, $reg, $site, $image, $co, $xo, $status, $class, $format, $tf, $tg, $desc);
		showpos ();
	}
}

// if we're going by position:
//elseif ($srPos)
else
{

	if ($position == "-----Select Position----")
		echo "Please select a position!\n";
	else
    {
	    $pos = $position;

	    // get all ships
	    if ($pos == "Commanding Officer" || $pos == "Executive Officer")
        {
        	if ($pos == "Commanding Officer")
            {
		        $qry = "SELECT * FROM {$spre}ships WHERE tf<>'99' AND co='0' ORDER BY name";
		        $rank = "";
		        $coname = "Open";
            }
            else
		        $qry = "SELECT * FROM {$spre}ships WHERE tf<>'99' AND co <>'0' AND xo='0'";
			if(isset($_POST['format']) && sizeof($_POST['format']) > 0) {
				$qry .= " AND Format in ('" . implode("','",$_POST['format'])."')";
			}
			$qry .= " ORDER BY name";
	        $result = $database->openConnectionWithReturn($qry);
	        list($sid,$name,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,,,$desc,$format)=mysql_fetch_array($result);


	        // print ship info
	        if ($sid)
            {
                $searchres = "1";
	            echo "The following ships have the <FONT COLOR=\"green\">$pos</FONT> position open:<br /><br />";

	            while ($sid)
                {
	                ship_list ($database, $mpre, $spre, $sdb, $uflag, $textonly, "", $sid, $name, $reg, $site, $image, $co, $xo, $status, $class, $format, $tf, $tg, $desc);

					if ($pos == "Commanding Officer")
						echo "<form action=\"index.php?option=app&task=co\" method=\"post\">\n";
                    else
						echo "<form action=\"index.php?option=app\" method=\"post\">\n";
                    ?>
                    <input type="hidden" name="position" value="<?php echo $pos ?>">
                    <input type="hidden" name="ship" value="<?php echo $name ?>">
                    <input type="Submit" value="Apply for this ship"></form></p><br />

	                <?php
	                list($sid,$name,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,,,$desc,$format)=mysql_fetch_array($result);
	            }
	        }
	    }
        else
        {
	        $qry = "SELECT * FROM {$spre}ships WHERE tf<>'99' AND co<>'0'";
		if(isset($_POST['format']) && sizeof($_POST['format']) > 0) {
			$qry .= " AND Format in ('" . implode("','",$_POST['format'])."')";
		}
		$qry .= "ORDER BY name";

	        $result = $database->openConnectionWithReturn($qry);

	        echo "The following ships have the <FONT COLOR=\"green\">$pos</FONT> position open:<br /><br />";

	        while ( list($sid,$name,$reg,$class,$site,$co,$xo,$tf,$tg,$status,$image,,,$desc,$format)=mysql_fetch_array($result) )
            {
	            $qry2 = "SELECT id FROM {$spre}characters WHERE ship = '$sid' AND pos='$pos'";
	            $result2 = $database->openConnectionWithReturn($qry2);

				// Check for CO customizations
	            if (!mysql_num_rows($result2))
                {
	                $qry3 = "SELECT action FROM {$spre}positions
                    		 WHERE ship = '$sid' AND pos='$pos' AND action='rem'";
	                $result3 = $database->openConnectionWithReturn($qry3);

	                if (!mysql_num_rows($result3))
                    {
	                    $searchres = "1";
	                    ship_list ($database, $mpre, $spre, $sdb, $uflag, $textonly, "", $sid, $name, $reg, $site, $image, $co, $xo, $status, $class, $format, $tf, $tg, $desc);
	                    ?>
	                    <form action="index.php?option=app" method="post">
                        <input type="hidden" name="ship" value="<?php echo $name ?>">
                        <input type="hidden" name="position" value="<?php echo $pos ?>">
                        <input type="submit" value="Apply for this ship"></form></p><br />
	                    <?php
	                }
	            }
	        }
	    }
    }
}

if (!$searchres)
    echo "Sorry, no matches <br />\n";
else
{
    echo "<hr /><br /><br />\n";
    echo "Done searching.\n";
}
?>

<br /><br />

<?php
// shows open positions on a ship
function showpos ()
{
	global $database, $sid, $name, $reg, $class, $site, $co, $xo, $tf, $tg, $status, $image, $desc, $position, $relpath, $mpre, $spre;

	echo "<table width=\"95%\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\"><br /><tr>\n";
	echo "<td colspan=\"3\" align=\"left\"><font size=\"3.5\"><b>Open Positions:</b></font></td></tr><tr>\n";
	if ($co == '0')
    {
		echo "<td><font color=\"orange\">Commanding Officer</font></td>\n";
		print "</tr></table>\n";
		echo "<form action=\"index.php?option=app&task=co\" method=\"post\">\n";
	}
    else
    {
		$count = 0;

		$filename = $relpath . "tf/positions.txt";
		$contents = file($filename);
		$length = sizeof($contents);
		$count = 0;
		$counter = 0;
		do
        {
			$counter = $counter + 1;
			$contents[$counter] = trim($contents[$counter]);

			$pos = addslashes($contents[$counter]);
			$qry2 = "SELECT id FROM {$spre}characters WHERE ship = '$sid' AND pos='$pos'";
			$result2 = $database->openConnectionWithReturn($qry2);

			if (!mysql_num_rows($result2))
            {
				$qry3 = "SELECT action FROM {$spre}positions
                		 WHERE ship = '$sid' AND pos='$pos' AND action='rem'";
				$result3 = $database->openConnectionWithReturn($qry3);

				if (!mysql_num_rows($result3))
                {
					echo "<td><font color=\"";
					if($contents[$counter] == $_POST['position']) { echo "green"; } else { echo "orange"; } 
					echo "\">".$contents[$counter];
					echo "</font></td>\n";
					$count = $count + 1;
				}
			}

			if ($count == 3)
            {
				echo "</tr>\n\n<tr>";
				$count = 0;
			}
		} while ($counter < ($length - 1));

		$qry2 = "SELECT pos FROM {$spre}positions WHERE ship = '$sid' AND action = 'add'";
		$result2 = $database->openConnectionWithReturn($qry2);

		while (list ($pos) = mysql_fetch_array($result2) )
        {
        	$qry3 = "SELECT id FROM {$spre}characters
            		 WHERE ship='$sid' AND pos='$pos'";
        	$result3 = $database->openConnectionWithReturn($qry3);

            if (!mysql_num_rows($result3))
            {
	            echo "<td><font color=\"orange\">";
			if($_POST['position'] == $pos) { echo "<b>"; }
			echo $pos;
			echo "</font></td>\n";
	            $count = $count + 1;

	            if ($count == 3)
	            {
	                echo "</tr>\n\n<tr>";
	                $count = 0;
	            }
            }
		}

		print "</tr></table>\n";
		echo "<form action=\"index.php?option=app\" method=\"post\">";
	}
    echo "<input type=\"hidden\" name=\"ship\" value=\"{$name}\">\n";
    echo "<input type=\"Submit\" value=\"Apply for this ship\"></form></p><br />\n";
}

?>
