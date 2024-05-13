<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main page</title>
    <link rel="stylesheet" href="style.css">
</head>
</head>

<header><nav class="navbar">
<style>
        /* CSS styles for tables */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* CSS styles for buttons */
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
                border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-decoration: none;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;

        }

        body{
    margin: 0px;
}
h1{
    color: blue;
}



.navbar ul{
    list-style-type:none ;
    background-color: hsl(0, 40%, 2%);
    padding: 0px;
    margin: 0px;
    overflow: hidden;
}

.navbar a{
    color: white;
    text-decoration: none;
    padding: 15px;
    display: block;
    text-align: center;
}

.navbar a:hover{
    background-color: blue;
}

.navbar li{
    float: left;
}
    
    </style>
    <ul>
        <h1>PNP</h1>
<li><a href="main.php">home</a></li>
<li><a href="user_plan.php">plan</a></li>
<li><a href="plan.php">New plan</a></li>
<li><a href="expense\report.php">report</a></li>
<li><a href="expense\emps\indexx.php">members</a></li>
<li><a href="mailto:sallybahgat@gmail.com">Send Email</a></li>
<li><a href="#"><i class="fab fa-instagram"></i></a></li>
    </ul>

</nav></header>
<body>
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
        include("config.php");
$sql_expired = "SELECT id, name, EXP_DT, amount, phone FROM expired_clients";
$result_expired = mysqli_query($connection, $sql_expired);

            // عرض بيانات جدول expired_clients في الجدول
            while($row = mysqli_fetch_assoc($result_expired)) {
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['EXP_DT']."</td>";
                echo "<td>".$row['amount']."</td>";
                echo "<td>".$row['phone']."</td>";
                echo "<td>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

<a href="expense\emps\searchexp.php" class="btn btn-outline-warning btn-lg" role="button">searchexpireclients</a>
</form>
</body>
</html>
