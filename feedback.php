<?php
session_start();


include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $feedback_text = mysqli_real_escape_string($conn, $_POST['feedback_text']);

    $sql = "INSERT INTO feedback (user_id, feedback_text) VALUES ('$user_id', '$feedback_text')";
    if (mysqli_query($conn, $sql)) {
        $success_message = "Thank you for your feedback!";
    } else {
        $error_message = "Error submitting feedback. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(120deg,rgb(252, 252, 252),rgb(194, 194, 193));
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .feedback-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      max-width: 500px;
      width: 100%;
    }
    .feedback-card h4 {
      font-weight: 600;
      margin-bottom: 1.5rem;
      text-align: center;
      color: #333;
    }
    .form-control {
      border-radius: 10px;
      resize: none;
    }
    .btn-submit {
      background: linear-gradient(to right, #5e60ce, #7400b8);
      border: none;
      color: white;
      padding: 0.5rem 1.5rem;
      border-radius: 25px;
      font-size: 0.9rem;
      transition: background 0.3s ease;
    }
    .btn-submit:hover {
      background: linear-gradient(to right, #4e54c8, #8f94fb);
    }
  </style>
</head>
<body>
  <div class="feedback-card">
    <h4>We value your feedback!</h4>
    <form action="submit_feedback.php" method="post">
      <div class="mb-3">
        <textarea class="form-control" name="feedback" rows="5" placeholder="Your feedback..." required></textarea>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-submit">Submit</button>
      </div>
    </form>
  </div>
</body>
</html>

