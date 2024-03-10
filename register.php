<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="screen.css">
</head>
<body id="login">

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

    <div class="container mt-6" id="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="text-center mt-5 mb-3"><b>Registration Form</b></h1>
                <?php
                    // var_dump($_POST);
                    session_start();

                    if (isset($_SESSION["user"])){
                        header("Location: message.php");
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

                        $radio_country = $_POST['radio_country'];

                        $errors = array();

                        if ($radio_country == 'PH') {

                            $lname = $_POST['lastname'];
                            $fname = $_POST['firstname'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $repeat_password = $_POST['repeatPassword'];
                            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                            $region = $_POST['region'];
                            $province = $_POST['province'];
                            $city_mun = $_POST['cityMunicipality'];
                            $brgy = $_POST['barangay'];
                            $lot_blk = $_POST['lotBlk'];
                            $street = $_POST['street'];
                            $ph_subdv = $_POST['phaseSubdivision'];

                            if (empty($lname) || empty($fname) || empty($email) || empty($password) || empty($repeat_password)) {
                                // || empty($lot_blk) || empty($street) || empty($ph_subdv)
                                array_push($errors,"All fields are required");
                            }

                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                array_push($errors,"Email is not valid");
                            }

                            if (strlen($password)<8) {
                                array_push($errors,"Password must be at least 8 characters long");
                            }

                            if ($password != $repeat_password) {
                                array_push($errors,"Password does not match");
                            }

                            require_once "database.php";
                            $sql = "SELECT * FROM user WHERE email = '$email'";
                            $result = mysqli_query($conn, $sql);
                            $rowCount = mysqli_num_rows($result);
                            if ($rowCount > 0) {
                                array_push($errors,"Email Already Exists!");
                            }

                            if (count($errors) > 0) {
                                foreach ($errors as $error) {
                                    echo"<div class='alert alert-danger'>$error</div>";
                                } 
                            } else {
                                require_once "database.php";
                                $sql = "INSERT INTO user (lname, fname, email, password, region, province, city_mun, brgy, lot_blk, street, ph_subdv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = mysqli_stmt_init($conn);
                                $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                                if ($preparestmt) {
                                    mysqli_stmt_bind_param($stmt, "sssssssssss", $lname, $fname, $email, $passwordHash, $region, $province, $city_mun, $brgy, $lot_blk, $street, $ph_subdv);
                                    if (mysqli_stmt_execute($stmt)) {
                                        echo "<div class = 'alert alert-success'> You are Registered Successfully! </div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                                    }
                                } else {
                                    die("Something went wrong");
                                }
                            }
                        } elseif ($radio_country == "other") {

                            $other_lname = $_POST['other_lastname'];
                            $other_fname = $_POST['other_firstname'];
                            $other_email = $_POST['other_email'];
                            $other_password = $_POST['other_password'];
                            $other_repeat_password = $_POST['other_repeatPassword'];
                            $other_passwordHash = password_hash($other_password, PASSWORD_DEFAULT);
                            $country = $_POST['country'];
                            $state = $_POST['state'];
                            $city = $_POST['city_other'];
                            $other_lot_blk = $_POST['other_lotBlk'];
                            $other_street = $_POST['other_street'];
                            $other_ph_subdv = $_POST['other_phaseSubdivision'];

                            if (empty($other_lname) || empty($other_fname) || empty($other_email) || empty($other_password) || empty($other_repeat_password)) {
                                // || empty($lot_blk) || empty($street) || empty($ph_subdv)
                                array_push($errors,"All fields are required");
                            }

                            if (!filter_var($other_email, FILTER_VALIDATE_EMAIL)) {
                                array_push($errors,"Email is not valid");
                            }

                            if (strlen($other_password)<8) {
                                array_push($errors,"Password must be at least 8 characters long");
                            }

                            if ($other_password != $other_repeat_password) {
                                array_push($errors,"Password does not match");
                            }

                            require_once "database.php";
                            $sql = "SELECT * FROM user WHERE email = '$other_email'";
                            $result = mysqli_query($conn, $sql);
                            $rowCount = mysqli_num_rows($result);
                            if ($rowCount > 0) {
                                array_push($errors,"Email Already Exists!");
                            }

                            if (count($errors) > 0) {
                                foreach ($errors as $error) {
                                    echo"<div class='alert alert-danger'>$error</div>";
                                } 
                            } else {
                                require_once "database.php";
                                $sql = "INSERT INTO user (lname, fname, email, password, country, state, city_mun, lot_blk, street, ph_subdv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt = mysqli_stmt_init($conn);
                                $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                                if ($preparestmt) {
                                    mysqli_stmt_bind_param($stmt, "ssssssssss", $other_lname, $other_fname, $other_email, $other_passwordHash, $country, $state, $city, $other_lot_blk, $other_street, $other_ph_subdv);
                                    if (mysqli_stmt_execute($stmt)) {
                                        echo "<div class = 'alert alert-success'> You are Registered Successfully! </div>";
                                    } else {
                                        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
                                    }
                                } else {
                                    die("Something went wrong");
                                }
                            }
                        } else {
                            $errors[] = "Invalid country selection.";
                        }

                        // require_once "database.php";
                        // $sql = "SELECT * FROM user WHERE email = '$email'";
                        // $result = mysqli_query($conn, $sql);
                        // $rowCount = mysqli_num_rows($result);
                        // if ($rowCount > 0) {
                        //     array_push($errors,"Email Already Exists!");
                        // }
                        // header("Location: " . $_SERVER['PHP_SELF']);
                        // exit();
                    }

                    // if (isset($_SESSION['success_message'])) {
                    //     echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
                    //     // Clear the success message from the session
                    //     unset($_SESSION['success_message']);
                    // }
                ?>
                
                <form method="post">    

                    <div class="form-group">
                        <label>Select Country:</label>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="philippines" name="radio_country" value="PH" checked onclick="toggleCountryDropdown()">
                                        <label class="form-check-label" for="option2">Philippines</label>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="otherCountry" name="radio_country" value="other" onclick="toggleCountryDropdown()">
                                        <label class="form-check-label" for="option1">Others</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="philippines-dropdown">

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="lastname">Last Name:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name"> 
                            </div>
                            <div class="col-md-6">
                                <label for="firstname">First Name:</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="repeatPassword">Repeat Password:</label>
                            <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password">
                        </div>

                        <div class="form-group">
                            <label for="region">Region:</label>
                            <select class="form-control" id="region" name="region">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="province">Province:</label>
                            <select class="form-control" id="province" name="province">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cityMunicipality">City/Municipality:</label>
                            <select class="form-control" id="cityMunicipality" name="cityMunicipality">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="barangay">Barangay:</label>
                            <select class="form-control" id="barangay" name="barangay">
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="lotBlk">Lot/Blk:</label>
                                <input type="text" class="form-control" id="lotBlk" name="lotBlk" placeholder="Enter Lot/Blk">
                            </div>
                            <div class="col-md-6">
                                <label for="street">Street:</label>
                                <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phaseSubdivision">Phase/Subdivision:</label>
                            <input type="text" class="form-control" id="phaseSubdivision" name="phaseSubdivision" placeholder="Enter Phase/Subdivision">
                        </div>
                    </div>

                    <div class="other-country-dropdown">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="lastname">Last Name:</label>
                                <input type="text" class="form-control" id="other_lastname" name="other_lastname" placeholder="Enter Last Name"> 
                            </div>
                            <div class="col-md-6">
                                <label for="firstname">First Name:</label>
                                <input type="text" class="form-control" id="other_firstname" name="other_firstname" placeholder="Enter First Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" class="form-control" id="other_email" name="other_email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="other_password" name="other_password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="repeatPassword">Repeat Password:</label>
                            <input type="password" class="form-control" id="other_repeatPassword" name="other_repeatPassword" placeholder="Repeat Password">
                        </div>

                        <div class="form-group">
                            <label for="country">Country:</label>
                            <select class="form-control country" aria-label="Default select example" id="country" name="country" onchange="loadStates()">
                            </select>   
                        </div>

                        <div class="form-group">
                            <label for="state">State:</label>
                            <select class="form-control state" aria-label="Default select example" id="state" name="state" onchange="loadCities()">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City:</label>
                            <select class="form-control city" aria-label="Default select example" id="city_other" name="city_other">
                            </select>   
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="lotBlk">Lot/Blk:</label>
                                <input type="text" class="form-control" id="other_lotBlk" name="other_lotBlk" placeholder="Enter Lot/Blk">
                            </div>
                            <div class="col-md-6">
                                <label for="street">Street:</label>
                                <input type="text" class="form-control" id="other_street" name="other_street" placeholder="Enter Street">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phaseSubdivision">Phase/Subdivision:</label>
                            <input type="text" class="form-control" id="other_phaseSubdivision" name="other_phaseSubdivision" placeholder="Enter Phase/Subdivision">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit" value="1">Register</button>
                    <p class="mt-2">Already have an account? <a href="login.php">Login here</a>.</p>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap scripts for ph-locations -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
    <script type="text/javascript" src="jquery.ph-locations-v1.0.4.js"></script>
    <script src="philippines.js" type="text/javascript"></script>
    <!-- <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script> -->

    <!-- Bootstrap scripts for countries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="other-countries.js" type="text/javascript"></script>

    <!-- JS for swapping between ph and other countries -->
    <script src="country-swap.js" type="text/javascript"></script>

</body>
</html>