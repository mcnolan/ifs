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
  * Date:	12/12/03
  * Comments: Sample Application
 ***/

if (!defined("IFS"))
{
	$relpath = "../";
	include("../configuration.php");
	include("../includes/header.php");
}

echo "<h1>Sample {$field}</h1><br />";

if ($app == "crew")
{
	if ($field == "bio")
    {
		?>

<textarea name="Character_Bio" rows="20" cols="80">
--- insert sample bio here ---
</textarea>


		<?
	}
    elseif ($field == "post")
    {
        ?>

<textarea name="Sample_Post" rows="20" cols="80">
--- insert sample post here ---
</textarea>

			<?
	}
}

if (!defined("IFS"))
{
	$no_back_to = "1";
	include ("../includes/footer.php");
}

?>