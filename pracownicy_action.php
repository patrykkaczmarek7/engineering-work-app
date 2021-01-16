<?php 
    session_start();
    include 'pracownicy_config.php';
    
    // Nadanie zmiennych
    $update = false;
	$id = "";
    $photo = "";
    $name = "";
	$email = "";
	$specialty = "";
	

    // Dodanie rekordu do bazy danych
    if(isset($_POST['add'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$specialty = $_POST['specialty'];

        // Image znajduje się w HTML - skrypt korzysta z niego
        $photo = $_FILES['image']['name'];
		$upload = "pracownicy_uploads/".$photo;

        // Wstawić w pracownicy_crud wartości ?,?,?,?
        $query = "INSERT INTO pracownicy_crud(name,email,specialty,photo)VALUES(?,?,?,?)";
        // Komunikat (stmt - statement). Prepared Statements polega to na tym, 
        // że najpierw przygotowujemy instrukcję dla bazy z miejscami przygotowanymi 
        // dla argumentów, po czym osobno przypisujemy argumenty w kolejnym poleceniu. 
        // W ten sposób nie ma mowy o ingerencji w wykonywany kod SQL, gdyż nie łączymy 
        // wielu stringów w jeden i nie wykonujemy go w całości.
        $stmt=$conn->prepare($query);
        // Połączenie zmiennych jako string, bo to są string'i
        $stmt->bind_param("ssss",$name,$email,$specialty,$upload);
        // Wykonanie przygotowanego zapytania z podstawionymi danymi
        $stmt->execute();
        // Przenoszenie pliku do folderu pracownicy_uploads. tmp_name tworzy plik
        move_uploaded_file($_FILES['image']['tmp_name'], $upload);
        
        // Powrót do strony po dodaniu rekordu
        header('location:pracownicy.php');
        $_SESSION['response'] = "Employee added!";
        // Kolor powiadomienia
        $_SESSION['res_type'] = "success";
    } 

    // Sekcja usuwania
    if(isset($_GET['delete'])) {
        $id=$_GET['delete'];

        // Usuwanie zdjęcia również z folderu zdjęć
        $sql = "SELECT photo FROM pracownicy_crud WHERE id=?";
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
        $imagepath = $row['photo'];
        // Usuwa plik
        unlink($imagepath);

        // Sekcja usuwania w bazie danych
        $query = "DELETE FROM pracownicy_crud WHERE id=?";
        // Wyżej wyjaśnienie
        $stmt = $conn->prepare($query);
        // Połączenie zmiennych jako int, bo to są int'y
        $stmt->bind_param("i",$id);
        // Wykonanie przygotowanego zapytania z podstawionymi danymi
        $stmt->execute();

        // Powrót do strony po dodaniu rekordu
        header('location:pracownicy.php');
        $_SESSION['response'] = "Employee deleted!";
        // Kolor powiadomienia
        $_SESSION['res_type'] = "success";

    }

    // Sekcja edytowania
    if(isset($_GET['edit'])) {
        $id = $_GET['edit'];

        $query = "SELECT * FROM pracownicy_crud WHERE id=?";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $_result = $stmt->get_result();
        $row = $_result->fetch_assoc();

        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $specialty = $row['specialty'];
        $photo = $row['photo'];

        // Ustawienie update na true, żeby zmienić przycisk
        $update = true;
    }

    // Sekcja edycji pracownika
    if(isset($_POST['update'])) {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$specialty = $_POST['specialty'];
		$oldimage = $_POST['oldimage'];

		if(isset($_FILES['image']['name']) && ($_FILES['image']['name']!="")) {
			$newimage="pracownicy_uploads/".$_FILES['image']['name'];
			unlink($oldimage);
			move_uploaded_file($_FILES['image']['tmp_name'], $newimage);
		}
		else{
			$newimage=$oldimage;
		}
		$query = "UPDATE pracownicy_crud SET name=?,email=?,specialty=?,photo=? WHERE id=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ssssi",$name,$email,$specialty,$newimage,$id);
		$stmt->execute();

		$_SESSION['response']="Employee updated!";
        $_SESSION['res_type']="success";
        
		header('location:pracownicy.php');
    }
    
    if(isset($_GET['details'])) {
        $id = $_GET['details'];
        $query = "SELECT * FROM pracownicy_crud WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $vid = $row['id'];
        $vname = $row['name'];
        $vemail = $row['email'];
        $vspecialty = $row['specialty'];
        $vphoto = $row['photo'];
    }
?>

