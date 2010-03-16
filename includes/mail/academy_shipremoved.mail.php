<?
//Academy instructor receives this when one of their students has been removed from their ship
$subject = $fleetname . " Academy - Student Removal";
$body = "A student in one of your classes has been removed from ";
$body .= "his/her ship.\n\n";
$body .= "Character: $charname\n\n";
$body .= "This message was automatically generated.\n\n";
$headers = "From: " . email-from . "\n";
$headers .= "X-Sender:<".$fleetname."HQ> \n";
$headers .= "X-Mailer: PHP\n";
$headers .= "Return-Path: <".$webmasteremail.">\n";
mail($recip, $subject, $body, $headers);
?>
