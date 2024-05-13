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
<script src="js/general.js"></script>
<script src="js/user.js"></script>
<?php include('inc/container.php');?>
<div class="container" style="">  
	<h2>Expense Management System with PHP & MySQL</h2>	
	<br>
	<?php include('top_menus.php'); ?>	
	<div> 	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" id="addUser" class="btn btn-info" title="Add user"><span class="glyphicon glyphicon-plus"></span></button>
				</div>
			</div>
		</div>
		<table id="userListing" class="table table-bordered table-striped">
			<thead>
				<tr>						
					<th>Sn.</th>					
					<th>Name</th>					
					<th>Email</th>
					<th>Role</th>						
					<th></th>
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	
	<div id="userModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="userForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Edit User</h4>
					</div>
					<div class="modal-body">						
						
						<div class="form-group">
							<label for="country" class="control-label">Role</label>							
							<select class="form-control" id="role" name="role"/>
								<option value="">Select Role</option>							
								<option value="admin">Admin</option>
								<option value="user">User</option>								
							</select>							
						</div>
						
						<div class="form-group">							
							<label for="Income" class="control-label">First Name</label>							
							<input type="text" name="first_name" id="first_name" autocomplete="off" class="form-control" placeholder="first name"/>
											
						</div>
						
						<div class="form-group"
							<label for="project" class="control-label">Last Name</label>
							<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" >			
						</div>	

						<div class="form-group"
							<label for="project" class="control-label">Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Email" >			
						</div>
						
						<div class="form-group"
							<label for="project" class="control-label">New Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="password" >			
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
</div>
 <?php include('inc/footer.php');?>
