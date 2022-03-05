<?php 
    include_once "header.php";
?>
            <tr class="table-content">
                <td colspan="2">
                    <div class="content">
            <?php
                require_once "includes/functions-inc.php";

                if (isset($_SESSION["username"])) {
                    echo '
                        W trakcie tworzenia...
                    ';
                } else {
                    header("location: home.php");
                    exit();
                }
            ?>                    
                    </div>
                </td>
            </tr>
<?php
    include_once "footer.php";
?>