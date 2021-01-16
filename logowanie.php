<?php

    //Pozwala dokumentowi korzystać z sesji
    session_start();

    if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {

        // Przekierowanie do strony logowanie.
        header('Location: logowanie.php');

        // Opuszczamy plik. Nie ma potrzeby, żeby pozostał ciągle otwarty
        exit();
    }

?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <title>Log in</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="images/jpg" href="images/SH.png"/>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet"/>
        <!-- Bootstrap Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"/>
        <!-- Bootstrap  -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"/>
        <!-- CSS files  -->        
        <link rel="stylesheet" href="css/style_logowanie.css"/>
    </head>

    <body>
        <div class="login-form">
            <h1>Log in</h1> 
            <hr /> 
            <br />
            <br />
            <br />

            <div class="row">

                <!-- Lewa strona  -->
                <div class="col-md-6">           
                    <br />
                    <br />
                    <!-- metoda POST przekierywująca  -->
                    <form action="zaloguj.php" class="login_text" method="POST">
                        <!-- Logowanie i hasło -->
                        Login: <br /> <i class="fa fa-address-book-o"></i> <input type="text" name="login" /> <br />
                        Password: <br /> <i class="fa fa-key"></i> <input type="password" name="haslo" /> <br /><br />
                        <!-- Button -->
                        <input type="submit" class= "button" value="Sign in" />
                    </form>
                    <!-- Incorrect login or password! -->
                    <?php

                        if(isset($_SESSION['blad'])) 
                        echo $_SESSION['blad'];

                    ?>
                    <br />
                    <br />                  
                </div>

                <!-- Prawy -->
                <div class="col-md-6">
                    <br /> <img src="images/logowanie/SH.png" alt="JavaScript" width="200px" height="200px"/> <br />
                    <h4>Software House</a>     
                </div>
            </div>
        </div> 

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>           
    </body>
</html>