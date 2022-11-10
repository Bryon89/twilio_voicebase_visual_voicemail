<?php

/* Bryon's PHP Library */
require_once('VBAPIs.php');

parse_str(file_get_contents("php://input"), $TwilioCallBackData);

/* Collect Everything we need to send to VoiceBase (3  total) */
// 1 Twilio's Wav Recording
$RecordingUrl = $TwilioCallBackData['RecordingUrl'];

// 2 Optional: Pass the current time and Twilio's 'from' phone number through VoiceBase
$from = $TwilioCallBackData['From'];

$time = date("h:i:sa");

$metadata = '{"extended" : {"starttime" : "'. $time . '", "from" : "' . $from . '"}}';

// 3 Instructions for how we want VoiceBase to process the voicemail recording
$voicemailconfiguration = file_get_contents('voicemail.json'); 

// Finally, use Bryon's PHP library to send the voicemail to VoiceBase
VBAPIs::uploadMediaUrl($RecordingUrl, $voicemailconfiguration, $metadata);

?>
