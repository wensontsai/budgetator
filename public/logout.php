<?php

session_start();
session_destroy();

header('Location: /budgetator/public/#/logoutsuccess');

// function redirect($url, $statusCode = 303)
// {
//    header('Location: ' . $url, true, $statusCode);
//    die();
// }

// redirect('/budgetator/public/#/logoutsuccess', $statusCode);
?>



