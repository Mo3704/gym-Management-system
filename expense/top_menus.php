<h3><?php if($_SESSION["userid"]) { echo "Logged in : ".ucfirst($_SESSION["name"]); } ?> | <a href="logout.php">Logout</a> </h3><br>
<p><strong>Welcome <?php echo ucfirst($_SESSION["role"]); ?></strong></p>	
<ul class="nav nav-tabs">
	
	<?php if($_SESSION["role"] == 'admin') { ?>
		<li id="expense"><a href="expense.php">Expense</a></li>
		<li id="report"><a href="report.php">View Report</a></li>
		<li id="income"><a href="income.php">Income</a></li>
		<li id="expense_category"><a href="expense_category.php">Expense Category</a></li>		
		<li id="income_category"><a href="income_category.php">Income Category</a></li> 		
		<li id="user"><a href="user.php">Users</a></li>	
	<?php } ?>

</ul>