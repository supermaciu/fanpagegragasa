<?php 
    include_once "header.php";
?>

<script type="text/javascript" src="js/leaderboard/search.js" defer></script>
            <tr class="table-content">
                <td colspan="2">
                    <div class="content">

                        <span class="search-addon">Szukaj</span>
                        <input type="text" name="searchbar" id="searchbar"
                        placeholer="Nazwa użytkownika..." class="form-control">

                        <div id="result">
                            <?php
                                $sql = "SELECT * FROM users;";
                                $result = mysqli_query($conn, $sql);

                                echo '<div class="list-accounts">';
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {            
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
                                    }
                                }
                                echo '</div>';
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
<?php
    include_once "footer.php";
?>