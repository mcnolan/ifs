<?
$subject = "New User Submitted Article";
$message .= "Hello Admin,\n\n";
$message .= "A new user article '$arttitle' has been submitted by '$author' for the '$live_site' website.\n";
$message .= "Please go to '$live_site/administrator' to view and approve this article\n\n";
$message .= "Please do not respond to this message as it is automatically generated and is for information purposes only\n";
$headers .= "From: " . emailfrom . "\n";
$headers .= "X-Sender: <$live_site> \n";
$headers .= "X-Mailer: PHP\n"; // mailer
$headers .= "Return-Path: <$email>\n";  // Return path for errors
mail($recipient, $subject, $message, $headers);
?>