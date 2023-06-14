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
    $askBtn = '    <div class="askbtn"><a class="link" href="./ask.html">Ask a question</a></div>';
    $loginBtn = '';
    $phoneauth ='  <div class="login-btnnav">
    <a href="./logout.php">Logout</a>
  </div>';
  
} else {
    $loggedInBtn = '<button onclick="window.location.href=\'./signup.php\'">Signup</button>';
    $loginBtn = '<button onclick="window.location.href=\'./login.php\'">Login</button>';
    $askBtn = '';
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];



  // Retrieve data from the qna table
  $sql = "SELECT qna.*, Users.Name AS UserName
  FROM qna
  JOIN Users ON qna.UserID = Users.UserID
  WHERE qna.id = '$id'";
$result = mysqli_query($conn, $sql);

  $questionLoop = '';

  if (mysqli_num_rows($result) > 0) {
      // Loop through each row
      while ($row = mysqli_fetch_assoc($result)) {
          // Retrieve the question details
          $questionTitle = $row['questionTitle'];
          $problemDetails = $row['problemDetails'];
          $answerExpectations = $row['answerExpectations'];
          $tags = $row['tags'];
          $askedTime = $row['askedTime'];
          $updatedTime = $row['updatedTime'];
          $upvote = $row['upvote'];
          $downvote = $row['downvote'];
          $qname = $row['UserName'];


          // Append the question HTML to the $questionLoop variable
          $questionLoop .= '
              <div class="middle-nav">
                  <div class="questions">
                      <div class="que">
                          <div class="name">' . $qname . '</div>
                          <div class="q">' . $questionTitle . '</div>
                          <div class="statement"> <strong>Problem Details: </strong>' . $problemDetails . '</div>
                          <div class="statement"><strong>Answer Expectations: </strong>' . $answerExpectations . '</div>

                      </div>
                  </div>
              </div>
              <hr />';
      }
  } else {
    $questionLoop = 'No rows found.';
  }


       if (isset($_POST['upvote'])) {
        $answerID = $_POST['answer_id'];
    
        $voteQuery = "SELECT * FROM answers WHERE answeredBy='$userID' AND id='$answerID'";
        $voteResult = mysqli_query($conn, $voteQuery);
    
        // if (mysqli_num_rows($voteResult) == 0) {
            $sqlUpvote = "UPDATE answers SET upvote = upvote + 1 WHERE id = '$answerID'";
            mysqli_query($conn, $sqlUpvote);
        // }
    }
    
         if (isset($_POST['downvote'])) {
          $answerID = $_POST['answer_id'];
      
          $voteQuery = "SELECT * FROM answers WHERE answeredBy='$userID' AND id='$answerID'";
          $voteResult = mysqli_query($conn, $voteQuery);
      
          // if (mysqli_num_rows($voteResult) == 0) {
              $sqlDownvote = "UPDATE answers SET downvote = downvote + 1 WHERE id = '$answerID'";
              mysqli_query($conn, $sqlDownvote);
          // }
      }


  // Fetch answers from the table with user details
  $sqlAnswer = "SELECT answers.id, answers.answerDetails,answers.answeredTime, answers.upvote, answers.downvote,  Users.Name AS answeredBy
                FROM answers
                JOIN Users ON answers.answeredBy = Users.UserID
                WHERE answers.questionID='$id'";
  $resultAnswer = mysqli_query($conn, $sqlAnswer);

  $answerLoop = '';

  if (mysqli_num_rows($resultAnswer) > 0) {
      // Loop through each row
      while ($rowAnswer = mysqli_fetch_assoc($resultAnswer)) {
        $answerID = $rowAnswer['id'];
          $answeredBy = $rowAnswer['answeredBy'];
          $answerDetails = $rowAnswer['answerDetails'];
          $answeredTime= $rowAnswer['answeredTime'];
          $upvote = $rowAnswer['upvote'];
          $downvote = $rowAnswer['downvote'];

          $answerLoop .= '
          <div class="answers">
              <div class="ans">
                  <div class="name">' . $answeredBy . '</div>
                  <div class="statement">' . $answerDetails . '</div>
              </div>
              <div class="votes">
                  <form action="" method="post">
                      <input type="hidden" name="answer_id" value="' . $answerID . '">
                      <button class="likes" type="submit" name="upvote"><i class="fa fa-thumbs-up"></i>'. $upvote .'</button>
                  </form>
                  <form action="" method="post">
                      <input type="hidden" name="answer_id" value="' . $answerID . '">
                      <button type="submit" class="likes" name="downvote"><i class="fa fa-thumbs-down"></i>'. $downvote .'</button>
                  </form>
              </div>
              <div class="time"><strong>Answered at: </strong>' . $answeredTime . '</div>
          </div>
          <hr>';
      
      }
  } else {
    $answerLoop = '    No answers found.';
  }
} else {
  echo "id parameter is not set in the URL.";
}

// Close the database connection
mysqli_close($conn);

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pace Developers Community</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <link rel="stylesheet" href="../style.css">
    <!-- <link rel="stylesheet" href="./answer.css"> -->
    <link rel="stylesheet" href="./temp.css">
    <link rel="stylesheet" href="./sidenav.css">
    <style>

.auth-btns{
      display: none;
    }
  .answers{
    width: 78vw;
    margin-left: 22vw;
    padding: 15px;
    background: #000;
}
.time{
position: absolute;
color: #fff;
right: 0;
margin-top: -10px;
color: #333;
background-color: #fff;
padding: 2px 10px;
border-radius: 2px;

}
.votes{
  display: flex;
}
.likes, .dislikes{
  color: white;
  margin-bottom: -20px;
  background: none;
  border: none;
  padding: 10px;

}
.likes i, .dislikes i{
  color: lavender;
  padding: 10px;
  cursor: pointer;
  font-size: 16px;
}
@media (max-width: 768px) {
    .answers{
        width: 92vw;
        margin: 0;

    }
    .answerit{
        /* width: 100vw; */
        margin: 0;
    }
    .time{
        font-size: 10px;
    }
    .likes, .dislikes{
`       font-size: 10px;
    }
    .something{
        /* height: auto; */
        margin: 0;
    }
    .questions{
        max-width: 100vw;
        margin: 0;
    }
    .logo img{
    margin-left: 0px;

  }
  .auth-btns{
      display: flex;
    }
}
.submitAnswer{
  cursor: pointer;
}.que{
  height: auto;
  padding: 20px;
}

   </style>
</head>
<body>
    <!-- header nav start -->
    <div class="navbar">
        <div class="logo">
            <img src="../images/logo.png" alt="logo failed to load" height="100" />
        </div>
        <div class="nav">
            <ul>
                <li><a class="link" href="../index.php">Home</a></li>
                <li><a class="link" href="/about">About</a></li>
                <li><a class="link" href="/contact">Contact Us</a></li>
                <li><a class="link" href="./profile.php"><i class="fa fa-user"></i> <?php echo $name; ?></a></li>
            </ul>
        </div>
        <div class="search">
            <input type="text" placeholder="Search" />
        </div>
        <div class="search-btn">
            <button><i class="fa fa-search"></i></button>
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
<div onclick="openNav()" class="menu-bars">
    <i class="fa fa-bars"></i>
  </div>
  <div id="navPhone" class="navside">
    <div onclick="closeNav()" class="cancelbtn">X</div>

    <ul>
      <li>
        <a class="sidelink" href="../index.php">
          <i class="fa fa-home"></i> Home
        </a>
      </li>
      <li>
        <a class="sidelink" href="./questions.php">
          <i class="fa fa-book"></i> Questions
        </a>
      </li>
      <li>
        <a class="sidelink" href="#">
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
<?php   echo $phoneauth; ?>
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



    <!-- answer start  -->
    <div class="something">
        <h1>Answers</h1>
    </div>
    <?php echo $questionLoop; ?>
    <?php echo $answerLoop; ?>
    <div class="answerit">
        <form action="./submit_answer.php?question_id=<?php echo $id?>" method="POST">
            <textarea placeholder="Type your answer" name="answer" cols="30" rows="10"></textarea>
            <input type="hidden" name="question_id" value="<?php echo $id; ?>">
            <input class="submitAnswer" type="submit" value="Submit" />
        </form>
    </div>

    <!-- answer end  -->

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
                <a href=""><i class="fa fa-instagram"></i></a>
                <a href=""><i class="fa fa-instagram"></i></a>
                <a href=""><i class="fa fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="copyright">
        <p>&copy; PDC. All rights Reserved</p>
        <p>with love by PACE</p>
    </div>
    <!-- footer end  -->
    <?php echo $askBtn; ?>
    <script>

  function openNav(){
  document.getElementById('navPhone').style.width="100vw";
  }
  
  function closeNav(){
  document.getElementById('navPhone').style.width="0";
  }
</script>
</body>
</html>
