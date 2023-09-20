<?php
    require_once "./permissions.php";
    require_once "./CommonInterface.php";
    require_once "./DatabaseInterface.php";

    $userid = $_SESSION["userid"];
    $username = $_SESSION["user"];
    $databaseObj = new DatabaseInterface();

    $input = json_decode(file_get_contents('php://input'),false);

    if(!is_object($input))
    {
        return_error("nice try :)");
    }

    if(!isset($input->action))
    {
        return_error("nice try :)");
    }

    switch ($input->action)
    {
        case "logout":
            session_destroy();
            return_success("logged out");
            break;

        default:
            return_error("Malformed request");
    }
