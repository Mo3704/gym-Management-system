<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>search page</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="">
                    <br />
                    <p style="font-size:18px; margin-left:100px;">search
                        <input type="text" autofocus="autofocus" name="search_file" id="search_file" style="width:230px; font-size:18px;" class="textboxclass" />
                        <input type="submit" style="font-size:18px; margin-top:-9px;" class="btn btn-primary" name="submit" value="search">
                    </p>
                </form>
                <a href="indexx.php"><input type="submit" style="font-size:16px; margin-top:10px;" class="btn btn-info" name="submit" value="back to data"></a>
                <br><br>
                <table class="table  table-hover table-responsive  table-primary">
                    <thead class="table-warning">
                        <tr>
                            <th scope="col">Actions</th>
                            <th scope="col">phone</th>
                            <th scope="col">plan</th>
                            <th scope="col">amount</th>
                            <th scope="col">age</th>
                            <th scope="col">EXP_DT</th>
                            <th scope="col">subs_DT</th>
                            <th scope="col">name</th>
                            <th scope="col">id</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include ('conn.php');
                        error_reporting(0);
                        if ($_POST['submit']) {
                            $search_file = $_POST['search_file'];
                            $sql = mysqli_query($conn, "SELECT id,name,subs_DT,EXP_DT,age,plan,amount,phone FROM clients WHERE id LIKE '%$search_file%' OR name LIKE '%$search_file%' OR plan LIKE '%$search_file%' OR amount LIKE '%$search_file%' OR age LIKE '%$search_file%'");
                            if (empty($search_file)) {
                                echo '<script language="javascript">';
                                echo 'alert("عليك بملء الحقل الرجاء المحاولة مرة أخرى")';
                                echo '</script>';
                                header("refresh:2; url=index.php");
                            } else if (mysqli_num_rows($sql) > 0) {
                                while ($row = mysqli_fetch_array($sql)) {
                                    echo "<tr>";
                                    echo "<td>";
                                   echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
                                    echo "<a href='delete.php?id=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
                                    echo "</td>";
                                    echo "<td>".$row['phone']."</td>";
                                    echo "<td>".$row['plan']."</td>";
                                    echo "<td>".$row['amount']."</td>";
                                    echo "<td>".$row['age']."</td>";
                                    echo "<td>".$row['EXP_DT']."</td>";
                                    echo "<td>".$row['subs_DT']."</td>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "<td>".$row['id']."</td>";
                                
                                 
                                }
                            } else {
                                echo '<div class="alert alert-danger" style="width:130px; float:left; margin-top:-142px;">sorry there is not </div>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
