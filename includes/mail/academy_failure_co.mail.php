<?
$subject = $fleetname . " Academy Failure";
$body = "Course: $coursename\n";
$body .= "Grade: " . $mark[$stuid] . "\n";
$body .= "Character: $rank $charname\n";
$body .= "Ship: $ship\n\n";
$body .= "Instructor: $name - $instemail\n\n";
$body2 = $body . "This message was automatically generated.\n\n";
$headers = "From: " . email-from . "\n";
$headers .= "X-Sender:<".$fleetname." HQ> \n";
$headers .= "X-Mailer: PHP\n";
$headers .= "Return-Path: <".$webmasteremail.">\n";
mail($coemail, $subject, $body2, $headers);
?>