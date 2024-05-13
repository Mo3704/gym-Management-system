<?php
include('conn.php');

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query to retrieve expired client data from the expired_clients table
    $query_expired = mysqli_query($conn, "SELECT name, EXP_DT, phone, amount FROM expired_clients WHERE Id='$id'");
    
    // Check if the query executed successfully
    if (!$query_expired) {
        die("Error: " . mysqli_error($conn)); // This line will output the error message if the query fails
    }
    
    $row_expired = mysqli_fetch_array($query_expired);
    
    // Display the retrieved values in the form fields
    $name = $row_expired['name'];
    $EXP_DT = $row_expired['EXP_DT'];
    $phone = $row_expired['phone'];
    $amount = $row_expired['amount'];
} else {
    echo "No client ID provided!";
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $subs_DT = $_POST['subs_DT'];
    $EXP_DT = $_POST['EXP_DT'];
    $age = $_POST['age'];
    $plan = $_POST['plan'];
    $amount = $_POST['amount'];
    $phone = $_POST['phone'];
    
    // Validate form data (You can add your validation logic here)
    
    // Insert data into clients table
    $insert_query = "INSERT INTO clients (name, subs_DT, EXP_DT, age, plan, amount, phone) 
                    VALUES ('$name', '$subs_DT', '$EXP_DT', '$age', '$plan', '$amount', '$phone')";
    
    if ($conn->query($insert_query) === TRUE) {
        echo "تمت إضافة العميل بنجاح!";
        
        // Delete similar data from expired_clients table
        $delete_query = "DELETE FROM expired_clients WHERE name='$name' AND phone='$phone'";
        if ($conn->query($delete_query) === TRUE) {
            echo "تم مسح البيانات المشابهة في جدول العملاء المنتهيين بنجاح!";
        } else {
            echo "حدث خطأ أثناء مسح البيانات المشابهة في جدول العملاء المنتهيين: " . $conn->error;
        }
    } else {
        echo "حدث خطأ أثناء إضافة العميل: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>renew bookink</title>
</head>
<body>
    <h2>add boking</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        الاسم: <input type="text" name="name" value="<?php echo $name; ?>"><br><br>
        تاريخ الاشتراك: <input type="date" name="subs_DT" value="<?php echo $subs_DT; ?>"><br><br>
        تاريخ الانتهاء: <input type="date" name="EXP_DT" value="<?php echo $EXP_DT; ?>"><br><br>
        العمر: <input type="text" name="age"><br><br>
        الخطة: <input type="text" name="plan"><br><br>
        المبلغ: <input type="text" name="amount" value="<?php echo $amount; ?>"><br><br>
        الهاتف: <input type="text" name="phone" value="<?php echo $phone; ?>"><br><br>
        <input type="submit" name="submit" value="إضافة">
    </form>
</body>
</html>
