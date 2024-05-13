<?php
include('conn.php');

function getCheckboxValue($checkbox){
    if(isset($_POST[$checkbox]) && $_POST[$checkbox] == '1') {
        return 1;
    } else {
        return  0;
    }}



// التحقق مما إذا كان المعرف موجودًا وليس فارغًا
if(isset($_GET['id_edit']) && !empty($_GET['id_edit'])) {
    // استقبال المعرف من العنوان URL
    $id = $_GET['id_edit'];
    
     // استقبال البيانات المرسلة عبر النموذج
     $name = $_POST['name'];
     $subs_DT = $_POST['subs_DT'];
     $EXP_DT = $_POST['EXP_DT'];
     $age = isset($_POST['age'])?$_POST['age']:null;
     $phone=$_POST['phone'];
     
     if(isset($_POST['plan'])) {
        $plan_name = $_POST['plan'];

        // Query to get the plan ID from the 'plan' table based on the plan name
        $plan_query = "SELECT id FROM plan WHERE name = '$plan_name'";
        $plan_result = mysqli_query($conn, $plan_query);

        // Check if the query was successful and there is a row returned
        if($plan_result && mysqli_num_rows($plan_result) > 0) {
            // Fetch the plan ID from the result
            $plan_row = mysqli_fetch_assoc($plan_result);
            $plan = $plan_row['id'];}}

     $inst_date1=isset($_POST['inst_date1'])?$_POST['inst_date1'] : null ; 
     $inst_date2=isset($_POST['inst_date2'])?$_POST['inst_date2'] : null ; 
     $inst_date3=isset($_POST['inst_date3'])?$_POST['inst_date3'] : null ; 
    
     //3 installments
     if (!empty( $inst_date1) && !empty( $inst_date2) && !empty( $inst_date3)) {
     $con1=getCheckboxValue('checkbox1');
     $con2=getCheckboxValue('checkbox2');
     $con3=getCheckboxValue('checkbox3');
     
     $amount1=isset($_POST['amount1'])?$_POST['amount1'] : null ;
     $amount2=isset($_POST['amount2'])?$_POST['amount2'] : null ;
     $amount3=isset($_POST['amount3'])?$_POST['amount3'] : null ;
        
     $sql = "UPDATE clients 
                SET 
                name = '$name', 
                subs_DT = '$subs_DT', 
                EXP_DT = '$EXP_DT', 
                plan = '$plan', 
                phone = '$phone', 
                inst1 = '$inst_date1', 
                amount1 = '$amount1', 
                con_inst1 = '$con1', 
                inst2 = '$inst_date2', 
                amount2 = '$amount2', 
                con_inst2 = '$con2', 
                inst3 = '$inst_date3', 
                amount3 = '$amount3', 
                con_inst3 = '$con3', 
                age = '$age' 
                WHERE 
                Id = '$id'";

     //2installments
     }elseif (!empty( $inst_date1) && !empty( $inst_date2)){
        $con1=getCheckboxValue('checkbox4');
        $con2=getCheckboxValue('checkbox5');
        

        $inst_date1=isset($_POST['inst_date1'])?$_POST['inst_date1'] : null ; 
        $inst_date2=isset($_POST['inst_date2'])?$_POST['inst_date2'] : null ; 
     
        $amount1=isset($_POST['amount1'])?$_POST['amount1'] : null ;
        $amount2=isset($_POST['amount2'])?$_POST['amount2'] : null ;
      
      $sql = "UPDATE clients 
                SET 
                name = '$name', 
                subs_DT = '$subs_DT', 
                EXP_DT = '$EXP_DT', 
                plan = '$plan', 
                phone = '$phone', 
                inst1 = '$inst_date1', 
                amount1 = '$amount1', 
                con_inst1 = '$con1', 
                inst2 = '$inst_date2', 
                amount2 = '$amount2', 
                con_inst2 = '$con2', 
                age = '$age' 
                WHERE 
                Id = '$id'";

        //full payment
     }else{
        $amount =isset($_POST['amount'])?$_POST['amount'] : null ;
     
         $sql = "UPDATE clients 
                SET 
                name = '$name', 
                subs_DT = '$subs_DT', 
                EXP_DT = '$EXP_DT', 
                plan = '$plan', 
                phone = '$phone',  
                age = '$age', 
                amount = '$amount' 
                WHERE 
                Id = '$id'";
    } 

     

    // التحقق مما إذا كانت العملية ناجحة
    if (mysqli_query($conn, $sql)) {
        
        header('Location: indexx.php');

        
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // إذا كان المعرف غير موجود أو فارغ، فقم بإعادة توجيه المستخدم إلى الصفحة الرئيسية أو أي صفحة أخرى
    header('Location: indexx.php');
    exit;
}
?>
