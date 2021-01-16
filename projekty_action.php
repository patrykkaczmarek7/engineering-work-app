<?php 
    session_start();
    include 'projekty_config.php';
    
    // Nadanie zmiennych
    $update = false;
	$id = "";
    $photo = "";
    $name = "";
	$domain = "";
	$price = "";
	

    // Dodanie rekordu do bazy danych
    if(isset($_POST['add'])) {
		$name = $_POST['name'];
		$domain = $_POST['domain'];
		$price = $_POST['price'];

        // Image znajduje się w HTML - skrypt korzysta z niego
        $photo = $_FILES['image']['name'];
		$upload = "projekty_uploads/".$photo;

        // Wstawić w projekty_crud wartości ?,?,?,?
        $query = "INSERT INTO projekty_crud(name,domain,price,photo)VALUES(?,?,?,?)";
        // Komunikat (stmt - statement). Prepared Statements polega to na tym, 
        // że najpierw przygotowujemy instrukcję dla bazy z miejscami przygotowanymi 
        // dla argumentów, po czym osobno przypisujemy argumenty w kolejnym poleceniu. 
        // W ten sposób nie ma mowy o ingerencji w wykonywany kod SQL, gdyż nie łączymy 
        // wielu stringów w jeden i nie wykonujemy go w całości.
        $stmt=$conn->prepare($query);
        // Połączenie zmiennych jako string, bo to są string'i
        $stmt->bind_param("ssss",$name,$domain,$price,$upload);
        // Wykonanie przygotowanego zapytania z podstawionymi danymi
        $stmt->execute();
        // Przenoszenie pliku do folderu projekty_uploads. tmp_name tworzy plik
        move_uploaded_file($_FILES['image']['tmp_name'], $upload);
        
        // Powrót do strony po dodaniu rekordu
        header('location:projekty.php');
        $_SESSION['response'] = "Project added!";
        // Kolor powiadomienia
        $_SESSION['res_type'] = "success";
    } 

    // Sekcja usuwania
    if(isset($_GET['delete'])) {
        $id=$_GET['delete'];

        // Usuwanie zdjęcia również z folderu zdjęć
        $sql = "SELECT photo FROM projekty_crud WHERE id=?";
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
        $query = "DELETE FROM projekty_crud WHERE id=?";
        // Wyżej wyjaśnienie
        $stmt = $conn->prepare($query);
        // Połączenie zmiennych jako int, bo to są int'y
        $stmt->bind_param("i",$id);
        // Wykonanie przygotowanego zapytania z podstawionymi danymi
        $stmt->execute();

        // Powrót do strony po dodaniu rekordu
        header('location:projekty.php');
        $_SESSION['response'] = "Project deleted!";
        // Kolor powiadomienia
        $_SESSION['res_type'] = "success";

    }

    // Sekcja edytowania
    if(isset($_GET['edit'])) {
        $id = $_GET['edit'];

        $query = "SELECT * FROM projekty_crud WHERE id=?";
        $stmt=$conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $_result = $stmt->get_result();
        $row = $_result->fetch_assoc();

        $id = $row['id'];
        $name = $row['name'];
        $domain = $row['domain'];
        $price = $row['price'];
        $photo = $row['photo'];

        // Ustawienie update na true, żeby zmienić przycisk
        $update = true;
    }

    // Sekcja edycji projektu
    if(isset($_POST['update'])) {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$domain = $_POST['domain'];
		$price = $_POST['price'];
		$oldimage = $_POST['oldimage'];

		if(isset($_FILES['image']['name']) && ($_FILES['image']['name']!="")) {
			$newimage="projekty_uploads/".$_FILES['image']['name'];
			unlink($oldimage);
			move_uploaded_file($_FILES['image']['tmp_name'], $newimage);
		}
		else{
			$newimage=$oldimage;
		}
		$query = "UPDATE projekty_crud SET name=?,domain=?,price=?,photo=? WHERE id=?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("ssssi",$name,$domain,$price,$newimage,$id);
		$stmt->execute();

		$_SESSION['response']="project updated!";
        $_SESSION['res_type']="success";
        
		header('location:projekty.php');
    }
    
    if(isset($_GET['details'])) {
        $id = $_GET['details'];
        $query = "SELECT * FROM projekty_crud WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $vid = $row['id'];
        $vname = $row['name'];
        $domain = $row['domain'];
        $price = $row['price'];
        $vphoto = $row['photo'];
    }
?>

