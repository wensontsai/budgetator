<?php

session_start();

require('functions/D3_functions.php');

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
                    <!-- <div id="D3_piechart">
                        <button class="randomize btn btn-sm">March</button>
                        <button class="btn btn-sm" id="april">April</button>

                    </div> -->
                   <!--  <svg id="svg_donut" width="600" height="400"></svg> -->
                    <svg id="svg2"></svg>
                </tr>
            </table>
        </div>


    </div>
<br>
<script>
// runD3();
// runD50();
runD74();
</script>


<?php } else { ?>

    <div>
        please log in
    </div>

<?php } ?>
