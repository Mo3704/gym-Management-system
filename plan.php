<?php
// Include the config.php file
include("config.php");

// Check if the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $plan_name = $_POST["plan-name"];
    $validity = $_POST["validity"];
    $amount = $_POST["amount"];
    $classes = isset($_POST["classes"]) ? $_POST["classes-count"] : 0;
    $private_sessions = isset($_POST["private_sessions"]) ? $_POST["private-session-count"] : 0;
    $invitations = isset($_POST["invitations"]) ? $_POST["invitation-count"] : 0;

    // Validate validity and amount as integers
    if (is_numeric($validity) && is_numeric($amount)) {
        // Convert validity and amount to integers
        $validity = intval($validity);
        $amount = intval($amount);
    // Check if the plan name already exists in the database
    $check_query = "SELECT * FROM plan WHERE name = '$plan_name'";
    $result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($result) > 0) {     
        // Plan name already exists, display an error message
        echo "Error: A plan with the name '$plan_name' already exists.";
    } else {
     // Prepare the SQL statement for inserting the new plan
        $sql = "INSERT INTO plan (name, validity, amount, classes, private_sessions, invitations) 
            VALUES ('$plan_name', $validity, $amount, '$classes', '$private_sessions', '$invitations')";

        // Perform the database query
        if (mysqli_query($connection, $sql)) {
            // Redirect to a success page or display a success message
            echo "Data inserted successfully!";
            header("location:user_plan.php?message=success");
            
        } else {
            // Handle query execution errors
            echo "Error: " . mysqli_error($connection);
        }
    }}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Plan</title>
    <link rel="stylesheet" href="styleplan.css">
    <style>
        /* Style to display form elements inline */
        .form-group {
            margin-bottom: 10px; /* Add space between form groups */
        }

        label {
            display: inline-block;
            width: 150px; /* Adjust label width as needed */
        }

        input[type="number"] {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensures padding and border are included in width */
        }

        input[type="text"],
        input[type="number"],
        input[type="checkbox"] {
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <h1>Add Plan</h1>
    <form class="gym-form" action="plan.php" method="post" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="plan-name">Plan Name:</label>
            <input type="text" id="plan-name" name="plan-name" required>
        </div>
        <div class="form-group">
            <label for="validity">Duration (days) :</label>
            <input type="number" id="validity" name="validity" required>
        </div>
        <div class="form-group">
            <label for="amount">Price:</label>
            <input type="number" id="amount" name="amount" required>
        </div>

        <div class="form-group" id="private-sessions-group">
            <input type="checkbox" id="private_sessions" name="private_sessions" value="1">
            <label for="private_sessions">Private Sessions</label>
            <select id="private-session-count" name="private-session-count" style="display: none;">
                <option value="1">1 Session</option>
                <option value="5">5 Sessions</option>
                <option value="10">10 Sessions</option>
            </select>
        </div>
        <div class="form-group" id="invitations-group">
            <input type="checkbox" id="invitations" name="invitations" value="1">
            <label for="invitations">Invitations</label>
            <select id="invitation-count" name="invitation-count" style="display: none;">
                <option value="1">1</option>
                <option value="3">3</option>
                <option value="6">6</option>
            </select>
        </div>
        <div class="form-group" id="classes-group">
            <input type="checkbox" id="classes" name="classes" value="1">
            <label for="classes">Classes</label>
            <select id="classes-count" name="classes-count" style="display: none;">
                <option value="8">8</option>
                <option value="12">12</option>
                <option value="24">24</option>
                <option value="48">48</option>
            </select>
        </div>

        
        <button type="submit">Add Plan</button>
    </form>

    <center><a href="user_plan.php"><button type="button">Show Plans</button></a></center>

    <script>
        function validateForm() {
           var planName = document.getElementById('plan-name').value;
            var validity = document.getElementById('validity').value;
            var amount = document.getElementById('amount').value;

            if (planName.trim() === '' || validity.trim() === '' || amount.trim() === '') {
                alert('Please fill out all required fields.');
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        document.getElementById('private_sessions').addEventListener('change', function() {
            var privateSessionCountSelect = document.getElementById('private-session-count');
            if (this.checked) {
                privateSessionCountSelect.style.display = 'inline-block'; // Show the select dropdown
                privateSessionCountSelect.required = true; // Make the select dropdown required
            } else {
                privateSessionCountSelect.style.display = 'none'; // Hide the select dropdown
                privateSessionCountSelect.required = false; // Make the select dropdown not required
            }
        });

        document.getElementById('invitations').addEventListener('change', function() {
            var invitationCountSelect = document.getElementById('invitation-count');
            if (this.checked) {
                invitationCountSelect.style.display = 'inline-block'; // Show the select dropdown
                invitationCountSelect.required = true; // Make the select dropdown required
            } else {
                invitationCountSelect.style.display = 'none'; // Hide the select dropdown
                invitationCountSelect.required = false; // Make the select dropdown not required
            }
        });

        document.getElementById('classes').addEventListener('change', function() {
            var classesCountSelect = document.getElementById('classes-count');
            if (this.checked) {
                classesCountSelect.style.display = 'inline-block'; // Show the select dropdown
                classesCountSelect.required = true; // Make the select dropdown required
            } else {
                classesCountSelect.style.display = 'none'; // Hide the select dropdown
                classesCountSelect.required = false; // Make the select dropdown not required
            }
        });

        
     
    </script>
</body>
</html>