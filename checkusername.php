<?php
/*
 * PHP page for username validation during registration.
 */
$db = new PDO('sqlite:site.sq3');

$stmt = $db -> prepare("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username VARCHAR(10) NOT NULL, password VARCHAR(255), gender VARCHAR(10));");
/* execute the query */
$stmt->execute();

if(!empty($_POST['username'])) {
    /* prepare the query */
    $stmt = $db -> prepare("SELECT * FROM users WHERE username = :username");

    /* Assign bind parameters */
    $stmt -> bindParam(':username', $_POST['username'], PDO::PARAM_STR);

    /* execute the query */
    $stmt->execute();

    /* fetch all results */
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /*
     * Get the username count when entered.
     * If the count is < 1, return username valid else re-enter username
     */
    if(count($res) < 1)
        echo "Username accepted";
    else
        echo "Username already exists";

    /* close connection */
    $db = null;

}

?>

