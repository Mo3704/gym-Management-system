<?php 
include("conn.php");

// استقبال القيمة المرسلة عبر النموذج
$search_term = $_POST['search_term'];

// استعداد الاستعلام SQL مع توجيه البحث باختلاف الحالات
$sql = "SELECT * FROM clients WHERE 
            id LIKE '%$search_term%' OR 
            age LIKE '%$search_term%' OR 
            amount LIKE '%$search_term%' OR 
            plan LIKE '%$search_term%' OR
            name LIKE '%$search_term%'";

$query = mysqli_query($conn, $sql);

// عرض النتائج في جدول HTML
echo "<table class='table table-hover table-responsive table-primary'>";
echo "<thead class='table-warning'>";
echo "<tr>";
echo "<th scope='col'>ID</th>";
echo "<th scope='col'>Name</th>";
echo "<th scope='col'>Subs_DT</th>";
echo "<th scope='col'>EXP_DT</th>";
echo "<th scope='col'>Age</th>";
echo "<th scope='col'>Plan</th>";
echo "<th scope='col'>Amount</th>";
echo "<th scope='col'>Phone</th>";
echo "<th scope='col'>Actions</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while($row = mysqli_fetch_assoc($query)) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['subs_DT']."</td>";
    echo "<td>".$row['EXP_DT']."</td>";
    echo "<td>".$row['age']."</td>";
    echo "<td>".$row['plan']."</td>";
    echo "<td>".$row['amount']."</td>";
    echo "<td>".$row['phone']."</td>";
    echo "<td>";
    echo "<a href='edit.php?id=".$row['id']."'>Edit</a> | ";
    echo "<a href='delete.php?id=".$row['id']."' onclick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
    echo "</td>";
    echo "</tr>";
   
}

echo "</tbody>";
echo "</table>";
?>
