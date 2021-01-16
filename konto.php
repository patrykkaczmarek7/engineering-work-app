<?php

    //Pozwala dokumentowi korzystać z sesji
    session_start();

    // Sprawdzenie, czy użytkownik jest zalogowany
    if(!isset($_SESSION['zalogowany'])) {
        // Przekierowanie do strony logowanie.
        header('Location: logowanie.php');
        // Opuszczamy plik. Nie ma potrzeby, żeby pozostał ciągle otwarty
        exit();
    }
    // Jeśli formularz jest wysłany
    if (isset($_POST['email'])) {
        
        // Udana walidacja
        $wszystko_OK = true;

        // Sprawdź poprawność nickname
        $nick = $_POST['nick'];

        // Sprawdzenie długości nick'a
        if ((strlen($nick) < 3) || (strlen($nick) > 20 )) {

            $wszystko_OK = false;
            $_SESSION['e_nick'] = "Login must be between 3 and 20 characters long!";
       
        }

        // Sprawdzenie, czy wszystkie znaki w łańcuchu są alfanumeryczne
        if (ctype_alnum($nick) == false) {

            $wszystko_OK = false;
            $_SESSION['e_nick'] = "Login must consist of letters and numbers only";

        }

        // Sprawdź poprawność adresu email
        $email = $_POST['email'];
        // Pomaga usunąć niedopuszczalne znaki z adresu email
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB!=$email)) {

            $wszystko_OK = false;
            $_SESSION['e_email'] = "Please enter a correct e-mail address!";

        }

        //Sprawdź poprawność hasła
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        // Funkcja sprawdzająca, czy hasło ma od 8 do 20 znaków
        if ((strlen($haslo1) < 8) || (strlen($haslo1) >20)) {

            $wszystko_OK = false;
            $_SESSION['e_haslo'] = "Password must be 8 to 20 characters long!";

        }

        if ($haslo1 != $haslo2) {

            $wszystko_OK = false;
            $_SESSION['e_haslo'] = "Entered passwords are not the same";

        }

        $haslo_hash =  password_hash($haslo1, PASSWORD_DEFAULT); 
       
        // Czy zaakceptowano regulamin
        if (!isset($_POST['regulamin'])) {

            $wszystko_OK = false;
            $_SESSION['e_regulamin'] = "You have to accept regulations!";

        }

        // Sprawdzenie zaznaczenia reCAPTCHY
        $sekret = "6LeP4voUAAAAAJQOEEnazEVxDI2fXD988Jfupqw1";

        // Pobierz zawartość pliku do zmiennej. reCAPTCHA z sekretnym kluczem
        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);

        // Sprawdzenie w JSON google
        $odpowiedz = json_decode($sprawdz);


        // Funkcja, która sprawdza, czy użytkownik zaznaczył reCAPTCHA
        if ($odpowiedz->success == false) {

            $wszystko_OK = false;
            $_SESSION['e_bot'] = "Please confirm that you are not a bot!";

        }

        // Połącznie
        require_once "connect.php";
        // Raportowanie błędów oparte o wyjątki
        mysqli_report(MYSQLI_REPORT_STRICT);


        try {

            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno!=0) {

                // Rzuć nowym wyjątkiem. Catch ma go złapach i wyświetlić
                throw new Exception(mysqli_connect_errno());
            }

            else {

                // Czy email już istnieje
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

                // Jeśli jest błąd
                if (!$rezultat) throw new Exception($polaczenie->error);

                // Sprawdzenie czy e-mail się powtarza
                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili>0) {

                    $wszystko_OK = false;
                    $_SESSION['e_email'] = "There is already an account with the given e-mail address!";
        
                }

                // Czy nick jest juz zarezerwowany
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");

                // Jeśli jest błąd
                if (!$rezultat) throw new Exception($polaczenie->error);

                // Sprawdzenie czy e-mail się powtarza
                $ile_takich_nickow = $rezultat->num_rows;
                if($ile_takich_nickow>0) {

                    $wszystko_OK = false;
                    $_SESSION['e_nick'] = "There is already a user with this login!";
        
                }

                // Jeśli użytkownik wpisał wszystko poprawnie - rejestruje się
                if ($wszystko_OK == true) {

                    if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email')")) {

                        $_SESSION['udanarejestracja'] = true;
                        header('Location: home.php');

                    }

                    else {

                        throw new Exception($polaczenie->error);

                    }
                    
                }

                // Zamknięcie połączenia
                $polaczenie->close();

            }

        }

        catch(Exception $e) {

            echo '<span style="color:rgb(255, 81, 81);">Server error. Sorry for the inconvenience. Please register at another date!</span>';
            echo '<br />Developer information: '.$e;
        }


    }

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Add account</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="images/jpg" href="images/SH.png"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet"/>
    <!-- Bootstrap Fonts -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"/>
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous"/>
    <!-- CSS files  -->        
    <link rel="stylesheet" href="css/style_rejestracja.css"/>
    <!-- reCAPTCHA od google -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

    <body>
        <div class="register-form">
        <h1>Adding an account to the system</h1> 
            <hr /> 
            <br />
            <br />
            <br />

            <div class="row">

                <!-- Lewa strona  -->
                <div class="col-md-6">           
                        <br /><br />
                        <!-- metoda POST przekierywująca  -->
                    <form method="post" class="register-text">

                        Login: <br /> <i class="fa fa-address-book-o"></i> <input type="text" name="nick"/><br />

                        <?php
                            
                            // Skrypt sprawdzający poprawność podanego nick'a
                            if (isset($_SESSION['e_nick'])) {

                                echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                                unset($_SESSION['e_nick']);

                        }

                        ?>


                        E-mail: <br /> <i class="fa fa-envelope"></i> <input type="text" name="email" /><br />

                        <?php

                            // Skrypt sprawdzający poprawność podanego e-mail'a
                            if (isset($_SESSION['e_email'])) {

                                echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                                unset($_SESSION['e_email']);

                        }

                        ?>

                        Password: <br /> <i class="fa fa-key"></i> <input type="password" name="haslo1" /><br />

                        <?php

                            // Skrypt sprawdzający poprawność podanego hasla
                            if (isset($_SESSION['e_haslo'])) {

                                echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
                                unset($_SESSION['e_haslo']);
                            }

                        ?>

                        Repeat the password: <br /> <i class="fa fa-repeat"></i> <input type="password" name="haslo2" /><br />
                        <br />
                        <label>
                            <input type="checkbox" name="regulamin" /> I accept the regulation (<a href="regulamin.html" class="register" target="_blank">Check</a>) 
                        </label>
                        
                        <?php

                            // Skrypt sprawdzający poprawność zakceptowanego regulaminu
                            if (isset($_SESSION['e_regulamin'])) {

                                echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                                unset($_SESSION['e_regulamin']);
                            }

                        ?>

                        <br />
                        <br />
                        
                        
                        <!-- reCAPTCHA od google -->
                        <div class="g-recaptcha" data-sitekey="6LeP4voUAAAAAJevLGsVrDlMdVCHe_aivTqkJQec"></div>
                        <?php

                            // Skrypt sprawdzający poprawność zakceptowanego regulaminu
                            if (isset($_SESSION['e_bot'])) {

                                echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                                unset($_SESSION['e_bot']);
                            }

                        ?>

                        <br />

                        <!-- Przycisk zarejestrowania się -->
                        <input type="submit" class="button" value="Add account"/>
                    </form>
                </div>
                <!-- Prawy -->
                <div class="col-md-6">
                    <br /> <img src="images/logowanie/SH.png" alt="JavaScript" width="200px" height="200px"/> <br /> <br />
                    <a href="home.php" class="login">Would you like to go back<br /> to the aplication? <br />Return</a>      
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