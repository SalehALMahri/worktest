<?php
// Database connection configuration
$hostname = "localhost";
$username = "root";
$password = "toor";
$dbname = "test";

$conn = new mysqli($hostname, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicleId = $_POST["vehicleId"];
    $fuelAmount = $_POST["fuelAmount"];
    $date = date("Y-m-d");

    // Handle photo upload
    $uploadDir = 'C:/xampp/htdocs/uploads/';
    $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
        // Retrieve previous RemainingFuel value
        $sqlCheckFuelUsage = "SELECT RemainingFuel FROM checkfuelusage WHERE WorkerName = 'Ail' ORDER BY ID DESC LIMIT 1";
        $result = $conn->query($sqlCheckFuelUsage);

        if ($result !== false) {
            if ($row = $result->fetch_assoc()) {
                $previousRemainingFuel = $row['RemainingFuel'];
            } else {
                // No existing data, assume initial RemainingFuel value
                $previousRemainingFuel = 20000;
            }

            // Calculate new RemainingFuel
            $remainingFuel = $previousRemainingFuel - $fuelAmount;

            // Insert data into fuelusage table
            $sqlFuelUsage = "INSERT INTO fuelusage (VehicleId, FuelAmount, Date) VALUES ('$vehicleId', $fuelAmount, '$date')";
            $conn->query($sqlFuelUsage);

            // Insert data into checkfuelusage table
            $sqlCheckFuelUsage = "INSERT INTO checkfuelusage (WorkerName, FuelTank, VehicleId, FuelAmount, Date, RemainingFuel, PhotoPath) VALUES ('Ail', $previousRemainingFuel, '$vehicleId', $fuelAmount, '$date', $remainingFuel, '$uploadFile')";
            $conn->query($sqlCheckFuelUsage);

            // Redirect to another page (display page)
            header("Location: test.html");
            exit();
        } else {
            echo "Error retrieving previous RemainingFuel value: " . $conn->error;
        }
    } else {
        echo "Error uploading photo.";
    }
}

$conn->close();
?>
