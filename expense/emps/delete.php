<?php
	$id=$_GET['id'];
	include('conn.php');
	mysqli_query($conn,"delete from `clients` where id='$id'");
	header('location:indexx.php');
?>