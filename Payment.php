<?php
include 'db.php'; // Incluir la conexión a la base de datos

// Supongamos que tienes el UserID del mesero almacenado en una sesión o variable
$waiterUserID = 3; // Este es un ejemplo; deberías obtener este valor de la sesión o del login

// Obtener los pagos realizados al mesero
$paymentsQuery = "SELECT * FROM payment WHERE EmployeeID = ?";
$stmt = $conn->prepare($paymentsQuery);
$stmt->bind_param("i", $waiterUserID);
$stmt->execute();
$payments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close(); // Cerrar la conexión después de todas las operaciones
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Restaurant Manager - Payments</title>
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
							<li class="active"><a href="Payment.php">Payments</a></li>
							<li><a href="tableswaiter.php">Tables/Tips</a></li>
							<li><a href="Order.php">Orders</a></li>
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
							<h1>Payment History</h1>
							<h2>View your payment records</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div id="fh5co-blog">
		<div class="container">
			<div class="row">
				<!-- Mostrar la tabla de pagos -->
				<div class="col-md-12 animate-box">
					<h3>Your Payments</h3>
					<table class="table">
						<thead>
							<tr>
								<th>Payment ID</th>
								<th>Payment Date</th>
								<th>Amount</th>
								<th>Payment Method</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($payments as $payment): ?>
							<tr>
								<td><?php echo $payment['PaymentID']; ?></td>
								<td><?php echo $payment['PaymentDate']; ?></td>
								<td>$<?php echo $payment['Amount']; ?></td>
								<td><?php echo $payment['PaymentMethod']; ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<!-- Sección para enviar sugerencias -->
				<div class="col-md-12 animate-box">
					<h3>Submit Your Suggestions</h3>
					<form method="POST" action="#">
						<textarea name="suggestion" placeholder="Write your suggestion here..." rows="4" class="form-control"></textarea>
						<button type="submit" class="btn btn-primary" style="margin-top: 10px;">Submit</button>
					</form>
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
						<li><a href="#">Orders</a></li>
						<li><a href="#">Tables</a></li>
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
