<?php
require "header.php";

?>
<main>
    <br><br><br>
    <div class="signup">
        <section>
            <h1>Signup</h1>
            <br>
            <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "emptyfields") {
                    echo '<p class="errorP"> Fill in all Fields!</p>';
                } else if ($_GET['error'] == "invaliduidmail") {
                    echo '<p class="errorP"> Invalid username and e-mail!</p>';
                } else if ($_GET['error'] == "invaliduid") {
                    echo '<p class="errorP"> Invalid username!</p>';
                } else if ($_GET['error'] == "invalidmail") {
                    echo '<p class="errorP"> Invalid e-mail!</p>';
                } else if ($_GET['error'] == "passwordcheck") {
                    echo '<p class="errorP"> Your passwords do not match!</p>';
                } else if ($_GET['error'] == "usertaken") {
                    echo '<p class="errorP"> Username is already taken!</p>';
                } else if ($_GET['error'] == "success") {
                    echo '<p class="errorP"> Signup Successful!</p>';
                }
            }
            ?>
            <form action="includes/signup.inc.php" method="Post">
                <input type="text" name="uid" placeholder="Username"><br>
                <input type="text" name="mail" placeholder="Email"><br>
                <input type="password" name="pwd" placeholder="Password"><br>
                <input type="password" name="pwd-repeat" placeholder="Repeat password"><br>
                <button class="btn btn-dark" type="submit" name="signup-submit">Signup</button><br>
            </form>
        </section>
    </div>
</main>