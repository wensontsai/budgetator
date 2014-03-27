<?php
/*** begin our session ***/
session_start();
include_once 'includes/db.php';

?>

<?php if (isset($_SESSION['user_id']) || !empty($_SESSION['user_id'])){  ?>


    <h4>add new expenses here: </h4>
    <form action="expense_submit.php" method="post">
      <fieldset>
        <p>
        <label for="expense_name">name</label>
        <input type="text" id="expense_name" name="expense_name" value="" maxlength="100" />
        </p>
        <p>
        <label for="expense_type">type</label>
        <input type="text" id="expense_type" name="expense_type" value="" maxlength="50" />
        </p>
        <p>
        <label for="expense_amount">amount</label>
        <input type="text" id="expense_amount" name="expense_amount" value="" maxlength="25" />
        </p>
        <p>
        <label for="necessary_expense">was this a truly necessary expense?</label>
        <INPUT TYPE="radio" id="necessary_expense" name="necessary_expense" value="1">Yes
        <INPUT TYPE="radio" id="necessary_expense" name="necessary_expense" value="0">No
        </p>
        <p>
        <button class="btn btn-sm">add expense</button>
        </p>
      </fieldset>
    </form>


    <?php
        /*** if we are here the data is valid and we can insert it into database ***/
        $expense_name = filter_var($_POST['expense_name'], FILTER_SANITIZE_STRING);
        $expense_type = filter_var($_POST['expense_type'], FILTER_SANITIZE_STRING);
        $expense_amount = filter_var($_POST['expense_amount'], FILTER_SANITIZE_STRING);
        $necessary_expense = filter_var($_POST['necessary_expense'], FILTER_SANITIZE_STRING);
        $user_id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);

        $stmt = $dbh->prepare("INSERT INTO expenses (expense_name, expense_type, expense_amount, necessary_expense, user_id ) VALUES (:expense_name, :expense_type, :expense_amount, :necessary_expense, :user_id)");

        /*** bind the parameters ***/
        $stmt->bindParam(':expense_name', $expense_name, PDO::PARAM_STR);
        $stmt->bindParam(':expense_type', $expense_type, PDO::PARAM_STR);
        $stmt->bindParam(':expense_amount', $expense_amount, PDO::PARAM_STR);
        $stmt->bindParam(':necessary_expense', $necessary_expense, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        /*** execute the prepared statement ***/
        $stmt->execute();

    ?>


<?php } else { ?>

<div>
    please log in
</div>

<?php } ?>


