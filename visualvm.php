<?php

require_once "VBAPIs.php";

require_once "credentials.php"; 

/* Twilio's PHP Library */
require_once "twilphplib/Services/Twilio.php"; 

//Collect the transcription from the VoiceBase CallBack
$VBCallBackJSON = file_get_contents('php://input');
$transcript = VBAPIs::parseCallBackTextTranscript($VBCallBackJSON);
$transcript = base64_decode($transcript);

/* Collect who the Voicemail was from */
$vb_json_response = json_decode($VBCallBackJSON,true);
$from = $vb_json_response['metadata']['extended']['from'];

/* Check the time we sent through VoiceBase and the time now to calculate the processing time */
$starttime = $vb_json_response['metadata']['extended']['starttime'];
$stoptime = date("h:i:sa");

$starttime = strtotime($starttime);
$stoptime = strtotime($stoptime);

$turnaroundtime = ($stoptime - $starttime);

/* Send SMS from Twilio */
 
/* Create Twilio Client */
$client = new Services_Twilio($twilio_account_sid, $twilio_auth_token);

/* Construct a Message */
$client->account->messages->create(array(
    "From" => $twilio_phone_number,
    "To" => $my_phone_number,
    "Body" => "New Voicemail from $from: $transcript *This took $turnaroundtime seconds to process at VoiceBase*"));
	
?> 