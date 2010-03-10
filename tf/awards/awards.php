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
  * Date:	12/22/03
  * Comments: Awards Admin - edit/add/delete awards
 ***/

if (!defined("IFS"))
	echo "Hacking attempt!";
else
{
	echo "<h1>Awards Admin</h1>\n";

	if (!$aid)
    {
		$qry = "SELECT id, name, level, intro FROM {$spre}awards
        		WHERE active='1' ORDER BY level ASC, name";
	    $result = $database->openConnectionWithReturn($qry);
	    while (list($aid, $name, $level, $intro) = mysql_fetch_array($result)) {
		    echo "(<a href=\"index.php?option=ifs&amp;task=awards&amp;action=edit&amp;aid={$aid}\">edit</a>) $name - Level $level<br />\n";
			echo "<blockquote>$intro</blockquote>\n";
            echo "<br /><br />\n";
        }
        echo "<a href=\"index.php?option=ifs&amp;task=awards&amp;action=edit&amp;aid=add\">Add an Award</a>\n";
        echo "<br /><br />\n";

        echo "<h2>Discontinued Awards</h2>\n";
		$qry = "SELECT id, name FROM {$spre}awards WHERE active='0' ORDER BY level ASC, name";
	    $result = $database->openConnectionWithReturn($qry);
	    while (list($aid, $name) = mysql_fetch_array($result))
		    echo "(<a href=\"index.php?option=ifs&amp;task=awards&amp;action=edit&amp;aid={$aid}\">edit</a>) $name<br />\n";
        echo "<br />\n";
    }
    else
    {
    	if ($aid != "add")
        {
			$qry = "SELECT name, image, level, active, intro, descrip
            		FROM {$spre}awards WHERE id='$aid'";
		    $result = $database->openConnectionWithReturn($qry);
		    list($name, $image, $level, $active, $intro, $descrip) = mysql_fetch_array($result);
        }
        ?>

        <form action="index.php?option=ifs&amp;task=awards&amp;action=save" method="post">
		   	<input type="hidden" name="aid" value="<?php echo $aid ?>" />
		    name: <input type="text" name="aname" value="<?php echo $name ?>" /><br />
	        Level: <input type="text" name="level" value="<?php echo $level ?>" /><br />
			Image: <input type="text" name="image" value="<?php echo $image ?>" /><br />
            <br />
            Intro:<br />
            <textarea name="intro" cols="60" rows="4"><?php echo $intro ?></textarea>
            <br /><br />
            Description:<br />
            <textarea name="descrip" cols="60" rows="4"><?php echo $descrip ?></textarea>
            <br /><br />
            <input type="submit" value="Submit" />
        </form>

		<?php
        if ($aid != "add")
        {
            if ($active == "1")
                $submitname = "Discontinue this award";
            else
                $submitname = "Revive this award";
        	?>
	        <form action="index.php?option=ifs&amp;task=awards&amp;action=del" method="post">
			   	<input type="hidden" name="aid" value="<?php echo $aid ?>" />
	          	<input type="submit" value="<?php echo $submitname ?>">
	      	</form>
        	<?php
        }
    }
}
?>