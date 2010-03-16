<?
$realbody = "Please forward this app.\n\n";
$realbody .= $body;
$subject = "CO App";
mail (webmasteremail, $subject, $realbody, $headers);
?>