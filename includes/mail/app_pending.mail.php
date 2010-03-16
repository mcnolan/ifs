<?
$realbody = "This character is currently pending, waiting to be assigned.\n";
//This line inserts the output from the join form
$realbody .= $body;
mail (webmasteremail, $subject, $realbody, $headers);
?>