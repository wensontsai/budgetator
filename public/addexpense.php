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


<?php } else { ?>

<div>
    please log in
</div>

<?php } ?>


