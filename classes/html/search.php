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
  * Date: 12/13/03
  * Comments: Search
 ***/

class search
{
    function openhtml()
    {
    	?>
        <table cellpadding="3" cellspacing="0" border="0" width="100%" class="newspane">
        <tr>
            <td class="articlehead" colspan="2">Search Engine</td>
        </tr>
        <tr>
            <td height="20" colspan="2">&nbsp;</td>
        </tr>
        <form action="index.php" method="post">
        <tr>
            <td colspan="2">
            	<input class="inputbox" type="text" name="searchword" value="<?echo $search ?>" size="30">
                &nbsp;<input class="button" type="submit" value="Search">
            </td>
        </tr>
        <input type="hidden" name="option" value="search">
        </form>
        <tr>
            <td height="20" colspan="2">&nbsp;</td>
        </tr>
    	<?php
    }

    function nokeyword()
    {
    	?>
        <tr>
            <td width="100%" colspan="2">Please enter search criteria</td>
        </tr>
    	<?php
    }

    function searchintro($searchword)
    {
    	?>
        <tr>
            <td width="100%" colspan="2">Search Keyword: <b><?php echo $searchword ?></b></td>
        </tr>
        <tr>
            <td>
    	<?php
    }

    function stories($id, $title, $time, $text, $searchword)
    {
    	?>
        <hr />
        <span class="componentheading">Stories Results</span><br />
        Number of results: <?php echo count($id) ?><br /><br />
        <ul>
        <?php
        for ($i=0; $i<count($id); $i++)
        {
            echo "<li><a href=\"index.php?option=news&task=viewarticle&sid={$id[$i]}\">";
            echo $title[$i] . "</a>, <span class=\"small\">{$time[$i]}</span><br />\n";

            $words = $text[$i];
            $words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
            $words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
            $words = preg_replace('/<!--.+?-->/','',$words);
            $words = preg_replace('/{.+?}/','',$words);
            $words = strip_tags($words);
            echo substr($words,0,200) . "&#133;</li><br /><br />\n";
        }
        echo "</ul>\n";
    }

    function articles($id, $title, $time, $text, $searchword)
    {
    	?>
        <hr />
        <span class="componentheading">Articles Results</span><br />
        Number of results: <?php echo count($id) ?><br /><br />
        <ul>
        <?
        for ($i=0; $i<count($id); $i++)
        {
            echo "<li><a href=\"index.php?option=articles&task=show&artid={$id[$i]}\">";
            echo $title[$i] . "</a><br />\n";

            $words = $text[$i];
            $words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
            $words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
            $words = preg_replace('/<!--.+?-->/','',$words);
            $words = preg_replace('/{.+?}/','',$words);
            $words = strip_tags($words);
            echo substr($words,0,300) . "&#133;</li><br /><br />\n";
        }
        echo "</ul>\n";
    }

    function faqs($id, $title, $text, $searchword)
    {
    	?>
        <hr />
        <span class="componentheading">FAQ Results</span><br />
        Number of results: <?php echo count($id) ?><br /><br />
        <ul>
        <?
        for ($i=0; $i<count($id); $i++)
        {
        	echo "<li><a href=\"index.php?option=faq&task=show&artid={$id[$i]}\">";
            echo $title[$i] . "</a><br />\n";

	        $words = $text[$i];
	        $words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
	        $words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
	        $words = preg_replace('/<!--.+?-->/','',$words);
	        $words = preg_replace('/{.+?}/','',$words);
	        $words = strip_tags($words);
	        echo substr($words,0,200) . "&#133;</li><br /><br />\n";
        }
        echo "</ul>\n";
    }

    function content($id, $mid, $heading, $content, $sublevel, $searchword)
    {
    	?>
        <hr />
        <span class="componentheading">Content Results</span><br />
        Number of results: <?php echo count($id) ?><br /><br />
        <ul>
        <?
        for ($i=0; $i<count($id); $i++)
        {
        	echo "<li><a href=\"index.php?option=displaypage&Itemid={$mid[$i]}&op=page&SubMenu=";
            if ($sublevel[$i] == 0)
            	echo $mid[$i];
            echo "\">{$heading[$i]}</a><br />";

            $words = $content[$i];
            $words = preg_replace("'<script[^>]*>.*?</script>'si","",$words);
            $words = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)', $words);
            $words = preg_replace('/<!--.+?-->/','',$words);
            $words = preg_replace('/{.+?}/','',$words);
            $words = strip_tags($words);
            echo substr($words,0,200) . "&#133;</li><br /><br />\n";
        }
        echo "</ul>\n";
    }

    function conclusion($totalRows, $searchword)
    {
    	?>
        </td>
        </tr>
        <tr>

		<td width="100%" colspan="2">
        <hr />
        Total <?php echo $totalRows ?> results found.
        Search for <b><?php echo $searchword ?></b> with
        <a href="http://www.google.com/search?q=<?php echo $searchword ?>" target="_blank">google</a>
        </td>
        </tr>
	    <?php
    }

    function closehtml()
    {
		echo "</table>\n";
    }
}
?>