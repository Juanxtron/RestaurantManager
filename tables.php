<?php
// Configurar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión a la base de datos
include 'db.php';

// Asignar el OwnerID activo (en este caso 1)
$ownerID = 1;

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST['number'];
    $seats = $_POST['seats'];
    $location = $_POST['location'];
    $waiterID = $_POST['waiterID'];
    $chefgroupID = $_POST['chefgroupID'];
    $served = 0;

    // Verificar si el WaiterID existe y está asociado al OwnerID activo
    $waiterQuery = "SELECT COUNT(*) FROM waiter WHERE WaiterID = ? AND OwnerID = ?";
    $stmt = $conn->prepare($waiterQuery);
    $stmt->bind_param("ii", $waiterID, $ownerID);
    $stmt->execute();
    $stmt->bind_result($waiterExists);
    $stmt->fetch();
    $stmt->close();

    if ($waiterExists == 0) {
        echo "<script>alert('Error: The WaiterID does not exist or is not associated with the active owner.');</script>";
    } else {
        // Verificar si el ChefgroupID existe
        $chefgroupQuery = "SELECT COUNT(*) FROM chefgroup WHERE ChefGroupID = ?";
        $stmt = $conn->prepare($chefgroupQuery);
        $stmt->bind_param("i", $chefgroupID);
        $stmt->execute();
        $stmt->bind_result($chefgroupExists);
        $stmt->fetch();
        $stmt->close();

        if ($chefgroupExists == 0) {
            echo "<script>alert('Error: The ChefgroupID does not exist.');</script>";
        } else {
            // Preparar la consulta SQL para la inserción
            $query = "INSERT INTO `table` (Number, Seats, Location, WaiterID, Served, ChefgroupID) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            if ($stmt) {
                $stmt->bind_param("iisiii", $number, $seats, $location, $waiterID, $served, $chefgroupID);

                if ($stmt->execute()) {
                    echo "<script>alert('Table added successfully!');</script>";
                } else {
                    echo "<script>alert('An error occurred: " . $stmt->error . "');</script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('Failed to prepare statement.');</script>";
            }
        }
    }
}

// Obtener las tablas no servidas
$query = "SELECT * FROM `table` WHERE Served = 0";
$result = $conn->query($query);

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restaurant Manager - Tables</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/modernizr-2.6.2.min.js"></script>
</head>
<body>
    
<div class="fh5co-loader"></div>
<div id="page">
    <nav class="fh5co-nav" role="navigation">
        <div class="top-menu">
            <div class="container">
                <div class="row">
                    <div class="col-xs-1">
                        <div id="fh5co-logo"><a href="index.html">Restaurant<span>Manager</span></a></div>
                    </div>
                    <div class="col-xs-11 text-right menu-1">
                        <ul>
							<li><a href="Owner.php">Home</a></li>
							<li><a href="inventory.php">Inventory</a></li>
							<li class="active"><a href="tables.php">Active Tables</a></li>
							<li><a href="employees.php">Employees</a></li>
							<li class="btn-cta"><a href="Login.html"><span>Logout</span></a></li>
						</ul>
                    </div>
                </div>                
            </div>
        </div>
    </nav>

    <header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url(images/img_bg_2.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <div class="display-t">
                        <div class="display-tc animate-box" data-animate-effect="fadeIn">
                            <h1>Manage Tables</h1>
                            <h2>Oversee your restaurant's table assignments</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-blog">
        <div class="container">
            <div class="row">
                <!-- Formulario para crear una nueva mesa -->
                <div class="col-md-12 animate-box">
                    <h3>Create a New Table</h3>
                    <form action="tables.php" method="post">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <input type="number" name="number" class="form-control" placeholder="Table Number" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="seats" class="form-control" placeholder="Seats" required>
                            </div>
                            <div class="col-md-4">
                                <select name="location" class="form-control" required>
                                    <option value="Main Hall">Main Hall</option>
                                    <option value="Patio">Patio</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <input type="number" name="waiterID" class="form-control" placeholder="Waiter ID" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="chefgroupID" class="form-control" placeholder="Chef Group ID" required>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Create Table" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de mesas no servidas -->
            <div class="row">
                <div class="col-md-12 animate-box">
                    <h3>Current Tables (Not Served)</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Table ID</th>
                                <th>Number</th>
                                <th>Seats</th>
                                <th>Location</th>
                                <th>Waiter ID</th>
                                <th>Chef Group ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['TableID']; ?></td>
                                <td><?php echo $row['Number']; ?></td>
                                <td><?php echo $row['Seats']; ?></td>
                                <td><?php echo $row['Location']; ?></td>
                                <td><?php echo $row['WaiterID']; ?></td>
                                <td><?php echo $row['ChefgroupID']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <footer id="fh5co-footer" role="contentinfo">
        <div class="container">
            <div class="row row-pb-md">
                <div class="col-md-3 fh5co-widget">
                    <h4>About Restaurant Manager</h4>
                    <p>Join us to efficiently manage your restaurant operations.</p>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1">
                    <h4>Links</h4>
                    <ul class="fh5co-footer-links">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Tables</a></li>
                        <li><a href="#">Inventory</a></li>
                        <li><a href="#">Employees</a></li>
                    </ul>
                </div>
            </div>
            <div class="row copyright">
                <div class="col-md-12 text-center">
                    <p>
                        <small class="block">&copy; 2024 Restaurant Manager. All Rights Reserved.</small> 
                    </p>
                    <p>
                        <ul class="fh5co-social-icons">
                            <li><a href="#"><i class="icon-twitter"></i></a></li>
                            <li><a href="#"><i class="icon-facebook"></i></a></li>
                            <li><a href="#"><i class="icon-linkedin"></i></a></li>
                            <li><a href="#"><i class="icon-dribbble"></i></a></li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.countTo.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/magnific-popup-options.js"></script>
<script src="js/main.js"></script>

</body>
</html>
