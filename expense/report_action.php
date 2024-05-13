<?php
include_once 'config/Database.php';
include_once 'class/Report.php';

$database = new Database();
$db = $database->getConnection();

$report = new Report($db);

if(!empty($_POST['action']) && $_POST['action'] == 'getReports') {
	$report->fromDate = $_POST['fromDate'];
	$report->toDate = $_POST['toDate'];
	$report->getReports();
}
?>