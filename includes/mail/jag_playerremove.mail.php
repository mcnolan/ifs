<?
//JAG record for player removal
$mailersubject = "JAG - Player Removed on " . $sname;
$mailerbody = "Ship Name: " . $sname . "\n";
$mailerbody .= "TF/TG: {$tfid} / {$tgid}\n";
$mailerbody .= "Crew: " . $cname . "\n";
$mailerbody .= "Rank: ". $rankname . "\n";
$mailerbody .= "Email: " . $pemail . "\n";
$mailerbody .= "Performed by: " . $coname . " ({$coemail})\n\n";
$mailerbody .= "Reason:\n";
$mailerbody .= $reason;
$mailerbody .= "\n\nThis message was automatically generated.";
$header = "From: ". email-from;
mail ($jag, $mailersubject, $mailerbody, $header);
?>
