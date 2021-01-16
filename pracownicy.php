<?php

// Zawiera ten plik
include 'pracownicy_action.php';

// ! to negacja. Funkcja powoduje przekierowanie nas do pierwszej strony logowania
// jeśli nie jesteśmy zalogowani.
if(!isset($_SESSION['zalogowany'])) {
    // Przekierowanie do strony logowanie.
    header('Location: logowanie.php');
    // Opuszczamy plik. Nie ma potrzeby, żeby pozostał ciągle otwarty
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>Employees</title>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        
        <!-- Favicon -->
        <link rel="shortcut icon" type="images/jpg" href="images/SH.png"/>
        <!-- Kompatybilność z najnowszą wersją bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet"/>
        <!-- Bootstrap Awesome Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"/>   
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"/>

        <!-- CSS files  -->        
        <link rel="stylesheet" href="css/style_pracownicy.css"/>

        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    </head>

    <body>
        
    <div class="wrapper">
            <!-- Sidebar  -->
            <nav id="sidebar">
                    <!-- Company logo  -->
                    <div class="sidebar-header">
                        <a href="home.php"><h3>Software House</h3></a>
                    </div>
                    <!-- Sidebar list  -->
                    <ul class="list-unstyled components">
                        <!-- Calendar part  -->
                        <li class="active">
                            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-calendar-check-o"></i><b> Calendar</b></a>
                            <ul class="collapse list-unstyled" id="homeSubmenu">
                                <li>
                                    <a href="terminy_projektow.php"><i class="fa fa-file-code-o"></i><b> Projects deadlines</b></a>
                                </li>

                                <li>
                                    <a href="nadchodzace_wydarzenia.php"><i class="fa fa-desktop"></i> Upcoming events</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Next part of sidebar  -->
                        <li>
                            <a href="projekty.php"><i class="fa fa-check-square-o"></i> Completed projects</a>
                        </li>

                        <li>
                            <a href="przypomnienia.php"><i class="fa fa-bell-o"></i> Reminder</a>
                        </li>
                            
                        <li>
                            <a href="faktury.php"><i class="fa fa-file-text-o"></i> Company invoices</a>
                        </li>

                        <li>
                            <a href="pracownicy.php"><i class="fa fa-user-circle-o"></i> Employees</a>
                        </li>

                        <li>
                            <a href="konto.php"><i class="fa fa-plus-circle"></i> Add account</a>
                        </li>
                    </ul>
                    <!-- Clients' list  -->
                    <ul class="list-unstyled client-list">
                        <li>
                            <a href="klienci.php"><i class="fa fa-users"></i> Clients</a>
                        </li>

                        <li>
                            <a href="spotkania_klienci.php"><i class="fa fa-address-card-o"></i> Meetings with clients</a>
                        </li>
                    </ul>       
                </nav>

            <!-- Page content  -->
            <div id="content">
                <!-- Navbar, menu button & icons  -->
                <nav id="top-nav" class="navbar navbar-expand-lg navbar-light bg-light">
                    <!-- Menu button  -->    
                    <button type="button" class="menu-btn" id="sidebarCollapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Icons button minimalized  Part 1 -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Icons button minimalized Part 2 -->
                    <div class="collapse navbar-collapse" id="navbarText">           
                        <div id="navbar-icons">               
                            <a onclick="openFullscreen();">
                                <!-- Full screen icon -->
                                <a class="icon" title="Full screen" id="myImg" onclick="openFullscreen();"><i class="fa fa-window-maximize fa-lg"></i></a>
                            </a>
                            <!-- Reminder icon -->
                            <a class="icon" title="Reminder" href="przypomnienia.php"><i class="fa fa-bell fa-lg"></i></a>
                            <!-- Log out icon -->
                            <a class="icon" title="Log off" href="logout.php"><i class="fa fa-power-off fa-lg"></i></a>
                        </div> 
                    </div>
                </nav>
                
                <!-- Content -->
                <div class="container-fluid">
                    <!-- Rotation -->
                    <h2 id="rotation" class="alert alert-danger text-center" role="alert">Rotate your device <i class="fa fa-mobile"></i> <br/> and refresh the page</h2>
                    <!-- Inscription -->
                    <br />
                    <h3 class="text-center text-dark mt-2">Employees in the company</h3>
                        <hr />
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <br />
                            <br />
                            <!-- Alert added record -->
                            <?php if (isset($_SESSION['response'])) { ?>
                            <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <b><?= $_SESSION['response']; ?></b>
                            </div>
                            <?php } unset($_SESSION['response']); ?>
                        </div>
                    </div>
                    <!-- Rows -->
                    <div class="row">
                        <!-- Left column -->
                        <div class="col-md-4">
                            <h3 class="text-center text-info">Add employee</h3>
                            <br />
                            <form action="pracownicy_action.php" method="post" enctype="multipart/form-data">
                                <!-- Id -->    
                                <input type="hidden" name="id" value="<?= $id; ?>"/>
                                <!-- Name -->    
                                <div class="form-group">
                                    <input type="text" name="name" value="<?= $name; ?>"class="form-control" placeholder="Name" required/>
                                </div>
                                <!-- e-mail -->  
                                <div class="form-group">
                                    <input type="email" name="email" value="<?= $email; ?>" class="form-control" placeholder="E-mail" required/>
                                </div>
                                <!-- specialty -->
                                <div class="form-group">
                                    <input type="tel" name="specialty" value="<?= $specialty; ?>" class="form-control" placeholder="Specialty" required/>
                                </div>
                                <!-- Select file button-->
                                <div class="form-group">
                                    <input type="hidden" name="oldimage" value="<?= $photo; ?>"/>
                                    <p>The maximum photo size: 2MB</p>
                                    <input type="file" name="image" class="custom-file"/>
                                    <img src="<?= $photo; ?>" width="120" class="img-thumbnail"/>
                                </div>
                                <!-- Send and update button -->
                                <div class="form-group">
                                    <?php if ($update == true) { ?>
                                    <input type="submit" name="update" class="btn btn-success btn-block" value="Update data"/>
                                    <?php } else { ?>
                                    <input type="submit" name="add" class="btn btn-info btn-block" value="Add"/>
                                    <?php } ?>
                                    <p>Recommended size of the image: 500px x 500px</p>
                                </div>
                            </form>
                        </div>
                        <!-- Right column -->
                        <div class="col-md-8">
                            <!-- Selecting from the database -->
                            <?php
                                $query = 'SELECT * FROM pracownicy_crud';
                                $stmt = $conn->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            ?>
                            <!-- Inscription -->
                            <h3 class="text-center text-info">Employees</h3>
                            <br />
                            <table class="table table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>E-mail</th>
                                        <th>Specialty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Fetching data from the database in HTML -->
                                    <?php 
                                        while ($row = $result->fetch_assoc()) { 
                                    ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><img src="<?= $row['photo']; ?>" width="70"/></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['specialty']; ?></td>
                                        <td>
                                        <!-- Action Buttons -->    
                                        <a href="pracownicy_details.php?details=<?= $row['id']; ?>" class="badge badge-primary p-2">Extend</a> <br/>
                                        <a href="pracownicy_action.php?delete=<?= $row['id']; ?>" class="badge badge-danger p-2" onclick="return confirm('Do you want to delete this employee?');">Delete</a> <br/> 
                                        <a href="pracownicy.php?edit=<?= $row['id']; ?>" class="badge badge-success p-2">Edit</a> 
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#data-table').DataTable({
                            "language": {
                                "lengthMenu": "View _MENU_ emplyees:",
                                "search": "Search:",
                                "previous":   "Previous",
                                "zeroRecords": "Emplyee not found",
                                "info": "Page _PAGE_ from _PAGES_",
                                "infoEmpty": "No results to display",
                                "infoFiltered": "(Searching from _MAX_ employees)",
                                "paginate": {
                                    "first": "First",
                                    "last": "Last",
                                    "next": "Next",
                                    "previous": "Previous"},
                            },                    
                                

                        paging: true
                        
                        });

                        
                    });
                </script>
            </div>  
        </div>
        <!-- Rotation. If screen is less than 500px, than alert is showed -->
        <script type="text/javascript">
            var rotation = document.getElementById('rotation'); 
            
            if (screen.width <500) {
                document.write(rotation);
            }
            else {
                document.getElementById("rotation").style.display = "none";
            }
            
        </script>

        <!-- Menu toggle -->
        <script src="js/menu-toggle.js"></script>
        <!-- Full Screen -->
        <script src="js/fullscreen.js"></script>
           

    </body>
</html>