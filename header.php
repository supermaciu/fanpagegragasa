<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="keywords" content="Fanpage Gragasa, Fanpage, Gragas">
        <meta name="description" content="Fanpage Gragasa">
        <meta name="author" content="Maciej Jankowski">

        <meta http-equiv="Cache-control" content="no-cache">

        <title>Fanpage Gragasa</title>
        <link rel="shortcut icon" type="image/x-icon" href="images/logo/gragas_logo_1.png" />

        <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

        <!-- jQuery -->
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
        </script>

        <?php
            if (isset($_SESSION["username"])) {
                echo '<script type="text/javascript">
                    var custom_cursor = ' . $_SESSION["custom_cursor"] . ';
                    var particle_cursor = ' . $_SESSION["particle_cursor"] . ';
                </script>';
            } else {
                echo '<script type="text/javascript">
                    var custom_cursor = 1;
                    var particle_cursor = 1;
                </script>';
            }
        ?>
        
        <script type="text/javascript" src="js/custom_cursor.js" defer></script>
        <script type="text/javascript" src="js/particle_cursor.js" defer></script>
    </head>
    <body>
        <?php
            require_once "includes/database-handler-inc.php";
            require_once "includes/functions-inc.php";

            if (isset($_SESSION["username"])) {
                echo '<div class="account-header">';

                        if (emptyInput($_SESSION["profile_picture"]) === false) {
                            echo '<img id="avatar" src="' . $_SESSION["profile_picture"] . '"
                            alt="placeholder-avatar" width="64px" height="64px">';
                        } else {
                            echo '<img id="avatar" src="images/avatar/placeholder.jpg"
                            alt="placeholder-avatar" width="64px" height="64px">';
                        }

                    echo '<div class="account-details">';
                    
                        if (isset($_SESSION["nickname"]) and emptyInput($_SESSION["nickname"]) === true) {
                            echo 'Nazwa użytkownika: ' . $_SESSION["username"] . ' <br>';
                        } else {
                            echo 'Nazwa użytkownika: ' . $_SESSION["nickname"] . ' (' . $_SESSION["username"] . ') <br>';
                        }
                            echo 'Punkty: 0';
                            echo '<a href="includes/logout-inc.php"><img id="logout" src="images/avatar/logout.jpg" 
                            alt="logout" width="24px"></a>';
                    echo '</div>';
                echo '</div>';
            }
        ?>
        </div>
        <table>
            <tr class="header">
                <td colspan="2">
                    <a href="home.php">
                        <img id="barrel" src="images/logo.png" alt="barrel" width="100px">
                    </a>
                    <br>
                    <a href="home.php">
                        Fanpage Gragasa
                    </a>
                </td>
            </tr>
            <tr class="menu">
                <td>
                    <ul>
                        <li><a href="home.php">Strona główna</a></li>
                        <li><a href="leaderboard.php">Użytkownicy</a></li>
            <?php
                if (isset($_SESSION["username"])) {
                    echo '<li><a href="profile.php">Profil</a></li>';
                    echo '<li><a href="includes/logout-inc.php">Wyloguj</a></li>';
                } else {
                    echo '<li><a href="signup.php">Zarejestruj się</a></li>';
                    echo '<li><a href="login.php">Zaloguj</a></li>';
                }
            ?>
                    </ul>
                </td>
            </tr>