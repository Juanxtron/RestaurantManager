<?php
// Conectar a la base de datos
include 'db.php';

// Supongamos que el UserID del chef está almacenado en una variable de sesión
// Aquí uso un valor de ejemplo, pero deberías reemplazarlo con la sesión real del UserID
$userID = 3; // Esto debe ser dinámico basado en la sesión del usuario

// Consultar los pagos asociados con el UserID del chef
$query = "SELECT PaymentID, PaymentDate, Amount, PaymentMethod FROM payment WHERE EmployeeID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

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
							<li><a href="Chef.php">Home</a></li>
							<li class="active"><a href="Payments.php">Payments</a></li>
							<li><a href="Dishes.php">Dishes</a></li>
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
							<h1>Payments Overview</h1>
							<h2>Review your payment history</h2>
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
							<?php
							// Mostrar los datos de la tabla payment
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row['PaymentID'] . "</td>";
									echo "<td>" . $row['PaymentDate'] . "</td>";
									echo "<td>" . $row['Amount'] . "</td>";
									echo "<td>" . $row['PaymentMethod'] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "<tr><td colspan='4'>No payments found</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Formulario decorativo para preguntas o quejas -->
			<div class="row">
				<div class="col-md-12 animate-box">
					<h3>Questions or Concerns?</h3>
					<form action="#" method="POST">
						<div class="form-group">
							<label for="question">Your Message:</label>
							<textarea id="question" name="question" class="form-control" rows="4" placeholder="Write your question or concern here..." required></textarea>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
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

<?php
// Cerrar la conexión
$stmt->close();
$conn->close();
?>
