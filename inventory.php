<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $ingredientID = $_POST['ingredient_id'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];
    
    // Establecer OwnerID manualmente (esto debería cambiarse según la lógica de tu sistema)
    $ownerID = 1; 
    
    // Establecer la fecha actual y un tiempo de entrega esperado
    $requestDate = date('Y-m-d');
    $expectedDeliveryTime = "14:00:00"; // Esto se puede cambiar o mejorar según tu lógica

    // Insertar en la tabla `inventoryrefillrequest`
    $stmt = $conn->prepare("INSERT INTO inventoryrefillrequest (IngredientID, Quantity, RequestDate, ExpectedDeliveryTime, Cost, OwnerID) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissdi", $ingredientID, $quantity, $requestDate, $expectedDeliveryTime, $cost, $ownerID);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Refill request successfully added!</p>";
    } else {
        echo "<p style='color:red;'>Error adding refill request: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Obtener el inventario actual
$inventoryQuery = "SELECT i.InventoryID, i.IngredientID, i.Quantity, ing.Name as IngredientName FROM inventory i JOIN ingredient ing ON i.IngredientID = ing.IngredientID";
$inventoryResult = $conn->query($inventoryQuery);

// Obtener el historial de refill requests (esto se mueve aquí para asegurar que se cargue siempre después de un POST)
$refillQuery = "SELECT * FROM inventoryrefillrequest";
$refillResult = $conn->query($refillQuery);

$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restaurant Manager - Inventory</title>
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
                                <li class="active"><a href="inventory.php">Inventory</a></li>
                                <li><a href="tables.php">Active Tables</a></li>
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
                                <h1>Inventory Management</h1>
                                <h2>Manage your restaurant's inventory efficiently</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div id="fh5co-blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 animate-box">
                        <h3>Current Inventory</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ingredient ID</th>
                                    <th>Ingredient Name</th>
                                    <th>Quantity</th>
                                    <th>Refill Inventory</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $inventoryResult->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['IngredientID']; ?></td>
                                        <td><?php echo $row['IngredientName']; ?></td>
                                        <td><?php echo $row['Quantity']; ?></td>
                                        <td>
                                            <form method="POST" action="inventory.php">
                                                <input type="hidden" name="ingredient_id" value="<?php echo $row['IngredientID']; ?>">
                                                <input type="number" name="quantity" placeholder="Quantity" required>
                                                <input type="number" step="0.01" name="cost" placeholder="Cost" required>
                                                <button type="submit" class="btn btn-primary">Refill</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12 animate-box">
                        <h3>Inventory Refill History</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Refill Request ID</th>
                                    <th>Ingredient ID</th>
                                    <th>Quantity</th>
                                    <th>Request Date</th>
                                    <th>Expected Delivery Time</th>
                                    <th>Cost</th>
                                    <th>Owner ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $refillResult->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['RefillRequestID']; ?></td>
                                        <td><?php echo $row['IngredientID']; ?></td>
                                        <td><?php echo $row['Quantity']; ?></td>
                                        <td><?php echo $row['RequestDate']; ?></td>
                                        <td><?php echo $row['ExpectedDeliveryTime']; ?></td>
                                        <td><?php echo $row['Cost']; ?></td>
                                        <td><?php echo $row['OwnerID']; ?></td>
                                    </tr>
                                <?php } ?>
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
