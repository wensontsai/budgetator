<?php

    include_once('includes/db.php');

    $stmt_expenses = $dbh->prepare("SELECT * FROM expenses WHERE user_id = :user_id");
    $stmt_expenses->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_expenses->execute();
    $expenses = $stmt_expenses->fetchAll(PDO::FETCH_OBJ);
    // print_r($expenses);

    // sql query to get labels and values for D3 graph
    $stmt_expenses_graph = $dbh->prepare("SELECT expense_type, expense_amount FROM expenses WHERE user_id = :user_id");
    $stmt_expenses_graph->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_expenses_graph->execute();
    $expenses_graph = $stmt_expenses_graph->fetchAll(PDO::FETCH_OBJ);



$food_total = 0;
$clothing_total = 0;
$unique_total = 0;

foreach($expenses_graph as $array) {

    if ($array->expense_type === "food") {
        $food_total += $array->expense_amount;
    }
    else if ($array->expense_type === "clothing") {
        $clothing_total += $array->expense_amount;
    }
    else if ($array->expense_type === "unique") {
        $unique_total += $array->expense_amount;
    }

}


$my_final_array = array(array("label"=>"food", "value"=>$food_total),
                        array("label"=>"unique", "value"=>$unique_total),
                        array("label"=>"clothing", "value"=>$clothing_total)
                        );


    $expenses_graph_json_clean = json_encode($my_final_array);

?>
