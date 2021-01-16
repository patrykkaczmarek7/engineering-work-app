
<!-- Skrypt PHP pobiera wprowadzone dane z HTML -->
<?php

//Pozwala dokumentowi korzystać z sesji
session_start();

// ( To jest || lub ) Jeśli nie mamy podanego loginu i hasła, przekierowuje nas do strony logowania
if ((!isset($_POST['login'])) || (!isset($_POST['haslo']))) {

    header('Location: logowanie.php');
    exit();

}

//Dodanie danych z pliku connect.php do zaloguj.php
require_once "connect.php";

//#1 Podajemy namiary w nawiasach i ustalamy połączenie z bazą
//#2 @ - sprawia, że nie wyrzuci błędu, bo sam nadaje kontrolę błędów
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

// Jeśli połączenie uda nam się ustanowić, to if się nie spełni. 0 = false, 1(i większe od 1) = true
if ($polaczenie->connect_errno!=0) {

    echo "Error: ".$polaczenie->connect_errno;
//  Z opisem błędu
//  echo "Error: ".$polacznie->connect_errno . "Opis: ". $polaczenie->connect_error;
} 

else {
    //Pobieranie danych
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    // Encje HTML. Uniemożliwia wykonanie skryptów w loginie
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    
    
    // rezultat zapytania SQL z zabezpieczeniem SQL Injection
    if ($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
        mysqli_real_escape_string($polaczenie,$login)))) {
        
        //Skrypt sprawdzający liczbę userów
        $ilu_userow = $rezultat->num_rows;
        
        //Jeśli jest jeden (a zawsze ma być tylko 1), to się zaloguje
        if ($ilu_userow>0) {

            // fetch assoc - przynieś dane i włóż je do tablicy asocjacyjnej
            $wiersz = $rezultat->fetch_assoc();

            // Funkcja sprawdzająca, czy haslo jest takie same jak zahashowane w bazie 
            if (password_verify($haslo, $wiersz['pass'])) {

                // Nie wylogowuje, ponieważ wartość jest ustawiona na true
                $_SESSION['zalogowany'] = true;
                

                $_SESSION['id'] = $wiersz['id'];

                //Tylko programista ma dostęp. 
                //Umożliwia przekazywanie zmiennych pomiędzy podstronami.
                //Zmienne są przechowywane po stronie serwera, ...
                //... a klient na swoim komputerze posiada tylko identyfikator sesji PHPSESSID
                $_SESSION['user'] = $wiersz['user'];
                $_SESSION['email'] = $wiersz['email'];
                
                

                // Jeśli udało nam się zalogować, to usuniemy z sesji zmienną błąd
                unset($_SESSION['blad']);
                // Pozbycie się z pamięci już niepotrzebnych rezultatów zapytania 
                $rezultat->close();

                header('Location: home.php');
                
            }

            else {
                // Komunikat o błędzie, jeśli wprowadzimy złe dane - inne niż w bazie danych
                $_SESSION['blad'] = '<span style="color:rgb(255, 81, 81)">Incorrect login or password!</span>';
                header('Location: logowanie.php');
            }
            
        } 

        else {
            // Komunikat o błędzie, jeśli wprowadzimy złe dane - inne niż w bazie danych
            $_SESSION['blad'] = '<span style="color:rgb(255, 81, 81)">Incorrect login or password!</span>';
            header('Location: logowanie.php');
        }

    }

    //Zamknięcie połączenia, żeby nie było nieskończoność
    $polaczenie->close();

}




?>
