<?php
        $to_email = "chopadelalit83@gmail.com";
		$subject = "Simple email demo";
		$body = "hiii... this is my first email demo creation";
		$headers = "From: lalit.choapde.bi@gmail.com";

		if (mail($to_email, $subject, $body, $headers)) 
		{
			echo "Email successfully send";
		}
		else
		{
			echo "Email Sending failed";
		}
		
		
?>
