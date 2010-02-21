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
  * This file based on code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	12/9/03
  * Comments: Decides what to do with submitted values
 ***/

// Work-around for shipdb problem
if ($option == "?option=shipdb")
	$option="shipdb";

switch ($option)
{
	case "archiveNews":
		include("pastarticles.php");
		break;
	case "articles":
		include("articles.php");
		break;
    case "app":
		include("apps/index.php");
		break;
    case "birthdays":
    	$bdetails = "1";
    	include("birthday.php");
        break;
	case "contact":
		include("contact.php");
		break;
	case "displaypage":
		include("displaypage.php");
		break;
    case "error":
    	include("error.php");
    	break;
	case "faq":
		include("faq.php");
		break;
	case "ifs":
    	include("ifs.php");
        break;
	case "news":
		include("news.php");
		break;
	case "online":
		$ondetails = "1";
		include("whosOnline.php");
		break;
    case "opl":
        include("opl/index.php");
        break;
	case "registration":
		include("registration.php");
		break;
    case "search":
		include("search.php");
		break;
	case "shipdb":
    	include("shipdb.php");
        break;
    case "ships":
        include("tf/ships.php");
        break;
	case "spotlight":
		$needspot = "1";
		include("spotlight.php");
        break;
	case "surveyresult":
		include("pollBooth.php");
		break;
	case "user":
		include("userpage.php");
		break;
    case "weblinks":
		include("weblinks.php");
		break;
	default:
		$Itemid=1;
		include("body.php");
		break;
}

?>