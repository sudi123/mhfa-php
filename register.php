<?php
/*
 * PHP Register functionality that gets called form index.php through AJAX.
 */
require('constants/Constants.php');

/*  Check if this page is accessed only through the form(index.php). Else Return "Not Authorised" */
if (!empty($_SERVER['HTTP_X_MY_CUSTOM_HEADER']) && $_SERVER['HTTP_X_MY_CUSTOM_HEADER'] == Constants::REGISTER) {

    /* Use the password_hash() to hash the users password */
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    /* Use the trim() to remove unwanted spaces while persisting in database */
    $username = trim($_POST['username']);

    $db = new PDO('sqlite:site.sq3');
    /* Create a prepared statement for creating a table if not exists */
    $stmt = $db->prepare("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username VARCHAR(10) NOT NULL, password VARCHAR(255), gender VARCHAR(10));");
    /* execute the query */
    $stmt->execute();

    /* Now perform the insert operation */
    /* Create a prepared statement */
    $stmt = $db->prepare("INSERT INTO users (username, password, gender) VALUES (:username, :password, :gender)");

    /* bind params */
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $_POST['gender'], PDO::PARAM_STR);

    /*
     * Execute the query to INSERT data
     * If insertion is successful, return success message else failure message
     */
    if ($stmt->execute()) {
        echo Constants::REGISTRATION_SUCCESSFUL;
    } else {
        echo Constants::REGISTRATION_FAILURE;
    }
    /* close connection */
    $db = null;
} else {
    echo Constants::UNAUTHORISED;
}
?>

