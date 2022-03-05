<?php

    if (isset($_POST["submit"])) {
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        require_once "database-handler-inc.php";
        require_once "functions-inc.php";

        if (emptyInput($username, $password) !== false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        if (userExistsLogin($conn, $username, $username) === false) {
            header("location: ../login.php?error=invalidlogin");
            exit();
        }

        loginUser($conn, $username, $password);

    } else {
        header("location: ../login.php");
        exit();
    }

?>