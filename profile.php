<?php
    include_once "header.php";
?>

<script type="text/javascript" src="js/profile/upload.js" defer></script>
            <tr class="table-content">
                <td colspan="2">
                    <div class="content">
                <?php
                    if (!isset($_SESSION["username"])) {
                        header("location: home.php");
                        exit();
                    }

                    require_once "includes/database-handler-inc.php";
                    
                    echo '
                        <section class="profile-area">
                            <h2 class="form">Profil</h2>

                            <form action="includes/profile-inc.php" method="post" enctype="multipart/form-data">
                                <table>
                                    <tr>
                                        <td>
                                            Awatar:
                                        </td>
                                        <td>';
                                            if (empty($_SESSION["profile_picture"])) {
                                                echo '<div class="wrapper">
                                                        <p class="size-info">128px x 128px</p>
                                                        <img class="profile-picture" alt="profile-picture" src="images/avatar/placeholder.jpg" width="128px" height="128px">
                                                    </div>
                                                    <div class="wrapper">
                                                        <p class="size-info">64px x 64px</p>
                                                        <img class="profile-picture" alt="profile-picture" src="images/avatar/placeholder.jpg" width="64px" height="64px"> <br>
                                                    </div>';
                                            } else {
                                                echo '<div class="wrapper">
                                                        <p class="size-info">128px x 128px</p>
                                                        <img class="profile-picture" alt="profile-picture" src="' . $_SESSION["profile_picture"] . '" width="128px" height="128px">
                                                    </div>
                                                    <div class="wrapper">
                                                        <p class="size-info">64px x 64px</p>
                                                        <img class="profile-picture" alt="profile-picture" src="' . $_SESSION["profile_picture"] . '" width="64px" height="64px"> <br>
                                                    </div>';
                                            }
                                            
                                            echo '
                                            
                                            <input class="upload-button" type="file" name="profile_picture" accept="image/*" onchange="previewImage(this)">
                                            <button class="reset-button" id="reset_picture" type="button" name="reset_picture">Resetuj</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nazwa użytkownika:
                                        </td>
                                        <td>
                                            <input disabled class="input-text" type="text" name="username"
                                            value="' . $_SESSION["username"] . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Przezwisko/ksywka:
                                        </td>
                                        <td>';
                                            echo '<input class="input-text" type="text" name="nickname"';
                                            if (emptyInput($_SESSION["nickname"]) === true) {
                                                echo 'placeholder="(brak)"';
                                            } else {
                                                echo 'value="' . $_SESSION["nickname"] . '"';
                                            }
                                            echo '>';
                                    echo '</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            E-mail:
                                        </td>
                                        <td>
                                            <input disabled class="input-text" type="text" name="email"
                                            value="' . $_SESSION["email"] . '">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Niestandardowy kursor:
                                        </td>
                                        <td>
                                            <input class="cursor_options custom_cursor" type="checkbox" name="custom_cursor">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Cząsteczki:
                                        </td>
                                        <td>
                                            <input class="cursor_options particle_cursor" type="checkbox" name="particle_cursor">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button class="content" type="submit" name="submit">Zapisz</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            
                            
                        </section>
                    ';
                ?>

                <?php
                    if (isset($_GET["error"])) {
                        $error_message;

                        if ($_GET["error"] == "invalidext") {
                            $error_message = "*Przesłałeś/aś plik o złym rozszerzeniu.";
                        }
                        if ($_GET["error"] == "invalidsize") {
                            $error_message = "*Przesłałeś/aś za duży plik.";
                        }
                        if ($_GET["error"] == "uploaderror") {
                            $error_message = "*Błąd przy przesyłaniu pliku.";
                        }
                        if ($_GET["error"] == "invalidnickname") {
                            $error_message = "*Wpisałeś/aś złe przezwisko (ksywkę).";
                        }
                        
                        echo '<p class="error-message">' . $error_message . '<br>Spróbuj ponownie.</p>';
                    }
                ?>
                    </div>
                </td>
            </tr>
<?php
    include_once "footer.php";
?>