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

// Fetch data from checkfuelusage table
$sqlDisplay = "SELECT * FROM checkfuelusage";
$result = $conn->query($sqlDisplay);

echo "<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 150vh;
        margin: 0;
    }
    .card {
        width: 80%; /* Adjust the width as needed */
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>";

echo "<div class='card'>";
echo "<table>";
echo "<tr><th>ID</th><th>Worker Name</th><th>Fuel Tank</th><th>VehicleId</th><th>Fuel Amount</th><th>Remaining Fuel</th><th>Date</th><th>Photo</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['ID']}</td><td>{$row['WorkerName']}</td><td>{$row['FuelTank']}</td><td>{$row['VehicleId']}</td><td>{$row['FuelAmount']}</td><td>{$row['RemainingFuel']}</td><td>{$row['Date']}</td>";
    // Display the photo if available 
    echo "<td>";
    if (!empty($row['PhotoPath'])&& file_exists($row['PhotoPath'])) {
        $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $row['PhotoPath']);
        echo "<img src='{$relativePath}' alt='Photo' style='max-width: 150px; height: auto;'> ";
    }else {
        echo "No photo available";
    }

    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

$conn->close();
?>
