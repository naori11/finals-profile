<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Landing Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="screen.css">
</head>
<body>
<nav id="desktop-nav">
            <a class="logo">Juvan!</a>
            <ul class="navigation-bar">
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="interests.html">Achievements</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </nav>
    
        <nav id="mobile-nav">
            <div class="hamburger-bar">
                <div class="logo">Juvan!</div>
                <div class="hamburger-menu">
                    <div class="hamburger-icon" onclick="toggleMenu()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="menu-links">
                        <li><a href="index.html" onclick="toggleMenu()">Home</a></li>
                        <li><a href="about.html" onclick="toggleMenu()">About</a></li>
                        <li><a href="interests.html" onclick="toggleMenu()">Achievements</a></li>
                        <li><a href="contact.html" onclick="toggleMenu()">Contact</a></li>
                    </div>
                </div>
            </div>
        </nav>

<?php
session_start();

if (isset($_SESSION['user_name'])) {
    $userName = $_SESSION['user_name'];
    echo "<div class='container' id='spec_container'>";
    echo "<h1 class='text-center mt-5 mb-3 welcome'>Welcome, $userName!</h1>";
    echo "<p class='text-center'>Leave a message to me!:</p>";

    if (isset($_SESSION['message_status']) && $_SESSION['message_status'] == 'success') {
        echo "<div class='alert alert-success'>Message submitted successfully!</div>";
        unset($_SESSION['message_status']);
    }

    require_once "database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = $_POST['message'];

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $sql = "INSERT INTO messages (user_id, message) VALUES (?, ?)";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "is", $userId, $message);
                
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['message_status'] = 'success';
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Something went wrong. Please try again later.</div>";
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='alert alert-danger'>You must be logged in to submit a message.</div>";
        }
    }
    
    echo "<form action='' method='post'>";
    echo "<div class='form-group'>";
    echo "<label for='message'>Message:</label>";
    echo "<textarea class='form-control' id='message' name='message' rows='3' required></textarea>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary mr-2'>Submit</button>";
    echo "<a href='logout.php' class='btn ml-2'>Logout</a>";
    echo "</form>";
    echo "</div>";
} else {
    header("Location: login.php");
    exit;
}
?>


<div class="credits">
    <p><span>Made by</span>: Juvan Emanuel Paulo | BSIT - MI 222</p>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
