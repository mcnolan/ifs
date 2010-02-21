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
	 *	File Name: survey.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("classes/html/HTML_survey.php");
	$surveyhtml = new HTML_survey();

	require("classes/survey.php");
	$survey = new survey();

	switch($task){
		case "edit":
			$pollid = $cid[0];
			$survey->editsurvey($surveyhtml, $database, $option, $pollid, $myname, $mpre);
			break;
		case "saveedit":
			$selection = split("&", $_SERVER['REQUEST_URI']);
			$selections = array();
			$k = 0;
			for ($i = 0; $i < count($selection); $i++){
				if (eregi("menu", $selection[$i])){
					$selected = split("=", $selection[$i]);
					$selections[$k] = $selected[1];
					$k++;
					}
				}

			for ($i = 0; $i < count($selections); $i++){
				$selections[$i] = ereg_replace( "[+]", " ", $selections[$i]);
				}
			$survey->saveeditsurvey($database, $option, $pollid, $polloption, $optionCount, $pollorder, $mytitle, $selections, $mpre);
			break;
		case "savenew":
			$selection = split("&", $_SERVER['REQUEST_URI']);
			$selections = array();
			$k = 0;
			for ($i = 0; $i < count($selection); $i++){
				if (eregi("menu", $selection[$i])){
					$selected = split("=", $selection[$i]);
					$selections[$k] = $selected[1];
					$k++;
					}
				}

			for ($i = 0; $i < count($selections); $i++){
				$selections[$i] = ereg_replace( "[+]", " ", $selections[$i]);
				}

			$survey->savenewsurvey($database, $option, $mytitle, $pollorder, $polloption, $selections, $mpre);
			break;
		case "remove":
			$survey->removesurvey($database, $option, $cid, $mpre);
			break;
		case "new":
			$survey->addSurvey($option, $database, $surveyhtml, $mpre);
			break;
		case "publish":
			$survey->publishsurvey($option, $database, $cid, $pollid, $mpre);
			break;
		case "unpublish":
			$survey->unpublishsurvey($option, $database, $cid, $pollid, $mpre);
			break;
		default:
			$survey->showSurvey($option, $surveyhtml, $database, $mpre);
		}
?>