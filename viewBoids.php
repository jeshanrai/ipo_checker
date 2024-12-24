<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Database connection (Procedural Style)
$conn = mysqli_connect('localhost', 'root', '', 'boid_recordbook');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM boiddetails WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All BOIDs - BOID Recordbook</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding-top: 70px; /* Prevent content from overlapping the fixed navbar */
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        /* Table and buttons styling */
        .boid-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }

        .boid-table th, .boid-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .boid-table th {
            background-color: #f1f1f1;
        }

        .edit-btn, .delete-btn {
            background-color: #00bcd4;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-btn:hover, .delete-btn:hover {
            background-color: #008c9e;
        }

        /* Styling for the navbar */
        nav {
            background: #333;
            padding: 1rem;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .nav-left {
            display: flex;
            gap: 1.5rem;
        }

        .nav-right {
            margin-left: auto;
        }

        nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1rem;
            transition: background 0.3s ease, color 0.3s ease;
            border-radius: 4px;
        }

        nav a:hover {
            background: #00bcd4;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="nav-left">
            <a href="index.php"><i class="fas fa-home"></i> HOME</a>
            <a href="addBoid.php"><i class="fas fa-plus-circle"></i> Add BOID</a>
            <a href="viewBoids.php"><i class="fas fa-list"></i> All BOIDs</a>
        </div>
        <div class="nav-right">
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <!-- BOID Table -->
    <div class="container">
        <h2>Your BOIDs</h2>
        <table class="boid-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>BOID Number</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Fetching data from the database
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['boid_number'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>
                                <button class='edit-btn' onclick='editBoid(" . $row['id'] . ")'>Edit</button>
                                <button class='delete-btn' onclick='deleteBoid(" . $row['id'] . ")'>Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript for Edit and Delete functionality
        function editBoid(boidId) {
            window.location.href = "editBoid.php?id=" + boidId;
        }

        function deleteBoid(boidId) {
            if (confirm("Are you sure you want to delete this BOID?")) {
                window.location.href = "deleteBoid.php?id=" + boidId;
            }
        }
    </script>
</body>
</html>
