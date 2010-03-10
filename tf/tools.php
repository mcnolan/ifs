<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net
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
  * Date:	5/07/04
  * Comments: Acts as a switchboard for IFS functions
 ***/

if (defined("IFS") && $action == "common")
{
	// Verification for COs, TGCOs, and TFCOs
	if ($task != "common")
    {
	    $qry = "SELECT s.id
        	FROM {$spre}ships s, {$spre}characters c
            WHERE s.co=c.id AND c.player=$uid AND s.id!=".UNASSIGNED_SHIP."
            	AND s.id!=".TRANSFER_SHIP." AND s.id!=".DELETED_SHIP;
		$result = $database->openConnectionWithReturn($qry);
	    list ($usership) = mysql_fetch_array($result);

		$qry = "SELECT t.tf
        	    FROM {$spre}characters c, {$spre}taskforces t, {$spre}ships s
                WHERE t.tg=0 AND t.co=c.id AND c.player='$uid'
                	AND s.tf=t.tf AND s.id='$sid'";
	    $result = $database->openConnectionWithReturn($qry);
	    list ($usertf) = mysql_fetch_array($result);

        $qry = "SELECT t.tg
                FROM {$spre}characters c, {$spre}taskforces t, {$spre}ships s
                WHERE t.tg!=0 AND t.co=c.id AND c.player='$uid'
                    AND s.tf=t.tf AND s.tg=t.tg AND s.id='$sid'";
        $result = $database->openConnectionWithReturn($qry);
        list ($usertg) = mysql_fetch_array($result);

	}

	switch($lib)
    {
	   /* Naming convention:       						*
	    * a: awards				lib-awards.php			*
        * c: crew		        lib-crew.php			*
        * r: service record		lib-records.php			*
        * s: ship				lib-ship.php			*/

        // Detailed view of awards: public access
		case 'adet':
        	awards_detail ($database, $mpre, $spre, $award);
            break;

        // Listing of awards: public access
        case 'alist':
            awards_list($database, $mpre, $spre);
            break;

        // Reason for winning an award: public access
        case 'areason':
        	awards_reason($database, $mpre, $spre, $rid);
            break;

        // Recipients of an award: public access
		case 'arecip':
        	awards_recipients($database, $mpre, $spre, $award);
            break;

        // View Academy history
        case 'cacad':
        	$qry = "SELECT id FROM {$spre}characters WHERE id='$cid' AND player='" . uid . "'";
            $result = $database->openConnectionWithReturn($qry);

        	if (defined("admin") || mysql_num_rows($result) || ($uflag['c'] == 1 && $sid == $usership) ||
				$uflag['t'] > 0 || $uflag['g'] > 0)
				crew_academy($database, $mpre, $spre, $pid);
            else
            	echo "You do not have access.";
            break;

        // Add crew to a ship: CO or OPM
		case 'cadd':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) || $uflag['p'] >= 1)
	            crew_edit($database, $spre, $mpre, $cid, $sid, 'add', $uflag);
            else
            	echo "You do not have access.";
            break;

        // View crew app: admins, the player himself, or CO
		case 'capp':
        	$qry = "SELECT ship FROM {$spre}characters WHERE id='$cid'";
            $result = $database->openConnectionWithReturn($qry);
            list ($sid) = mysql_fetch_array($result);

    	  	$qry = "SELECT id FROM {$spre}characters WHERE id='$cid' AND player='" . uid . "'";
            $result = $database->openConnectionWithReturn($qry);

        	if (defined("admin") || mysql_num_rows($result) || ($uflag['c'] == 1 && $sid == $usership))
		    	crew_view_app ($database, $spre, $cid);
            else
            	echo "You do not have access.";
			break;

        // Delete a character: CO or OPM
    	case 'cdel':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) || ($uflag['p'] >= 1))
	        	crew_delete_confirm ($database, $mpre, $spre, $cid, $sid, $uflag);
            else
            	echo "You do not have access.";
            break;

        // Delete a character, step two
        case 'cdel2':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) || $uflag['p'] >= 1)
    	    	crew_delete_save ($database, $mpre, $spre, $cid, $sid, $reason, $uflag);
            else
            	echo "You do not have access.";
            break;

        // Mass delete: OPM only
        case 'cdelall':
        	if ($uflag['p'] >= 1)
            	crew_delete_all($database, $spre, $mpre, $deletechars, $delreason);
            else
            	echo "You do not have access.";

        // Edit a crewmemner: CO, OPM, TFCO, TGCO
        case 'cedit':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['p'] > 0 || ($uflag['t'] > 0 && $usertf) ||
               	($uflag['g'] > 0 && $usertg) )
	            crew_edit_reason($database, $spre, $mpre, $add, $position, $otherpos, $cname, $email, $race, $gender, $rank, $sid, $cid, $pending, $uflag);
            else
            	echo "You do not have access.";
        	break;

        // Edit a crewmemner, step two
		case 'cedit2':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['p'] >= 1 || ($uflag['t'] >=1 && $usertf) ||
                ($uflag['g'] > 0 && $usertg) )
	            crew_edit_save($database, $spre, $mpre, $add, $position, $otherpos, $cname, $email, $race, $gender, $rank, $reason, $sid, $cid, $pending, $uflag);
            else
            	echo "You do not have access.";
            break;

        // Search email address & list characters: admins only
        case 'clistem':
        	if (defined("admin"))
	        	crew_list_email ($database, $mpre, $spre, $email, $uflag);
            else
            	echo "You do not have access.";
            break;

        // List crew by ID number: admins only
        case 'clistid':
        	if (defined("admin"))
	        	crew_list_id ($database, $mpre, $spre, $pid, $uflag);
            else
            	echo "You do not have access.";
            break;

        // Crew tranafers: OPM only
        case 'ctrans':
        	if ($uflag['p'] >= 1)
            	crew_transfer ($database, $mpre, $spre, $cid, $sid);
            else
            	echo "You do not have access.";
            break;

        // View/edit info about a crewmember: Admins, CO
		case 'cview':
        	if (defined("admin") || ($uflag['c'] == 1 && $sid == $usership))
	            crew_edit($database, $spre, $mpre, $cid, $sid, $action, $uflag);
            else
            	echo "You do not have access.";
            break;

        // Add service record entry: admins, CO
	    case "radd":
        	if (defined("admin") || ($uflag['c'] == 1 && $sid == $usership))
		    	record_add_details ($database, $spre, $mpre, $cid, $level, $date, $entry, $pname, $radmin, $uflag);
            else
            	echo "You do not have access.";
		    break;

        // View details on service record entry: admins, player, CO
	    case "rdetails":
        	$qry = "SELECT id FROM {$spre}characters WHERE id='$cid' AND player='" . uid . "'";
            $result = $database->openConnectionWithReturn($qry);

        	if (defined("admin") || mysql_num_rows($result) || ($uflag['c'] == 1 && $sid == $usership))
		    	record_details ($database, $spre, $mpre, $rid, "", $uflag);
            else
            	echo "You do not have access.";
	    	break;

        // Save new record entry: admins, CO
	    case "rsave":
        	if (defined("admin") || ($uflag['c'] == 1 && $sid == $usership))
		    	record_add_save ($database, $spre, $mpre, $cid, $level, $date, $entry, $pname, $details, $radmin, $uflag);
            else
            	echo "You do not have access.";
			break;

        // View service record: admins, player, CO
		case "rview":
        	$qry = "SELECT id FROM {$spre}characters WHERE id='$cid' AND player='" . uid . "'";
            $result = $database->openConnectionWithReturn($qry);

        	if (defined("admin") || mysql_num_rows($result) || ($uflag['c'] == 1 && $sid == $usership))
		    	record_view ($database, $spre, $mpre, $cid, "", $uflag);
            else
            	echo "You do not have access.";
			break;

        // Add a ship: TFCOs, FCOps
		case 'sadd':
			$qry = "SELECT t.tf
            		FROM {$spre}characters c, {$spre}taskforces t, {$spre}ships s
                    WHERE t.tg=0 AND t.co=c.id AND c.player='$uid'";
		    $result = $database->openConnectionWithReturn($qry);
		    list ($usertf) = mysql_fetch_array($result);

        	if ($uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) || $uflag['o'] > 0)
				ship_add($database, $mpre, $spre, $uflag, $tf, $format, $sname, $class, $registry, $status, $grpid);
            else
            	echo "You do not have access.";
	        break;

        // View/edit admin info for a ship: TFCO, TGCO, FCOps
		case 'sadmin':
        	if ($uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) ||
            	($uflag['g'] > 0 && $usertg) || $uflag['o'] > 0)
				ship_view_admin($database, $mpre, $spre, $sdb, $sid, $uflag);
            else
            	echo "You do not have access.";
	        break;

        // Edit admin info, step two
	    case 'sadmin2':
        	if ($uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) ||
            	($uflag['g'] > 0 && $usertg) || $uflag['o'] > 0)
		      	ship_admin_save ($database, $mpre, $spre, $sid, $coid, $shipname, $registry, $class, $website, $format, $grpid, $status, $image, $sorder, $notes, $uflag);
            else
            	echo "You do not have access.";
	        break;

        // Clear crew from a ship: TFCOs, FCOps
        case 'sclear':
        	if ($uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) || $uflag['o'] > 0)
				ship_clear_crew ($database, $mpre, $spre, $sid, $reason, $uflag);
            else
            	echo "You do not have access.";
	        break;

        // Delete a ship: TFCO, FCOps
	    case 'sdel':
        	if ($uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) || $uflag['o'] > 0)
		      	ship_delete($database, $mpre, $spre, $sid, $uflag);
            else
            	echo "You do not have access.";
	        break;

        // Edit notes for a ship: CO, TFCO, TGCO, FCOps
        case 'snotes':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) ||
                ($uflag['g'] > 0 && $usertg) || $uflag['o'] > 0)
    	    	ship_edit_notes($database, $mpre, $spre, $sid, $notes, $uflag);
            else
            	echo "You do not have access.";
            break;

        // List past monthly reports: CO, TFCO, FCOps, TGCO
        case 'srepl':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) || $uflag['o'] > 0 ||
                ($uflag['g'] > 0 && $usertg))
    	    	ship_reports_list($database, $mpre, $spre, $sid);
            else
            	echo "You do not have access.";
            break;

        // View past monthly reports: CO, TFCO, FCOps, TGCO
        case 'srepv':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf)|| $uflag['o'] > 0 ||
                ($uflag['g'] > 0 && $usertg) )
    	    	ship_reports_view($database, $mpre, $spre, $rid);
            else
            	echo "You do not have access.";
            break;

        // Transfer a ship (between TFs): FCOps
        case 'strans':
        	if ($uflag['o'] >= 1)
            	ship_transfer ($database, $mpre, $spre, $sid, $tfid, $tgid);
            else
            	echo "You do not have access.";
            break;

        // View ship's manifest: CO, TFCO, OPM, TGCO, FCOps
		case 'sview':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) ||
                ($uflag['p'] >= 1) || ($uflag['g'] > 0 && $usertg) || $uflag['o'] > 0)
	        	ship_view_info($database, $mpre, $spre, $sid, $uflag);
            else
            	echo "You do not have access.";
            break;

        // Edit ship website: CO, TFCO, TGCO, FCOps
        case 'swebsite':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) ||
                ($uflag['g'] > 0 && $usertg) || $uflag['o'] > 0)
        		ship_edit_website($database, $mpre, $spre, $sid, $url, $uflag);
            else
            	echo "You do not have access.";
            break;

        // Edit ship XO: CO, TFCO, TGCO, FCOps, OPM
        case 'sxo':
        	if ($uflag['c'] == 2 || ($uflag['c'] == 1 && $sid == $usership) ||
            	$uflag['t'] == 2 || ($uflag['t'] == 1 && $usertf) ||
                ($uflag['p'] >= 1) || ($uflag['g'] > 0 && $usertg) || $uflag['o'] > 0)
	        	ship_edit_xo($database, $mpre, $spre, $sid, $xoid, $uflag);
            else
            	echo "You do not have access.";
            break;

	    default:
        	redirect("");
	    	break;
	}
}
else
	echo "Hacking attempt!";
?>