<?php
	// Config
  $template_path = "./templates/";
  $email = "severin@schols.de";
  
  // Debug mode?!?
  $debug = file_exists("DEBUG_ENABLED");
	
	// Get input information from POST request
	if (!isset($_POST['body'])) {
		echo "missing information";
		exit;
	}
	$body = $_POST['body'];
	$json = json_decode($body);
	
	// Sanitize inputs
	if (!in_array($json->type, array("gt", "gte", "lt", "lte", "eq", "change", "frozen", "live"))) {
			echo "Invalid type";
			exit();
	}
	
	// Read content from template
	$content = file_get_contents($template_path . $json->type);
	
	// Replace placeholders
	$replacements = array(
	  "%FEED_TITLE%" => $json->environment->title,
	  "%FEED_ID%" => $json->environment->id,
	  "%FEED_URL%" => $json->environment->feed,
		"%DATASTREAM_ID%" => $json->triggering_datastream->id,
		"%DATASTREAM_TIMESTAMP%" => $json->triggering_datastream->at,
		"%DATASTREAM_CURRENT_VALUE%" => $json->triggering_datastream->value->current_value
		);
	$content = str_replace(array_keys($replacements), array_values($replacements), $content);
	
	$subject = "Cosm Trigger from feed \"{$json->environment->title}\"";
	//$content = "Frozen datastream: " . $json->triggering_datastream->url;
	
	// Debug Output
	if ($debug) {
		echo "<html><body><h3>$subject</h3><p><i>To: $email</i></p><pre>$content</pre></body></html>";
		exit();
	}
	
	// Send eMail
	mail($email, $subject , $content);
?>
