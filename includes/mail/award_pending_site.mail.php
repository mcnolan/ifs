<?
//Webmaster notification that there is an award pending approval
$mailersubject = "Pending Award";
$mailerbody = "Award: $aname\n";
$mailerbody .= "There is a new pending $fleetname Award submission waiting for your approval.\n";
$mailerbody .= "Head on over to {$live_site}/index.php?option=ifs&task=awards&action=pending to review this submission.\n";
$mailerbody .= "\n\nThis message was automatically generated.";
$header = "From: " . email-from;
mail (webmasteremail, $mailersubject, $mailerbody, $header);
?>
