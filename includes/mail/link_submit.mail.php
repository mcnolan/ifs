<?
//Notification there is a new submitted link that requires moderation
$subject = "New User Submitted Weblink";
$message .= "Hello Admin,\n\n";
$message .= "A new web link '$linktitle' has been submitted by '$author' for the '$live_site' website.\n";
$message .= "Please go to $live_site/administrator to view and approve this link\n\n";
$message .= "Please do not respond to this message as it is automatically generated and is for information purposes only\n";
$headers .= "From: " . emailfrom . "\n";
$headers .= "X-Sender: \n";
$headers .= "X-Mailer: PHP\n"; // mailer
$headers .= "Return-Path: <$email>\n";  // Return path for errors
mail($recipient, $subject, $message, $headers);
?>
