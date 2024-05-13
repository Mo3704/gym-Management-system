<?php
	$id=$_GET['id'];
	include('conn.php');
	mysqli_query($conn,"delete from `expired_clients` where id='$id'");
	header('location:index.php');
?>