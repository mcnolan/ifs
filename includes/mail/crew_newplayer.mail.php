<?
//Player copy of site details when added through IFS (not an application)
$recipient = "$name <$email>";
$subject = $sitename . " New User Details";
$message = "Hello $name,\n\n";
$message .= "You have received this email because you have requested to join an \n";
$message .= $sitename . " simm. As such, the system has automatically generated a user ID and\n";
$message .= "password for you, in order to allow you to access features on the \n";
$message .= $sitename . " website. Your user name and password is:\n\n";
$message .= "Username - $username\n";
$message .= "Password - $pass\n\n";
$message .= "You have been added because you requested to join the crew of an ".$sitename." simm.\n";
$message .= "If you have received this email in error, simply ignore it. Please do not\n";
$message .= "respond to this email as it is automatically generated for information\n";
$message .= "purposes only.\n\n";
$message .= "Thanks for simming in ".$sitename.",\n";
$message .= $sitename . " webmaster\n\n";
$headers .= "From: " . email-from . "\n";
$headers .= "X-Sender:<".$sitename."HQ> \n";
$headers .= "X-Mailer: PHP\n"; // mailer
$headers .= "Return-Path: <".$webmasteremail.">\n";  // Return path for errors
mail($recipient, $subject, $message, $headers);
?>
