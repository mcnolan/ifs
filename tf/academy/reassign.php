<?php
/***
  * INTEGRATED FLEET MANAGEMENT SYSTEM
  * OBSIDIAN FLEET
  * http://www.obsidianfleet.net/ifs/
  *
  * Developer:	Frank Anon
  * 	    	fanon@obsidianfleet.net
  *
  * Updated By: David VanScott
  *		davidv@anodyne-productions.com
  *
  * Version:	1.14n
  * Release Date: June 3, 2004
  * Patch 1.13n:  December 2009
  * Patch 1.14n:  March 2010
  *
  * Copyright (C) 2003-2004 Frank Anon for Obsidian Fleet RPG
  * Distributed under the terms of the GNU General Public License
  * See doc/LICENSE for details
  *
  * This file contains code from Mambo Site Server 4.0.12
  * Copyright (C) 2000 - 2002 Miro International Pty Ltd
  *
  * Date:	6/13/04
  * Comments: Admin interface for Academy settings and stuffs
  *
  * See CHANGELOG for patch details
  *
***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	?>
	<br /><center>
	Welcome to Academy Tools<br />
	Please note that your login will time out after about 10 minutes of inactivity.
	</center><br /><br />
	
	<h2>Reassign Academy Students</h2>
	<p>Using the fields below, you can select a character and a new instructor so the student can be reassigned. <strong>Note:</strong> the list of students only shows students who have started their course within the last 90 days.</p><br />

    <?php
    if (!$lib)
    {
		$qry = "SELECT course, name FROM {$spre}acad_courses WHERE active = 1 AND section = 0";
	    $result = $database->openConnectionWithReturn($qry);
	
		while ($fetch = mysql_fetch_assoc($result)) {
			extract($fetch, EXTR_OVERWRITE);
			
			if ($course == 3 || $course == 12 || $course == 13 || $course == 14)
			{
				$array[$course] = array(
					'course' => $name,
					'students' => array()
				);
			}
		}
		
		$today = getdate();
		$constraint = 86400 * 90;
		$date = $today[0] - $constraint;
		
		$qry = "SELECT a.*, b.* FROM {$spre}acad_students AS a, {$spre}characters AS b WHERE a.status = 'p' AND b.id = a.cid AND a.sdate >= '$date'";
		$result = $database->openConnectionWithReturn($qry);
		
		while ($fetch = mysql_fetch_assoc($result)) {
			extract($fetch, EXTR_OVERWRITE);
			
			$array[$course]['students'][] = array(
				'cid' => $cid,
				'name' => $name
			);
		}
		
		echo '<form method="post" action="index.php?option=ifs&task=academy&action=reassign&lib=move">';
		
		echo '<b>Student:</b> &nbsp;&nbsp; <select name="character">';
		
		foreach ($array as $key => $value)
		{
			echo '<optgroup label="'. $value['course'] .'">';
			
			foreach ($value['students'] as $a => $b)
			{
				echo '<option value="'. $b['cid'] .','. $key .'">'. $b['name'] .'</option>';
			}
			
			echo '</optgroup>';
		}
		
		echo '</select>';
		
	    $qry = "SELECT a.*, b.* FROM {$spre}acad_instructors AS a, {$spre}characters AS b WHERE a.active = 1 AND a.cid = b.id";
		$result = $database->openConnectionWithReturn($qry);
		
		while ($fetch = mysql_fetch_array($result)) {
			extract($fetch, EXTR_OVERWRITE);
			
			$array[$course]['instructors'][] = array(
				'id' => $fetch[0],
				'name' => $fetch[6]
			);
		}
		
		echo '<br /><br />';
		
		echo '<b>Instructor:</b> &nbsp;&nbsp; <select name="instructor">';
		
		foreach ($array as $key => $value)
		{
			echo '<optgroup label="'. $value['course'] .'">';
			
			foreach ($value['instructors'] as $a => $b)
			{
				echo '<option value="'. $b['id'] .'">'. $b['name'] .'</option>';
			}
			
			echo '</optgroup>';
		}
		
		echo '</select>';
		
		echo '<br /><br />';
		
		echo '<input type="submit" name="submit" value="Submit" />';
		
		echo '</form>';
    }
    else if ($lib == "move")
    {
		$info = explode(',', $_POST['character']);
		$instructor = $_POST['instructor'];
		
		if (is_numeric($info[0]) && is_numeric($instructor) && is_numeric($info[1]))
		{
			$qry = "UPDATE {$spre}acad_students SET inst = $instructor WHERE cid = $info[0] AND course = $info[1]";
			$result = $database->openConnectionWithReturn($qry);
			//$rows = mysql_affected_rows($result);
			
			echo 'Student instructor was successfully updated! <a href="index.php?option=ifs&task=academy&action=reassign">Click here</a> to reassign another student.';
		}
    }
}
?>
