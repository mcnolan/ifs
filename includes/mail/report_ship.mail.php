<?
//Monthly Co Report
$mailersubject = "Monthly Report for the " . $sname;
$mailerbody = "Ship Name: " . $sname . " ({$sid})\n";
$mailerbody .= "Commanding Officer: " . $commoff . ".\n";
$mailerbody .= "Ship's Website: " . $site . "\n";
$mailerbody .= "Ship's Status: " . $status . "\n";
$mailerbody .= "\n\nCrew List:\n";

$mailerbody .= $crewlisting;

$mailerbody .= "Simm Information:\n";
$mailerbody .= "~~~~~~~~~~~~~~~~~\n";	
$mailerbody .= "Current Mission Title: " . $mission . "\n\n";
$mailerbody .= "Mission Description:\n";
$mailerbody .= "$missdesc\n\n";
$mailerbody .= "What have you done this month to improve the quality of your sim?\n";
$mailerbody .= "$improvement\n\n\n";
$mailerbody .= "Misc Information:\n";
$mailerbody .= "~~~~~~~~~~~~~~~~~\n";
$mailerbody .= "Additional Comments:\n";
$mailerbody .= "$comments\n\n";
?>
