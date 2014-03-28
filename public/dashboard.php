<?php

session_start();

include_once 'includes/db.php';

    $stmt = $dbh->prepare("SELECT * FROM expenses WHERE user_id = :user_id");

    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

    $stmt->execute();

    // $results = $stmt->fetchAll();

    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
    // print_r($results);

?>


<?php if (isset($_SESSION['user_id']) || !empty($_SESSION['user_id'])){  ?>
    <div id="summary">

        <br><?php echo $_SESSION['login_message'] ?><br>
        Here is what your budget is looking like.
        <br><br>
        <h4>expenses:</h4>
        <table>
            <tr>
                <td class="yo more">name</td>
                <td class="yo more">type</td>
                <td class="yo more">amount</td>
                <td class="yo more">necessary?</td>
                <!-- <td class="yo more">user ID</td> -->
            </tr>

<?php
        // echo "<pre>";
        // echo var_dump($results);
        // echo "</pre>";

        foreach($results as $value){
            echo "<tr>";
            echo "<td class='yo'>". $value->expense_name ."</td>";
            echo "<td class='yo'>". $value->expense_type ."</td>";
            echo "<td class='yo'>$". $value->expense_amount ."</td>";
            if($value->necessary_expense === '0'){
                echo "<td class='yo'>". "no" ."</td>";
                // echo "<td class='yo'>". $value->user_id ."</td>";
            } else {
                echo "<td class='yo'>". "yes" ."</td>";

            }

            echo "</tr>";
        }
?>

        </table>
    </div>
<br>
    <div><a href="/budgetator/public/logout.php">Log out</a></div>

<?php } else { ?>

    <div>
        please log in
    </div>

<?php } ?>
