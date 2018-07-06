<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";

    use Unm\Scheduler\{
      Scon
    };

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

    $reply = new stdClass();
    $reply->status = 200;
    $reply->data = null;
