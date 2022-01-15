<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta>
    <title>

    </title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body class="parent">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img class="leon" src="img/quarto_icon.png" alt="logo"></a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <?php
                        if(isset($_SESSION['userId'])){
                        echo '<li class="nav-item">
                            <a class="nav-link" aria-current="page" href="game.php">Game</a>
                            </li>';
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="aboutUs.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="contact.php">Contact</a>
                        </li>
                       
                    </ul>
                </div>
                <div>
                    <!-- post safe data -->
                    <?php
                    if (isset($_SESSION['userId'])) {
                        echo '<form action="includes/logout.inc.php" method="POST">
                    <button type="submit" class="btn btn-primary" name="logout-submit">Logout</button>
                </form>';
                    } else {
                        echo '<form action="includes/login.inc.php" method="POST">
                    <input type="text" name="mailuid" placeholder="Username/E-mail">
                    <input type="password" name="pwd" placeholder="Password">
                    <button class="btn btn-primary" type="submit" name="login-submit">Login</button>
                    <a href="signup.php" class="btn btn-primary">Signup</a>
                </form>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
</body>

</html>