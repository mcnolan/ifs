<?PHP
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
	 *	File Name: components.php
	 *	Developers: Danny Younes - danny@miro.com.au
	 *				Nicole Anderson - nicole@miro.com.au
	 *	Date: 27-11-2002
	 * 	Version #: 4.0.11
	 *	Comments:
	**/

	class components {
		function viewcomponents($database, $componentshtml, $option, $mpre){
			$query = "SELECT id, title, publish, checked_out, editor, ordering, position, module FROM " . $mpre . "components ORDER BY position, ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$id[$i] = $row->id;
				$title[$i] = $row->title;
				$publish[$i] = $row->publish;
				$checkedout[$i] = $row->checked_out;
				$editor[$i] = $row->editor;
				$ordering[$i] = $row->ordering;
				$position[$i] = $row->position;
				$module[$i] = $row->module;
				$i++;
				}
			$componentshtml->showComponents($id, $title, $option, $publish, $editor, $ordering, $position, $module);
			}

		function addComponent($database, $componentshtml, $option, $text_editor, $mpre){
			$query = "SELECT ordering FROM " . $mpre . "components WHERE position='left' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$leftorder[$i] = $row->ordering;
				$i++;
				}
			mysql_free_result($result);

			$query = "SELECT ordering FROM " . $mpre . "components WHERE position='right' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$rightorder[$i] = $row->ordering;
				$i++;
				}
			mysql_free_result($result);

			$componentshtml->addComponent($leftorder, $rightorder, $option, $text_editor);
			}

		function saveComponent($database, $title, $content, $position, $order, $mpre){
			if (($title == "") || ($content == "")){
				print "<SCRIPT> alert('Please complete the Title and Content fields'); window.history.go(-1); </SCRIPT>\n";
				}

			$query = "SELECT title FROM " . $mpre . "components WHERE title='$title'";
			$result = $database->openConnectionWithReturn($query);
			$num = mysql_num_rows($result);
			if ($num > 0){
				print "<SCRIPT> alert('There is a component already with that title, please try again!'); window.history.go(-1); </SCRIPT>\n";
				}

			$query = "INSERT INTO " . $mpre . "components SET title='$title', position='$position', ordering='$order', checked_out_time='00:00:00', publish='no'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT ordering, id, title FROM " . $mpre . "components WHERE ordering >= '$order' AND position='$position' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$numItems = mysql_num_rows($result);
			for ($i = 0; $i < $numItems; $i++){
				list($ordering, $id, $titleComponent) = mysql_fetch_row($result);
				if ($titleComponent <> $title){
					$ordering++;
					$query = "UPDATE " . $mpre . "components SET ordering='$ordering' WHERE id='$id'";
					$database->openConnectionNoReturn($query);
					}
				}

			$query = "SELECT id FROM " . $mpre . "components WHERE title='$title'";

			$result = $database->openConnectionWithReturn($query);
			while($row = mysql_fetch_object($result)){
				$id = $row->id;
				}

			mysql_free_result($result);

			$query = "INSERT INTO " . $mpre . "component_module SET content='$content', componentid='$id'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT MAX(id) AS maximum FROM " . $mpre . "components";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$max = $row->maximum;
				}
			?>
			<SCRIPT>document.location.href="index2.php?option=Components"</SCRIPT>
			<?}

		function editComponent($componentshtml, $database, $option, $componentid, $myname, $text_editor, $mpre){
			if ($componentid == ""){
				print "<SCRIPT> alert('Select a component to edit'); window.history.go(-1);</SCRIPT>\n";
				}

			$query = "SELECT title, checked_out, editor FROM " . $mpre . "components WHERE id='$componentid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				$title = $row->title;
				$editor = $row->editor;
				}
			$stringcmp = strcmp($editor,$myname);
			if (($checked == 1) && ($stringcmp <> 0)){
				print "<SCRIPT>alert('The component $title is currently being edited by another administrator'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				exit(0);
				}

			$date = date("H:i:s");
			$query = "UPDATE " . $mpre . "components SET checked_out='1', checked_out_time='$date', editor='$myname' WHERE id='$componentid'";
			$database->openConnectionNoReturn($query);

			$query = "SELECT ordering FROM " . $mpre . "components WHERE position='left' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$leftorder[$i] = $row->ordering;
				$i++;
				}
			mysql_free_result($result);

			$query = "SELECT ordering FROM " . $mpre . "omponents WHERE position='right' ORDER BY ordering";
			$result = $database->openConnectionWithReturn($query);
			$i = 0;
			while ($row = mysql_fetch_object($result)){
				$rightorder[$i] = $row->ordering;
				$i++;
				}
			mysql_free_result($result);

			$query = "SELECT ordering, title, position, module FROM " . $mpre . "components WHERE components.id='$componentid'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$ordering = $row->ordering;
				$title = $row->title;
				$position = $row->position;
				$module = $row->module;

				if ($module == ""){
					$query2 = "SELECT content FROM " . $mpre . "component_module WHERE componentid='$componentid'";
					$result2 = $database->openConnectionWithReturn($query2);
					while ($row2 = mysql_fetch_object($result2)){
						$content = $row2->content;
						}
					}
				}

			$componentshtml->editComponent($componentid, $title, $content, $position, $option, $leftorder, $rightorder, $ordering, $module, $text_editor);
			}

		function saveeditcomponent($html, $database, $title, $content, $position, $show, $componentid, $order, $original, $myname, $module, $mpre){
			if (($title == "") || (($content == "") && (!isset($module)))){
				print "<SCRIPT> alert('Please complete the title and content fields'); window.history.go(-1); </SCRIPT>\n";
				}

			if ($show == ""){
				$show = "false";
				}
			else {
				$show = "true";
				}

			$query = "SELECT * FROM " . $mpre . "components WHERE id='$componentid' AND checked_out=1 AND editor='$myname'";
			$result = $database->openConnectionWithReturn($query);
			if (mysql_num_rows($result) > 0){
				if ($original < $order){
					$query = "SELECT id, ordering FROM " . $mpre . "components WHERE ordering>='$original' AND ordering<='$order' AND position='$position' ORDER BY ordering ";
					$result = $database->openConnectionWithReturn($query);
					$i = 0;
					while ($row = mysql_fetch_object($result)){
						$id[$i] = $row->id;
						$changeorder[$i] = $row->ordering;
						$i++;
						}
					}
				elseif ($original > $order){
					$query = "SELECT id, ordering FROM " . $mpre . "components WHERE ordering<'$original' AND ordering>='$order' AND position='$position' ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					$i = 0;
					while ($row = mysql_fetch_object($result)){
						$id[$i] = $row->id;
						$changeorder[$i] = $row->ordering;
						$i++;
						}
					}


				if ($original < $order){
					for ($i = 0; $i < count($id); $i++){
						$query = "UPDATE " . $mpre . "components SET ordering=ordering-1 WHERE id='$id[$i]'";
						$database->openConnectionNoReturn($query);
						}
					}
				elseif ($original > $order){
					for ($i = 0; $i < count($id); $i++){
						$query = "UPDATE " . $mpre . "components SET ordering=ordering+1 WHERE id='$id[$i]'";
						$database->openConnectionNoReturn($query);
						}
					}

				$query = "UPDATE " . $mpre . "components SET title='$title', position='$position', ordering='$order', checked_out=0, checked_out_time='00:00:00', editor=NULL WHERE id='$componentid'";
				$database->openConnectionNoReturn($query);
				$query = "UPDATE " . $mpre . "component_module SET content='$content' WHERE componentid=$componentid";
				$database->openConnectionNoReturn($query);
				?>
				<SCRIPT>document.location.href="index2.php?option=Components"</SCRIPT>
				<?
				}
			else {
				print "<SCRIPT>alert('Your job has timed out, too bad'); document.location.href='index2.php?option=$option'</SCRIPT>\n";
				}
			}

		function removecomponent($database, $option, $cid, $mpre){
			if (count($cid) == 0){
				print "<SCRIPT> alert('Select a component to delete'); window.history.go(-1);</SCRIPT>\n";
				}

			$query = "SELECT checked_out FROM " . $mpre . "components WHERE id='$cid[0]'";
			$result = $database->openConnectionWithReturn($query);
			while ($row = mysql_fetch_object($result)){
				$checked = $row->checked_out;
				}

			if ($checked == 1){
				print "<SCRIPT>alert('This component cannot be deleted because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
				exit(0);
				}

			for ($i = 0; $i < count($cid); $i++){
				$query = "SELECT position FROM " . $mpre . "components WHERE id='$cid[$i]'";
				$result = $database->openConnectionWithReturn($query);
				list($deleteposition)=mysql_fetch_array($result);

				$query = "DELETE FROM " . $mpre . "components WHERE id='$cid[$i]'";
				$database->openConnectionNoReturn($query);
				$query = "DELETE FROM " . $mpre . "component_module WHERE componentid='$cid[$i]'";
				$database->openConnectionNoReturn($query);


				if ($deleteposition=="right"){
					$query = "SELECT id FROM " . $mpre . "components WHERE position='right' ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					$b = 1;
					while ($row = mysql_fetch_object($result)){
						$query = "UPDATE " . $mpre . "components SET ordering='$b' WHERE id='$row->id'";
						$database->openConnectionNoReturn($query);
						$b++;
					}
				}else{
					$query = "SELECT id FROM " . $mpre . "components WHERE position='left' ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					$b = 1;
					while ($row = mysql_fetch_object($result)){
						$query = "UPDATE " . $mpre . "components SET ordering='$b' WHERE id='$row->id'";
						$database->openConnectionNoReturn($query);
						$b++;
					}
				}
			}
			print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
		}

		function publishComponent($database, $option, $cid, $componentid, $title, $content, $position, $order, $original, $mpre){
			if (count($cid) > 0){
				$query = "SELECT checked_out, editor FROM " . $mpre . "components WHERE id='$cid[0]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					$editor = $row->editor;
					}

				if ($checked == 1){
					print "<SCRIPT>alert('This component cannot be unpublished because it is being edited by $editor'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
					exit(0);
					}

				for ($i = 0; $i < count($cid); $i++){
					$query = "UPDATE " . $mpre . "components SET publish='1' WHERE id='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($componentid)){
				if ($original < $order){
					$query = "SELECT id, ordering FROM " . $mpre . "components WHERE ordering>='$original' AND ordering<='$order' AND position='$position' ORDER BY ordering ";
					$result = $database->openConnectionWithReturn($query);
					$i = 0;
					while ($row = mysql_fetch_object($result)){
						$id[$i] = $row->id;
						$changeorder[$i] = $row->ordering;
						$i++;
						}
					}
				elseif ($original > $order){
					$query = "SELECT id, ordering FROM " . $mpre . "components WHERE ordering<'$original' AND ordering>='$order' AND position='$position' ORDER BY ordering";
					$result = $database->openConnectionWithReturn($query);
					$i = 0;
					while ($row = mysql_fetch_object($result)){
						$id[$i] = $row->id;
						$changeorder[$i] = $row->ordering;
						$i++;
						}
					}


				if ($original < $order){
					for ($i = 0; $i < count($id); $i++){
						$query = "UPDATE " . $mpre . "components SET ordering=ordering-1 WHERE id='$id[$i]'";
						$database->openConnectionNoReturn($query);
						}
					}
				elseif ($original > $order){
					for ($i = 0; $i < count($id); $i++){
						$query = "UPDATE " . $mpre . "components SET ordering=ordering+1 WHERE id='$id[$i]'";
						$database->openConnectionNoReturn($query);
						}
					}

				$query = "UPDATE " . $mpre . "components SET publish='1', editor=NULL, checked_out=0, checked_out_time='00:00:00', title='$title', ordering='$order' WHERE id='$componentid'";
				$database->openConnectionNoReturn($query);
				}
			else {
				print "<SCRIPT> alert('Select a component to publish'); window.history.go(-1);</SCRIPT>\n";
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
			}

		function unpublishComponent($database, $option, $componentid, $cid, $mpre){
			if (count($cid) > 0){
				$query = "SELECT checked_out FROM " . $mpre . "components WHERE id='$cid[0]'";
				$result = $database->openConnectionWithReturn($query);
				while ($row = mysql_fetch_object($result)){
					$checked = $row->checked_out;
					}

				if ($checked == 1){
					print "<SCRIPT>alert('This component cannot be unpublished because it is being edited by another administrator'); document.location.href='index2.php?option=$option';</SCRIPT>\n";
					exit(0);
					}

				for ($i = 0; $i < count($cid); $i++){
					$query = "UPDATE " . $mpre . "components SET publish='0' WHERE id='$cid[$i]'";
					$database->openConnectionNoReturn($query);
					}
				}
			elseif (isset($componentid)) {
				$query = "UPDATE " . $mpre . "components SET publish='0' WHERE id='$componentid'";
				$database->openConnectionNoReturn($query);

				$query = "UPDATE " . $mpre . "components SET editor=NULL, checked_out=0, checked_out_time='00:00:00'";
				$database->openConnectionNoReturn($query);
				}
			else {
				print "<SCRIPT> alert('Select a component to unpublish'); window.history.go(-1);</SCRIPT>\n";
				exit(0);
				}
			print "<SCRIPT>document.location.href='index2.php?option=$option';</SCRIPT>\n";
			}
		}
?>