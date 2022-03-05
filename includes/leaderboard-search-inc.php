<?php

    require_once "database-handler-inc.php";
    require_once "functions-inc.php";

    $output = '';

    if (isset($_POST["query"])) {
        $search = mysqli_real_escape_string($conn, $_POST["query"]);
        $query = "
            SELECT * FROM users
            WHERE username LIKE '%".$search."%';
        ";
    } else {
        $query = "
            SELECT * FROM username ORDER BY id;
        ";
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            //$output .= '
                echo '<div class="list-account">';
                    if (emptyInput($row["profile_picture"]) === false) {
                            echo '<img id="avatar" src="' . $row["profile_picture"] . '"
                            alt="placeholder-avatar" width="128px" height="128px">';
                        } else {
                            echo '<img id="avatar" src="images/avatar/placeholder.jpg"
                            alt="placeholder-avatar" width="128px" height="128px">';
                        }

                    echo '<div class="account-details">';
                    
                        if (isset($row["nickname"]) and emptyInput($row["nickname"]) === true) {
                            echo 'Nazwa użytkownika: ' . $row["username"] . ' <br>';
                        } else {
                            echo 'Nazwa użytkownika: ' . $row["nickname"] . ' (' . $row["username"] . ') <br>';
                        }
                            echo 'Punkty: 0';
                    echo '</div>';
                echo '</div>';
            //';
        }

        //echo $output;
    } else {
        echo 'Nie istnieje użytkownik o takiej nazwie.';
    }
?>