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
	 *	File Name: faq.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class faq {
		function showFaq($database, $option, $faqhtml, $categories, $mpre){
			$query = "SELECT categoryid, categoryname FROM " . $mpre . "categories WHERE section='Faq'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$categoryid[$i] = $row->categoryid;
				$categoryname[$i] = $row->categoryname;
				$i++;
				}
			mysql_free_result($result);

			if ($categories == "all"){
				$query = "SELECT artid, title, published, checked_out, editor, archived, approved FROM " . $mpre . "faqcont";
			}elseif ($categories=="new") {
				$query = "SELECT artid, title, published, checked_out, editor, archived, approved FROM " . $mpre . "faqcont WHERE approved=0";
			}elseif ($categories <> ""){
				$query = "SELECT artid, title, published, checked_out, editor, archived, approved FROM " . $mpre . "faqcont WHERE faqid=$categories";
			}

			if ($categories!=""){
				$result = $database->openConnectionWithReturn($query);
				$i = 0;
				while ($row = mysql_fetch_object($result)){
					$artid[$i] = $row->artid;
					$title[$i] = $row->title;
					$published[$i] = $row->published;
					$editor[$i] = $row->editor;
					$checkedout[$i] = $row->checked_out;
					$archived[$i] = $row->archived;
					$approved[$i] = $row->approved;
					$i++;
				}
			}
			$faqhtml->showFaq($option, $artid, $title, $published, $editor, $archived, $checkedout, $categoryid, $categoryname, $categories, $approved);
		}

		function editFaq($faqhtml, $database, $option, $id, $myname, $categories, $text_editor, $mpre){
			$query = "SELECT title, checked_out, editor FROM " . $mpre . "faqcont WHERE artid='$id'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$title = $row->title;
				$editor = $row->editor;
				}

			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The story $title is currently being edited by $editor'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				exit(0);
				}

			$date = date("H:i:s");
			$query = "UPDATE " . $mpre . "faqcont SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE artid='$id'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT " . $mpre . "faqcont.artid AS artid, " . $mpre . "faqcont.faqid AS faqid, " . $mpre . "faqcont.ordering AS ordering, " . $mpre . "faqcont.title AS title, " . $mpre . "faqcont.content AS content, " . $mpre . "categories.categoryid AS faqcategoryid, " . $mpre . "categories.categoryname AS faqcategoryname FROM " . $mpre . "faqcont, " . $mpre . "categories
					  WHERE " . $mpre . "faqcont.faqid=" . $mpre . "categories.categoryid AND " . $mpre . "faqcont.artid='$id'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$artid = $row->artid;
				$title = $row->title;
				$content = $row->content;
				$faqid = $row->faqid;
				$faqcategoryid = $row->faqcategoryid;
				$faqcategoryname = $row->faqcategoryname;
				$orderingfaq = $row->ordering;
				}

			mysql_free_result($result);

			$query = "SELECT MAX(ordering) AS maxnum FROM " . $mpre . "faqcont WHERE faqid='$faqcategoryid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$maxnum = $row->maxnum;
				}

			$query = "SELECT categoryname, categoryid FROM " . $mpre . "categories WHERE section='Faq'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			$ordering = Array();
			while ($row = mysql_fetch_object($result)){
				$categorycid[$i] = $row->categoryid;
				$categorytitle[$i] = $row->categoryname;
				$query = "SELECT * FROM " . $mpre . "faqcont WHERE faqid=$categorycid[$i]";
				$result2 = $database->openConnectionWithReturn($query);
				$count = mysql_num_rows($result2);
				$ordering["$categorytitle[$i]"] = $count;
				$i++;
				}
			$faqhtml->editFaq($artid, $title, $content, $categoryid, $categoryname, $faqcategoryid, $faqcategoryname, $option, $ordering, $maxnum, $categorycid, $categorytitle, $faqid, $orderingfaq, $categories, $text_editor);
			}

		function saveeditfaq($faqhtml, $database, $option, $title, $section, $content, $artid, $myname, $ordering, $porder, $categories, $pcategory, $mpre){
			if (($title == "") || ($content == "")){
				print "<SCRIPT> alert('A FAQ must contain and title and content.'); window.history.go(-1); </SCRIPT>\n";
				}

				$query = "UPDATE " . $mpre . "faqcont SET faqid='$section', title='$title', content='$content', checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);

			print "<SCRIPT>document.location.href='index2.php?option=$option&task=edit&cid%5B%5D=$artid&categories=$categories'</SCRIPT>\n";
			}

		function addFaq($faqhtml, $database, $option, $text_editor, $categories, $mpre){
			$query = "SELECT categoryname, categoryid FROM " . $mpre . "categories WHERE section='Faq'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			$ordering = Array();
			while ($row = mysql_fetch_object($result)){
				$categorycid[$i] = $row->categoryid;
				$categorytitle[$i] = $row->categoryname;
				$query = "SELECT * FROM " . $mpre . "faqcont WHERE faqid=$categorycid[$i]";
				$result2 = $database->openConnectionWithReturn($query);
				$count = mysql_num_rows($result2);
				$ordering["$categorytitle[$i]"] = $count;
				$i++;
				}
			$faqhtml->addFaq($option, $categorycid, $categorytitle, $ordering, $text_editor, $categories);
			}

		function savefaq($database, $option, $title, $section, $content, $ordering, $categories, $mpre){
			if (($title == "") || ($content == "")){
				print "<SCRIPT> alert('A FAQ must contain and title and content.'); window.history.go(-1); </SCRIPT>\n";
				}

			//$title = addslashes($title);
			//$content = addslashes($content);
			$query = "INSERT INTO " . $mpre . "faqcont SET faqid='$section', title='$title', content='$content'";
			$database->openConnectionNoReturn($query);
			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			}

		function removefaq($database, $option, $cid, $categories, $mpre){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT faqid FROM " . $mpre . "faqcont WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$topic = $row->faqid;
					}

				$query = "DELETE FROM " . $mpre . "faqcont WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);

				$query = "SELECT * FROM " . $mpre . "faqcont WHERE faqid='$topic'";
				$result = $database->openConnectionWithReturn($query);
				$count = mysql_num_rows($result);
				if ($count == 0){
					$query = "UPDATE " . $mpre . "categories SET published=0 WHERE categoryid='$topic'";
					$database->openConnectionNoReturn($query);
					}
				}

			$query = "SELECT artid FROM " . $mpre . "faqcont WHERE faqid='$topic' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 1;
			while ($row = mysql_fetch_object($result)){
				$sid = $row->artid;
				$query = "UPDATE " . $mpre . "faqcont SET ordering=$i WHERE artid=$sid";
				$database->openConnectionNoReturn($query);
				$i++;
				}

			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			}

		function publishfaq($database, $option, $cid, $artid, $myname, $categories, $mpre){
			if (count($cid) > 0){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT checked_out, approved FROM " . $mpre . "faqcont WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
						$approved = $row->approved;
						}

					if ($checked == 1){
						print "<SCRIPT>alert('This faq cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
						}

					if ($approved == 0){
						print "<SCRIPT>alert('This faq cannot be published because it has not been approved'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
						}

					$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "faqcont WHERE " . $mpre . "faqcont.faqid=" . $mpre . "categories.categoryid AND " . $mpre . "faqcont.artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$isitpub = $row->catpub;
						$topic = $row->topic;
						}

					if ($isitpub == 0){
						$query = "UPDATE " . $mpre . "faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
						$database->openConnectionNoReturn($query);
						$query = "UPDATE " . $mpre . "categories SET published=1 WHERE categoryid='$topic'";
						$database->openConnectionNoReturn($query);
						}
					mysql_free_result($result);

					$query = "UPDATE " . $mpre . "faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($artid)) {
				$query = "SELECT checked_out, editor, approved FROM " . $mpre . "faqcont WHERE artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$editor = $row->editor;
					$approved = $row->approved;
					}

				if (($checked == 1) && ($editor <> $myname)){
					print "<SCRIPT>alert('This faq cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				if ($approved == 0){
					print "<SCRIPT>alert('This faq cannot be published because it has not been approved'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "faqcont WHERE " . $mpre . "faqcont.faqid=" . $mpre . "categories.categoryid AND " . $mpre . "faqcont.artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->catpub;
					$topic = $row->topic;
					}

				if ($isitpub == 0){
					$query = "UPDATE " . $mpre . "faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
					$database->openConnectionNoReturn($query);
					$query = "UPDATE " . $mpre . "categories SET published=1 WHERE categoryid='$topic'";
					$database->openConnectionNoReturn($query);
					}
				mysql_free_result($result);

				$query = "UPDATE " . $mpre . "faqcont SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				}else{
					print "<SCRIPT>alert('Please select a faq to publish'); window.history.go(-1);</SCRIPT>\n";
				}

			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			}

		function unpublishfaq($database, $option, $cid, $artid, $myname, $categories, $mpre){
			if (count($cid) > 0){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT checked_out FROM " . $mpre . "faqcont WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
						}

					if ($checked == 1){
						print "<SCRIPT>alert('This faq cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
						exit(0);
						}

					$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "faqcont WHERE " . $mpre . "faqcont.faqid=" . $mpre . "categories.categoryid AND " . $mpre . "faqcont.artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$isitpub = $row->catpub;
						$topic = $row->topic;
						}

					if ($isitpub == 1){
						$query = "UPDATE " . $mpre . "faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
						$database->openConnectionNoReturn($query);
						//added this check 3/9/01
						if (mysql_num_rows($result) == 0){
							$query = "UPDATE " . $mpre . "categories SET published=0 WHERE categoryid='$topic'";
							$database->openConnectionNoReturn($query);
						}
					}
					mysql_free_result($result);

					$query = "UPDATE " . $mpre . "faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($artid)){
				$query = "SELECT checked_out, editor FROM " . $mpre . "faqcont WHERE artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$editor = $row->editor;
					}

				if (($checked == 1) && ($editor <> $myname)){
					print "<SCRIPT>alert('This faq cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "faqcont WHERE " . $mpre . "faqcont.faqid=" . $mpre . "categories.categoryid AND " . $mpre . "faqcont.artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->catpub;
					$topic = $row->topic;
					}

				if ($isitpub == 1){
					$query = "UPDATE " . $mpre . "faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
					$database->openConnectionNoReturn($query);
					//added this check 3/9/01
					if (mysql_num_rows($result) == 0){
						$query = "UPDATE " . $mpre . "categories SET published=0 WHERE categoryid='$topic'";
						$database->openConnectionNoReturn($query);
					}
				}
				mysql_free_result($result);

				$query = "UPDATE " . $mpre . "faqcont SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				}else{
					print "<SCRIPT>alert('Please select a faq to unpublish'); window.history.go(-1);</SCRIPT>\n";
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			}

		function archivefaq($database, $option, $cid, $categories, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT> alert('Please select an faq to archive'); window.history.go(-1); </SCRIPT>\n";
				}
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out, approved FROM " . $mpre . "faqcont WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$approved = $row->approved;
					}

				if ($checked == 1){
					print "<SCRIPT>alert('This faq cannot be archived because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				if ($approved == 0){
					print "<SCRIPT>alert('This faq cannot be archived because it has not been approved'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "UPDATE " . $mpre . "faqcont SET archived=1 WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				}
			}

		function unarchivefaq($database, $option, $cid, $categories, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT> alert('Please select an faq to unarchive'); window.history.go(-1); </SCRIPT>\n";
				}

			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT checked_out FROM " . $mpre . "faqcont WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					}

				if ($checked == 1){
					print "<SCRIPT>alert('This faq cannot be archive because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
					exit(0);
					}

				$query = "UPDATE " . $mpre . "faqcont SET archived=0 WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				}
		}

		function approvefaq($database, $option, $artid, $categories, $category, $content, $title, $mpre){
			$query = "UPDATE " . $mpre . "faqcont SET approved=1, checked_out=0, checked_out_time='00:00:00', editor=NULL, faqid=$category, content='$content', title='$title', published='1' WHERE artid=$artid";
			$database->openConnectionNoReturn($query);

			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
		}
}?>