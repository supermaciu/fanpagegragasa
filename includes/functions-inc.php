<?php

    $username_min_len = 4;
    $username_max_len = 20;
    
    $password_min_len = 4;
    $password_max_len = 26;
    $valid_password_spec_chars = array('!', '@', '#', '$');

    function emptyInput(...$elements) {
        $result = false;

        foreach ($elements as $element) {
            if (empty($element)) {
                $result = true;
            }
        }

        return $result;
    }

    function invalidSignupUsername($username, $r) {
        global $username_min_len, $username_max_len;

        $result;

        if ($r == "<") {
            if (!(strlen($username) >= $username_min_len)) {
                $result = true;
            } else {
                $result = false;
            }
        } else if ($r == ">") {
            if (!(strlen($username) <= $username_max_len)) {
                $result = true;
            } else {
                $result = false;
            }
        } else if ($r == "regex") {
            $regex = "/^[a-zA-Z\d_]*$/";
            
            if (!preg_match($regex, $username)) {
                $result = true;
            } else {
                $result = false;
            }
        }

        return $result;
    }

    function invalidSignupNickname($nickname) {
        global $username_min_len, $username_max_len;
        $regex = "/^[a-zA-Z\d\p{Zs}_ąćśęółżź]*$/";

        $result;

        if (!(strlen($nickname) >= $username_min_len) or !(strlen($nickname) <= $username_max_len)
        or !preg_match($regex, $nickname)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    function invalidSignupEmail($email) {
        $result;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    function invalidSignupPassword($password, $password_repeat) {
        global $password_min_len, $password_max_len, $valid_password_spec_chars;

        $result;
        //$number_of_num_chars = 0;
        //$number_of_spec_chars = 0;

        /*
        for ($i = 0; $i < strlen($password); $i++) {
            for ($j = 0; $j <= 9; $j++) { 
                if ($password[$i] == $j) {
                    $number_of_spec_chars += 1;
                }
            }
            
            for ($k=0; $k < count($valid_password_spec_chars); $k++) { 
                if ($password[$i] == $valid_password_spec_chars[$k]) {
                    $number_of_spec_chars += 1;
                }
            }
        }
        */

        if (strlen($password) >= $password_min_len and strlen($password) <= $password_max_len
            and strlen($password_repeat) >= $password_min_len and strlen($password_repeat) <= $password_max_len) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    function passwordsMatchError($password, $password_repeat) {
        $result;

        if ($password !== $password_repeat) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    function usernameExists($conn, $username) {
        $result;

        $sql = "SELECT * FROM users WHERE username = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return 0;
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $result_data = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result_data)) {
            return $row;
        } else {
            $result = false;
        }

        mysqli_stmt_close($stmt);
        return $result;
    }

    function emailExists($conn, $email) {
        $result;

        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return 0;
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result_data = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result_data)) {
            return $row;
        } else {
            $result = false;
        }

        mysqli_stmt_close($stmt);
        return $result;
    }

    function userExistsLogin($conn, $username, $email) {
        $result;

        $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return 0;
        }

        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);

        $result_data = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result_data)) {
            return $row;
        } else {
            $result = false;
        }

        mysqli_stmt_close($stmt);
        return $result;
    }

    function loginUser($conn, $username, $password) {
        $user = userExistsLogin($conn, $username, $username);

        if ($user === false) {
            header("location: ../login.php?error=invalidlogin");
            exit();
        }

        $hashed_password = $user["password"];

        //sprawdzanie hashu
        $check_password = password_verify($password, $hashed_password);

        if ($check_password === false) {

            header("location: ../login.php?error=invalidpassword");
            exit();

        } else if ($check_password === true) {

            session_start();

            $_SESSION["id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["nickname"] = $user["nickname"];
            $_SESSION["email"] = $user["email"];

            $_SESSION["custom_cursor"] = $user["custom_cursor"];
            $_SESSION["particle_cursor"] = $user["particle_cursor"];

            $_SESSION["profile_picture"] = $user["profile_picture"];
            
            header("location: ../home.php");
            exit();
            
        }
    }

    function createUser($conn, $username, $nickname, $email, $password) {

        $sql = "INSERT INTO users (username, nickname, email, password) VALUES (?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return 0;
        }

        //hashowanie hasła
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ssss", $username, $nickname, $email, $hashed_password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        loginUser($conn, $username, $password);

    }

    function updateProfilePicture($conn, $profile_picture_ext, $profile_picture_tmp, $reset_picture) {
        session_start();

        $sql = "UPDATE users SET profile_picture = ? WHERE username = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return 0;
        }
        
        $username = $_SESSION["username"];

        if ($reset_picture) {
            $e = "";
            mysqli_stmt_bind_param($stmt, "ss", $e, $username);
        } else {
            //$profile_picture_new_name = uniqid("", true) . "." . $profile_picture_ext;
            $profile_picture_new_name = $_SESSION["id"] . "." . $profile_picture_ext;
            $profile_picture_dest = "images/avatar/uploads/" . $profile_picture_new_name;

            move_uploaded_file($profile_picture_tmp, "../" . $profile_picture_dest);

            mysqli_stmt_bind_param($stmt, "ss", $profile_picture_dest, $username);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        session_start();

        $_SESSION["profile_picture"] = $profile_picture_dest;
    }

    function updateOptions($conn, $options) {
        session_start();
        $username = $_SESSION["username"];

        foreach ($options as $key => $value) {
            $sql = "UPDATE users SET " . $key . " = ? WHERE username = ?;";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo $sql;
                return 0;
            }

            $type_stmt = "";
            if (gettype($value) == "integer") {
                $type_stmt = $type_stmt . "i";
            } else if (gettype($value) == "string") {
                $type_stmt = $type_stmt . "s";
            }
            $type_stmt = $type_stmt . "s";

            mysqli_stmt_bind_param($stmt, $type_stmt, $value, $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            session_start();

            $_SESSION[$key] = $value;
        }
    }

    function resetRecord($conn, $key, $value="") {
        $sql = "UPDATE users SET " . $key . " = ?;";
        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_bind_param($stmt, "s", $value);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        session_start();

        $_SESSION[$key] = $value;

        header("location: ../profile.php");
        exit();
    }

    function updateProfile($conn, $options, $profile_picture_ext, $profile_picture_tmp, $reset_picture) {

        if (!empty($profile_picture_tmp) or $reset_picture == true) {
            updateProfilePicture($conn, $profile_picture_ext, $profile_picture_tmp, $reset_picture);
        }

        updateOptions($conn, $options);

        header("location: ../profile.php");
        exit();
    }
?>