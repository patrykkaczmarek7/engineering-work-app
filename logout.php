<?php

    //Pozwala dokumentowi korzystać z sesji
    session_start();

    // Wymazuje sesje
    session_unset();

    header('Location: logowanie.php');

?>