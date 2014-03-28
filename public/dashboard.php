<?php

session_start();

include_once 'includes/db.php';

    $stmt_expenses = $dbh->prepare("SELECT * FROM expenses WHERE user_id = :user_id");
    $stmt_expenses->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_expenses->execute();
    $expenses = $stmt_expenses->fetchAll(PDO::FETCH_OBJ);
    // print_r($expenses);

?>


<?php if (isset($_SESSION['user_id']) || !empty($_SESSION['user_id'])){  ?>
    <div id="summary">

        <br><?php echo $_SESSION['login_message'] ?><br>
        Here is what your budget is looking like.
        <br><br>

        <div class="leftward col-md-6">
            <h4>expenses:</h4>
            <table >
                <tr>
                    <td class="yo more">name</td>
                    <td class="yo more">type</td>
                    <td class="yo more">amount</td>
                    <td class="yo more">necessary?</td>
                    <!-- <td class="yo more">user ID</td> -->
                </tr>

<?php
        // echo "<pre>";
        // echo var_dump($expenses);
        // echo "</pre>";


            // $type_array = array('food','clothing','social','unique','travel');

            // foreach($type_array as $typer){
            //     echo "$" .$typer. "_count = 0";
            //     echo "$" .$typer. "_type = []";

            // }

            $food_count = 0;
            $clothing_count = 0;
            $social_count = 0;
            $unique_count = 0;
            $travel_count = 0;

            $expense_array = [];

            $food_type =[];
            $clothing_type =[];
            $social_type =[];
            $unique_type =[];
            $travel_type =[];


            foreach($expenses as $value){

                $expense_array[] = $value->expense_amount;
                        if($value->expense_type === "clothing"){
                            $clothing_count++;
                        } else if ($value->expense_type === "food"){
                            $food_count++;
                        } else if ($value->expense_type === "social"){
                            $social_count++;
                        } else if ($value->expense_type === "unique"){
                            $unique_count++;
                        } else if ($value->expense_type === "food"){
                            $travel_count++;
                        }

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
<br><br><br>

            <h4>expenses breakdown:</h4>

            <table>
                <tr>
                    <td class="yo more">type</td>
                    <td class="yo more"></td>
                    <td class="yo more">amount</td>
                    <td class="yo more">percentage</td>
                    <!-- <td class="yo more">user ID</td> -->
                </tr>
                <tr>
                    <td class="yo">food</td>
                    <td class="yo"></td>
                    <td class="yo"><?php echo $food_count ?></td>
                    <td class="yo"><?php echo $food_count/count($expense_array) *100?>%</td>
                </tr>
                <tr>
                    <td class="yo">clothing</td>
                    <td class="yo"></td>
                    <td class="yo"><?php echo $clothing_count ?></td>
                    <td class="yo"><?php echo $clothing_count/count($expense_array) *100?>%</td>
                </tr>
                <tr>
                    <td class="yo">social</td>
                    <td class="yo"></td>
                    <td class="yo"><?php echo $social_count ?></td>
                    <td class="yo"><?php echo $social_count/count($expense_array) *100?>%</td>
                </tr>
                <tr>
                    <td class="yo">unique</td>
                    <td class="yo"></td>
                    <td class="yo"><?php echo $unique_count ?></td>
                    <td class="yo"><?php echo $unique_count/count($expense_array) *100?>%</td>
                </tr>
                <tr>
                    <td class="yo">travel</td>
                    <td class="yo"></td>
                    <td class="yo"><?php echo $travel_count ?></td>
                    <td class="yo"><?php echo $travel_count/count($expense_array) *100?>%</td>
                </tr>
                    <!-- <td class="yo more">user ID</td> -->
            </table>
            <br><br>
            <table>
                <tr>
                    <td class="yo more">total:</td>
                                        <td class="yo more"></td>

                    <td>$<?php echo array_sum($expense_array); ?></td>
                </tr>
            </table>


        </div >

        <div class="rightward col-md-6">
            <h4>income:</h4>
            <table>
                <tr>
                    <td>income column names</td>
                </tr>

                <tr>
                    <td>income data here</td>
                </tr>
            </table>
<br><br><br>

            <h4>expense data visualization</h4>
            <table>
                <tr>
                    <td>percentages spent viz</td>
                </tr>
            </table>
        </div>


    </div>
<br>


<?php } else { ?>

    <div>
        please log in
    </div>

<?php } ?>
