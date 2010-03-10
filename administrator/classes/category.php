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
	 *	File Name: category.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class category {
		function showcategory($database, $option, $categoryhtml, $act, $mpre){
			$query = "SELECT  categoryid, categoryname, published, checked_out, editor FROM " . $mpre . "categories WHERE section='$option' ORDER BY categoryname";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$cid[$i] = $row->categoryid;
				$cname[$i] = $row->categoryname;
				$publish[$i] = $row->published;
				$checkedout[$i] = $row->checked_out;
				$editor[$i] = $row->editor;

				if ($option == "News"){
					$query = "SELECT * FROM " . $mpre . "stories WHERE topic='$cid[$i]'";
					}
				elseif ($option == "Faq"){
					$query = "SELECT * FROM " . $mpre . "faqcont WHERE faqid=$cid[$i]";
					}
				elseif ($option == "Articles"){
					$query = "SELECT * FROM " . $mpre . "articles WHERE secid=$cid[$i]";
					}
				elseif ($option == "Weblinks"){
					$query = "SELECT * FROM " . $mpre . "links WHERE cid=$cid[$i]";
					}
				$result2 = $database->openConnectionWithReturn($query);
				$count[$i] = mysql_num_rows($result2);
				$i++;
				}
			mysql_free_result($result);

			$categoryhtml->showcategory($option, $cid, $cname, $act, $count, $publish, $checkedout, $editor);
			}

		function editcategory($categoryhtml, $database, $option, $uid, $act, $myname, $mpre){
			$query = "SELECT categoryname, checked_out, editor FROM " . $mpre . "categories WHERE categoryid='$uid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$title = $row->categoryname;
				$editor = $row->editor;
				}
			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The category $title is currently being edited by another administrator'); document.location.href='index2.php?option=$option&act=categories'</SCRIPT>\n";
				exit(0);
				}

			$date = date("H:i:s");
			$query = "UPDATE " . $mpre . "categories SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE categoryid='$uid'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT categoryname FROM " . $mpre . "categories WHERE categoryid='$uid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$cname = $row->categoryname;
				}
			mysql_free_result($result);

			$categoryhtml->editcategory($option, $cname, $uid, $act);
			}

		function savecategory($categoryhtml, $database, $option, $categoryname, $image, $act, $uid, $pname, $position, $mpre){
			if ($categoryname == ""){
				print "<SCRIPT> alert('Your Category must contain a title.'); window.history.go(-1); </SCRIPT>\n";
				}

			if ($pname <> $categoryname){
				$query = "SELECT * FROM " . $mpre . "categories WHERE categoryname='$categoryname' AND section='$option'";
				$result = $database->openConnectionWithReturn($query);
				if (mysql_num_rows($result) > 0){
					print "<SCRIPT>alert('There is a category already with that name, please try again!'); document.location.href='index2.php?option=$option&act=$act&cid=$uid'</SCRIPT>\n";
					exit(0);
					}
				}

			$query = "UPDATE " . $mpre . "categories SET categoryname='$categoryname', checked_out=0, checked_out_time = '00:00:00', editor=NULL WHERE categoryid='$uid'";
			$database->openConnectionNoReturn($query);
			print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories&task=edit&cid%5B%5D=$uid'</SCRIPT>\n";
			}

		function newcategory($database, $option, $act, $categoryhtml, $mpre){
			$categoryhtml->addcategory($option, $act);
			}

		function savenewcategory($option, $database, $categoryname, $act, $mpre){
			if ($categoryname == ""){
				print "<SCRIPT> alert('Your Category must contain a title.'); window.history.go(-1); </SCRIPT>\n";
				}

			$query = "SELECT categoryid FROM " . $mpre . "categories WHERE categoryname='$categoryname' AND section='$option'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				print "<SCRIPT>alert('There is a category already with that name, please try again!'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
				}

			$query = "INSERT INTO " . $mpre . "categories SET categoryname='$categoryname', section='$option'";
			$database->openConnectionNoReturn($query);
			print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories'</SCRIPT>\n";
			}

		function removecategory($database, $option, $cid, $act, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT>alert('Please select a category to delete'); window.history.go(-1);</SCRIPT>\n";
				}

			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT categoryname FROM " . $mpre . "categories WHERE categoryid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$name = $row->categoryname;
					}
				mysql_free_result($result);

				if ($option == "News"){
					$query = "SELECT * FROM " . $mpre . "stories WHERE topic='$cid[$i]'";
					}
				elseif ($option == "Faq"){
					$query = "SELECT * FROM " . $mpre . "faqcont WHERE faqid=$cid[$i]";
					}
				elseif ($option == "Articles"){
					$query = "SELECT * FROM " . $mpre . "articles WHERE secid=$cid[$i]";
					}
				elseif ($option == "Weblinks"){
					$query = "SELECT * FROM " . $mpre . "links WHERE cid=$cid[$i]";
					}

				$result = $database->openConnectionWithReturn($query);

				if (mysql_num_rows($result) > 0){
					print "<SCRIPT>alert('Category $name cannot be removed, contains stories');</SCRIPT>\n";
					}
				else {
					$query = "DELETE FROM " . $mpre . "categories WHERE categoryid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option&act=$act'</SCRIPT>\n";
			}

		function publishcategory($option, $database, $uid, $cid, $image, $categoryname, $position, $mpre){
			if (count($cid) > 0){
				$count = count($cid);
				for ($i = 0; $i < $count; $i++){
					if ($option == "News"){
						$query = "SELECT checked_out FROM " . $mpre . "stories WHERE sid='$cid[$i]'";
						$result = $database->openConnectionWithReturn($query);
						while ($row = mysql_fetch_object($result)){
							$checked = $row->checked_out;
							}

						if ($checked == 1){
							print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
							exit(0);
							}

						for ($i = 0; $i < count($cid); $i++){
							$query = "SELECT sid FROM " . $mpre . "stories WHERE topic='$cid[$i]' and published=1";
							$result = $database->openConnectionWithReturn($query);
							if (mysql_num_rows($result)==0){
								$query2="select categoryname from " . $mpre . "categories where categoryid='$cid[$i]'";
								$result2=$database->openConnectionWithReturn($query2);
								list($catname)=mysql_fetch_array($result2);
								$pat="'";
								$replace="\\'";
								$catname=eregi_replace($pat, $replace, $catname);
								print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published news'); </SCRIPT>\n";
								}
							else {
								$query = "UPDATE " . $mpre . "categories SET published='1' WHERE categoryid='$cid[$i]'";
								$database->openConnectionNoReturn($query);
								}
							}
						}
					elseif ($option == "Weblinks"){
						$query = "SELECT checked_out FROM " . $mpre . "links WHERE cid='$cid[$i]'";
						$result = $database->openConnectionWithReturn($query);
						while ($row = mysql_fetch_object($result)){
							$checked = $row->checked_out;
							}

						if ($checked == 1){
							print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
							exit(0);
							}

						for ($j = 0; $j < count($cid); $j++){
							$query = "SELECT lid FROM " . $mpre . "links WHERE cid='$cid[$i]' and published=1";
							$result = $database->openConnectionWithReturn($query);
							if (mysql_num_rows($result)==0){
								$query2="select categoryname from " . $mpre . "categories where categoryid='$cid[$i]'";
								$result2=$database->openConnectionWithReturn($query2);
								list($catname)=mysql_fetch_array($result2);
								$pat="\'";
								$replace="\\\\'";
								$catname=eregi_replace($pat, $replace, $catname);
								$pat="'";
								$replace="\\'";
								$catname=eregi_replace($pat, $replace, $catname);
								print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published links'); </SCRIPT>\n";
								}
							else {
								$query = "UPDATE categories SET published='1' WHERE " . $mpre . "categoryid='$cid[$j]'";
								$database->openConnectionNoReturn($query);
								}
							}
						}
					elseif ($option == "Faq"){
						$query = "SELECT checked_out FROM " . $mpre . "faqcont WHERE artid='$cid[$i]'";
						$result = $database->openConnectionWithReturn($query);
						while ($row = mysql_fetch_object($result)){
							$checked = $row->checked_out;
							}

						if ($checked == 1){
							print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
							exit(0);
							}

						for ($i = 0; $i < count($cid); $i++){
							$query = "SELECT artid FROM " . $mpre . "faqcont WHERE faqid='$cid[$i]' and published=1";
							$result = $database->openConnectionWithReturn($query);
							if (mysql_num_rows($result)==0){
								$query2="select categoryname from " . $mpre . "categories where categoryid='$cid[$i]'";
								$result2=$database->openConnectionWithReturn($query2);
								list($catname)=mysql_fetch_array($result2);
								$pat="'";
								$replace="\\'";
								$catname=eregi_replace($pat, $replace, $catname);
								print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published faqs'); </SCRIPT>\n";
							}
							else {
								$query = "UPDATE " . $mpre . "categories SET published='1' WHERE categoryid='$cid[$i]'";
								$database->openConnectionNoReturn($query);
								}
							}
						}
					elseif ($option == "Articles"){
						$query = "SELECT checked_out FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
						$result = $database->openConnectionWithReturn($query);
						while ($row = mysql_fetch_object($result)){
							$checked = $row->checked_out;
							}

						if ($checked == 1){
							print "<SCRIPT>alert('This category cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
							exit(0);
							}

						for ($i = 0; $i < count($cid); $i++){
							$query = "SELECT * FROM " . $mpre . "articles WHERE secid='$cid[$i]'";
							$result = $database->openConnectionWithReturn($query);
							if (mysql_num_rows($result) > 0){
								$query = "SELECT artid FROM " . $mpre . "articles WHERE secid='$cid[$i]' and published=1";
								$result = $database->openConnectionWithReturn($query);
								if (mysql_num_rows($result)==0){
									$query2="select categoryname from " . $mpre . "categories where categoryid='$cid[$i]'";
									$result2=$database->openConnectionWithReturn($query2);
									list($catname)=mysql_fetch_array($result2);
									$pat="'";
									$replace="\\'";
									$catname=eregi_replace($pat, $replace, $catname);
									print "<SCRIPT>alert('Category \"$catname\" cannot be published because it has no published articles');</SCRIPT>\n";
									}
								else {
									$query = "UPDATE " . $mpre . "categories SET published='1' WHERE categoryid='$cid[$i]'";
									$database->openConnectionNoReturn($query);
									}
								}
							else {
								print "<SCRIPT>alert('Cannot publish category, doesn\'t contain articles');</SCRIPT>\n";
								}
							}
						}
					}
				}
			elseif (isset($uid)){
				if ($option == "Articles"){
					$query = "SELECT * FROM " . $mpre . "articles WHERE secid='$uid'";
					$result = $database->openConnectionWithReturn($query);
					if (mysql_num_rows($result) > 0){
						$query = "UPDATE " . $mpre . "categories SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						}
					else {
						$query = "UPDATE " . $mpre . "categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						print "<SCRIPT>alert('Category cannot be published because it contains no articles.');</SCRIPT>\n";
						}
					}
				if ($option == "News"){
					$query = "SELECT * FROM " . $mpre . "stories WHERE topic='$uid'";
					$result = $database->openConnectionWithReturn($query);
					if (mysql_num_rows($result) > 0){
						$query = "UPDATE " . $mpre . "categories SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						}
					else {
						$query = "UPDATE " . $mpre . "categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						print "<SCRIPT>alert('Category cannot be published because it contains no news.');</SCRIPT>\n";
						}
					}
				if ($option == "Faq"){
					$query = "SELECT * FROM " . $mpre . "faqcont WHERE faqid='$uid'";
					$result = $database->openConnectionWithReturn($query);
					if (mysql_num_rows($result) > 0){
						$query = "UPDATE " . $mpre . "categories SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						}
					else {
						$query = "UPDATE " . $mpre . "categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						print "<SCRIPT>alert('Category cannot be published because it contains no faq\'s.');</SCRIPT>\n";
						}
					}
				if ($option == "Weblinks"){
					$query = "SELECT * FROM " . $mpre . "links WHERE cid='$uid'";
					$result = $database->openConnectionWithReturn($query);
					if (mysql_num_rows($result) > 0){
						$query = "UPDATE " . $mpre . "links SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						}
					else {
						$query = "UPDATE " . $mpre . "categories SET editor=NULL, checked_out=0, checked_out_time='00:00:00', categoryname='$categoryname', categoryimage='$image', image_position='$position' WHERE categoryid='$uid'";
						$database->openConnectionNoReturn($query);
						print "<SCRIPT>alert('Category cannot be published because it contains no weblinks.');</SCRIPT>\n";
						}
					}
				}
			else {
				print "<SCRIPT> alert('Select a category to publish'); window.history.go(-1);</SCRIPT>\n";
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories';</SCRIPT>\n";
			}

		function unpublishcategory($option, $database, $uid, $cid, $mpre){
			if (count($cid) > 0){
				$query = "SELECT checked_out FROM " . $mpre . "stories WHERE sid='$cid[0]'";
				$result = $database->openConnectionWithReturn($query);

				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					}

				if ($checked == 1){
					print "<SCRIPT>alert('This category cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
					exit(0);
					}

				for ($i = 0; $i < count($cid); $i++){
					$query = "UPDATE " . $mpre . "categories SET published='0' WHERE categoryid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($uid)){
				$query = "UPDATE " . $mpre . "categories SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE categoryid='$uid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				print "<SCRIPT> alert('Select a category to unpublish'); window.history.go(-1);</SCRIPT>\n";
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option&act=categories';</SCRIPT>\n";
			}
		}
?>
