<?php 
    include_once "header.php";
?>
            <tr class="table-content">
                <td colspan="2">
                    <div class="content">
                        
                        <section class="signup-form">
                            <h2 class="form">Rejestracja</h2>

                            <form action="includes/signup-inc.php" method="post">
                                <input autofocus class="input-text" type="text" name="username" placeholder="Nazwa użytkownika">
                                <input class="input-text" type="text" name="nickname" placeholder="Przezwisko/ksywka (Opcjonalne)">
                                <input class="input-text" type="email" name="email" placeholder="E-mail">
                                <input class="input-text" type="password" name="password" placeholder="Hasło">
                                <input class="input-text" type="password" name="password_repeat" placeholder="Powtórz hasło">

                                <button type="submit" name="submit">Zarejestruj się</button>
                            </form>
                        </section>

                        <?php
                            if (isset($_GET["error"])) {
                                $error_message;

                                if ($_GET["error"] == "emptyinput") {
                                    $error_message = "*Zostawiłeś/aś puste pola.";
                                }
                                if ($_GET["error"] == "usernameexists") {
                                    $error_message = "*Ta nazwa użytkownika już istnieje.";
                                }
                                if ($_GET["error"] == "emailexists") {
                                    $error_message = "*Ten e-mail już istnieje.";
                                }
                                if ($_GET["error"] == "invalidusernamel") {
                                    $error_message = "*Wpisałeś/aś za krótką nazwę użytkownika.";
                                }
                                if ($_GET["error"] == "invalidusernameg") {
                                    $error_message = "*Wpisałeś/aś za długą nazwę użytkownika.";
                                }
                                if ($_GET["error"] == "invalidusernamer") {
                                    $error_message = "*Wpisałeś/aś złą nazwę użytkownika. (Nie używaj polskich znaków)";
                                }
                                if ($_GET["error"] == "invalidnickname") {
                                    $error_message = "*Wpisałeś/aś złe przezwisko (ksywkę).";
                                }
                                if ($_GET["error"] == "invalidemail") {
                                    $error_message = "*Wpisałeś/aś zły email.";
                                }
                                if ($_GET["error"] == "invalidpassword") {
                                    $error_message = "*Wpisałeś/aś złe hasło.";
                                }
                                if ($_GET["error"] == "passwordmatcherror") {
                                    $error_message = "*Wpisane przez ciebie hasła nie są takie same.";
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