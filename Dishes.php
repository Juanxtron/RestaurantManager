<?php
include 'db.php'; // Incluir la conexión a la base de datos

// Manejar la inserción de nuevos platos
if (isset($_POST['addDish'])) {
    $dishName = $_POST['dishName'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $preparationTime = $_POST['preparationTime'];
    $available = isset($_POST['available']) ? 1 : 0;

    $insertDishQuery = "INSERT INTO dish (Name, Description, Price, PreparationTime, Available) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertDishQuery);
    $stmt->bind_param("ssdsi", $dishName, $description, $price, $preparationTime, $available);
    $stmt->execute();
    $stmt->close();

    // Redirigir para evitar múltiples envíos del formulario
    header("Location: Dishes.php");
    exit();
}

// Manejar la inserción de nuevos ingredientes a un plato
if (isset($_POST['addDishIngredient'])) {
    $dishID = $_POST['dishID'];
    $ingredientID = $_POST['ingredientID'];
    $quantity = $_POST['quantity'];

    $insertIngredientQuery = "INSERT INTO dishingredient (DishID, IngredientID, Quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertIngredientQuery);
    $stmt->bind_param("iid", $dishID, $ingredientID, $quantity);
    $stmt->execute();
    $stmt->close();

    // Redirigir para evitar múltiples envíos del formulario
    header("Location: Dishes.php");
    exit();
}

// Obtener la tabla combinada de platos y sus ingredientes
$dishIngredientQuery = "SELECT d.DishID, d.Name as DishName, d.Description, d.Price, d.PreparationTime, d.Available, 
                        i.IngredientID, i.Name as IngredientName, di.Quantity
                        FROM dish d
                        LEFT JOIN dishingredient di ON d.DishID = di.DishID
                        LEFT JOIN ingredient i ON di.IngredientID = i.IngredientID";
$dishIngredients = $conn->query($dishIngredientQuery)->fetch_all(MYSQLI_ASSOC);

// Obtener los platos no disponibles
$unavailableDishesQuery = "SELECT * FROM unavailabledish"; 
$unavailableDishes = $conn->query($unavailableDishesQuery)->fetch_all(MYSQLI_ASSOC);

$conn->close(); // Asegúrate de cerrar la conexión después de todas las operaciones
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Restaurant Manager - Dishes</title>
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
							<li><a href="Payments.php">Payments</a></li>
							<li class="active"><a href="Dishes.php">Dishes</a></li>
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
                            <h1>Manage Dishes</h1>
                            <h2>View and manage your dishes and ingredients</h2>
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
                    <h3>All Dishes with Ingredients</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dish ID</th>
                                <th>Dish Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Preparation Time</th>
                                <th>Available</th>
                                <th>Ingredient ID</th>
                                <th>Ingredient Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dishIngredients as $row): ?>
                            <tr>
                                <td><?php echo $row['DishID']; ?></td>
                                <td><?php echo $row['DishName']; ?></td>
                                <td><?php echo $row['Description']; ?></td>
                                <td><?php echo $row['Price']; ?></td>
                                <td><?php echo $row['PreparationTime']; ?></td>
                                <td><?php echo $row['Available'] ? 'Yes' : 'No'; ?></td>
                                <td><?php echo $row['IngredientID']; ?></td>
                                <td><?php echo $row['IngredientName']; ?></td>
                                <td><?php echo $row['Quantity']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Add New Dish</h3>
                    <form method="POST" action="Dishes.php">
                        <input type="text" name="dishName" placeholder="Dish Name" required>
                        <input type="text" name="description" placeholder="Description" required>
                        <input type="number" step="0.01" name="price" placeholder="Price" required>
                        <input type="time" name="preparationTime" placeholder="Preparation Time" required>
                        <label><input type="checkbox" name="available" value="1"> Available</label>
                        <button type="submit" name="addDish">Add Dish</button>
                    </form>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Add New Ingredient to Dish</h3>
                    <form method="POST" action="Dishes.php">
                        <input type="number" name="dishID" placeholder="Dish ID" required> <!-- Campo para DishID -->
                        <input type="number" name="ingredientID" placeholder="Ingredient ID" required> <!-- Campo para IngredientID -->
                        <input type="number" step="0.01" name="quantity" placeholder="Quantity" required> <!-- Campo para Quantity -->
                        <button type="submit" name="addDishIngredient">Add Ingredient</button>
                    </form>
                </div>

                <div class="col-md-12 animate-box">
                    <h3>Unavailable Dishes</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dish ID</th>
                                <th>Date</th>
                                <th>Chef Group ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($unavailableDishes as $unavailableDish): ?>
                            <tr>
                                <td><?php echo $unavailableDish['DishID']; ?></td>
                                <td><?php echo $unavailableDish['Date']; ?></td>
                                <td><?php echo $unavailableDish['ChefGroupID']; ?></td>
                            </tr>
                            <?php endforeach; ?>
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

