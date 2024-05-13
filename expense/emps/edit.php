<?php
    include('conn.php');
    $id=$_GET['id'];
    $query=mysqli_query($conn,"select * from clients where id='$id'");
    $row=mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/emp.css">
    <title>Edit</title>
    <style>
   body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: lightgray;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="%23333" d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke="%23333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 12px;
            padding-right: 30px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <script>
       function freezeExpirationDate() {
        var freezeDaysInput = document.getElementById("freeze-days");
        var freezeDays = parseInt(freezeDaysInput.value);

        var expireDateInput = document.getElementById("EXP_DT");
        var expireDate = new Date(expireDateInput.value);

        // Calculate the new expiration date by adding the freeze days to the current expiration date
        expireDate.setDate(expireDate.getDate() + freezeDays);

        // Format the new expiration date as YYYY-MM-DD for input value
        var formattedExpireDate = expireDate.toISOString().slice(0, 10);

        // Set the value of the expiration date input field
        expireDateInput.value = formattedExpireDate;
    }

    function updateExpireDate() {
        var planSelect = document.getElementById("plan");
        var selectedOption = planSelect.options[planSelect.selectedIndex];
        var planValidity = selectedOption.getAttribute("data-validity");

        var enrollDateInput = document.getElementById("subs_DT");
        var expireDateInput = document.getElementById("EXP_DT");

        var enrollDate = new Date(enrollDateInput.value);
        enrollDate.setDate(enrollDate.getDate() + parseInt(planValidity)); // Calculate expiration date

        // Format the date as YYYY-MM-DD for input value
        var formattedExpireDate = enrollDate.toISOString().slice(0, 10);

        // Set the value of the expire-date input field
        expireDateInput.value = formattedExpireDate;
    }
   

    function formatDate(date) {
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return year + '-' + month + '-' + day;
    }
    
    </script>
<div class="container justify-content-center">
    <div class="mb-3 row justify-content-center">
        <div class="col-sm-4">
            <form method="POST" action="update.php?id_edit=<?php echo $id; ?>">

                <label class="col-sm-2 col-form-label">ID </label>
                <input class="form-control" type="text" name="id" required value="<?php echo $id; ?> " readonly>

                <label class="col-sm-2 col-form-label">name : </label>
                <input class="form-control" type="text" name="name" required value="<?php echo $row['name']; ?>">

                <label class="col-sm-2 col-form-label">phone </label>
                <input class="form-control" type="number" name="phone" required value="<?php echo $row['phone']; ?>">

                <label class="col-sm-2 col-form-label">age </label>
                <input class="form-control" type="number" name="age"  value="<?php echo $row['age']; ?>">

                <?php
    // Fetch the name of the current plan from the database
    $current_plan_id = $row['plan'];

    // Query to fetch the name of the current plan based on its ID
    $plan_query = "SELECT name FROM plan WHERE id = '$current_plan_id'";
    $plan_result = mysqli_query($conn, $plan_query);

    // Initialize a flag to check if the current plan is found
    $current_plan_found = false;

    // Check if the query was successful and there is a row returned
    if ($plan_result && mysqli_num_rows($plan_result) > 0) {
        $plan_row = mysqli_fetch_assoc($plan_result);
        $current_plan_name = $plan_row['name'];
        $current_plan_found = true;
    }

  // Fetch the list of plans from your database
  $sql = "SELECT * FROM plan";
  $result = mysqli_query($conn, $sql);

  // Check if the query was successful and there are rows returned
  if ($result && mysqli_num_rows($result) > 0) {
      // Output the select element with options
      echo ' <label for="plan">Plan:</label>';
      echo '<select class="form-select" id="plan" name="plan" onchange="updateExpireDate()">';
      
      // Output the first option with the current plan selected if found
      if ($current_plan_found) {
          echo '<option value="' . $current_plan_id . '" data-validity="' . $current_plan_validity . '" selected>' . $current_plan_name . '</option>';
      }
      
      // Output the rest of the options
      while ($row = mysqli_fetch_assoc($result)) {
          // Skip the option if it's the same as the current plan
          if ($current_plan_found && $row['id'] == $current_plan_id) {
              continue;
          }
          echo '<option value="' . $row['id'] . '" data-validity="' . $row['validity'] . '">' . $row['name'] . ' , price : ' . $row['amount'] . ' , duration : ' . $row['validity'] . '</option>';
      }
      
      echo '</select>';
  } else {
      // Handle the case where no plans are found
      echo 'No plans found.';
  }
?>
<?php
    include('conn.php');
    $id=$_GET['id'];
    $query=mysqli_query($conn,"select * from clients where id='$id'");
    $row=mysqli_fetch_array($query);
?>

                <label class="col-sm-2 col-form-label">Subscription</label>
                    <input id="subs_DT" class="form-control" type="date" name="subs_DT" required value="<?php echo $row['subs_DT']; ?>">

                    <label class="col-sm-2 col-form-label">EXP_DT</label>
                    <input id="EXP_DT" class="form-control" type="date" name="EXP_DT" required value="<?php echo $row['EXP_DT']; ?>">

                    <label class="col-sm-2 col-form-label">Freeze </label>
                    <input id="freeze-days" class="form-control" type="number" name="freeze_days" value="0">
                    <button type="button" class="btn btn-primary" onclick="freezeExpirationDate()">Update</button>

                <br>
             <?php
                //3 installments
                if (!empty($row['inst1']) && !empty($row['inst2']) && !empty($row['inst3'])) {

            

                    echo '<label class="col-sm-2 col-form-label">Installment 1</label>';
                    echo '<input class="form-control" type="date" name="inst_date1" required value="' . $row["inst1"] . '">';
                    echo '<input class="form-control" type="number" name="amount1" required value="' . $row["amount1"] . '">';
                    echo ' <label for="checkbox1">confirm payment 1</label>';
                    
                      $checkbox_value1 = $row["con_inst1"];
                      echo '<input type="checkbox" id="checkbox1" name="checkbox1" value="1" ' . ($row["con_inst1"] == 1 ? 'checked' : '') . '>';

                    echo '<br>';


                    echo '<label class="col-sm-2 col-form-label">Installment 2 </label>';
                    echo '<input class="form-control" type="date" name="inst_date2" required value="' . $row["inst2"] . '">';
                    echo '<input class="form-control" type="number" name="amount2" required value="' . $row["amount2"] . '">';
                    echo ' <label for="checkbox2">confirm payment 2</label>';
                    $checkbox_value2 = $row["con_inst2"];
                    echo '<input type="checkbox" id="checkbox2" name="checkbox2" value="1"' . ($row["con_inst2"] == 1 ? 'checked' : '') . '>';

                    echo '<br>';
                   
                   
                    echo '<label class="col-sm-2 col-form-label">Installment 3 </label>';
                    echo '<input class="form-control" type="date" name="inst_date3" required value="' . $row["inst3"] . '">';
                    echo '<input class="form-control" type="number" name="amount3" required value="' . $row["amount3"] . '">';
                    echo ' <label for="checkbox3">confirm payment 3</label>';
                    $checkbox_value3 = $row["con_inst3"];
               
                    echo '<input type="checkbox" id="checkbox3" name="checkbox3" value="1" ' . ($row["con_inst3"] == 1 ? 'checked' : '') . ' >';

                    #2 installments
                } else if (!empty($row['inst1']) && !empty($row['inst2'])){
              
    
                    
                    echo '<label class="col-sm-2 col-form-label">Installment 1</label>';
                    echo '<input class="form-control" type="date" name="inst_date1" required value="' . $row["inst1"] . '">';
                    echo '<input class="form-control" type="number" name="amount1" required value="' . $row["amount1"] . '">';
                    echo ' <label for="checkbox4">confirm payment</label>';
                    $checkbox_value1 = $row["con_inst1"];
                    echo '<input type="checkbox" id="checkbox4" name="checkbox4" value="1"' . ($row["con_inst1"] == 1 ? 'checked' : '') . '>';
  
                    echo '<br>';


                    echo '<label class="col-sm-2 col-form-label">Installment 2 </label>';
                    echo '<input class="form-control" type="date" name="inst_date2" required value="' . $row["inst2"] . '">';
                    echo '<input class="form-control" type="number" name="amount2" required value="' . $row["amount2"] . '">';
                    echo ' <label for="checkbox5">confirm payment</label>';
                    $checkbox_value2 = $row["con_inst2"];
                    echo '<input type="checkbox" id="checkbox5" name="checkbox5" value="1" ' . ($row["con_inst2"] == 1 ? 'checked' : '') . '>';
  
                    echo '<br>';
            
                   
                } else{
                    echo '<label class="col-sm-2 col-form-label">Amount Paid </label>';
                    echo '<input class="form-control" type="number" name="amount" required value="' . $row["amount"] . '">';
                    
                }
                ?>
                <br>
       

                <br><br>
                <input type="submit" value="save" class="btn btn-primary" name="">
            </form>
        </div>
    </div>
</div> 
</body>
</html>