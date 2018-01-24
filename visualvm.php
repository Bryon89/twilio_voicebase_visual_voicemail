<?php

/* Need Twilio Credentials */
require "credentials.php"; 

/* Need Twilio Library */
require "twilphplib/Services/Twilio.php"; 


$string = file_get_contents('php://input');
$vb_json_response =json_decode($string,true);

$starttime = $vb_json_response['media']['metadata']['extended']['time'];
$stoptime = date("h:i:sa");

$starttime = strtotime($starttime);
$stoptime = strtotime($stoptime);

$turnaroundtime = (($stoptime - $starttime)). " seconds";

$voicemailnumber = $myphonenumber;

$transcript = $vb_json_response['media']['transcripts']['text'];
 
/* Create Twilio Client */
$client = new Services_Twilio($twilio_account_sid, $twilio_auth_token);

/* Construct a Message */
$client->account->messages->create(array(
    "From" => $twilio_phone_number,
    "To" => $my_phone_number,
    "Body" => "New Voicemail: $transcript *This took $turnaroundtime seconds to process at VoiceBase*"));
	
/* Twilio SMS in 48 seconds
	https://www.twilio.com/blog/2016/07/send-sms-with-php-and-twilio-in-60-seconds.html */
?>