<?
$subject = "New User Submitted News Story";
$message .= "Hello Admin Person,\n\n";
$message .= "A new user news story '$newstitle' has been submitted by '$author' for the '$live_site' website.\n";
$message .= "Please go to '$live_site/administrator/' to view and approve this news story\n\n";
$message .= "Please do not respond to this message as it is automatically generated and is for information purposes only\n";
$headers .= "From: " . emailfrom . "\n";
$headers .= "X-Sender: <$live_site> \n";
$headers .= "X-Mailer: PHP\n"; // mailer
$headers .= "Return-Path: <$email>\n";  // Return path for errors
mail($recip, $subject, $message, $headers);
?>