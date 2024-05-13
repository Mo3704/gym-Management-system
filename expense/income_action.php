<?php
include_once 'config/Database.php';
include_once 'class/Income.php';

$database = new Database();
$db = $database->getConnection();

$income = new Income($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listIncome') {
	$income->listIncome();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getIncomeDetails') {
	$income->income_id = $_POST["id"];
	$income->getIncomeDetails();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addIncome') {
	$income->income_category = $_POST["income_cat"];
	$income->amount = $_POST["amount"];
	$income->income_date = $_POST["income_date"];
	$income->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateIncome') {
	$income->id = $_POST["id"];
	$income->income_category = $_POST["income_cat"];
	$income->amount = $_POST["amount"];
	$income->income_date = $_POST["income_date"];
	$income->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteIncome') {
	$income->id = $_POST["id"];
	$income->delete();
}
?>