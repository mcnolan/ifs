<?
//Monthly TFCO report
$mailersubject = "Monthly Report for Task Force " . $tfid;
$mailerbody = "Task Force: $tfid - $tfname\n";
$mailerbody .= "CO: $tfco\n";
$mailerbody .= "\n";
$mailerbody .= "Total Ships: $ships\n";
$mailerbody .= "    CO'ed Ships: $coships\n";
$mailerbody .= "        Active Ships: $actships\n";
$mailerbody .= "        Inactive Ships: $inships\n";
$mailerbody .= "    Open Ships: $openships\n";
$mailerbody .= "\n";
$mailerbody .= "Total Characters: $totalchar\n";
$mailerbody .= "Average Characters per COed ship: $avchar\n";
$mailerbody .= "\n";
$mailerbody .= "Promotions:\n";
$mailerbody .= "$promotions\n\n";
$mailerbody .= "New COs:\n";
$mailerbody .= "$newco\n\n";
$mailerbody .= "Resigned COs:\n";
$mailerbody .= "$resigned\n\n";
$mailerbody .= "Website Updates:\n";
$mailerbody .= "$webupdates\n\n";
$mailerbody .= "Other Notes:\n";
$mailerbody .= "$other\n\n";
$mailerbody .= "Submitted " . date("F j, Y") . "\n";
?>
