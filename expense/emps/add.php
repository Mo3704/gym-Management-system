<?php
include "conn.php";

// استقبال البيانات من الاستمارة باستخدام $_POST
$namee = $_POST['namee'];
$subs_date = $_POST['subs_date'];
$exp_date = $_POST['exp_date'];
$age = $_POST['age'];
$plan = $_POST['plan'];
$amount = $_POST['amount'];
$phone = $_POST['phone'];

// استخدام استعلام SQL لإدراج البيانات في قاعدة البيانات
mysqli_query($conn, "INSERT INTO clients (namee, subs_DT, EXP_DT, age,plan,amount,phone)
VALUES ('$namee', '$subs_date', '$exp_date', '$age', '$class', '$amount')");

// إعادة التوجيه إلى الصفحة الرئيسية بعد الإدراج
header('location: index.php');
?>