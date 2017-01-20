<?php
$to_address = "talhatahir@margallapackages.com";
$subject = "Message | ";
$message = "This is the body of the email.\n\n";
$message .= "More body: probably a variable.\n";
$headers = "From: talhatahir@margallapackages.com\r\n";
mail($to_address,$subject,$message,$headers);
echo "Mail Sent 4";
?> 