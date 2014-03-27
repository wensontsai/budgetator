<?php

session_start();
session_destroy();

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}

redirect('/budgetator/public/logoutsuccess.php', $statusCode);
?>



