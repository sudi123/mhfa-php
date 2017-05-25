<?php
/*
 * PHP Login functionality that gets called form index.php through AJAX.
 */
require('entities/Response.php');
require('constants/Constants.php');

/*  Set a variable to hold the header which is being sent during AJAX call*/
$customHeader = $_SERVER['HTTP_X_MY_CUSTOM_HEADER'];
$errorFlag = FALSE;

/*  Check if this page is accessed only through the form(index.php). Else Return "Not Authorised" */
if (!empty($customHeader) && $customHeader == Constants::LOGIN) {
    /* Create object for Response */
    $response = new Response();
    /* Use the trim() to remove unwanted spaces while persisting in database */
    $username = trim($_POST['username']);

    $db = new PDO('sqlite:site.sq3');
    /* Create a prepared statement for creating a table if not exists */
    $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username VARCHAR(10) NOT NULL, password VARCHAR(255), gender VARCHAR(10));");
    /* execute the query */
    $stmt->execute();

    /* Now perform the select operation */
    /* Create a prepared statement */
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");

    /* bind params */
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    $stmt->execute();

    /* fetch all results */
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* Check if the user has been registered before */
    if (count($res) == Constants::ONE) {
        /*  Check for password match
         *  If matched, assign the response object to the value from contents table where id = 2
         */
        if (password_verify($_POST['password'], $res[0]['password']) == Constants::ONE) {
            $stmt = $db->query('SELECT body FROM contents WHERE cid = 2;')
                ->fetch()['body'];
            $response->setResponseFlag(TRUE);
            $response->setResponseMessage($stmt . " with cid = 2");
        }
        else {
            $errorFlag = TRUE;
        }
    }
    else {
        $errorFlag = TRUE;
    }

    if ($errorFlag == TRUE) {
        /*
         *  Either the password doesnt match or the username does not exist, return "Invalid User"
         */
        $response->setResponseFlag(FALSE);
        $response->setResponseMessage(Constants::INVALID_USER);
    }
    echo json_encode($response);
    /* close connection */
    $db = null;
}
else {
    echo Constants::UNAUTHORISED;
}


?>

