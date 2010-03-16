<?
//Co receives this when an award submission was denied.
$mailersubject = "$fleetname Award Status";
$mailerbody = "On " . date("F j, Y", $date) . " you nominated $rank $cname ($sname) for the $aname.\n\n";
$mailerbody .= "the nomination has been reviewed, but unfortunately we must inform you that the award was denied\n\n";
$mailerbody .= "there are many reasons for which an award might be denied, including an incomplete submission or simply too much competition for the award.";
$mailerbody .= "For more information regarding this nomination, please email $webmasteremail\n";
$mailerbody .= "\n\nthis message was automatically generated.";
$header = "From: " . email-from;
mail ($email, $mailersubject, $mailerbody, $header);
?>
