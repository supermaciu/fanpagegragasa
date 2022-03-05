<?php

    if (isset($_POST["submit"])) {
        
        $username = $_POST["username"];
        $nickname = $_POST["nickname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password_repeat = $_POST["password_repeat"];

        require_once "database-handler-inc.php";
        require_once "functions-inc.php";

        if (emptyInput($username, $email, $password, $password_repeat) !== false) {
            header("location: ../signup.php?error=emptyinput");
            exit();
        }
        if (usernameExists($conn, $username) !== false) {
            header("location: ../signup.php?error=usernameexists");
            exit();
        }
        if (emailExists($conn, $email) !== false) {
            header("location: ../signup.php?error=emailexists");
            exit();
        }
        if (invalidSignupUsername($username, "<") !== false and emptyInput($nickname) !== false) {
            header("location: ../signup.php?error=invalidusernamel");
            exit();
        }
        if (invalidSignupUsername($username, ">") !== false and emptyInput($nickname) !== false) {
            header("location: ../signup.php?error=invalidusernameg");
            exit();
        }
        if (invalidSignupUsername($username, "regex") !== false and emptyInput($nickname) !== false) {
            header("location: ../signup.php?error=invalidusernamer");
            exit();
        }
        if (invalidSignupNickname($nickname) !== false and emptyInput($nickname) === false) {
            header("location: ../signup.php?error=invalidnickname");
            exit();
        }
        if (invalidSignupEmail($email) !== false) {
            header("location: ../signup.php?error=invalidemail");
            exit();
        }
        if (invalidSignupPassword($password, $password_repeat) !== false) {
            header("location: ../signup.php?error=invalidpassword");
            exit();
        }
        if (passwordsMatchError($password, $password_repeat) !== false) {
            header("location: ../signup.php?error=passwordmatcherror");
            exit();
        }

        createUser($conn, $username, $nickname, $email, $password);

    } else {
        header("location: ../signup.php");
        exit();
    }

?>