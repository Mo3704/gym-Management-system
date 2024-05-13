<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Payment</title>
    <link rel="stylesheet" href="../../stylepay.css">
</head>
<body>

<script>

    function updateExpireDate(planValidity) {
        var enrollDateInput = document.getElementById("enroll-date");
        var expireDateInput = document.getElementById("expire-date");

        var enrollDate = new Date(enrollDateInput.value);
        enrollDate.setDate(enrollDate.getDate() + parseInt(planValidity)); // Calculate expiration date

        // Format the date as YYYY-MM-DD for input value
        var formattedExpireDate = enrollDate.toISOString().slice(0, 10);

        // Set the value of the expire-date input field
        expireDateInput.value = formattedExpireDate;
    }
    

    
    function handleInstallmentPlan() {
        var fullPaymentCheckbox = document.getElementById("full-payment");
        var installmentsContainer = document.getElementById("installments-container");
        var datesContainer = document.getElementById("dates-container");

        if (fullPaymentCheckbox.checked) {
            installmentsContainer.style.display = "none";
            datesContainer.style.display = "none";
        } else {
            installmentsContainer.style.display = "block";
            datesContainer.style.display = "block";
        }
    }

    function showInstallmentDates() {
        var installmentsSelect = document.getElementById("installments");
        var numInstallments = installmentsSelect.value;
        var datesContainer = document.getElementById("dates-container");

        datesContainer.innerHTML = ""; // Clear previous dates

        var enrollDate = new Date(document.getElementById("enroll-date").value);
        var expireDate = new Date(document.getElementById("expire-date").value);

        for (var i = 0; i < numInstallments; i++) {
            var inputDate = document.createElement("input");
            inputDate.type = "date";
            inputDate.name = "installment-date[]"; // Use array to collect multiple dates
            inputDate.min = formatDate(enrollDate);
            inputDate.max = formatDate(expireDate);
            datesContainer.appendChild(inputDate);
            
            var inputAmount = document.createElement("input");
            inputAmount.type = "number";
            inputAmount.name = "installment-amount[]"; // Use array to collect multiple amounts
            inputAmount.placeholder = "Amount Paid";
            datesContainer.appendChild(inputAmount);

            datesContainer.appendChild(document.createElement("br"));
        }
    }

    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return year + '-' + month + '-' + day;
    }
    
    function confirmFullPayment() {
        var fullPaymentCheckbox = document.getElementById("full-payment");
        
        if (fullPaymentCheckbox.checked) {
            var confirmPayment = confirm('Confirm full payment?');
            if (!confirmPayment) {
                return false;
            }
        }
     
        return true;
        
        
    }
</script>

<?php
    include("../../config.php");
    
    session_start();

    if(isset(  $_POST['id'])){
        $id =  $_POST['id'];
        $sql = "SELECT * FROM expired_clients WHERE id = '$id' ";

        // Execute the query
        $result = mysqli_query($connection, $sql);
    
        // Check if the query was successful
        if ($result) {
            // Fetch the rows from the result set
            $row = mysqli_fetch_assoc($result);
            $name=$row['name'];
            $phone=$row['phone'];
        }
    }
    if (isset($_POST['plan_id'])) {
        // Retrieve the value of the variable
        $plan_id = $_POST['plan_id'];
        

        // Check if a selected plan is available in session
        $sql = "SELECT * FROM plan WHERE id = '$plan_id'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            // Store selected plan details in session variables
            $_SESSION['selected_plan'] = mysqli_fetch_assoc($result);
        }
    }

    if (isset($_SESSION['selected_plan'])) {
        $selected_plan = $_SESSION['selected_plan'];
       
        
    }
        
?>



<h1>Add New Payment</h1>
<form class="gym-form" action="payment.php" method="POST" onsubmit="return confirmFullPayment();">
    <div class="form-group">
        <label for="member-id">Member ID:</label>
        <input type="text" id="member-id" name="member-id" value="<?php echo $id; ?>" readonly required>
     </div>
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"required>
    </div>
    <div class="form-group">
        <label for="plan">Plan:</label>
        <input type="text" id="plan" name="plan" value="<?php echo htmlspecialchars($selected_plan['name']); ?>" readonly required>
    </div>
    <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo '$' . htmlspecialchars($selected_plan['amount']); ?>" readonly required>
    </div>
    
    <div class="form-group">
        <label for="enroll-date">Enroll Date:</label>
        <input type="date" id="enroll-date" name="enroll-date" onchange="updateExpireDate(<?php echo  htmlspecialchars($selected_plan['validity']); ?>);" required>
    </div>
    <div class="form-group">
        <label for="expire-date">Expire Date:</label>
        <input type="date" id="expire-date" name="expire-date" value="<?php echo $expire_date; ?>" readonly required>
    </div>
   
    <div class="form-group">
        <label for="full-payment">Full Payment:</label>
        <input type="checkbox" id="full-payment" name="full-payment" checked onclick="handleInstallmentPlan();">
    </div>
    <div class="form-group" id="installments-container" style="display: none;">
        <label for="installments">Installments:</label>
        <select id="installments" name="installments" onchange="showInstallmentDates();">
            <option value="" hidden></option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
    </div>
    <div class="form-group" id="dates-container" style="display: none;"></div>
    <button type="submit">Add Payment</button>
</form>

<?php
    // Check if the form was submitted via POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $member_id = isset($_POST['member-id']) ? $_POST['member-id'] : 'NULL';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $enroll_date = isset($_POST['enroll-date']) ? $_POST['enroll-date'] : '';
        $expire_date = isset($_POST['expire-date']) ? $_POST['expire-date'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $plan = isset($selected_plan['id']) ? $selected_plan['id'] : '';

        // Check if it's a full payment or installment payment
        if (isset($_POST['full-payment'])) {
            // Full payment
            $amount=$selected_plan['amount'];
            $sql = "INSERT INTO clients (Id, name, subs_DT, EXP_DT, plan, phone,type,amount) 
                    VALUES ('$member_id', '$name', '$enroll_date', '$expire_date', '$plan', '$phone','full_payment','$amount')";
        } else {
            // Installment payment
            $installments = isset($_POST['installments']) ? $_POST['installments'] : '';
            $installmentDates = isset($_POST['installment-date']) ? $_POST['installment-date'] : array();
            $installmentAmounts = isset($_POST['installment-amount']) ? $_POST['installment-amount'] : array();

            // Construct the SQL statement dynamically based on the number of installments and provided dates
            $sql = "INSERT INTO clients (Id, name, subs_DT, EXP_DT, plan, phone,type";
            for ($i = 1; $i <= $installments; $i++) {
                $sql .= ", inst$i, amount$i"; // Add column names for each installment date and amount
            }
            $sql .= ") VALUES ('$member_id', '$name', '$enroll_date', '$expire_date', '$plan', '$phone','installment'";
            for ($i = 0; $i < $installments; $i++) {
                if (isset($installmentDates[$i]) && isset($installmentAmounts[$i])) {
                    $installment_date = $_POST['installment-date'][$i];
                    $installment_amount = $_POST['installment-amount'][$i];
                    $sql .= ", '$installment_date', '$installment_amount'"; // Add provided installment dates and amounts
                } else {
                    $sql .= ", NULL, NULL"; // Insert NULL for missing installment dates and amounts
                }
            }
            $sql .= ")";
        }

        // Execute the SQL query
        if (mysqli_query($connection, $sql)) {
           
            exit;
        } else {
            // Handle query execution errors
            echo "Error: " . mysqli_error($connection);
        }

    $del = "DELETE FROM expired_clients WHERE id = '$id'";
    if (mysqli_query($connection, $del)) {
    
    //header("Location: indexx.php");
    exit;
    }}

?>

</body>
</html>