<?
//Password reset notification
$message = "The user account '$checkusername' has this email associated with it.  A web user from $live_site has just requested that a new password be sent.\n\n Your New Password is: $newpass\n\nIf you didn't ask for this, don't worry. You are seeing this message, not them. If this was an error just login with your new password and then change your password to what you would like it to be.";
$subject="User Password for $checkusername";
mail($confirmEmail, $subject, $message, "From: " . emailfrom);
?>
