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
  * This file based on code from Ship Database
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  *
  * Date:	5/01/04
  * Comments: Ship Database
 ***/

if (!defined("IFS"))
{
	include("configuration.php");
	include("includes/header.php");
}

// put this all in one huge table for stylesheet purposes
echo "<table><tr><td>\n";
echo "<h1>Ship Database</h1><br />\n";

// Return results from searching technology
if ($techsearch)
{
	echo "<h2>Results for Technology Search<br />\n";
    echo "<i>{$techsearch}</i></h2><br /><br />\n";
   	$qry = "SELECT id, name
    		FROM {$sdb}weapons
            WHERE name like '%{$techsearch}%'
            	OR description like '%{$techsearch}%'
            GROUP BY name";
	$result = $database->openShipsWithReturn($qry);
    if (!mysql_num_rows($result))
    	echo "No results.<br />\n";

    while (list($did, $dname) = mysql_fetch_array($result))
    	if (!defined("IFS"))
	    	echo "<a href=\"shipdb.php?detail={$did}\">{$dname}</a><br />\n";
        else
	    	echo "<a href=\"index.php?option=shipdb&amp;detail={$did}\">{$dname}</a><br />\n";
}

// Details about a specific weapon or feature/addon
elseif ($detail)
{
	$qry = "SELECT w.name, w.description, w.sub, t.type, w.image
    		FROM {$sdb}weapons w, {$sdb}types t
            WHERE w.id='$detail' AND w.type=t.id
            GROUP BY w.name";
   	$result = $database->openShipsWithReturn($qry);
   	list ($dname, $ddesc, $sub, $type, $dimage) = mysql_fetch_array($result);

    echo "<h3>$dname</h3><br />\n";
    echo "Type: $type<br />\n";
    if ($sub != "0")
    {
    	$qry = "SELECT name FROM {$sdb}weapons WHERE id='$sub'";
        $result = $database->openShipsWithReturn($qry);
        list ($subname) = mysql_fetch_array($result);
        echo "Associated With: ";
    	if (!defined("IFS"))
	    	echo "<a href=\"shipdb.php?detail={$sub}\">{$subname}</a><br />\n";
        else
	    	echo "<a href=\"index.php?option=shipdbdetail={$sub}\">{$subname}</a><br />\n";
    }

   	if ($dimage)
    	echo "<img src=\"images/shipdb/{$dimage}\" alt=\"{$dname}\" /><br />\n";

	if ($ddesc)
		echo "<p>$ddesc</p>\n";
	else
		echo "<p>No Description Available.</p>\n";

	if ($pop != "y")
    {
		echo "<p>Found on:<br />\n";
    	$qry = "SELECT c.name, d.name
        		FROM {$sdb}classes c, {$sdb}equip e, {$sdb}category d, {$sdb}weapons w
                WHERE w.name='$dname' AND e.equipment=w.id AND e.type='w'
                	AND e.ship=c.id AND c.category=d.id AND e.number>'0'";
		$result = $database->openShipsWithReturn($qry);
	    while (list($cname, $catname,) = mysql_fetch_array($result))
    		echo $cname . " Class " . $catname . "<br />\n";
	    echo "</p>\n";
    }

}

// Details about a specific class of ship
elseif ($sclass)
{
    $qry = "SELECT c.name, duration, resupply, refit, d.name, t.type, t.support, cruisevel,
	    		maxvel, emervel, eveltime, officers, enlisted, passengers, marines,
	            evac, shuttlebays, length, width, height, decks, notes, c.description, image
            FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
            WHERE c.id='$sclass' AND c.category=d.id AND d.type=t.id";
    $result = $database->openShipsWithReturn($qry);
    list ($cname, $duration, $resupply, $refit, $category, $type, $support, $cruisevel, $maxvel,
    	  $emervel, $eveltime,  $officers, $enlisted, $passengers, $marines, $evac,
          $shuttlebays, $length, $width, $height, $decks, $notes, $desc, $image)
          = mysql_fetch_array($result);

    echo "<h2>{$cname} Class {$type}</h2>\n";
    echo "<u><b>Category: {$category}</b></u><br /><br />\n";
    if ($image)
	    echo "<img src=\"images/shipdb/{$image}\" alt=\"{$cname}\"><br /><br />\n";

	echo "Expected Duration: $duration years<br />\n";
	if ($type != "Starbase")
		echo "Time Between Resupply: $resupply years<br />\n";

    echo "Time Between Refit: $refit years<br /><br />\n";

    echo "<a class=\"heading\">Personnel</a><br />\n";
    if ($officers != "0")
    {
	    echo "Officers: $officers<br />\n";
    	echo "Enlisted Crew: $enlisted<br />\n";
        echo "Marines: $marines<br />\n";
    }
    else
		echo "Crew: $enlisted<br />\n";

    if ($passengers != "0")
    	echo "Passengers: $passengers<br />\n";

	if ($type != "Starbase")
    {
	    if ($evac != "0")
	        echo "Maximum (Evacuation) Capacity: $evac<br />\n";
		echo "<br />";

	    echo "<a class=\"heading\">Speed</a><br />\n";
	    echo "Cruising Velocity: Warp $cruisevel<br />\n";
	    echo "Maximum Velocity: Warp $maxvel<br />\n";
	    echo "Emergency Velocity: Warp $emervel (for $eveltime hours)<br />\n";
	}
    else
		echo "Starship Docking Capacity: $evac<br />\n";

	echo "<br />\n";

    echo "<a class=\"heading\">Dimensions</a><br />\n";
	if ($type != "Starbase")
    {
	    echo "Length: $length metres<br />\n";
	    echo "Width: $width metres<br />\n";
	    echo "Height: $height metres<br />\n";
	}
    else
    {
	    echo "Diameter: $length metres<br />\n";
	    echo "Main Height: $width metres<br />\n";
	    echo "Overall Height: $height metres<br />\n";
	}
    echo "Decks: $decks<br /><br />\n";

	if ($support == "n")
    {
		$qry = "SELECT e.number, c.id, c.name, d.name, t.type
    			FROM {$sdb}equip e, {$sdb}classes c, {$sdb}category d, {$sdb}types t
    			WHERE e.ship='$sclass' AND e.type='c' AND e.equipment=c.id
                	AND c.category=d.id AND d.type=t.id
            	ORDER BY t.type, c.name";
	    $result = $database->openShipsWithReturn($qry);
    	echo "<a class=\"heading\">Auxiliary Craft</a><br />\n";
        echo "Shuttlebays: $shuttlebays<br />\n";
	    while (list($enum, $cid, $cname, $catname, $type) = mysql_fetch_array($result))
        {
        	if ($oldtype != $type)
            {
            	echo "{$type}s<br />\n";
                $oldtype = $type;
            }
			if (!defined("IFS"))
	    		echo "&nbsp;&nbsp;&nbsp;" .
                	 "<a href=\"shipdb.php?sclass={$cid}\">{$cname} {$catname}</a>: $enum<br />\n";
			else
	    		echo "&nbsp;&nbsp;&nbsp;" .
	                 "<a href=\"index.php?option=shipdb&amp;sclass={$cid}\">" .
                     "{$cname} {$catname}</a>: $enum<br />\n";
	    }
	    echo "<br />\n";
    }

	$qry = "SELECT e.number, w.id, w.name, t.type
    		FROM {$sdb}equip e, {$sdb}weapons w, {$sdb}types t
    		WHERE e.ship='$sclass' AND e.type='w' AND e.equipment=w.id
            	AND w.sub='0' AND w.type=t.id
            ORDER BY t.type, w.name";
    $result = $database->openShipsWithReturn($qry);
    echo "<a class=\"heading\">Armament</a><br />\n";
    if (!mysql_num_rows($result))
    	echo "None<br />\n";

    while (list($wnum, $wid, $wname, $type) = mysql_fetch_array($result))
    {
    	if ($oldtype != $type)
        {
        	echo "{$type}s<br />\n";
            $oldtype = $type;
        }
    	if ($wnum == "1")
        	if (!defined("IFS"))
		    	echo "&nbsp;&nbsp;&nbsp;" .
                	 "<a href=\"javascript: var t=window.open" .
                     "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
                     "'width=400,height=350,scrollbars=yes')\">{$wname}</a><br />\n";
            else
		    	echo "&nbsp;&nbsp;&nbsp;" .
                	 "<a href=\"javascript: var t=window.open" .
                     "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
                     "'width=400,height=350,scrollbars=yes')\">{$wname}</a><br />\n";
        elseif ($wnum != "0")
        	if (!defined("IFS"))
	    		echo "&nbsp;&nbsp;&nbsp;" .
                	 "<a href=\"javascript: var t=window.open" .
                     "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
                     "'width=400,height=350,scrollbars=yes')\">{$wname}</a>: $wnum<br />\n";
            else
	    		echo "&nbsp;&nbsp;&nbsp;" .
        	         "<a href=\"javascript: var t=window.open" .
     	             "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
	                 "'width=400,height=350,scrollbars=yes')\">{$wname}</a>: $wnum<br />\n";

		$qry2 = "SELECT e.number, w.id, w.name, t.type
    			FROM {$sdb}equip e, {$sdb}weapons w, {$sdb}types t
    			WHERE e.ship='$sclass' AND e.type='w' AND e.equipment=w.id
                	AND w.sub='$wid' AND w.type=t.id
    	        ORDER BY e.sort";
	    $result2 = $database->openShipsWithReturn($qry2);

	    while (list($wnum, $wid, $wname) = mysql_fetch_array($result2))
        	if ($wnum == "1")
            	if (!defined("IFS"))
			    	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
                    	 "<a href=\"javascript: var t=window.open" .
                         "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
                         "'width=400,height=350,scrollbars=yes')\">{$wname}</a><br />\n";
                else
			    	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
                    "<a href=\"javascript: var t=window.open" .
                    "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
                    "'width=400,height=350,scrollbars=yes')\">{$wname}</a><br />\n";
            elseif ($wnum != "0")
            	if (!defined("IFS"))
			    	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
                    	 "<a href=\"javascript: var t=window.open" .
                         "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
                         "'width=400,height=350,scrollbars=yes')\">{$wname}</a>: $wnum<br />\n";
				else
			    	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
                    	 "<a href=\"javascript: var t=window.open" .
                         "('shipdb.php?detail={$wid}&amp;pop=y','setPop'," .
                         "'width=400,height=350,scrollbars=yes')\">{$wname}</a>: $wnum<br />\n";
    }
    echo "<br /><b>$notes</b><br /><br />\n";

	if ($desc)
    {
	    echo "<a class=\"heading\">Description</a><br />\n";
	    echo $desc . "\n";
	    echo "<br /><br />\n";
	}

	$qry = "SELECT deck, descrip FROM {$sdb}decks WHERE ship='$sclass'";
	$result = $database->openShipsWithReturn($qry);

    if (mysql_num_rows($result))
    {
    	?>
	    <b>Deck Listing:</b><br /><br />
	    <table border="1">
	    <tr>
        	<th border="1">Deck</th>
            <th border="1">Description</th>
        </tr>
        <?php
	    while ( list($decknum, $deckdesc) = mysql_fetch_array($result) )
        	$decklist[$decknum] = $deckdesc;

        for ($i = 1; $i <= $decks; $i++)
	    {
        	echo "<tr>\n";
            echo "<td border=\"1\">$i</td>\n";
            echo "<td border=\"1\">{$decklist[$i]}&nbsp;</td>\n";
            echo "</tr>\n";
		}

	    echo "</table>\n";
	    echo "<br /><br />\n";
    }

	if ($pop != "y" && $support == "y")
    {
 		echo "<a class=\"heading\">Found on:</a><br />\n";
	    $qry = "SELECT c.name, d.name
        		FROM {$sdb}classes c, {$sdb}equip e, {$sdb}category d
                WHERE e.equipment='$sclass' AND e.type='c' AND e.ship=c.id
                	AND c.category=d.id AND e.number>'0'";
		$result = $database->openShipsWithReturn($qry);
	    while (list($cname, $catname,) = mysql_fetch_array($result))
	    	echo $cname . " Class " . $catname . "<br />\n";
	    echo "<br /><br />\n";
    }

    echo "<a href=\"index.php?option=shipdb\">Back to the Ship Database</a>\n";

}

// Default: get listing of all classes
else
{
	echo "<h1>Starships / Starbases</h1>\n";
	$qry = "SELECT c.id, c.name, c.active, t.type
    		FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
            WHERE c.category=d.id AND d.type=t.id AND t.support='n'
            ORDER BY t.type, c.name";
	$result = $database->openShipsWithReturn($qry);
    while(list($cid, $cname, $cactive, $type) = mysql_fetch_array($result))
    {
    	if ($cactive == "1")
        {
	      	if ($oldtype != $type)
	        {
		       	echo "{$type}s<br />\n";
	            $oldtype = $type;
	        }

	    	if (!defined("IFS"))
		    	echo "&nbsp;&nbsp;&nbsp;" .
	            	 "<a href=\"shipdb.php?sclass={$cid}\">{$cname} Class</a><br />\n";
			else
		    	echo "&nbsp;&nbsp;&nbsp;" .
	            	 "<a href=\"index.php?option=shipdb&amp;sclass={$cid}\">{$cname} Class</a><br />\n";
        }
        else
        {
        	$inactiveshipid[] = $cid;
            $inactiveshipname[] = $cname;
            $inactiveshiptype[] = $type;
        }
  	}
    echo "<br />\n";

	echo "<h1>Support Craft</h1>\n";
	$qry = "SELECT c.id, c.name, c.active, t.type, t.support
    		FROM {$sdb}classes c, {$sdb}category d, {$sdb}types t
            WHERE c.category=d.id AND d.type=t.id AND t.support='y'
            ORDER BY t.type, c.name";
	$result = $database->openShipsWithReturn($qry);
    while(list($cid, $cname, $cactive, $type) = mysql_fetch_array($result))
    {
    	if ($cactive == "1")
        {
	       	if ($oldtype != $type)
	        {
	           	echo "{$type}s<br />\n";
	            $oldtype = $type;
	        }
	    	if (!defined("IFS"))
		    	echo "&nbsp;&nbsp;&nbsp;" .
	            	 "<a href=\"shipdb.php?sclass={$cid}\">{$cname} Class</a><br />\n";
	        else
		    	echo "&nbsp;&nbsp;&nbsp;" .
	            	 "<a href=\"index.php?option=shipdb&amp;sclass={$cid}\">{$cname} Class</a><br />\n";
        }
        else
        {
        	$inactiveshipid[] = $cid;
            $inactiveshipname[] = $cname;
            $inactiveshiptype[] = $type;
        }
  	}
    echo "<br />\n";

    echo "<h1>Technology</h1>\n";
   	if (!defined("IFS"))
    	echo "<form action=\"shipdb.php\" method=\"post\">\n";
    else
    	echo "<form action=\"index.php?option=shipdb\" method=\"post\">\n";

	echo "Search for technology: ";
    echo "<input type=\"text\" length=\"20\" name=\"techsearch\" /><br />\n";
    echo "<input type=\"submit\" value=\"Search\" /><br />\n";
    echo "<br />\n";

    if ( is_array($inactiveshipid) )
    {
	    echo "<h1>Inactive Classes</h1>\n";
    	$displayed_types = array();
	    for ($i = 0; array_key_exists($i, $inactiveshipid); $i++)
	    {
	    	$cid = $inactiveshipid[$i];
	        $cname = $inactiveshipname[$i];
	        $type = $inactiveshiptype[$i];

	    	if ( !in_array($type, $displayed_types) )
	        {
		       	echo "{$type}s<br />\n";
	            $displayed_types[] = $type;
	        }

		   	if (!defined("IFS"))
		    	echo "&nbsp;&nbsp;&nbsp;" .
		           	 "<a href=\"shipdb.php?sclass={$cid}\">{$cname} Class</a><br />\n";
		    else
		    	echo "&nbsp;&nbsp;&nbsp;" .
		           	 "<a href=\"index.php?option=shipdb&amp;sclass={$cid}\">{$cname} Class</a><br />\n";
	    }
    }
    echo "<br /><br />\n";

}

// end stylesheet-purposed table
echo "</td></tr></table>\n";

if (!defined("IFS"))
{
	$no_back_to = "1";
	include ("includes/footer.php");
}

?>