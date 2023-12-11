<?php


// Assuming you have a valid database connection
$host = "feenix-mariadb.swin.edu.au";
$username = "s104674124";
$password = "250498";
$database = "s104674124_db";

$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the POST request
$vehicleId = $_POST['vehicleId'];
$fuelAmount = $_POST['fuelAmount'];

// Insert data into the FuelUsage table
$sql = "INSERT INTO FuelUsage (VehicleId, FuelAmount, Date) VALUES ('$vehicleId', '$fuelAmount', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "Record saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
