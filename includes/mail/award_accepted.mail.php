<?
//Co receives when an award recommendation is accepted
$mailersubject = "$fleetname Award Status";
$mailerbody = "On " . date("F j, Y", $date) . " you nominated $rank $cname ($sname) for the $aname.\n\n";
$mailerbody .= "the nomination has been reviewed, and we are glad to inform you that the award as been approved\n\n";
$mailerbody .= "thanks for taking good care of your crew!\n";
$mailerbody .= "\n\nthis message was automatically generated.";
$header = "From: " . email-from;
mail ($email, $mailersubject, $mailerbody, $header);
?>
