<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include("../conn.php");

if(isset($_SESSION['UserID']) ) { 
    $userID = $_SESSION['UserID'];
    $name =    $_SESSION['Name'];
    $loggedInBtn = '<button onclick="window.location.href=\'./logout.php\'">Logout</button>';
    $askBtn= '    <div class="askbtn"><a class="link" href="./pages/ask.html">Ask a question</a></div>';
    $loginBtn= '';

  $phoneauth ='  <div class="login-btnnav">
  <a href="./logout.php">Logout</a>
</div>';


$sqlUser = "SELECT * FROM Users WHERE UserID='$userID'";
  $resultUser = mysqli_query($conn, $sqlUser);

  if (mysqli_num_rows($resultUser) > 0) {
      while ($rowUser= mysqli_fetch_assoc($resultUser)) {
        $email = $rowUser['Email'];
        $phone = $rowUser['PhoneNumber'];




      }
  } else {
    $answerLoop = '    No answers found.';
  }




   
} else {
  $loggedInBtn = '<button onclick="window.location.href=\'./pages/signup.php\'">Signup</button>';
  $loginBtn= '<button onclick="window.location.href=\'./pages/login.php\'">Login</button>';
  $askBtn= '';
  $phoneauth ='    <div class="login-btnnav">
  <a href="./pages/login.php">Login</a>
</div>
<div class="signup-btnnav">
  <a href="./pages/signup.php">Signup</a>
</div>';

$userID ='not logged in';


}

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

    <link rel="stylesheet" href="../style.css" />
    <style>
    /* ==================mobile devices================== */
    .auth-btns{
      display: none;
    }
    @media (max-width: 768px) {

      .navside{
    transition: 0.3s;
    position: absolute;
    width:0;
    overflow: hidden;
    z-index: 99999;

  }
  .navside ul{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }
  .auth-btns{
  display: flex;
  width: 100vw;
  justify-content: center;
  
}
.signup-btnnav a{
  display: flex;
  cursor: pointer;
  border: none;
  background-color: teal;
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
.login-btnnav a{
  display: flex;
  cursor: pointer;
  border: 3px solid teal;
  background-color:#e6e6fabb;
  height: 35px;
  width: 80px;
  /* position: absolute; */
  /* right: 100px; */
  margin: 10px;
  border-radius: 15px;
  color: teal;
font-size: 17px;
font-weight: bold;
justify-content: center;
align-items: center;
text-decoration: none;}
    }
.profile{
    margin-left: 22vw;
    background-color: #333;
    width: 78vw;
    height: 50vh;
    display: flex;
    align-items: center;
    color: #fff;
}

.profile {
  display: flex;
  align-items: center;
}


.profile-picture {
  position: relative;

}

.profile-initial {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background-color: #ccc;
  color: #fff;
  font-size: 72px;
  font-weight: bold;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-left: 30px;
}

.profile-picture img {
  
  display: none;
  width: 150px;
  height: 150px;
  border-radius: 50%;
  margin-left: 30px;
  opacity: 0;
  
}

.profile-info {
  margin-left: 20px;
}

.profile-name {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
  color: teal;

}



.profile-details {
  list-style-type: none;
  padding: 0;
}

.profile-detail-item {
  margin-bottom: 5px;
}

.detail-label {
  font-weight: bold;
  color: teal;
}
.detButtons{
  display: flex;
  flex-direction: column;
  position: absolute;
  right: 20vw;

}
.detButtons a{
color: white;
background: teal;
text-decoration: none;
padding: 15px 25px;
margin: 20px;
border-radius: 5px;
}
    </style>
  </head>
  <style>

  </style>
  <body>
    <!-- header nav start  -->
    <div class="navbar">
      <div class="logo">
        <img src="../images/logo.png" alt="logo failed to load" height="100" />
      </div>
      <div class="nav">
        <ul>
          <li>
            <a class="link" href="../index.php">Home</a>
          </li>
          <li>
            <a class="link" href="#">About</a>
          </li>
          <li>
            <a class="link" href="#">Contact Us</a>
          </li>
          <li>
            <!-- Rendered conditionally based on localStorage token -->
            <a class="link" href="#">
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
        <a class="sidelink" href="">
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

<!-- profile start  -->
  <div class="profile">
    <div class="profile-picture">
      <div class="profile-initial"></div>
      <img >
    </div>
    <div class="profile-info">
      <h1 class="profile-name"><?php   echo $name; ?>
</h1>
      <ul class="profile-details">
        <li class="profile-detail-item"><span class="detail-label">Email :</span> <?php echo $email;?></li>
        <li class="profile-detail-item"><span class="detail-label">Phone:</span> <?php echo $phone;?></li>
      </ul>
    </div>

    <div class="detButtons">
      <a href="">My Questions</a>
      <a href="">My Answers</a>


    </div>
  </div>
<!-- profile end  -->



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
<script>
  window.addEventListener('DOMContentLoaded', function () {
  var profileName = document.querySelector('.profile-name');
  var profileInitial = document.querySelector('.profile-initial');
  var profilePicture = document.querySelector('.profile-picture img');

  var initials = profileName.textContent.trim().split(' ').map(function (word) {
    return word[0].toUpperCase();
  });

  profileInitial.textContent = initials.join('');
  profilePicture.style.display = 'block';
});

</script>
  </body>
</html>
