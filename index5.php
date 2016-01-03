<?php
 require('Twilio.php');

$AccountSid = "AC56336699792326710f6bf1096dadb5a4";
$AuthToken = "fc56d43927e04b1b5331394472ebcc97";

// Instantiate a new Twilio Rest Client
$client = new Services_Twilio($AccountSid, $AuthToken);

/* Your Twilio Number or Outgoing Caller ID */
$from = "+16138007340";

// make an associative array of server admins. Feel free to change/add your
// own phone number and name here.
$people = array(
  "+16476674651" => "Adesh",
  "+16135919990" => "Bryon",
);

// Iterate over all admins in the $people array. $to is the phone number,
// $name is the user's name
foreach ($people as $to => $name) {
  // Send a new outgoing SMS
  $body = "A new lead is available in Ottawa. Reply 'yes' to accept";
  $client->account->sms_messages->create($from, $to, $body);
  echo "Sent message to $name";
}

?>
