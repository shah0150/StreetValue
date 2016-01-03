
<?php
 
/* Include twilio-php, the official Twilio PHP Helper Library, 
 * which can be found at
 * http://www.twilio.com/docs/libraries
*/
 
include('Twilio.php');
 
/* Controller: Match the keyword with the customized SMS reply. */
function index(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Reply with one of the following keywords: 
yes, no, ok, great.");
    echo $response;
}
 
function yes(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Great! We will be in touch with you soon");
    echo $response;
}
 
function no(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Oh! Then when are you planning to send?");
    echo $response;
}
 
function ok(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Good!!.");
    echo $response;
}
 
function great(){
    $response = new Services_Twilio_Twiml();
    $response->sms("Merry Christmas");
    echo $response;
}
 
/* Read the contents of the 'Body' field of the Request. */
$body = $_REQUEST['Body'];
 
/* Remove formatting from $body until it is just lowercase 
characters without punctuation or spaces. */
$result = preg_replace("/[^A-Za-z0-9]/u", " ", $body);
$result = trim($result);
$result = strtolower($result);
 
/* Router: Match the ‘Body’ field with index of keywords */
switch ($result) {
    case 'yes’':
        monkey();
        break;
    case 'no':
        dog();
        break;
    case 'ok':
        pigeon();
        break;
    case 'great':
        owl();
        break;
 
/* Optional: Add new routing logic above this line. */
    default:
        index();
}