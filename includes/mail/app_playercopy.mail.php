<?
//Player application form, Player copy.
$realbody = "Thank you for submitting an application!  Your application will be reviewed, and you will be contacted shortly.\n";
if ($neednewuser) { $realbody .= $message; }
$realbody .= "Here is a copy of your application:\n\n";
$realbody .= $body;
$realbody .= "\nYou are being sent this email because you requested to join the crew of a simm.\n";
$realbody .= "If this is in error, please notify " . webmasteremail . "\n";
mail ($Email, $subject, $realbody, $headers);
?>
