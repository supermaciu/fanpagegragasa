<?php 
    include_once "header.php";
?>
            <tr class="table-content">
                <td colspan="2">
                    <div class="content">
            <?php
                require_once 'includes/functions-inc.php';

                if (isset($_SESSION["username"])) {
                    if (emptyInput($_SESSION["nickname"]) === false) {
                        echo '<h1 class="home">Witaj, ' . $_SESSION["nickname"] .'!</h1>';
                    } else if (emptyInput($_SESSION["nickname"]) === true) {
                        echo '<h1 class="home">Witaj, ' . $_SESSION["username"] .'!</h1>';
                    }
                } else {
                    echo '<h1 class="home">Witaj, przywoływaczu!</h1>';
                }
            ?>
            <?php
                if (isset($_SESSION["username"])) {
                    echo '
                        <p class="home">
                        Forum jest jeszcze w trakcie tworzenia, lecz mamy też inne atrakcje:
                        </p>

                        <br>

                        <a href="profile.php"><button class="content bigger">Profil</button></a>
                        <a href="leaderboard.php"><button class="content bigger">Użytkownicy</button></a>
                        <a href="games.php"><button class="content bigger">Gry</button></a>
                        ';
                } else {
                    echo '
                        <p class="home">
                            Fanpage Gragasa to forum dyskusyjne na temat ulubionego czempiona każdego gracza Ligi Legend - Gragasa!
                            <br><br>
                            Zapraszamy do wspólnej konwersacji o skinach (skórek), lorze (historii bohatera) lub o czymś w ogóle innym, to
                            wy decydujcie!
                        </p>

                        <br>

                        <img src="images/gragas.gif" alt="gragas-dancing" width="15%">

                        <br>

                        <div class="signup-area">
                            <a href="signup.php"><button class="content">Zarejestruj się</button></a>
                            a jeżeli masz już założone konto
                            <a href="login.php"><button class="content">Zaloguj się</button></a>
                        </div>
                        ';
                }
            ?>
                        
                    </div>
                </td>
            </tr>
<?php
    include_once "footer.php";
?>