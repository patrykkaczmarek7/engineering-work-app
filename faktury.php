<?php
    include 'faktury_action.php';
    //Pozwala dokumentowi korzystać z sesji
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
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>Invoices</title>

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
        <link rel="stylesheet" href="css/style_faktury.css"/>

        <!-- Datatables  -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
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
                    <a class="navbar-brand"><i class="fa fa-file-text-o"></i><b> Company invoices:</b></a>
                    <a href="faktury_dodaj.php" type="button" class="btn btn-success">Add</a>
                    <a href="faktury.php" type="button" class="btn btn-primary">Update data</a>
                    <!-- Alert -->
                    <div class=" row justify-content-center">
                        <div class="col-md-12">
                            <!-- Alert added record -->
                            <?php if (isset($_SESSION['response'])) { ?>
                                <br />
                                <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <b><?= $_SESSION['response']; ?></b>
                                </div>
                            <?php } unset($_SESSION['response']); ?>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <br />
                            <h3 class="text-center text-dark mt-2">Company invoices added to the system</h3>
                            <hr />
                            <br />

                            <table id="table_faktury" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice name</th>
                                        <th>File size in MB</th>
                                        <th class="text-center">Downloads</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($files as $file): ?>
                                    
                                        <tr>
                                            <td><?php echo $file['id'];?></td>
                                            <td><?php echo $file['name'];?></td>
                                            <td><?php echo $file['size'] / 1000 . "KB";?></td>
                                            <td class="text-center">
                                                <?php echo $file['downloads'];?>
                                            </td>
                                            <td class="text-center">
                                                <a href="faktury.php?file_id=<?php echo $file['id']?>" class="btn btn-info">Download</a>
                                                <a href="faktury_action.php?delete=<?= $file['id']; ?>" class="btn btn-danger" onclick="return confirm('Do you want to delete this invoice?');">Delete</a>
                                            </td>
                                        </tr>

                                        <?php endforeach ; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script   script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <!--    Datatables-->
        <script script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
  
        <script>   
            $(document).ready(function() {
                $('#table_faktury').DataTable({
                    "language": {
                        "lengthMenu": "View _MENU_ invoices:",
                        "search": "Search:",
                        "previous":   "Previous",
                        "zeroRecords": "Invoice not found",
                        "info": "Page _PAGE_ from _PAGES_",
                        "infoEmpty": "No results to display",
                        "infoFiltered": "(Searching from _MAX_ invoices)",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Back"},
                        },                    
                    paging: true
                                        
                });  
            });
        </script>

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