<?php

//Pozwala dokumentowi korzystać z sesji
session_start();
// ! to negacja. Funkcja powoduje przekierowanie nas do pierwszej strony logowania
// jeśli nie jesteśmy zalogowani.
if(!isset($_SESSION['zalogowany'])) {
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
        <title>Reminder</title>

        <!-- Favicon -->
        <link rel="shortcut icon" type="images/jpg" href="images/SH.png"/>
        <!-- Kompatybilność z najnowszą wersją bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet"/>
        <!-- Bootstrap Awesome Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"/>
            

        <!-- CSS files  -->        
        <link rel="stylesheet" href="css/style_przypomnienia.css"/>
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
                <!-- Sekcja Przypomnienia -->
                <div class="element">
                    <div class="container-fluid">
                        <a class="navbar-brand"><b><i class="fa fa-bell-o"></i> Reminder:</b></a>
                    </div>

                    <div class="container-fluid">
                        <div class="row my-5">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="form-Task">
                                            <div class="form-group">
                                                <input type="text" id="title" class="form-control" maxlength="50" autocomplete="off" placeholder="Title and date" required/>
                                            </div>
                                            <div class="form-group">
                                                <textarea id="description" cols="30" rows="10" class="form-control" maxlength="500" autocomplete="off"
                                                placeholder="Description" required></textarea>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success btn-block">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="navbar navbar-expand-lg navbar-light bg-light">
                                    <div class=" col-sm-3 text-center">
                                        <p class="font-weight-bold">Title and date</p>
                                    </div>
                                    <div class=" col-sm-6 text-center">
                                        <p class="font-weight-bold">Description</p>
                                    </div>
                                    <div class=" col-sm-3 text-center">
                                        <p class="font-weight-bold">Delete</p>
                                    </div>
                                </div>
                                <hr />
                                <div id="tasks"></div>
                            </div>
                        </div>
                    </div>

                    <script src="js/przypomnienia.js"></script>
                </div>
            </div>  
        </div>
              
        <!-- jQuery CDN - Slim version (=without AJAX) -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <!-- Popper.JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

        <!-- Menu toggle -->
        <script src="js/menu-toggle.js"></script>
        <!-- Full Screen -->
        <script src="js/fullscreen.js"></script>
        
    </body>
</html>