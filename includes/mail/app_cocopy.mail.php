<?
$realbody = "This character has been automatically added to your ship's manifest.\n";
$realbody .= "Please login to update the character's rank and position.\n\n";
//This line inserts the output from the app form
$realbody .= $body;
mail ($coemail, $subject, $realbody, $headers);
?>