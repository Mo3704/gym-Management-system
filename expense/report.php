<?php
include_once 'config/Database.php';
include_once 'class/User.php';
include_once 'class/Expense.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$expense = new Expense($db);

if(!$user->loggedIn()) {
	header("Location: index.php");
}

include('inc/header.php');
?>
<title>webdamn.com : Demo Expense Management System with PHP & MySQL</title>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<!-- <script src="js/general.js"></script> -->
<!-- <script src="js/report.js"></script> -->
<script>
$(document).ready(function(){
    $('#viewReport').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        
        $.ajax({
            url: 'getIncomeByDate.php',
            method: 'POST',
            data: {from_date: from_date, to_date: to_date},
            success: function(data){
                $('#listReports').html(data);
                $('#reportTable').show();
                $('#detailSection').show();
                $('#noRecords').hide();
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }
			
        });
    });
});
</script>
<link rel="stylesheet" href="../style.css">

<header><nav class="navbar">
    
    <ul>
        <h1>PNP</h1>
<li><a href="../main.php">home</a></li>
<li><a href="../user_plan.php">Register</a></li>
<li><a href="../plan.php">New plan</a></li>
<li><a href="../expense\report.php">report</a></li>
<li><a href="../expense\emps\indexx.php">members</a></li>
    </ul>
</nav></header>
<?php include('inc/container.php');?>
<div class="container" style="">  
	<h2>Expense Management System </h2>	
	<br>
	<?php include('top_menus.php'); ?>	
	<div> 	
		<div class="panel-heading">
			<div class="row">	
				<div>
					<h4>View Income and Expense Reports</h4>
				</div>
				
				<div class="col-md-2" style="padding-left:0px;">
					<input type="date" class="form-control" id="from_date" name="from_date" placeholder="From date" >
				</div>
				<div class="col-md-2" style="padding-left:0px;">
					<input type="date" class="form-control" id="to_date" name="to_date" placeholder="To date" >
				</div>
				<div class="col-md-2" style="padding-left:0px;">
					<button type="submit" id="viewReport" class="btn btn-info" title="View Report"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
		</div>
		<table class="table table-bordered table-striped" id="reportTable" style="display:none;">
			<thead>
				<tr>									
					<th>Date</th>					
					<th>Income</th>
					<th>Expense</th>
					<th>Net profit</th>									
				</tr>				
			</thead>
			<tbody id="listReports">
			
			</tbody>
		</table>
		</div>
		<div class="panel-heading" id="noRecords" style="display:none;">
		</div>
	</div>	
	
</div>
 <?php include('inc/footer.php');?>
