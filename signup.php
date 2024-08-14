<?php
include 'db.php';  // Asegúrate de que db.php esté en la misma carpeta o ajusta la ruta si está en otro lugar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Combinar los nombres para el campo 'Name'
    $fullName = $fname . ' ' . $lname;

    // Inserta en la tabla User
    $stmt = $conn->prepare("INSERT INTO User (Username, PasswordHash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    if ($stmt->execute()) {
        $userID = $stmt->insert_id;

        // Inserta en la tabla correspondiente según el rol
        if ($role == 'owner') {
            $contactInfo = $_POST['contact_info_owner'];
            $address = $_POST['address'];
            $stmt = $conn->prepare("INSERT INTO Owner (Name, Contactinfo, Address, UserID) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $fullName, $contactInfo, $address, $userID);
            $stmt->execute();
        } elseif ($role == 'chef') {
            $specialization = $_POST['specialization'];
            $socialSecurityNumber = $_POST['social_security_number_chef'];
            $eps = $_POST['eps_chef'];
            $healthInsurance = $_POST['health_insurance_chef'];
            $stmt = $conn->prepare("INSERT INTO Chef (Name, Contactinfo, Specialization, UserID, Social_Security_Number, EPS, Health_Ensurance) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssisss", $fullName, $email, $specialization, $userID, $socialSecurityNumber, $eps, $healthInsurance);
            $stmt->execute();
        } elseif ($role == 'waiter') {
            $socialSecurityNumber = $_POST['social_security_number_waiter'];
            $eps = $_POST['eps_waiter'];
            $healthInsurance = $_POST['health_insurance_waiter'];
            $stmt = $conn->prepare("INSERT INTO Waiter (Name, Contactinfo, UserID, Social_Security_Number, EPS, Health_Ensurance) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiiss", $fullName, $email, $userID, $socialSecurityNumber, $eps, $healthInsurance);
            $stmt->execute();
        }

        // Redirigir a la página de inicio de sesión
        echo "<script>alert('Account created successfully!'); window.location.href='Login.html';</script>";
    } else {
        echo "<script>alert('Error creating account. Please try again.'); window.location.href='signup.html';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
