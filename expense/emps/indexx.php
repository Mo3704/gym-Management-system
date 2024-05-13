<<?php
// Include the file for database connection
include('conn.php');

// Query to retrieve data from the 'clients' table
$sql_clients = "SELECT * FROM clients";
$result_clients = mysqli_query($conn, $sql_clients);

// Query to retrieve data from the 'clients' table with additional columns
$sql_clien = "SELECT * FROM clients";
$result_cli = mysqli_query($conn, $sql_clien);

// استعلام لاسترجاع البيانات من جدول expired_clients
$sql_expired = "SELECT id, name, EXP_DT, amount, phone FROM expired_clients";
$result_expired = mysqli_query($conn, $sql_expired);

// Query to insert data into 'expired_clients' table
$sql_insert = "INSERT INTO expired_clients (name, EXP_DT, amount, phone)
        SELECT name, EXP_DT, amount, phone
        FROM clients
        WHERE EXP_DT < CURDATE();";

// Execute the insert query
if (mysqli_query($conn, $sql_insert)) {
    echo "Insert query executed successfully.";
} else {
    echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
}

// Query to delete data from 'clients' table
$sql_delete = "DELETE FROM clients
               WHERE EXP_DT < CURDATE();";

// Execute the delete query
if (mysqli_query($conn, $sql_delete)) {
    echo "Delete query executed successfully.";
} else {
    echo "Error: " . $sql_delete . "<br>" . mysqli_error($conn);
}

// You can continue using $result_clients, $result_cli, $result_expired in your code
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management</title>
    <style>
         /* General styles for tables */
         .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
        }

        /* Button styles */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 30px;
            transition: background-color 0.3s ease;
            font-size: 16px;
            border: none;
            cursor: pointer;
            outline: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Additional styles for specific elements */
        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Fancy button effect */
        .btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            top: 0;
            left: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .btn:hover::after {
            opacity: 0;
        }

        /* Large button */
        .btn-lg {
            padding: 18px 32px;
            font-size: 20px;
        }

        /* Blue button */
        .btn-blue {
            background-color: #007bff;
        }

        .btn-blue:hover {
            background-color: #0056b3;
        }

        /* Green button */
        .btn-green {
            background-color: #28a745;
        }

        .btn-green:hover {
            background-color: #218838;
        }

        /* Red button */
        .btn-red {
            background-color: #dc3545;
        }

        .btn-red:hover {
            background-color: #c82333;
        }
    </style>
    <link rel="stylesheet" href="../../style.css">

<header><nav class="navbar">
    
    <ul>
        <h1>PNP</h1>
<li><a href="../../main.php">home</a></li>
<li><a href="../../user_plan.php">Register</a></li>
<li><a href="../../plan.php">New plan</a></li>
<li><a href="../report.php">report</a></li>
<li><a href="indexx.php">members</a></li>
    </ul>
</nav></header>
</head>
<body>
    <h2>Clients</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Plan</th>
                <th>Subscription Date</th>
                <th>Expiration Date</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // عرض بيانات جدول clients في الجدول
            while($row = mysqli_fetch_assoc($result_clients)) {
                echo "<tr>";
                echo "<td>".$row['Id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['phone']."</td>";
                echo "<td>".$row['age']."</td>";
                echo "<td>".$row['plan']."</td>";

                echo "<td>".$row['subs_DT']."</td>";
                echo "<td>".$row['EXP_DT']."</td>";
                if($row['type']=='installment'){
                    $amount1=isset($row['amount1'])? intval($row['amount1']) : 0 ;
                    $amount2=isset($row['amount2'])? intval($row['amount2']) : 0 ;
                    $amount3=isset($row['amount3'])? intval($row['amount3']) : 0 ;
                    echo "<td>".$amount3+$amount2+$amount1 ."</td>";    
                }else{
                echo "<td>".$row['amount']."</td>";
            }
            echo "<td>".$row['type']."</td>";
        
                echo "<td>";
                echo "<a href='edit.php?id=".$row['Id']."'>Edit</a> | ";
                echo "<a href='delete.php?id=".$row['Id']."' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <body>
    <h2>Clients instalments</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Plan</th>
                <th>Subscription Date</th>
                <th>Expiration Date</th>
                <th>install 1</th>
                <th>amount 1</th>
                <th>paid confirmation 1</th>
                <th>install 2</th>
                <th>amount 2</th>
                <th>paid confirmation 2</th>
                <th>install 3</th>
                <th>amount 3</th>
                <th>paid confirmation 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            // عرض بيانات جدول clients في الجدول
            
            while($row = mysqli_fetch_assoc($result_cli)) {
                if (!empty($row['inst1'])){
                echo "<tr>";
                echo "<td>".$row['Id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['phone']."</td>";
                echo "<td>".$row['age']."</td>";
                echo "<td>".$row['plan']."</td>";
                echo "<td>".$row['subs_DT']."</td>";
                echo "<td>".$row['EXP_DT']."</td>";
                echo "<td>".$row['inst1']."</td>";
                echo "<td>".$row['amount1']."</td>";
                if(intval($row['con_inst1'])==1){
                    echo "<td>".'paid'."</td>";
                }else{
                    echo "<td>".'not paid'."</td>";

                }
                echo "<td>".$row['inst2']."</td>";
                echo "<td>".$row['amount2']."</td>";
                if(intval($row['con_inst2'])==1){
                    echo "<td>".'paid'."</td>";
                }else{
                    echo "<td>".'not paid'."</td>";

                }     
                if(isset($row['inst3'])){           
                echo "<td>".$row['inst3']."</td>";
                echo "<td>".$row['amount3']."</td>";
                if(intval($row['con_inst3'])==1){
                    echo "<td>".'paid'."</td>";
                }else{
                    echo "<td>".'not paid'."</td>";

                }}else{
                    echo "<td>".''."</td>";
                    echo "<td>".''."</td>";
                    echo "<td>".''."</td>";
                }
               
                
                echo "<td>";
                echo "<a href='edit.php?id=".$row['Id']."'>Edit</a> | ";
                echo "<a href='delete.php?id=".$row['Id']."' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }}
            ?>
            
        </tbody>
    </table>

    <body>
    <h2><b>Near instalments due date</b></h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Plan</th>
                <th>Subscription Date</th>
                <th>Expiration Date</th>
                <th>install 1</th>
                <th>amount 1</th>
                <th>paid confirmation 1</th>
                <th>install 2</th>
                <th>amount 2</th>
                <th>paid confirmation 2</th>
                <th>install 3</th>
                <th>amount 3</th>
                <th>paid confirmation 3</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            
            //see if there are any installments to be paid in the next 10 days
            $query = "SELECT * FROM clients 
            WHERE (DATEDIFF(inst1, CURDATE()) <= 10 AND con_inst1 = 0) 
               OR (DATEDIFF(inst2, CURDATE()) <= 10 AND con_inst2 = 0) 
               OR (DATEDIFF(inst3, CURDATE()) <= 10 AND con_inst3 = 0)";
            $due_inst =mysqli_query($conn, $query); 
              while($row = mysqli_fetch_assoc($due_inst)) {
                echo "<tr>";
                echo "<td>".$row['Id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['phone']."</td>";
                echo "<td>".$row['age']."</td>";
                echo "<td>".$row['plan']."</td>";
                echo "<td>".$row['subs_DT']."</td>";
                echo "<td>".$row['EXP_DT']."</td>";
                echo "<td>".$row['inst1']."</td>";
                echo "<td>".$row['amount1']."</td>";
                if(intval($row['con_inst1'])==1){
                    echo "<td>".'paid'."</td>";
                }else{
                    echo "<td>".'not paid'."</td>";

                }
                echo "<td>".$row['inst2']."</td>";
                echo "<td>".$row['amount2']."</td>";
                if(intval($row['con_inst2'])==1){
                    echo "<td>".'paid'."</td>";
                }else{
                    echo "<td>".'not paid'."</td>";

                }     
                if(isset($row['inst3'])){           
                echo "<td>".$row['inst3']."</td>";
                echo "<td>".$row['amount3']."</td>";
                if(intval($row['con_inst3'])==1){
                    echo "<td>".'paid'."</td>";
                }else{
                    echo "<td>".'not paid'."</td>";

                }}else{
                    echo "<td>".''."</td>";
                    echo "<td>".''."</td>";
                    echo "<td>".''."</td>";
                }
               
                
                echo "<td>";
                echo "<a href='edit.php?id=".$row['Id']."'>Edit</a> | ";
                echo "<a href='delete.php?id=".$row['Id']."' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            
        </tbody>
    </table>


    <h2>Expired Clients</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Expiration Date</th>
                <th>Amount</th>
                <th>Phone</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // عرض بيانات جدول expired_clients في الجدول
            while($row = mysqli_fetch_assoc($result_expired)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['EXP_DT']."</td>";
                echo "<td>".$row['amount']."</td>";
                echo "<td>".$row['phone']."</td>";
                echo "<td>";
                echo "<a href='user_plan.php?id=".$row['id']."'>Edit</a> | ";
                echo "<a href='delete_expred_clients.php?id=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>


    <a href="search.php" class="btn btn-outline-warning btn-lg" role="button">Search</a>

    <form action="print_pdf.php" method="post">
    <button type="submit" name="print_pdf" class="btn btn-outline-success btn-lg">PDF</button>
</form>
</body>
</html>