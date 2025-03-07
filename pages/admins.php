<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("../conn.php");
$name = "";
if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    $name = $_SESSION['Name'];
    $loggedInBtn = '<button onclick="window.location.href=\'../logout.php\'">Logout</button>';
    $askBtn = '    <div class="askbtn"><a class="link" href="./pages/ask.html">Ask a question</a></div>';
    $loginBtn = '';
} else {
    $loggedInBtn = '<button onclick="window.location.href=\'./signup.php\'">Signup</button>';
    $loginBtn = '<button onclick="window.location.href=\'./pages/login.php\'">Login</button>';
    $askBtn = '';
}


mysqli_close($conn);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEVCOM - Developers Community</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>

    <link rel="stylesheet" href="../style.css" />
    <style>
        .active_side {
            color: #FFBF00;
        }

        .answer-btn a {
            color: white;
            text-decoration: none;
        }

        .statement {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
            text-overflow: ellipsis;

        }
    </style>
</head>

<body>
    <!-- header nav start  -->
    <div class="navbar">
        <div class="logo">
            <img src="../images/logo.png" alt="logo failed to load" height="100" />
        </div>
        <div class="nav">
            <ul>
                <li>
                    <a class="link" href="/">Home</a>
                </li>
                <li>
                    <a class="link" href="/about">About</a>
                </li>
                <li>
                    <a class="link" href="/contact">Contact Us</a>
                </li>
                <li>
                    <!-- Rendered conditionally based on localStorage token -->
                    <a class="link" href="/blog">
                        <i class="fa fa-user"></i> <?php echo $name ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="search">
            <input type="text" placeholder="Search" />
        </div>
        <div class="search-btn">
            <button>
                <i class="fa fa-search"></i>
            </button>
        </div>
        <div class="login-btn">
            <?php echo $loginBtn; ?>

        </div>
        <div class="signup-btn">
            <?php echo $loggedInBtn; ?>
        </div>

    </div>
    <!-- header nav close -->



    <!-- side nav start -->
    <div class="menu-bars">
        <i class="fa fa-bars"></i>
    </div>
    <div class="navside">
        <div class="cancelbtn">X</div>

        <ul>
            <li>
                <a class="sidelink" href="../index.php">
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            <li>
                <a class="sidelink " href="./questions.php">
                    <i class="fa fa-book"></i> Questions
                </a>
            </li>
            <li>
                <a class="sidelink" href="./community.php">
                    <i class="fa fa-users"></i> Community
                </a>
            </li>
            <li>
                <a class="sidelink active_side" href="./admins.php">
                    <i class="fa fa-user"></i> Admins
                </a>
            </li>
            <li>
                <a class="sidelink " href="./tags.php">
                    <i class="fa fa-tags"></i> Tags
                </a>
            </li>
            <li>
                <a class="sidelink " href="./docs.php">
                    <i class="fa fa-file-code-o"></i> Docs...
                </a>
            </li>
        </ul>
        <div class="login-btnnav">
            <button>Login</button>
        </div>
        <div class="signup-btnnav">
            <button>Signup</button>
        </div>
        <div class="estra">
            <ul>
                <li>
                    <a class="linkli" href="/about">About</a>
                </li>
                <li>
                    <a class="linkli" href="/contact">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- side nav close  -->



    <!-- questions start  -->
    <div class="something">
        <h1>Community</h1>
    </div>
    <?php
    ?>
    <!-- Rendered Notes -->
    <!-- You can use server-side templating or JavaScript to dynamically generate the QueItem components -->
    <!-- Example static HTML -->
    <div class="que-item">
        <!-- QueItem HTML -->
    </div>

    <!-- questions end  -->




    <!-- footer start  -->
    <div class="footer">
        <div class="logof">
            <img src="../images/logo.png" alt="" />
            <p>
                PDC Forum is a social questions and Answer Engine. Which will help you
                to solve your problem and connect with other people.
            </p>
        </div>
        <div class="column">
            <h1>About Us</h1>
            <a href="">Meet the Team</a>
            <a href="">Blog</a>
            <a href="">About Us</a>
            <a href="">Contact Us</a>
        </div>
        <div class="column">
            <h1>Legal Stuff</h1>
            <a href="">Terms of Use</a>
            <a href="">Privacy Policy</a>
            <a href="">Cookie Policy</a>
        </div>
        <div class="column">
            <h1>Help</h1>
            <a href="">Knowledge Base</a>
            <a href="">Support</a>
        </div>
        <div class="column">
            <h1>Follow</h1>
            <div class="row">
                <a href="">
                    <i class="fa fa-instagram"></i>
                </a>
                <a href="">
                    <i class="fa fa-instagram"></i>
                </a>
                <a href="">
                    <i class="fa fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="copyright">
        <p>&copy; PDC. All rights Reserved</p>
        <p>with love by PACE</p>
    </div>

    <!-- footer end  -->
    <?php echo $askBtn; ?>

</body>

</html>