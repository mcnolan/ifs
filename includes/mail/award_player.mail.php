<?
//Award notification, winners copy.
$mailersubject = "Congratulations - You've Received An Award!";
$mailerbody = "Hello, $cname, and congratulations!\n\n";
$mailerbody .= "You've just been awarded the $fleetname $aname.  Your Commanding Officer had this to say about you:\n";
$mailerbody .= "---\n";
$mailerbody .= $reason;
$mailerbody .= "\n---\n\n";
$mailerbody .= "Head on over to {$live_site}/index.php?option=ifs&task=common&action=common&lib=areason&rid=$rid to receive your award!\n";
$mailerbody .= "\n\nThis message was automatically generated.";
$header = "From: " . email-from;
mail ($email, $mailersubject, $mailerbody, $header);
?>
