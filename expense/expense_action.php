<?php
include_once 'config/Database.php';
include_once 'class/Expense.php';

$database = new Database();
$db = $database->getConnection();

$expense = new Expense($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listExpense') {
	$expense->listExpense();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getExpenseDetails') {
	$expense->income_id = $_POST["id"];
	$expense->getExpenseDetails();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addExpense') {
	$expense->expense_category = $_POST["expense_cat"];
	$expense->amount = $_POST["amount"];
	$expense->expense_date = $_POST["expense_date"];
	$expense->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateExpense') {
	$expense->id = $_POST["id"];
	$expense->expense_category = $_POST["expense_cat"];
	$expense->amount = $_POST["amount"];
	$expense->expense_date = $_POST["expense_date"];
	$expense->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteExpense') {
	$expense->id = $_POST["id"];
	$expense->delete();
}

?>