<?php
	if (!isset($_POST['body'])) {
		echo "missing information";
		exit;
	}
	$body = $_POST['body'];
	$json = json_decode($body);
	$content = "Frozen datastream: " . $json->triggering_datastream->url;
	mail("severin@schols.de", "Cosm Trigger - Frozen datastream", $content);
?>
