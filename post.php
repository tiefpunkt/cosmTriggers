<?php
	// Config
  $template_path = "./templates/";
  $email = "severin@schols.de";
	
	// Get input information from POST request
	if (!isset($_POST['body'])) {
		echo "missing information";
		exit;
	}
	$body = $_POST['body'];
	$json = json_decode($body);
	
	// Read content from template
	//...
	
	// Replace placeholders
	//...
	
	$subject = "Cosm Trigger - Frozen datastream";
	$content = "Frozen datastream: " . $json->triggering_datastream->url;
	
	// Debug Output
	echo "<html><body><h3>$subject</h3><p><i>To: $email</i></p><pre>$content</pre></body></html>";
	
	// Send eMail
	//mail($email, $subject , $content);
?>
