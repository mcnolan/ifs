<?
//Existing ship application
$to = webmasteremail . ", $Email";
$subject = "Ship Application";
$headers = "From: " . emailfrom . "\nX-Mailer:PHP\nip: $ip";
$realbody = "Simm application received -- thank you!\n";
$realbody .= "Please note that this is not an acceptance letter.  After reviewing the application, we will email you our decision.\n\n";
$realbody .= $body;
mail ($to, $subject, $realbody, $headers);
?>
