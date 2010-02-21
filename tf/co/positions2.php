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
  * This file based on code from Open Positions List
  * Copyright (C) 2002, 2003 Frank Anon
  *
  * Date:	12/22/03
  * Comments: Position editing for OPL
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	if ($pos_act == "remove")
    {
		for ($i=0;$i<sizeof($check);$i++)
        {
			$pos = $check[$i];

			$qry = "SELECT pos FROM {$spre}positions WHERE ship='$sid' AND action='rem' AND pos='$pos'";
			$result = $database->openConnectionWithReturn($qry);

			if (!mysql_num_rows($result))
            {
				$qry = "SELECT pos FROM {$spre}positions WHERE ship='$sid' AND action='add' AND pos='$pos'";
				$result = $database->openConnectionWithReturn($qry);

				if (mysql_num_rows($result))
					$qry = "DELETE FROM {$spre}positions WHERE ship='$sid' AND action='add' AND pos='$pos'";
				else
					$qry = "INSERT INTO {$spre}positions (ship, action, pos) VALUES ('$sid','rem','$pos')";
				$database->openConnectionNoReturn($qry);
			}
		}
		if ($adminship)
        	redirect("&amp;action=positions&amp;adminship={$adminship}");
        else
			redirect("&amp;action=positions");
	}
    elseif ($pos_act == "add")
    {
		if ($o1)
        {
			$n = sizeof($check);
			$check[$n] = $other;
		}

		if ($o2)
        {
			$n = sizeof($check);
			$check[$n] = $other2;
		}

		if ($o3)
        {
			$n = sizeof($check);
			$check[$n] = $other3;
		}

		for ($i=0;$i<sizeof($check);$i++)
        {
			$pos = $check[$i];

			$qry = "SELECT pos FROM {$spre}positions WHERE ship='$sid' AND action='rem' AND pos='$pos'";
			$result = $database->openConnectionWithReturn($qry);

			if (mysql_num_rows($result))
				$qry = "DELETE FROM {$spre}positions WHERE ship='$sid' AND action='rem' AND pos='$pos'";
			else
				$qry = "INSERT INTO {$spre}positions (ship, action, pos) VALUES ('$sid', 'add', '$pos')";
			$database->openConnectionNoReturn($qry);
		}

		if ($adminship)
			redirect("&amp;action=positions&amp;adminship={$adminship}");
		else
			redirect("&amp;action=positions");
	}
}

?>