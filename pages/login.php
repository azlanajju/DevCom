<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];

      include("../conn.php");
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['Name']; 
        $userID = $row['UserID'];

        session_start();
        $_SESSION['Name'] = $name;
        $_SESSION['UserID'] =  $userID ;

        header("Location: ../index.php");
        exit();
      } else {
     $err=  "Invalid email or password.";
      }

      mysqli_close($conn);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pace Developers Community</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="./pages.css" />
</head>
<body>
    <!-- login form start  -->
    <div id="container" class="login-container">
        <div class="loginBody">
            <div class="cancel" onClick="window.location.href='../index.php'">X</div>
            <div class="login-content">
                <form action="" method="POST">
                    <h2 class="title">Login</h2>
                    <h3 style="color:grey;" align="center"><?php echo $err ?> </h3>
 
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

                    <input type="submit" class="btn" value="Login in" />
                </form>
            </div>
        </div>
    </div>
    <!-- signup form end  -->
</body>
</html>
