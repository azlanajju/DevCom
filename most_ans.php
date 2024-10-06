<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
include("./conn.php");

if (isset($_SESSION['UserID'])) {
  $userID = $_SESSION['UserID'];
  $name =    $_SESSION['Name'];
  $loggedInBtn = '<button onclick="window.location.href=\'./logout.php\'">Logout</button>';
  $askBtn = '    <div class="askbtn"><a class="link" href="./pages/ask.php">Ask a question</a></div>';
  $loginBtn = '';

  $phoneauth = '  <div class="login-btnnav">
  <a href="./logout.php">Logout</a>
</div>';
} else {
  $loggedInBtn = '<button onclick="window.location.href=\'./pages/signup.php\'">Signup</button>';
  $loginBtn = '<button onclick="window.location.href=\'./pages/login.php\'">Login</button>';
  $askBtn = '';
  $phoneauth = '    <div class="login-btnnav">
  <a href="./pages/login.php">Login</a>
</div>
<div class="signup-btnnav">
  <a href="./pages/signup.php">Signup</a>
</div>';
}

// Retrieve data from the qna table
$sql = "SELECT qna.id, qna.UserID, Users.Name AS UserName, qna.questionTitle, qna.problemDetails, qna.answerExpectations, qna.tags, qna.askedTime, qna.updatedTime, qna.upvote, qna.downvote,
        COUNT(a.id) AS answerCount
        FROM qna
        LEFT JOIN answers a ON qna.id = a.questionID
        JOIN Users ON qna.UserID = Users.UserID
        GROUP BY qna.id
        ORDER BY answerCount DESC
        LIMIT 10";


$result = mysqli_query($conn, $sql);

$questionLoop = ''; // Initialize the variable outside the loop

// Check if any rows are returned
if (mysqli_num_rows($result) > 0) {
  // Loop through each row
  while ($row = mysqli_fetch_assoc($result)) {
    // Retrieve the question details
    $id = $row['id'];
    $userID = $row['UserID'];
    $qname = $row['UserName'];
    $questionTitle = $row['questionTitle'];
    $problemDetails = $row['problemDetails'];
    $answerExpectations = $row['answerExpectations'];
    $tags = $row['tags'];
    $askedTime = $row['askedTime'];
    $updatedTime = $row['updatedTime'];
    $upvote = $row['upvote'];
    $downvote = $row['downvote'];

    // Query to retrieve the number of answers for the current question
    $answerCountQuery = "SELECT COUNT(*) AS answerCount, upvote, downvote FROM answers WHERE questionID = '$id'";
    $answerCountResult = mysqli_query($conn, $answerCountQuery);
    $answerCountRow = mysqli_fetch_assoc($answerCountResult);
    $answerCount = $answerCountRow['answerCount'];
    $upvote = $answerCountRow['upvote'];
    $downvote = $answerCountRow['downvote'];
    $votes = $upvote + $downvote;




    // Append the question HTML to the $questionLoop variable
    $questionLoop .= '
        <div class="middle-nav">
            <div class="questions">
                <div class="que">
                    <div class="name">' . $qname . '</div>
                    <div class="q">' . $questionTitle . '</div>
                    <div class="statement">' . $problemDetails . '</div>
                    <div class="cont">
                        <div class="answer">' . $answerCount . ' Answers</div>
                        <div class="views">' . $votes . ' Votes</div>
                        <div class="answer-btn">
                            <a href="./pages/answer.php?id=' . $id . '">Answers</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />';
  }
} else {
  $questionLoop = "No Questions found.";
}

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

  <link rel="stylesheet" href="./style.css" />
  <style>
    /* ==================mobile devices================== */
    .auth-btns {
      display: none;
    }

    @media (max-width: 768px) {

      .navside {
        transition: 0.3s;
        position: absolute;
        width: 0;
        overflow: hidden;
        z-index: 99999;

      }

      .navside ul {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
      }

      .auth-btns {
        display: flex;
        width: 100vw;
        justify-content: center;

      }

      .signup-btnnav a {
        display: flex;
        cursor: pointer;
        border: none;
        background-color: #FFBF00;
        height: 35px;
        width: 80px;
        /* position: absolute; */
        /* right: 10px; */
        margin: 10px;
        border-radius: 15px;
        color: #e6e6fa;
        font-size: 17px;
        font-weight: bold;
        /* box-shadow: 2px 2px 1px 2px rgba(0, 128, 128, 0.507); */
        justify-content: center;
        align-items: center;
        text-decoration: none;
      }

      .login-btnnav a {
        display: flex;
        cursor: pointer;
        border: 3px solid #FFBF00;
        background-color: #e6e6fabb;
        height: 35px;
        width: 80px;
        /* position: absolute; */
        /* right: 100px; */
        margin: 10px;
        border-radius: 15px;
        color: #FFBF00;
        font-size: 17px;
        font-weight: bold;
        justify-content: center;
        align-items: center;
        text-decoration: none;
      }
    }

    .active_side {
      color: #FFBF00;
    }
  </style>
</head>
<style>
  .answer-btn a {
    color: white;
    text-decoration: none;
  }

  .answer-btn a:hover {
    color: #FFBF00;
  }

  .statement {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
    /* text-overflow: ellipsis; */
  }
</style>

<body>
  <!-- header nav start  -->
  <div class="navbar">
    <div class="logo">
      <img src="./images/logo.png" alt="logo failed to load" height="100" />
    </div>
    <div class="nav">
      <ul>
        <li>
          <a class="link " href="#">Home</a>
        </li>
        <li>
          <a class="link" href="/about">About</a>
        </li>
        <li>
          <a class="link" href="/contact">Contact Us</a>
        </li>
        <li>
          <!-- Rendered conditionally based on localStorage token -->
          <a class="link" href="./pages/profile.php">
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
  <!-- motto start  -->
  <div class="content">

  </div>
  <!-- motto end  -->


  <!-- side nav start -->
  <div onclick="openNav()" class="menu-bars">
    <i class="fa fa-bars"></i>
  </div>
  <div id="navPhone" class="navside">
    <div onclick="closeNav()" class="cancelbtn">X</div>

    <ul>
      <li>
        <a class="sidelink active_side" href="#">
          <i class="fa fa-home"></i> Home
        </a>
      </li>
      <li>
        <a class="sidelink" href="./pages/questions.php">
          <i class="fa fa-book"></i> Questions
        </a>
      </li>
      <li>
        <a class="sidelink" href="./pages/community.php">
          <i class="fa fa-users"></i> Community
        </a>
      </li>
      <li>
        <i class="fa fa-user"></i> Admins
      </li>
      <li>
        <i class="fa fa-tags"></i> Tags
      </li>
      <li>
        <i class="fa fa-file-code-o">..</i> Docs
      </li>
    </ul>
    <div class="auth-btns">
      <?php echo $phoneauth; ?>
    </div>
    <div class="estra">
      <ul>
        <li>
          <a class="linkli" href="">About</a>
        </li>
        <li>
          <a class="linkli" href="">Contact Us</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- side nav close  -->



  <!-- questions start  -->
  <div class="middle-nav-menu">
    <ul>
      <li>
        <a href="./index.php" class="menu-link ">Recent Questions</a>
      </li>
      <li>
        <a href="./most_vote.php" class="menu-link ">Most Voted</a>
      </li>
      <li>
        <a href="#" class="menu-link active">Most Answered</a>
      </li>
    </ul>
  </div>
  <?php
  echo $questionLoop;
  ?>

  <!-- questions end  -->




  <!-- footer start  -->
  <div class="footer">
    <div class="logof">
      <img src="./images/logo.png" alt="" />
      <p>
        DEVCOM is a social questions and Answer Engine. Which will help you
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
    <p>&copy; DEVCOM. All rights Reserved</p>
    <p>with love by PACE</p>
  </div>

  <!-- footer end  -->
  <?php echo $askBtn; ?>

  <script>
    function openNav() {
      document.getElementById('navPhone').style.width = "100vw";
    }

    function closeNav() {
      document.getElementById('navPhone').style.width = "0";
    }
  </script>
</body>

</html>