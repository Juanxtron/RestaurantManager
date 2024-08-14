<?php
session_start();
include 'db.php';  // Asegúrate de que db.php esté en la misma carpeta o ajusta la ruta si está en otro lugar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT u.UserID, u.Username, u.PasswordHash, r.RoleName 
                            FROM user u 
                            JOIN role r ON u.RoleID = r.RoleID 
                            WHERE u.Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si el usuario existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($UserID, $Username, $PasswordHash, $RoleName);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $PasswordHash)) {
            // Redirigir basado en el rol
            if ($RoleName == 'Owner') {
                header("Location: Owner.php");
                exit();
            } elseif ($RoleName == 'Chef') {
                header("Location: Chef.php");
                exit();
            } elseif ($RoleName == 'Waiter') {
                header("Location: Waiter.php");
                exit();
            }
        } else {
            echo "<script>alert('Incorrect username or password'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('Incorrect username or password'); window.location.href='login.php';</script>";
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>


