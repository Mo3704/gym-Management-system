<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once 'config/Database.php';
include_once 'class/Income.php';

$database = new Database();
$conn = $database->getConnection(); // Obtain a database connection

if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    
    // Initialize total amounts
    $total_income = 0;
    $total_expense = 0;
    $total_net_profit = 0;
    
    // Retrieve distinct months within the date range
    $sql_months = "SELECT DISTINCT month_year FROM (
                        (SELECT CONCAT(MONTH(subs_DT), ' ', YEAR(subs_DT)) AS month_year FROM clients WHERE subs_DT BETWEEN '$from_date' AND '$to_date')
                        UNION
                        (SELECT CONCAT(MONTH(inst1), ' ', YEAR(inst1)) AS month_year FROM clients WHERE con_inst1 = 1 AND inst1 BETWEEN '$from_date' AND '$to_date')
                        UNION
                        (SELECT CONCAT(MONTH(inst2), ' ', YEAR(inst2)) AS month_year FROM clients WHERE con_inst2 = 1 AND inst2 BETWEEN '$from_date' AND '$to_date')
                        UNION
                        (SELECT CONCAT(MONTH(inst3), ' ', YEAR(inst3)) AS month_year FROM clients WHERE con_inst3 = 1 AND inst3 BETWEEN '$from_date' AND '$to_date')
                        UNION
                        (SELECT CONCAT(MONTH(date), ' ', YEAR(date)) AS month_year FROM expense_expense WHERE date BETWEEN '$from_date' AND '$to_date')
                    ) AS subquery
                    ORDER BY STR_TO_DATE(CONCAT('01 ', month_year), '%d %M %Y') ASC";

    $months_result = mysqli_query($conn, $sql_months); 
    while ($month_row = mysqli_fetch_assoc($months_result)) {
        $month_year = $month_row['month_year'];
        
        // Retrieve income amount for the month
        $sql_income = "SELECT IFNULL(SUM(amount), 0) AS total_amount
                       FROM (
                           SELECT amount, subs_DT AS date FROM clients WHERE CONCAT(MONTH(subs_DT), ' ', YEAR(subs_DT)) = '$month_year'
                           UNION ALL
                           SELECT amount1, inst1 FROM clients WHERE con_inst1 = 1 AND CONCAT(MONTH(inst1), ' ', YEAR(inst1)) = '$month_year'
                           UNION ALL
                           SELECT amount2, inst2 FROM clients WHERE con_inst2 = 1 AND CONCAT(MONTH(inst2), ' ', YEAR(inst2)) = '$month_year'
                           UNION ALL
                           SELECT amount3, inst3 FROM clients WHERE con_inst3 = 1 AND CONCAT(MONTH(inst3), ' ', YEAR(inst3)) = '$month_year'
                       ) AS subquery";

        $income_result = mysqli_query($conn, $sql_income); 
        $income_row = mysqli_fetch_assoc($income_result);
        $income_amount = $income_row['total_amount'];
        
        // Retrieve expense amount for the month
        $sql_expense = "SELECT IFNULL(SUM(amount), 0) AS total_amount
                        FROM expense_expense
                        WHERE CONCAT(MONTH(date), ' ', YEAR(date)) = '$month_year'";

        $expense_result = mysqli_query($conn, $sql_expense); 
        $expense_row = mysqli_fetch_assoc($expense_result);
        $expense_amount = $expense_row['total_amount'];
        
        // Calculate net profit
        $net_profit = $income_amount - $expense_amount;
        
        // Display row if either income or expense is nonzero
        if ($income_amount > 0 || $expense_amount > 0) {
            echo "<tr>";
            echo "<td>$month_year</td>";
            echo "<td>$income_amount</td>";
            echo "<td>$expense_amount</td>";
            echo "<td>$net_profit</td>";
            echo "</tr>";
        }
        
        // Update total amounts
        $total_income += $income_amount;
        $total_expense += $expense_amount;
        $total_net_profit += $net_profit;
    }
    
    // Display totals
    echo "<tr>";
    echo "<td>Total</td>";
    echo "<td>$total_income</td>";
    echo "<td>$total_expense</td>";
    echo "<td>$total_net_profit</td>";
    echo "</tr>";

  }
?>
