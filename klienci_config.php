<?php
    // server, username of the server, password, name of the database
    $conn = new mysqli("localhost","root","","klienci");

    // Jeśli wystąpił błąd połączenia
    if($conn->connect_error) {
        die("Error with database connection!".$conn->connect_error);
    }
?>