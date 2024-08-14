<?php
// Incluir archivo de base de datos
include 'db.php';

// Suponiendo que tienes el OwnerID guardado en una sesión o variable
$ownerID = 1; // Esto debería cambiar dependiendo de cómo manejes la sesión

$query = "SELECT TotalRevenue, TotalCost FROM profit WHERE OwnerID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $ownerID);
$stmt->execute();
$stmt->bind_result($totalRevenue, $totalCost);
$stmt->fetch();
$stmt->close();

$totalProfit = $totalRevenue - $totalCost;

$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Restaurant Manager - Owner Dashboard</title>
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
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
							<li class="active"><a href="Owner.php">Home</a></li>
							<li><a href="inventory.php">Inventory</a></li>
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
							<h1>Welcome, Owner</h1>
							<h2>Manage your restaurant effectively</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div id="fh5co-blog">
		<div class="container">
			<div class="row">
				<!-- Add content here for the owner's dashboard -->
				<div class="col-md-12 animate-box">
					<h3>Overview</h3>
					<p>Welcome to the owner dashboard. Here you can manage inventory, orders, and employees.</p>
				</div>
			</div>
			<!-- Profit, Cost, and Revenue section -->
			<div class="row">
				<div class="col-md-12 animate-box">
					<h3>Financial Overview</h3>
					<canvas id="financialChart"></canvas>
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

<!-- Script para renderizar el gráfico -->
<script>
    var ctx = document.getElementById('financialChart').getContext('2d');
    var financialChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Revenue', 'Total Cost', 'Total Profit'],
            datasets: [{
                label: 'Financial Overview',
                data: [<?php echo $totalRevenue; ?>, <?php echo $totalCost; ?>, <?php echo $totalProfit; ?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>


