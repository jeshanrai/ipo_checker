  <?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'boid_recordbook');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $boid_number = $_POST['boid_number'];
    $name = $_POST['boid_name'];
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO boiddetails (boid_number, name, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $boid_number, $name, $user_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: viewBoids.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add BOID - BOID Recordbook</title>
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

    <!-- Form Container -->
    <div class="container">
        <h2>Add BOID</h2>
        <form action="addBoid.php" method="POST" class="boid-form">
            <div class="form-group">
                <label for="boid-number">BOID Number</label>
                <input type="text" id="boid-number" name="boid_number" required placeholder="Enter BOID number">
            </div>
            <div class="form-group">
                <label for="boid-name">Name</label>
                <input type="text" id="boid-name" name="boid_name" required placeholder="Enter your name">
            </div>
            <button type="submit" class="submit-btn">Add BOID</button>
        </form>
    </div>\

    <div>
        <button>chek result</button>
</div>
</body>
</html>
