<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include("../conn.php");

// Array of abusive words
include("./abusiveWords.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $questionTitle = $_POST['title'];
  $problemDetails = $_POST['description'];
  $answerExpectations = $_POST['expectation'];
  $tags = $_POST['tags'];
  $userID = $_SESSION['UserID'];

  // Check for abusive words
  $containsAbusiveWord = false;
  foreach ($abusiveWords as $word) {
    if (stripos($questionTitle, $word) !== false || stripos($problemDetails, $word) !== false || stripos($answerExpectations, $word) !== false || stripos($tags, $word) !== false) {
      $containsAbusiveWord = true;
      break;
    }
  }

  if ($containsAbusiveWord) {
    echo "<script> alert('Posting blocked due to abusive content.');</script>";
  } else {
    $formattedProblemDetails = nl2br($problemDetails);
    $formattedAnswerExpectations = nl2br($answerExpectations);

    $sql = "INSERT INTO qna (UserID, questionTitle, problemDetails, answerExpectations, tags)
            VALUES ('$userID', '$questionTitle', '$formattedProblemDetails', '$formattedAnswerExpectations', '$tags')";

    if (mysqli_query($conn, $sql)) {
      header("Location: ../index.php");
    } else {
      echo "<script>alert('error in asking questions')</script>";
    }
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
  <title>Ask Question</title>
  <link rel="stylesheet" href="./pages.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>

<body>

  <div class="body">
    <div class="container1">
      <h1>Ask Questions</h1>
      <form method="POST" action="">
        <div class="section">
          <label for="title">Title</label>
          <input value="wertyuiokjhgfdsas" placeholder="Enter the title related to your problem..." type="text" id="title" name="title" minlength="10" required />
        </div>
        <div class="section">
          <label for="description">Details of your problem</label>
          <textarea placeholder="Enter the detailed explanation of your project..." name="description" id="description" minlength="10" required>qwertyuiolkjhgfdzxcvbnm</textarea>
        </div>
        <div class="section">
          <label for="expectation">What you are expecting?</label>
          <textarea placeholder="What is your expected answer?" name="expectation" id="expectation" minlength="10" required>qwertyuioplkjhgfdaZxcvbnm</textarea>
        </div>
        <div class="section">
          <label for="tags">Tags</label>
          <input value="wertyuilkjhdzxcvbn" placeholder="Enter at least 5 tags" type="text" name="tags" id="tags" minlength="5" required />
        </div>
        <div class="buttons">
          <button type="submit" class="btn">Submit</button>
        </div>
      </form>
    </div>
  </div>



  <!-- footer start  -->
  <div class="afooter">
    <div class="alogof">
      <img src="../images/logo.png" alt="" />
      <p>
        PDC Forum is a social questions and Answer Engine. Which will help you to
        solve your problem and connect with other people.
      </p>
    </div>
    <div class="acolumn">
      <h1>About Us</h1>
      <a href="">Meet the Team</a>
      <a href="">Blog</a>
      <a href="">About Us</a>
      <a href="">Contact Us</a>
    </div>
    <div class="acolumn">
      <h1>Legal Stuff</h1>
      <a href="">Terms of Use</a>
      <a href="">Privacy Policy</a>
      <a href="">Cookie Policy</a>
    </div>
    <div class="acolumn">
      <h1>Help</h1>
      <a href="">Knowledge Base</a>
      <a href="">Support</a>
    </div>
    <div class="acolumn">
      <h1>Follow</h1>
      <div class="arow">
        <a href=""><i class="fa fa-instagram"></i></a>
        <a href=""><i class="fa fa-instagram"></i></a>
        <a href=""><i class="fa fa-instagram"></i></a>
      </div>
    </div>
  </div>
  <div class="acopyright">
    <p>&copy; PDC. All rights Reserved</p>
    <p>with love by PACE</p>
  </div>


  <!-- footer end  -->
</body>

</html>