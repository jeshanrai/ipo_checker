<?php
// session_start();
// include('config.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'boid_recordbook');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $boid_id = $_GET['id'];
    $user_id = $_SESSION['user_id']; // User ID stored in session

    // Fetch the BOID details to edit
    $sql = "SELECT * FROM boiddetails WHERE id = '$boid_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $boid_number = $_POST['boid_number'];
        $boid_name = $_POST['boid_name'];

        // Update the BOID details in the database
        $update_sql = "UPDATE boiddetails SET boid_number = '$boid_number', boid_name = '$boid_name' WHERE id = '$boid_id' AND user_id = '$user_id'";
        echo($update_sql);
        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('BOID updated successfully'); window.location.href = 'viewBoids.php';</script>";
        } else {
            echo "<script>alert('Error updating BOID');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit BOID</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
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

/* Form styling */
.boid-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 1rem;
    color: #555;
    margin-bottom: 5px;
}

input {
    padding: 10px;
    border: 2px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    color: #333;
    transition: border-color 0.3s;
}

input:focus {
    border-color: #00bcd4;
    outline: none;
}

.submit-btn {
    background-color: #00bcd4;
    color: white;
    font-size: 1.2rem;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
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

/* Tooltip for buttons */
button {
    margin-right: 10px;
}

        </style>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="index.php">HOME</a>
            <a href="addBoid.php">Add BOID</a>
            <a href="viewBoids.php">All BOIDs</a>
        </div>
        <div class="nav-right">
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h2>Edit BOID</h2>
        <!-- <form action="editBoid.php?id=<?php echo $boid_id; ?>" method="POST" class="boid-form">
            <div class="form-group">
                <label for="boid-number">BOID Number</label>
                <input type="text" id="boid-number" name="boid_number" value="<?php echo $row['boid_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="boid_name">Name</label>
                <input type="text" id="boid-name" name="boid_name" value="<?php echo $row['boid_name']; ?>" required>
            </div>
            <button type="submit" class="submit-btn">Update BOID</button>
        </form> -->
        <form action="editBoid.php" method="POST" class="boid-form">
            <div class="form-group">
                <label for="boid-number">BOID Number</label>
                <input type="text" id="boid-number" name="boid_number" required placeholder="Enter BOID number">
            </div>
            <div class="form-group">
                <label for="boid-name">Name</label>
                <input type="text" id="boid-name" name="boid_name" required placeholder="Enter your name">
            </div>
            <button type="submit" class="submit-btn">Update BOID</button>
        </form>
    </div>
</body>
</html>
