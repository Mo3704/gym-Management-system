<?php
include_once 'config/Database.php';
include_once 'class/Expense.php';

$database = new Database();
$db = $database->getConnection();

$expense = new Expense($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listCateogry') {
	$expense->listCateogry();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getCategoryDetails') {
	$expense->id = $_POST["id"];
	$expense->getCategoryDetails();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addCategory') {
	$expense->categoryName = $_POST["categoryName"];
	$expense->status = $_POST["status"];
	$expense->insertCategory();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateCategory') {
	$expense->id = $_POST["id"];
	$expense->categoryName = $_POST["categoryName"];
	$expense->status = $_POST["status"];	
	$expense->updateCategory();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteCategory') {
	$expense->id = $_POST["id"];
	$expense->deleteCategory();
}

?>