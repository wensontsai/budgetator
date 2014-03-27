<?php

/*** begin our session ***/
session_start();
include_once 'includes/db.php';


    $expense_name = filter_var($_POST['expense_name'], FILTER_SANITIZE_STRING);
    $expense_type = filter_var($_POST['expense_type'], FILTER_SANITIZE_STRING);
    $necessary_expense = filter_var($_POST['necessary_expense'], FILTER_SANITIZE_STRING);
    $expense_amount = filter_var($_POST['expense_amount'], FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['user_id'];

        /*** prepare the insert ***/
        $stmt = $dbh->prepare("INSERT INTO expenses (expense_name, expense_type, necessary_expense, expense_amount, user_id ) VALUES (:expense_name, :expense_type, :necessary_expense, :expense_amount, :user_id)");

        /*** bind the parameters ***/
        $stmt->bindParam(':expense_name', $expense_name, PDO::PARAM_STR);
        $stmt->bindParam(':expense_type', $expense_type, PDO::PARAM_STR);
        $stmt->bindParam(':necessary_expense', $necessary_expense, PDO::PARAM_BOOL);
        $stmt->bindParam(':expense_amount', $expense_amount, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        /*** execute the prepared statement ***/
        $stmt->execute();

        $message = "new expense added successfully";

?>

<html>
    <head>
        <title>expenses submit</title>
        <meta charset="utf-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/application.css" rel="stylesheet">

    </head>
<body>
    <div class="container">
        <p><?php echo $message; ?>
    <br><br>
    <a href="/budgetator/public/#/dashboard">go back to dashboard</a>

    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
