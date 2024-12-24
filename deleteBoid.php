<?php
session_start();
include('config.php');
$conn = new mysqli('localhost', 'root', '', 'boid_recordbook');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $boid_id = $_GET['id'];
    $user_id = $_SESSION['user_id']; // User ID stored in session

    // Delete the BOID
    $sql = "DELETE FROM boiddetails WHERE id = '$boid_id' AND user_id = '$user_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('BOID deleted successfully'); window.location.href = 'viewBoids.php';</script>";
    } else {
        echo "<script>alert('Error deleting BOID'); window.location.href = 'viewBoids.php';</script>";
    }
}
?>
