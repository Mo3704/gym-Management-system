<?php
include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Income.php';
?>

<?php
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$income = new Income($db);

if(!$user->loggedIn()) {
	header("Location: index.php");
}
include('inc/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>gym Management : Expense Management</title>
	<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/general.js"></script>
<script src="js/income.js"></script>
</head>
<body>
	<style>
    table {
        border-collapse: collapse;
        width: 100%;
		align-content: center;
		align-items: center;
    }
    
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    
    th {
        background-color: #f2f2f2;
    }
    
    tr:hover {
        background-color: #f5f5f5;
    }
</style>

<?php include('inc/container.php');?>
<div class="container" style="">  
	<h2>Expense Management System </h2>	
	<br>
	<?php include('top_menus.php'); ?>	
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				
			</div>
		</div>
		
	</div>
	
	<div id="incomeModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="incomeForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit Income</h4>
					</div>
					<div class="modal-body">						
						<div class="form-group">
							<label for="country" class="control-label">Category</label>							
							<select class="form-control" id="income_cat" name="income_cat">
							<option value="">Select Category</option>
							<?php 
							$categoryResult = $income->getCategoryList();
							while ($category = $categoryResult->fetch_assoc()) { 	
							?>
								<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>							
							<?php } ?>
							</select>							
						</div>
						
						<div class="form-group">							
							<label for="Income" class="control-label">Amount</label>							
							<input type="text" name="amount" id="amount" autocomplete="off" class="form-control" />
									
							
							
						</div>
						
						<div class="form-group"
							<label for="project" class="control-label">Date</label>
							<input type="date" class="form-control" id="income_date" name="income_date" placeholder="Income date" >			
						</div>						
										
					</div>
					
					<div class="modal-footer">
						<input type="hidden" name="id" id="id" />						
						<input type="hidden" name="action" id="action" value="" />
						<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php
// Query to retrieve the sum of amount and month-wise grouping
$sql="SELECT month_year, SUM(amount) AS total_amount
FROM (
    SELECT CONCAT(MONTH(subs_DT), ' ', YEAR(subs_DT)) AS month_year, amount, subs_DT
    FROM clients
    UNION ALL
    SELECT CONCAT(MONTH(inst1), ' ', YEAR(inst1)) AS month_year, amount1, inst1
    FROM clients
    WHERE con_inst1 = 1
    UNION ALL
    SELECT CONCAT(MONTH(inst2), ' ', YEAR(inst2)) AS month_year, amount2, inst2
    FROM clients
    WHERE con_inst2 = 1
    UNION ALL
    SELECT CONCAT(MONTH(inst3), ' ', YEAR(inst3)) AS month_year, amount3, inst3
    FROM clients
    WHERE con_inst3 = 1
) AS subquery
GROUP BY month_year
HAVING total_amount > 0
ORDER BY MIN(subs_DT) ASC;";

// Create a new instance of the Database class
$database = new Database();

// Get the database connection
$conn = $database->getConnection();// Execute the query
$result = mysqli_query($conn, $sql);


// Check if the query was successful
if ($result) {
    echo "<table border='1'>";
    echo "<tr><th>Month</th><th>Total Amount</th></tr>";
    
    // Fetch data and display it in a table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['month_year'] . "</td>";
        echo "<td>$" . $row['total_amount'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Display an error message if the query fails
    echo "Error: " . mysqli_error($conn);
}


?>
<BR>	
	<a href="emps\indexx.php" class="btn btn-primary">Go to report</a>


</div>

 <?php include('inc/footer.php');?>
</body>
</html>