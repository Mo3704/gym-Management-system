<?php
$conn=mysqli_connect("localhost","root","","gym");


// اختبار الاتصال

if(mysqli_connect_errno()){

    echo "ليس هنالك إتصال بقاعده البيانات:".mysqli_connect_error();


}

?>
