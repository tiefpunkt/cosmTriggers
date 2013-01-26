<?php
	// Config
	include("config.php");
  $template_path = "./templates/";
  
  // Debug mode?!?
  $debug = file_exists("DEBUG_ENABLED");
	
	// Get input information from POST request
	if (!isset($_POST['body'])) {
		header("HTTP/1.0 400 Bad Request");
		echo "Missing information";
		exit;
	}
	$body = $_POST['body'];
	$json = json_decode($body);
	
	// Sanitize inputs
	if (!in_array($json->environment->id, $authorized_feeds)) {
		header("HTTP/1.0 403 Forbidden");
		echo "Feed not authorized!";
		exit();
	}

	if (!in_array($json->type, array("gt", "gte", "lt", "lte", "eq", "change", "frozen", "live"))) {
			header("HTTP/1.0 400 Bad Request");
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
	
	// Email fields
	$subject = "Cosm Trigger from feed \"{$json->environment->title}\"";
	$headers = "From: cosmTrigger <cosmtrigger@tiefpunkt.com>\r\n".
    "Reply-To: severin@tiefpunkt.com\r\n";
	$content = wordwrap($content, 70);
	
	// Debug Output
	if ($debug) {
		echo "<html><body><h3>$subject</h3><p><i>To: $email</i></p><pre>".htmlentities($content)."</pre></body></html>";
		exit();
	}
	
	// Send eMail
	mail($email, $subject , $content, $headers);
?>
