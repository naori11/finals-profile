
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
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

    <div class="container mt-10" id="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="text-center mt-5 mb-3"><b>Login</b></h1>
                <?php 
                    session_start();
                    if (isset($_SESSION["user"])){
                        header("Location: message.php");
                    }

                    if(isset ($_POST["login"])){
                        $email = $_POST["email"];
                        $entered_password = $_POST["password"];
                        require_once "database.php";
                        $sql = "SELECT * FROM user WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);
                        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        if ($user) {
                            if (password_verify($entered_password, $user["password"])) {
                                $_SESSION["user"] = "yes";
                                $_SESSION['user_id'] = $user['id'];
                                $_SESSION['user_name'] = $user['fname'] . ' ' . $user['lname'];
                                header("Location: message.php");
                                die();
                            } else {
                                echo "<div class= 'alert alert-danger'> Password does not match. </div>";
                            }
                        } else {
                            echo "<div class= 'alert alert-danger'> Email does not match. </div>";
                        }
                    }
                ?>
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                    <p class="mt-2">Don't have an account? <a href="register.php">Register here</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
