<?php

// Zawiera ten plik
include 'klienci_action.php';

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
        <title>Add client</title>
        
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
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet"/>
        <!-- Bootstrap Awesome Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"/>

        <!-- CSS files  -->        
        <link rel="stylesheet" href="css/style_klienci2.css"/>

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
                    <!-- Inscription -->
                    <a class="navbar-brand"><i class="fa fa-users"></i><b> Clients:</b></a>
                    <a href="klienci.php" type="button" class="btn btn-success"><i class="fa fa-arrow-left"></i> Return</a>
                    <!-- Inscription with hr -->
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <h3 class="text-center text-dark mt-2">Add client</h3>
                            <hr />
                            <br />
                        </div>
                    </div>
                    <!-- Rows -->
                    <div class="row justify-content-center">
                        <!-- Main column -->
                        <div class="col-lg-4">
                            <form action="klienci_action.php" method="post" enctype="multipart/form-data">
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
                                <!-- phone -->
                                <div class="form-group">
                                    <input type="tel" name="phone" value="<?= $phone; ?>" class="form-control" placeholder="Phone" required/>
                                </div>
                                <!-- Select file button-->
                                <div class="form-group">
                                    <input type="hidden" name="oldimage" value="<?= $photo; ?>"/>
                                    <p>The maximum size of the logo: 2MB</p>
                                    <input type="file" name="image" class="custom-file">
                                    <img src="<?= $photo; ?>" width="120" class="img-thumbnail"/>
                                </div>
                                <!-- Send and update button -->
                                <div class="form-group">
                                    <?php if ($update == true) { ?>
                                    <input type="submit" name="update" class="btn btn-success btn-block" value="Update data"/>
                                    <?php } else { ?>
                                    <input type="submit" name="add" class="btn btn-info btn-block" value="Add"/>
                                    <?php } ?>
                                    <p>Recommended size of the logo: 500px x 500px</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
        </div>

        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

        <!-- Menu toggle -->
        <script src="js/menu-toggle.js"></script>
        <!-- Full Screen -->
        <script src="js/fullscreen.js"></script>
    </body>
</html>