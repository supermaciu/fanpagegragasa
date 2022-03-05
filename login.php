<?php 
    include_once "header.php";
?>
            <tr class="table-content">
                <td colspan="2">
                    <div class="content">
                        
                    <section class="login-form">
                        <h2 class="form">Logowanie</h2>

                        <form action="includes/login-inc.php" method="post">
                            <input autofocus class="input-text" type="text" name="username" placeholder="Nazwa użytkownika/E-mail">
                            <input class="input-text" type="password" name="password" placeholder="Hasło">

                            <button type="submit" name="submit">Zaloguj się</button>
                        </form>
                    </section>
                    
                    <?php
                        if (isset($_GET["error"])) {
                            $error_message;

                            if ($_GET["error"] == "emptyinput") {
                                $error_message = "*Zostawiłeś/aś puste pola.";
                            }
                            if ($_GET["error"] == "invalidusername") {
                                $error_message = "*Wpisałeś/aś złą nazwę użytkownika lub hasło.";
                            }
                            if ($_GET["error"] == "invalidpassword") {
                                $error_message = "*Wpisałeś/aś złe hasło.";
                            }
                            
                            echo '<p class="error-message">' . $error_message . '<br>Please try again.</p>';
                        }
                    ?>
                    </div>
                </td>
            </tr>
<?php
    include_once "footer.php";
?>