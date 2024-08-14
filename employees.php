<?php
// employees.php

// Incluir la conexión a la base de datos
include 'db.php';

// Establecer el OwnerID activo (puedes modificarlo según tu lógica de sesión)
$ownerID = 1; 

// Si el formulario de pago fue enviado, procesarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeID = $_POST['EmployeeID'];
    $amount = $_POST['Amount'];
    $paymentMethod = $_POST['PaymentMethod'];

    // Insertar un nuevo pago en la tabla payment
    $query = "INSERT INTO payment (EmployeeID, PaymentDate, Amount, PaymentMethod) VALUES (?, CURDATE(), ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $employeeID, $amount, $paymentMethod);
    $stmt->execute();
    $stmt->close();
}

// Consultar todos los pagos existentes para mostrarlos
$query = "SELECT PaymentID, EmployeeID, PaymentDate, Amount, PaymentMethod FROM payment";
$paymentResults = $conn->query($query);

// Consultar los chefs y waiters que pertenecen al OwnerID activo
$queryChefs = "SELECT ChefID, Name, Contactinfo, Specialization, Social_Security_Number, EPS, `Health Ensurance` FROM chef WHERE Owner = ?";
$stmtChefs = $conn->prepare($queryChefs);
$stmtChefs->bind_param("i", $ownerID);
$stmtChefs->execute();
$chefsResults = $stmtChefs->get_result();

$queryWaiters = "SELECT WaiterID, Name, Contactinfo, Social_Security_Number, EPS, `Health Ensurance` FROM waiter WHERE OwnerID = ?";
$stmtWaiters = $conn->prepare($queryWaiters);
$stmtWaiters->bind_param("i", $ownerID);
$stmtWaiters->execute();
$waitersResults = $stmtWaiters->get_result();

$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restaurant Manager - Employee Payments</title>
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
        <div class="top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-right">
                    </div>
                </div>
            </div>
        </div>
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
                            <li><a href="tables.php">Active Tables</a></li>
                            <li class="active"><a href="employees.php">Employees</a></li>
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
                            <h1>Employee Payments</h1>
                            <h2>Manage payments and view employee information</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="fh5co-blog">
        <div class="container">
            <!-- Payment Form -->
            <div class="row">
                <div class="col-md-12 animate-box">
                    <h3>Add New Payment</h3>
                    <form method="post" action="employees.php">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="EmployeeID">Employee ID</label>
                                <input type="number" id="EmployeeID" name="EmployeeID" class="form-control" placeholder="Enter Employee ID" required>
                            </div>
                            <div class="col-md-6">
                                <label for="Amount">Amount</label>
                                <input type="number" id="Amount" name="Amount" class="form-control" placeholder="Enter Amount" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="PaymentMethod">Payment Method</label>
                                <input type="text" id="PaymentMethod" name="PaymentMethod" class="form-control" placeholder="Enter Payment Method" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Add Payment" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment Table -->
            <div class="row">
                <div class="col-md-12 animate-box">
                    <h3>Payment History</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Employee ID</th>
                                <th>Payment Date</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $paymentResults->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['PaymentID']; ?></td>
                                <td><?php echo $row['EmployeeID']; ?></td>
                                <td><?php echo $row['PaymentDate']; ?></td>
                                <td><?php echo $row['Amount']; ?></td>
                                <td><?php echo $row['PaymentMethod']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chefs and Waiters Tables -->
            <div class="row">
                <div class="col-md-12 animate-box">
                    <h3>Your Chefs</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Chef ID</th>
                                <th>Name</th>
                                <th>Contact Info</th>
                                <th>Specialization</th>
                                <th>Social Security Number</th>
                                <th>EPS</th>
                                <th>Health Insurance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $chefsResults->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['ChefID']; ?></td>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Contactinfo']; ?></td>
                                <td><?php echo $row['Specialization']; ?></td>
                                <td><?php echo $row['Social_Security_Number']; ?></td>
                                <td><?php echo $row['EPS']; ?></td>
                                <td><?php echo $row['Health Ensurance']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 animate-box">
                    <h3>Your Waiters</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Waiter ID</th>
                                <th>Name</th>
                                <th>Contact Info</th>
                                <th>Social Security Number</th>
                                <th>EPS</th>
                                <th>Health Insurance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $waitersResults->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['WaiterID']; ?></td>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Contactinfo']; ?></td>
                                <td><?php echo $row['Social_Security_Number']; ?></td>
                                <td><?php echo $row['EPS']; ?></td>
                                <td><?php echo $row['Health Ensurance']; ?></td>
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
                        <li><a href="#">Inventory</a></li>
                        <li><a href="#">Orders</a></li>
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
