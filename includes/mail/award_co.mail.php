<?
//Co receives this when the grant a low level award to a player
$mailersubject = "One Of Your Crew Received An Award!";
$mailerbody = "Hello,\n\n";
$mailerbody .= "A member of your crew, $cname, has just been awarded the $fleetname $aname!\n";
$mailerbody .= "You had this to say about him/her:\n";
$mailerbody .= "---\n";
$mailerbody .= $reason;
$mailerbody .= "\n---\n\n";
$mailerbody .= "Head on over to {$live_site}/index.php?option=ifs&task=common&action=common&lib=areason&rid=$rid to view the award!\n";
$mailerbody .= "\n\nThis message was automatically generated.";
$header = "From: " . email-from;
mail ($coemail, $mailersubject, $mailerbody, $header);
?>
