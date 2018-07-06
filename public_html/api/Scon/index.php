<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
    require_once dirname(__DIR__, 3) . "/db/PdoGetter.php";
    use Unm\Scheduler\{
      Scon
    };

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    $reply = new stdClass();
    $reply->status = 200;
    $reply->data = null;

try {
    //grab the mySQL connection
    $pdo = PdoGetter::getPdo();
    //determine which HTTP method was used
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
    // sanitize input
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $profileAtHandle = filter_input(INPUT_GET, "profileAtHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    // make sure the id is valid for methods that require it
    if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
        throw(new InvalidArgumentException("id cannot be empty or negative", 405));
    }
    if($method === "GET") {

//        if(empty($id) === false) {
//            $profile = Profile::getProfileByProfileId($pdo, $id);
//            if($profile !== null) {
//                $reply->data = $profile;
//            }
//        } else if(empty($profileAtHandle) === false) {
//            $profile = Profile::getProfileByProfileAtHandle($pdo, $profileAtHandle);
//            if($profile !== null) {
//                $reply->data = $profile;
//            }
//        } else if(empty($profileEmail) === false) {
//            $profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
//            if($profile !== null) {
//                $reply->data = $profile;
//            }
//        }

    }
    elseif($method === "POST"){

    }
    elseif($method === "PUT") {

    } elseif($method === "DELETE") {

    } else {
        throw (new InvalidArgumentException("Invalid HTTP request", 400));
    }
    // catch any exceptions that were thrown and update the status and message state variable fields
} catch(\Exception | \TypeError $exception) {
    $reply->status = $exception->getCode();
    $reply->message = $exception->getMessage();
}