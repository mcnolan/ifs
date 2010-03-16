<?
$mailersubject = "Pending Award";
$mailerbody .= "You've just submitted an award for approval.\n\n";
$mailerbody = "Award: $aname\n";
$mailerbody .= "Crew: $cname\n";
$mailerbody .= "\n\nThis message was automatically generated.";
$header = "From: " . email-from;
mail ($coemail, $mailersubject, $mailerbody, $header);
?>