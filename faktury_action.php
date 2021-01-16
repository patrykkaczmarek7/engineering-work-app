<?php
session_start();
// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'file_upload');

$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);


$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'faktury_uploads/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];


    if (!in_array($extension, ['zip', 'pdf', 'docx', 'jpg', 'jpeg', 'JPG', 'JPEG'])) {
        $_SESSION['response'] = "Adding error! Permitted file extensions with an invoice is: <br/> 'zip', 'pdf', 'docx', 'jpg', 'jpeg', 'JPG', 'JPEG'";
        $_SESSION['res_type'] = "danger";
        

    } else if ($_FILES['myfile']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        $_SESSION['response'] = "No invoice file added because it is too big! The file cannot be larger than 1MB.";
        $_SESSION['res_type'] = "danger";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (name, size, downloads) VALUES ('$filename', $size, 0)";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['response'] = "Invoice added! To see the added invoice, click the update data button.";
                $_SESSION['res_type'] = "success";
            }
            } else {
                $_SESSION['response'] = "Adding error! Something went wrong. Check the invoice file, because it can be is too large or has a wrong extension.";
                $_SESSION['res_type'] = "danger";
            }
    }
}

// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'faktury_uploads/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('faktury_uploads/' . $file['name']));
        
        //This part of code prevents files from being corrupted after download
        ob_clean();
        flush();
        
        readfile('faktury_uploads/' . $file['name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}

// Sekcja usuwania
if(isset($_GET['delete'])) {
    $id=$_GET['delete'];

    // Usuwanie zdjęcia również z folderu zdjęć
    $sql = "SELECT name FROM files WHERE id=?";
    $stmt2 = $conn->prepare($sql);
    // Połączenie zmiennych jako int, bo to są int'y
    $stmt2->bind_param("i",$id);
    // Wykonanie przygotowanego zapytania z podstawionymi danymi
    $stmt2->execute();
    // Otrzymanie wyniku
    $_result2=$stmt2->get_result();
    // Wydobywanie danych 
    $row = $_result2->fetch_assoc();

    // Przypisanie zdjęcia jako zmienna
    $filepath = $row['name'];
    // Usuwa plik z podaną ścieżką
    unlink(dirname(__FILE__) . "/faktury_uploads/" . $filepath);

    // Sekcja usuwania w bazie danych
    $query = "DELETE FROM files WHERE id=?";
    // Wyżej wyjaśnienie
    $stmt = $conn->prepare($query);
    // Połączenie zmiennych jako int, bo to są int'y
    $stmt->bind_param("i",$id);
    // Wykonanie przygotowanego zapytania z podstawionymi danymi
    $stmt->execute();

    $_SESSION['response']="Invoice deleted!";
    $_SESSION['res_type']="success";
    header('location:faktury.php');
    

}
