<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Plans</title>
    <style>  body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        input[type="text"],
        input[type="number"],
        input[type="checkbox"] {
            display: inline-block;
            vertical-align: middle;
            margin-bottom: 10px;
        }

        .checkbox-group label {
            display: inline-block;
            margin-right: 20px;
        }

        .plans-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .plan {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: calc(33.33% - 20px); /* Adjust width based on desired layout */
        }

        .plan h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .plan p {
            font-size: 16px;
            margin-bottom: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form {
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            background-color: #fff;
        }

        form label,
        form input,
        form button {
            display: block;
            margin-bottom: 10px;
        }

        form button[type="submit"] {
            background-color: #28a745;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Available Plans</h1>
    <div class="plans-container">
    <?php
session_start();

include("config.php");

// Fetch and display available plans
$sql = "SELECT * FROM plan";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="plan">';
                echo '<h2><b><u>' . htmlspecialchars($row['name']) . '</u></b></h2>';
                echo '<p>Validity: ' . htmlspecialchars($row['validity']) . ' days</p>';
                echo '<p>Amount: $' . htmlspecialchars($row['amount']) . '</p>';
                $included = [];
                
               if ($row['invitations'] || $row['classes'] || $row['private_sessions']) {
    echo '<u><h2><p>Includes:</h2></u>';
}


                if ($row['invitations']) echo '<p>invitations : ' . htmlspecialchars($row['invitations']) . '</p>';;
                if ($row['classes'])  echo '<p>classes : ' . htmlspecialchars($row['classes']) . '</p>';
                if ($row['private_sessions'])  echo '<p>private sessions : ' . htmlspecialchars($row['private_sessions']) . '</p>';
            
                echo implode(', ', $included);
                echo '</p>';
                echo '<form action="payment.php" method="post">';
                echo '<input type="hidden" name="plan_id" value="' . $row['id'] . '">';
                echo '<button type="submit" name="subscribe" value="1">Subscribe Now</button>';
                echo '</form>';
                echo '</div>';
            }
} else {
    echo '<p>No plans found.</p>';
}

// /Process form submission when user selects a plan
// Process form submission when user selects a plan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subscribe"])) {
    // Retrieve the selected plan ID from the form submission
    $plan_id = $_POST["plan_id"];

    // Fetch selected plan details from the database using the retrieved plan ID
    $sql = "SELECT * FROM plan WHERE id = '$plan_id'";
    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $selected_plan = mysqli_fetch_assoc($result);

        // Store selected plan details in session variables
        $_SESSION['selected_plan'] = $selected_plan;

        // Redirect to payment page
        header("Location: payment.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to retrieve plan details. Please try again.";
        header("Location: user_plan.php");
        exit;
    }
}


mysqli_close($connection);
?>

    </div>
    <a href="plan.php">Make new plan</a>

    
</body>
</html>