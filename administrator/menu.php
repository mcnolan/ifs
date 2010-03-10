<?
$relpath = "../";
$title = "Admin";
$reqtype = "admin";

require("../includes/header.php");
?>

<BR>

<p><a href="https://myserverworld.com/login.pl">obsidianfleet.net server admin</a></p>
<p><a href="http://osmium.webfusion.co.uk/phpMyAdmin/index.php">OF MYSQL Admin System</a></p>

<p> Ship Database Stuff:
<ul>
<li><a href="<? echo $relpath ?>database/shipdb/editships.php">Ships admin</a></li>
<li><a href="<? echo $relpath ?>database/shipdb/editfighters.php">Fighter admin</a></li>
<li><a href="<? echo $relpath ?>database/shipdb/editshuttles.php">Shuttles admin</a></li>
<li><a href="<? echo $relpath ?>database/shipdb/editrunabouts.php">Runabouts admin</a></li>
<li><a href="<? echo $relpath ?>database/shipdb/editstarbases.php">Starbases admin</a></li>
</ul>

<p>
<p><a href="<? echo $relpath ?>resources/topsites/admin">Obsidian Fleet Top 100 Admin</a></p>
<p><a href="<? echo $relpath ?>resources/phprank/admin.php">OF Top Simms Admin</a></p>
<p><a href="<? echo $relpath ?>resources/bp/bpadmin.htm">OF Banner Exchange Admin</a></p>
<p><a href="<? echo $relpath ?>cgi-bin/ringlink/admin.pl">OF Webring Admin</a></p>
<p><a href="<? echo $relpath ?>resources/links/admin">OF Links Directory Admin</a></p>
<p><a href="<? echo $relpath ?>cgi-bin/awstats/awstats.pl">OF Stats Page</a></p>
<BR>

<? include($relpath . "includes/footer.php"); ?>