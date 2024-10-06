<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include("../conn.php");
$a_id = $_GET['question_id'];

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    echo $userID;
    $answer = $_POST['answer'];
    $questionID = $_POST['question_id'];

    // Check if the user exists
    $userExistsQuery = "SELECT * FROM Users WHERE UserID = '$userID'";
    $userExistsResult = mysqli_query($conn, $userExistsQuery);

    if (mysqli_num_rows($userExistsResult) > 0) {
        // User exists, insert the answer into the answers table
        $formattedAnswer = nl2br($answer); // Format the answer with preserved line breaks
        $insertQuery = "INSERT INTO answers (questionID, answeredBy, answerDetails) VALUES ('$questionID', '$userID', '$formattedAnswer')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo "Answer submitted successfully.";
            header("Location: ./answer.php?id=".$a_id); 

        } else {
            echo "Failed to submit the answer.";
        }
    } else {
        echo "Invalid user.";
    }
} else {
    echo "You must be logged in to submit an answer.";
}

// Close the database connection
mysqli_close($conn);
?>
