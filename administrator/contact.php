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
	 *	File Name: contact.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	require ("classes/html/HTML_contact.php");
	$contacthtml = new HTML_contact();

	switch ($task){
		case "save":
			savecontact($database, $companyname, $acn, $address, $suburb, $state, $postcode, $telephone, $facsimile, $email, $country, $mpre);
			break;
		default:
			showcontact($contacthtml, $database, $mpre);
		}


	function showcontact($contacthtml, $database, $mpre){
		$query = "SELECT * FROM " . $mpre . "contact_details";
		$result = $database->openConnectionWithReturn($query);
		while ($row = mysql_fetch_object($result)){
			$companyname = $row->name;
			$acn = $row->ACN;
			$address = $row->address;
			$suburb = $row->suburb;
			$state = $row->state;
			$country = $row->country;
			$postcode = $row->postcode;
			$telephone = $row->telephone;
			$facsimile = $row->fax;
			$email = $row->email_to;
			}

		$contacthtml->showcontact($companyname, $acn, $address, $suburb, $state, $postcode, $telephone, $facsimile, $email, $country);
		}

	function savecontact($database, $companyname, $acn, $address, $suburb, $state, $postcode, $telephone, $facsimile, $email, $country, $mpre){
		$query = "DELETE FROM " . $mpre . "contact_details";
		$database->openConnectionNoReturn($query);

		$query = "INSERT INTO " . $mpre . "contact_details SET name='$companyname', ACN='$acn', address='$address', suburb='$suburb', state='$state', country='$country', postcode='$postcode', telephone='$telephone', fax='$facsimile', email_to='$email'";
		$database->openConnectionNoReturn($query);

		print "<SCRIPT>document.location.href='index2.php'</SCRIPT>\n";
		}
?>