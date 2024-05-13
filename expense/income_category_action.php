<?php
include_once 'config/Database.php';
include_once 'class/Income.php';

$database = new Database();
$db = $database->getConnection();

$income = new Income($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listCateogry') {
	$income->listCateogry();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getCategoryDetails') {
	$income->id = $_POST["id"];
	$income->getIncomeCategoryDetails();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addCategory') {
	$income->categoryName = $_POST["categoryName"];
	$income->status = $_POST["status"];
	$income->insertCategory();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateCategory') {
	$income->id = $_POST["id"];
	$income->categoryName = $_POST["categoryName"];
	$income->status = $_POST["status"];	
	$income->updateCategory();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteCategory') {
	$income->id = $_POST["id"];
	$income->deleteCategory();
}
?>