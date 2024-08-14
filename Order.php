<?php
include 'db.php'; // Incluir la conexión a la base de datos

// Manejar la inserción de nuevas órdenes
if (isset($_POST['addOrder'])) {
    $tableID = $_POST['tableID'];
    $chefGroupID = $_POST['chefGroupID'];

    $insertOrderQuery = "INSERT INTO `order` (TableID, ChefGroupID, Totalcost, PaidOrder) VALUES (?, ?, 0, 0)";
    $stmt = $conn->prepare($insertOrderQuery);
    $stmt->bind_param("ii", $tableID, $chefGroupID);
    $stmt->execute();
    $stmt->close();

    // Redirigir para evitar múltiples envíos del formulario
    header("Location: Order.php");
    exit();
}

// Manejar la inserción de detalles de nuevas órdenes
if (isset($_POST['addOrderDetail'])) {
    $orderID = $_POST['orderID'];
    $quantity = $_POST['quantity'];
    $dishID = $_POST['dishID'];
    $waiterID = 1; // Este valor debe ser dinámico según el waiter que esté logueado

    // Obtener el precio del plato
    $dishQuery = "SELECT Price FROM dish WHERE DishID = ?";
    $stmt = $conn->prepare($dishQuery);
    $stmt->bind_param("i", $dishID);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();

    // Calcular el subtotal
    $subtotal = $price * $quantity;

    // Insertar el detalle de la orden
    $insertOrderDetailQuery = "INSERT INTO orderindividual (OrderID, Quantity, Subtotal, DishID, WaiterID, Activeorder) VALUES (?, ?, ?, ?, ?, 1)";
    $stmt = $conn->prepare($insertOrderDetailQuery);
    $stmt->bind_param("iidsi", $orderID, $quantity, $subtotal, $dishID, $waiterID);
    $stmt->execute();
    $stmt->close();

    // Redirigir para evitar múltiples envíos del formulario
    header("Location: Order.php");
    exit();
}

// Manejar la actualización de órdenes pagadas
if (isset($_POST['markPaid'])) {
    $orderID = $_POST['orderIDToMark'];

    $updateOrderQuery = "UPDATE `order` SET PaidOrder = 1 WHERE OrderID = ?";
    $stmt = $conn->prepare($updateOrderQuery);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $stmt->close();

    // Redirigir para evitar múltiples envíos del formulario
    header("Location: Order.php");
    exit();
}

// Obtener las órdenes activas
$orderQuery = "SELECT * FROM `order`";
$orderResult = $conn->query($orderQuery);

// Obtener los detalles de las órdenes activas
$orderDetailQuery = "SELECT * FROM orderindividual";
$orderDetailResult = $conn->query($orderDetailQuery);

// Obtener las órdenes inactivas
$inactiveOrdersQuery = "SELECT * FROM inactiveorders";
$inactiveOrdersResult = $conn->query($inactiveOrdersQuery);

$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restaurant Manager - Orders</title>
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
							<li><a href="Waiter.php">Home</a></li>
							<li><a href="Payment.php">Payments</a></li>
							<li><a href="tableswaiter.php">Tables/Tips</a></li>
							<li class="active"><a href="Order.php">Orders</a></li>
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
                            <h1>Manage Orders</h1>
                            <h2>View and manage your orders</h2>
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
                    <h3>Orders</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Table ID</th>
                                <th>Order Time</th>
                                <th>Chef Group ID</th>
                                <th>Total Cost</th>
                                <th>Paid Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $orderResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $order['OrderID']; ?></td>
                                <td><?php echo $order['TableID']; ?></td>
                                <td><?php echo $order['OrderTime']; ?></td>
                                <td><?php echo $order['ChefGroupID']; ?></td>
                                <td><?php echo $order['Totalcost']; ?></td>
                                <td><?php echo $order['PaidOrder'] ? 'Yes' : 'No'; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Order Details</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order Detail ID</th>
                                <th>Order ID</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Dish ID</th>
                                <th>Waiter ID</th>
                                <th>Active Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($orderDetail = $orderDetailResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $orderDetail['OrderDetailID']; ?></td>
                                <td><?php echo $orderDetail['OrderID']; ?></td>
                                <td><?php echo $orderDetail['Quantity']; ?></td>
                                <td><?php echo $orderDetail['Subtotal']; ?></td>
                                <td><?php echo $orderDetail['DishID']; ?></td>
                                <td><?php echo $orderDetail['WaiterID']; ?></td>
                                <td><?php echo $orderDetail['Activeorder'] ? 'Yes' : 'No'; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Add New Order</h3>
                    <form method="POST" action="Order.php">
                        <input type="number" name="tableID" placeholder="Table ID" required>
                        <input type="number" name="chefGroupID" placeholder="Chef Group ID" required>
                        <button type="submit" name="addOrder">Add Order</button>
                    </form>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Add New Order Detail</h3>
                    <form method="POST" action="Order.php">
                        <input type="number" name="orderID" placeholder="Order ID" required>
                        <input type="number" name="quantity" placeholder="Quantity" required>
                        <input type="number" name="dishID" placeholder="Dish ID" required>
                        <button type="submit" name="addOrderDetail">Add Order Detail</button>
                    </form>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Mark Order as Paid</h3>
                    <form method="POST" action="Order.php">
                        <input type="number" name="orderIDToMark" placeholder="Order ID" required>
                        <label><input type="checkbox" name="markAsPaid"> Mark as Paid</label>
                        <button type="submit" name="markPaid">Submit</button>
                    </form>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Inactive Orders</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>InactiveOrderID</th>
                                <th>OrderDetailID</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($inactiveOrder = $inactiveOrdersResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $inactiveOrder['InactiveOrderID']; ?></td>
                                <td><?php echo $inactiveOrder['OrderDetailID']; ?></td>
                                <td><?php echo $inactiveOrder['Date']; ?></td>
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
