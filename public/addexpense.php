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

             <!-- live search area start -->
            <br><br>

                <!-- main title -->
                <div class="icon">
                </div>
                <h1 class="title">Live Search</h1>
                <h5 class="title">searches through expenses and shows them</h5>

                <!-- main input -->
                <input id="search" type="text" id="search" autocomplete="off"/>

                <!-- show results -->
                <h4 id="results-text">Showing results for: <strong id="search-string">Array</strong></h4>
                <ul id="results"></ul>
            <br>
            <!-- live search area end-->


        <input type="text" id="expense_name" name="expense_name" value="" maxlength="100" />
        </p>
        <p>
        <label for="expense_type">type</label>
        <select  name="expense_type">
            <option value="food">food</option>
            <option value="clothing">clothing</option>
            <option value="social">social</option>
            <option value="unique">unique purchase</option>
            <option value="travel">travel</option>
        </select>
        </p>
        <p>
        <label for="expense_amount">amount $</label>
        <input type="text" id="expense_amount" name="expense_amount" value="" maxlength="15" />
        </p>
        <p>
        <label for="necessary_expense">was this a truly necessary expense?</label>
        <select name="necessary_expense">
            <option id="necessary_expense" name="necessary_expense" value="1">Yes</option>
            <option id="necessary_expense" name="necessary_expense" value="0">No</option>
        </select>
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



