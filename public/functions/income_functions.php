<?php

include_once('includes/db.php');

    $stmt_expenses = $dbh->prepare("SELECT * FROM incomes WHERE user_id = :user_id ORDER BY income_id DESC");
    $stmt_expenses->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_expenses->execute();
    $expenses = $stmt_expenses->fetchAll(PDO::FETCH_OBJ);


?>
