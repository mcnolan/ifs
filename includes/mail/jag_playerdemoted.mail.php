<?
$mailersubject = "JAG - Player Demoted on " . $sname;
$mailerbody = "Ship Name: " . $sname . "\n";
$mailerbody .= "Crew: " . $cname . "\n";
$mailerbody .= "Old Rank: " . $oldrank . "\n";
$mailerbody .= "New Rank: " . $newrank . "\n";
$mailerbody .= "Email: " . $pemail . "\n";
$mailerbody .= "Performed by: " . $coname . "\n\n";
$mailerbody .= "Reason:\n";
$mailerbody .= $reason;
$mailerbody .= "\n\nThis message was automatically generated.";

$header = "From: " . email-from;
mail ($jag, $mailersubject, $mailerbody, $header);
?>