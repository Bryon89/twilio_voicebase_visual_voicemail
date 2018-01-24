<?php

/* VoiceBase Bearer Token */
require "credentials.php"; 

/* Send the Wav! */
$RecordingUrl = $_POST['RecordingUrl'];	

$vb_api_endpoint = "https://apis.voicebase.com/v2-beta/media";

/* Pass the current time through VoiceBase */
$time = date("h:i:sa");
$custommetadata = '{ "metadata": {"extended" : {"time" : "'. $time . '"}}}';

$voicemailconfiguration = file_get_contents('voicemail.json'); 
	
	$headers = array(
	    'Authorization: Bearer ' . $vb_bearer_token,
	);
	$params = array(
	"configuration" => $voicemailconfiguration,
	"metadata" => $custommetadata,
	"media" => $RecordingUrl
	);
	
	/* Construct and run a curl request */

	set_time_limit(0);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_URL, $vb_api_endpoint);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	$response = curl_exec($ch);
	curl_close($ch);
	echo $response;

	?>
