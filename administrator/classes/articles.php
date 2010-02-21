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
	 *	File Name: articles.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class articles {
		function showArticles($option, $articleshtml, $database, $categories, $mpre){
			$query = "SELECT categoryid, categoryname FROM " . $mpre . "categories WHERE section='Articles' order by categoryname";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$categoryid[$i] = $row->categoryid;
				$categoryname[$i] = $row->categoryname;
				$i++;
				}
			mysql_free_result($result);

			if ($categories == "all"){
				$query = "SELECT artid, title, approved, author, secid, published, checked_out, editor, archived FROM " . $mpre . "articles ORDER BY title";
				$result = $database->openConnectionWithReturn($query);
			}elseif ($categories == "new"){
				$query = "SELECT artid, title, approved, author, secid, published, checked_out, editor, archived FROM " . $mpre . "articles WHERE approved=0 ORDER BY title";
				$result = $database->openConnectionWithReturn($query);
			}elseif ($categories <> ""){
				$query = "SELECT artid, title, approved, author, secid, published, checked_out, editor, archived FROM " . $mpre . "articles WHERE secid=$categories ORDER BY ordering, secid";
				$result = $database->openConnectionWithReturn($query);
			}

			if ($categories <> ""){
				$i = 0;
				while ($row = mysql_fetch_object($result)){
					$artid[$i] = $row->artid;
					$title[$i] = $row->title;
					$approved[$i]= $row->approved;
					$author[$i]= $row->author;
					$secid[$i]=$row->secid;
					$published[$i] = $row->published;
					$checkedout[$i] = $row->checked_out;
					$editor[$i] = $row->editor;
					$archived[$i] = $row->archived;
					$query2="select name, usertype from " . $mpre . "users where id='$userID[$i]'";
					$result2= $database->openConnectionWithReturn($query2);
					list ($authorName[$i], $usertype[$i])=mysql_fetch_array($result2);
					mysql_free_result($result2);
					$i++;
					}
				mysql_free_result($result);
				}
			$articleshtml->showArticles($artid, $title, $approved, $author, $usertype, $option, $published, $checkedout, $editor, $archived, $categoryid, $categoryname, $categories);
			}

		function editArticle($articleshtml, $database, $option, $artid, $myname, $categories, $text_editor, $mpre){
			if ($artid == ""){
				print "<SCRIPT> alert('Select an article to edit'); window.history.go(-1);</SCRIPT>\n";
				}

			$query = "SELECT categoryname, categoryid FROM " . $mpre . "categories WHERE section='Articles'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			$ordering = Array();
			while ($row = mysql_fetch_object($result)){
				$categorycid[$i] = $row->categoryid;
				$categorytitle[$i] = $row->categoryname;
				$query = "SELECT * FROM " . $mpre . "articles WHERE secid=$categorycid[$i]";

				$result2 = $database->openConnectionWithReturn($query);
				$count = mysql_num_rows($result2);
				$ordering["$categorytitle[$i]"] = $count;
				mysql_free_result($result2);
				$i++;
				}
			$query = "SELECT title, checked_out, editor FROM " . $mpre . "articles WHERE artid='$artid'";
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
			$query = "UPDATE " . $mpre . "articles SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE artid='$artid'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT " . $mpre . "articles.artid AS artid, " . $mpre . "articles.secid AS secid, " . $mpre . "articles.author AS author, " . $mpre . "articles.ordering AS ordering, " . $mpre . "articles.title AS title, " . $mpre . "articles.content AS content,
					  " . $mpre . "categories.categoryname AS secname, " . $mpre . "categories.categoryid AS secsecid FROM " . $mpre . "articles, " . $mpre . "categories WHERE " . $mpre . "articles.artid='$artid' AND
					  " . $mpre . "categories.categoryid=" . $mpre . "articles.secid";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$secid = $row->secid;
				$artid = $row->artid;
				$author = $row->author;
				$title = $row->title;
				$content = $row->content;
				$secname = $row->secname;
				$secsecid = $row->secsecid;
				$orderingarticles = $row->ordering;
				}
			mysql_free_result($result);

			$query = "SELECT MAX(ordering) AS maxnum FROM " . $mpre . "articles WHERE secid='$secid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$maxnum = $row->maxnum;
				}

			$query = "SELECT categoryid, categoryname, categoryimage FROM " . $mpre . "categories where section='Articles'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$sectionsecid[$i] = $row->categoryid;
				$sectionname[$i] = $row->categoryname;
				$sectionimage[$i] = $row->categoryimage;
				$i++;
			}
			$articleshtml->editarticle($secid, $artid, $title, $content, $secname, $secsecid, $sectionsecid, $sectionname, $sectionimage, $option, $task, $ordering, $maxnum, $categorycid, $categorytitle, $orderingarticles, $categories, $author, $text_editor);
		}

		function saveeditarticle($database, $option, $title, $artid, $content, $article, $task, $original, $ordering, $porder, $myname, $secsecid, $pcategory, $categories, $author, $mpre){
			$ordering=0;
			$porder=0;
			if (($title == "") || ($content == "")){
				print "<SCRIPT> alert('Please complete the Title and Content fields'); window.history.go(-1); </SCRIPT>\n";
				}

			$query = "SELECT * FROM " . $mpre . "articles WHERE artid='$artid' AND checked_out=1 AND editor='$myname'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) == 1){
				if (($ordering > $porder) && ($pcategory == $article)){
					$query = "SELECT artid FROM " . $mpre . "articles WHERE ordering<='$ordering' AND ordering > $porder WHERE secid=$article ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$articleid = $row->artid;
						$query = "UPDATE " . $mpre . "articles SET ordering=ordering - 1 WHERE artid=$artid";
						$database->openConnectionNoReturn($query);
						}
					}
				elseif (($ordering < $porder) && ($pcategory == $article)){
					$query = "SELECT artid FROM " . $mpre . "articles WHERE ordering >= $ordering AND ordering < $porder secid=$article ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$articleid = $row->artid;
						$query = "UPDATE " . $mpre . "articles SET ordering=ordering+1 WHERE artid=$artid";
						$database->openConnectionNoReturn($query);
						}
					}
				else {
					$query = "SELECT artid FROM " . $mpre . "articles WHERE ordering > $porder AND secid=$pcategory ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$query = "UPDATE " . $mpre . "articles SET ordering=ordering-1 WHERE artid='$row->artid'";
						$database->openConnectionNoReturn($query);
						}

					$query = "SELECT artid FROM " . $mpre . "articles WHERE ordering >= $ordering AND secid=$article ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$query = "UPDATE " . $mpre . "articles SET ordering=ordering+1 WHERE artid='$row->artid'";
						$database->openConnectionNoReturn($query);
						}
					}

				$query = "UPDATE " . $mpre . "articles SET secid='$article', title='$title', content='$content', author='$author', checked_out=0, checked_out_time='00:00:00', editor=NULL, ordering=$ordering WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				$query = "UPDATE " . $mpre . "articles SET secid='$article', title='$title', content='$content', author='$author', checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				}

			if ($original == "approvearticle")
				print "<SCRIPT>document.location.href='index2.php?option=$option&task=approvearticle&artid=$artid&categories=$categories'</SCRIPT>\n";
			else
				print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			}

		function addArticle($database, $option, $articleshtml, $categories, $text_editor, $mpre){
			$query = "SELECT categoryname, categoryid FROM " . $mpre . "categories WHERE section='Articles'";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			$ordering = Array();
			while ($row = mysql_fetch_object($result)){
				$categorycid[$i] = $row->categoryid;
				$categorytitle[$i] = $row->categoryname;
				$query = "SELECT * FROM " . $mpre . "articles WHERE secid=$categorycid[$i]";
				$result2 = $database->openConnectionWithReturn($query);
				$count = mysql_num_rows($result2);
				$ordering["$categorytitle[$i]"] = $count;

				$i++;
				}
			$articleshtml->addArticle($categorycid, $categorytitle, $option, $ordering, $categories, $text_editor);
			}

		function savenewarticle($database, $option, $title, $content, $category, $ordering, $uid, $author, $categories, $mpre){
			if (($title == "") || ($content == "") || ($category == "")){
				print "<SCRIPT> alert('Please complete the Title, Content and Section fields.'); window.history.go(-1); </SCRIPT>\n";
				}

			if ($ordering==""){
				$ordering=0;
			}

			$date=date("Y-m-d");
			$query = "INSERT INTO " . $mpre . "articles SET title='$title', content='$content', secid='$category', date='$date', ordering=$ordering, author='$author', approved=1";
			$database->openConnectionNoReturn($query);
			$query = "SELECT MAX(artid) AS art FROM " . $mpre . "articles";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$art = $row->art;
				}
			//print "<SCRIPT>document.location.href='index2.php?option=$option&cid%5B%5D=$art&task=edit&categories=$categories'</SCRIPT>\n";
			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			}

		function approvearticle($database, $option, $artid, $categories, $category, $author, $content, $title, $mpre){
			$query = "UPDATE " . $mpre . "articles SET approved=1, checked_out=0, checked_out_time='00:00:00', editor=NULL, secid=$category, author='$author', content='$content', title='$title', published='1' WHERE artid=$artid";
			$database->openConnectionNoReturn($query);

			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
			}

		function disapproveArticle($database, $option, $articleshtml, $artid, $mpre){
			if (count($artid)!=0){
				for ($i=0; $i < count($artid); $i++){
					$query="update " . $mpre . "articles set approved=0 where artid='$artid[$i]'";
					$database->openConnectionNoReturn($query);
				}
			}else{
				echo "<SCRIPT> alert('Select an article to disapprove'); window.history.go(-1);</SCRIPT>\n";
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option'</SCRIPT>\n";
		}

		function removearticle($database, $option, $cid, $categories, $myname, $mpre){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT * FROM " . $mpre . "articles WHERE artid=$cid[$i]";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					if ($row->checked_out == 1){
						$editor=$row->editor;
						if ($editor != $myname){
							print "<SCRIPT>alert('This article cannot be deleted because it is currently checked out'); window.history.go(-1);</SCRIPT>\n";
							exit();
						}
					}
					$approved=$row->approved;
					$content=$row->content;
				}
			}

			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT secid FROM" . $mpre . "articles WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$topic = $row->secid;
				}

				$query = "DELETE FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);

				$query = "SELECT * FROM " . $mpre . "articles WHERE secid='$topic'";
				$result = $database->openConnectionWithReturn($query);
				$count = mysql_num_rows($result);
				if ($count == 0){
					$query = "UPDATE " . $mpre . "categories SET published=0 WHERE categoryid='$topic'";
					$database->openConnectionNoReturn($query);
				}
			}

			$query = "SELECT artid FROM " . $mpre . "articles ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 1;
			while ($row = mysql_fetch_object($result)){
				$sid = $row->artid;
				$query = "UPDATE " . $mpre . "articles SET ordering=$i WHERE artid=$sid";
				$database->openConnectionNoReturn($query);
				$i++;
			}

			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories'</SCRIPT>\n";
		}

		function publisharticle($database, $option, $cid, $artid, $myname, $categories, $mpre){
			if (count($cid) > 0){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT approved FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$approve = $row->approved;
						}

					if ($approve == 0){
						print "<SCRIPT>alert('This article cannot be published, still waiting approval'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
						}

					$query = "SELECT checked_out FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
						}

					if ($checked == 1){
						print "<SCRIPT>alert('This article cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
						}

					$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "articles WHERE " . $mpre . "articles.secid=" . $mpre . "categories.categoryid AND " . $mpre . "articles.artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$isitpub = $row->catpub;
						$topic = $row->topic;
						}

					if ($isitpub == 0){
						$query = "UPDATE " . $mpre . "articles SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
						$database->openConnectionNoReturn($query);
						$query = "UPDATE " . $mpre . "categories SET published=1 WHERE categoryid='$topic'";
						$database->openConnectionNoReturn($query);
						}
					mysql_free_result($result);

					$query = "UPDATE " . $mpre . "articles SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($artid)){
				$query = "SELECT approved FROM " . $mpre . "articles WHERE artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$approve = $row->approved;
					}

				if ($approve == 0){
					print "<SCRIPT>alert('This article cannot be published, still waiting approval'); document.location.href='index2.php?option=$option&task=approvearticle&artid=$artid&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "SELECT checked_out, editor FROM " . $mpre . "articles WHERE artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$editor = $row->editor;
					}

				if (($checked == 1) && ($myname <> $editor)){
					print "<SCRIPT>alert('This article cannot be published because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "articles WHERE " . $mpre . "articles.secid=" . $mpre . "categories.categoryid AND artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->published;
					$topic = $row->topic;
					}
				if ($isitpub == 0){
					$query = "UPDATE " . $mpre . "articles SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
					$database->openConnectionNoReturn($query);
					$query = "UPDATE " . $mpre . "categories SET published=1 WHERE categoryid='$topic'";
					$database->openConnectionNoReturn($query);
					}
				mysql_free_result($result);

				$query = "UPDATE " . $mpre . "articles SET published='1', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				print "<SCRIPT> alert('Select an article to publish'); window.history.go(-1);</SCRIPT>\n";
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
			}

		function unpublisharticle($database, $option, $cid, $artid, $myname, $categories, $mpre){
			if (count($cid) > 0){
				for ($i = 0; $i < count($cid); $i++){
					$query = "SELECT approved FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$approve = $row->approved;
						}

					if ($approve == 0){
						print "<SCRIPT>alert('This article cannot be published, still waiting approval'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
						}

					$query = "SELECT checked_out, editor FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$checked = $row->checked_out;
						$editor = $row->editor;
						}

					if (($checked == 1) && ($myname <> $editor)){
						print "<SCRIPT>alert('This article cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
						exit(0);
						}

					$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "articles WHERE " . $mpre . "articles.secid=" . $mpre . "categories.categoryid AND " . $mpre . "articles.artid='$cid[$i]'";
					$result = $database->openConnectionWithReturn($query);
					while ($row = mysql_fetch_object($result)){
						$isitpub = $row->catpub;
						$topic = $row->topic;
						}
					if ($isitpub == 1){
						unset($query);
						$query1 = "UPDATE " . $mpre . "articles SET published=0, editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
						$database->openConnectionNoReturn($query1);
						//added this check 3/9/01
						if (mysql_num_rows($result) == 0){
							$query2 = "UPDATE " . $mpre . "categories SET published=0 WHERE categoryid='$topic'";
							$database->openConnectionNoReturn($query2);
						}
					}
					mysql_free_result($result);

					$query = "UPDATE " . $mpre . "articles SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($artid)){
				$query = "SELECT approved FROM " . $mpre . "articles WHERE artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$approve = $row->approved;
					}

				if ($approve == 0){
					print "<SCRIPT>alert('This article cannot be published, still waiting approval'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "SELECT * FROM " . $mpre . "articles WHERE artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$editor = $row->editor;
					}

				if (($checked == 1) && ($myname <> $editor)){
					print "<SCRIPT>alert('This article cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "SELECT " . $mpre . "categories.published AS catpub, " . $mpre . "categories.categoryid AS topic FROM " . $mpre . "categories, " . $mpre . "articles WHERE " . $mpre . "articles.secid=" . $mpre . "categories.categoryid AND " . $mpre . "articles.artid='$artid'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$isitpub = $row->published;
					$topic = $row->topic;
					}
				if ($isitpub == 1){
					$query = "UPDATE " . $mpre . "articles SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
					$database->openConnectionNoReturn($query);
					//added this check 3/9/01
					if (mysql_num_rows($result) == 0){
						$query = "UPDATE " . $mpre . "categories SET published=0 WHERE categoryid='$topic'";
						$database->openConnectionNoReturn($query);
					}
				}
				mysql_free_result($result);
				$query = "UPDATE " . $mpre . "articles SET published='0', editor=NULL, checked_out=0, checked_out_time='00:00:00' WHERE artid='$artid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				print "<SCRIPT> alert('Select an article to unpublish'); window.history.go(-1);</SCRIPT>\n";
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
			}

		function archivearticle($database, $option, $cid, $categories, $mpre){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT approved FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$approve = $row->approved;
					}
				mysql_free_result($result);

				if ($approve == 0){
					print "<SCRIPT>alert('This article cannot be archived, still waiting approval'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "UPDATE " . $mpre . "articles SET archived=1 WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				}
			}

		function unarchivearticle($database, $option, $cid, $categories, $mpre){
			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT approved FROM " . $mpre . "articles WHERE artid='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$approve = $row->approved;
					}
				mysql_free_result($result);

				if ($approve == 0){
					print "<SCRIPT>alert('This article cannot be unarchived, still waiting approval'); document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
					exit(0);
					}

				$query = "UPDATE " . $mpre . "articles SET archived=0 WHERE artid='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				print "<SCRIPT>document.location.href='index2.php?option=$option&categories=$categories';</SCRIPT>\n";
				}
			}
		}?>