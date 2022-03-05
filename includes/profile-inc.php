<?php

    if (isset($_POST["submit"])) {
        
        $nickname = $_POST["nickname"];

        $particle_cursor = $_POST["particle_cursor"];

        if ($particle_cursor == "on") {
            $particle_cursor = 1;
        } else {
            $particle_cursor = 0;
        }

        $custom_cursor = $_POST["custom_cursor"];

        if ($custom_cursor == "on") {
            $custom_cursor = 1;
        } else {
            $custom_cursor = 0;
        }

        $profile_picture = $_FILES["profile_picture"];
        $profile_picture_name = $profile_picture["name"];
        $profile_picture_tmp = $profile_picture["tmp_name"];
        $profile_picture_size = $profile_picture["size"];
        $profile_picture_error = $profile_picture["error"];

        $profile_picture_ext = explode('.', $profile_picture_name);
        $profile_picture_ext = strtolower(end($profile_picture_ext));
        
        $allowed_exts = array(
            "jpg",
            "jpeg",
            "png"
        );

        $reset_picture = $_COOKIE["reset_picture"];
        if ($reset_picture == "true") {
            $reset_picture = true;
        } else {
            $reset_picture = false;
        }

        require_once "database-handler-inc.php";
        require_once "functions-inc.php";

        if (!empty($profile_picture_name) or $profile_picture_error !== 4) {
            if (!in_array($profile_picture_ext, $allowed_exts)) {
                header("location: ../profile.php?error=invalidext");
                exit();
            }
            if ($profile_picture_size > 150000) {
                header("location: ../profile.php?error=invalidsize");
                exit();
            }
            if ($profile_picture_error !== 0) {
                header("location: ../profile.php?error=uploaderror");
                exit();
            }
        }
        if (invalidSignupNickname($nickname) !== false and emptyInput($nickname) === false) {
            header("location: ../profile.php?error=invalidnickname");
            exit();
        }
        
        $options = array(
            "nickname" => $nickname,
            "custom_cursor" => $custom_cursor,
            "particle_cursor" => $particle_cursor
        );

        updateProfile($conn, $options, $profile_picture_ext, $profile_picture_tmp, $reset_picture);
    } else {
        header("location: ../home.php");
        exit();
    }

?>