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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
        }

        .container {
            margin-top: 30px;
        }

        .feedback-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .btn-submit {
            width: 100%;
        }

        .alert {
            margin-top: 20px;
        }

        .btn-back {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="feedback-form">
        <h3 class="text-center">Submit Your Feedback</h3>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <form action="feedback.php" method="POST">
            <div class="form-group">
                <label for="feedback_text">Your Feedback</label>
                <textarea id="feedback_text" name="feedback_text" rows="5" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-submit mt-3">Submit Feedback</button>
        </form>

        <a href="dashboard.php">
            <button class="btn btn-secondary btn-back">Back to Dashboard</button>
        </a>
    </div>
</div>

</body>
</html>
