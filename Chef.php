<?php
// Conectar a la base de datos
include 'db.php';

// Manejar la inserción de un nuevo ingrediente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $expirationDate = $_POST['expirationDate'];
    $chefGroupID = $_POST['chefGroupID'];

    // Preparar la consulta de inserción
    $query = "INSERT INTO ingredient (Name, Unit, ExpirationDate, ChefgroupID) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $unit, $expirationDate, $chefGroupID);

    if ($stmt->execute()) {
        echo "<script>alert('Ingredient added successfully!');</script>";
    } else {
        echo "<script>alert('Error: Could not add ingredient. Please check your input.');</script>";
    }

    $stmt->close();
}

// Consulta para obtener los datos de la tabla ingredient
$query = "SELECT IngredientID, Name, Unit, ExpirationDate, ChefgroupID FROM ingredient";
$result = $conn->query($query);
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Restaurant Manager - Chef Dashboard</title>
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
							<li class="active"><a href="Chef.php">Home</a></li>
							<li><a href="Payments.php">Payments</a></li>
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
							<h1>Welcome, Chef</h1>
							<h2>Manage your kitchen and orders</h2>
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
					<h3>Ingredient List</h3>
					<table class="table">
						<thead>
							<tr>
								<th>Ingredient ID</th>
								<th>Name</th>
								<th>Unit</th>
								<th>Expiration Date</th>
								<th>Chef Group ID</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Mostrar los datos de la tabla ingredient
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $row['IngredientID'] . "</td>";
									echo "<td>" . $row['Name'] . "</td>";
									echo "<td>" . $row['Unit'] . "</td>";
									echo "<td>" . $row['ExpirationDate'] . "</td>";
									echo "<td>" . $row['ChefgroupID'] . "</td>";
									echo "</tr>";
								}
							} else {
								echo "<tr><td colspan='5'>No ingredients found</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 animate-box">
					<h3>Add New Ingredient</h3>
					<form action="Chef.php" method="POST">
						<div class="form-group">
							<label for="name">Name:</label>
							<input type="text" id="name" name="name" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="unit">Unit:</label>
							<input type="text" id="unit" name="unit" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="expirationDate">Expiration Date:</label>
							<input type="date" id="expirationDate" name="expirationDate" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="chefGroupID">Chef Group ID:</label>
							<input type="number" id="chefGroupID" name="chefGroupID" class="form-control" required>
						</div>
						<button type="submit" class="btn btn-primary">Add Ingredient</button>
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
$conn->close();
?>
