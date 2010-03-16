<?
//Co receives this email when a student has dropped out of the academy
$subject = $fleetname . " Academy Drop-out";
$body = "Course: $coursename\n";
$body .= "Character: $rank $charname\n";
$body .= "Ship: $ship\n\n";
$body .= "Instructor: $name - $instemail\n\n";
$body2 = $body . "This message was automatically generated.\n\n";
$headers = "From: " . email-from . "\n";
$headers .= "X-Mailer:PHP\n";
$headers .= "Return-Path: <".$webmasteremail.">\n";
mail($coemail, $subject, $body2, $headers);
?>
