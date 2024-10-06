<?php
include('../conn.php');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$cpassword = $_POST["cpassword"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($name != NULL || $email != NULL || $phone != NULL || $password != NULL || $cpassword != NULL) {
      $checkQuery = "SELECT * FROM Users WHERE Email = '$email'";
      $result = mysqli_query($conn, $checkQuery);
      if (mysqli_num_rows($result) == 0) {
            if ($password == $cpassword) {
                $query = "INSERT INTO Users (Name, Email, Password, PhoneNumber) VALUES ('$name', '$email', '$password', '$phone');";
                mysqli_query($conn, $query);

                if ($query) {

                    session_start();
                    $_SESSION['Name'] = $name;
                    $_SESSION['UserID'] = mysqli_insert_id($conn);

                    header('Location: ../index.php');
                    exit();
                } else {
                    $error = 'Failed to register user';
                }
            } else {
                $error = "Passwords do not match.";
                exit();
            }
        } else {
            $error ='User already exists';
            // header('Location: ../index.php');
            // exit();
        }
    } else {
        $error = "Fields cannot be empty";
    }
  }
// Close the connection
// $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEVCOM - Developers Community</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="./pages.css" />
</head>
<body>
    <!-- signup form start  -->
    <div id="container" class="login-container">
        <div class="loginBody">
            <div class="cancel" onClick="window.location.href='../index.php'">X</div>
            <div class="login-content">
                <form action="" method="POST">
                    <h2 class="title">Sign Up</h2>
                    <h3 style="color:grey;" align="center"><?php echo $error ?> </h3>

                    <div class="input-div one">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                            <h5>Name</h5>
                            <input
                                type="text"
                                class="input"
                                name="name"
                                required
                            />
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="i">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="div">
                            <h5>Email</h5>
                            <input
                                type="email"
                                class="input"
                                name="email"
                                required
                            />
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="i">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="div">
                            <h5>Phone Number</h5>
                            <input
                                type="tel"
                                class="input"
                                name="phone"
                                pattern="[0-9]{10}"
                                required
                            />
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <h5>Password</h5>
                            <input
                                type="password"
                                class="input"
                                name="password"
                                required
                            />
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <h5>Confirm Password</h5>
                            <input
                                type="password"
                                class="input"
                                name="cpassword"
                                required
                            />
                        </div>
                        <input type="hidden" class="inputfield" id="datetime" name="date_time"></span>

                    </div>
                    <input type="submit" class="btn" value="Sign Up" />
                </form>
            </div>
        </div>
    </div>
    <!-- signup form end  -->
</body>
</html>
