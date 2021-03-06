<?php
/*** begin our session ***/
session_start();

/*** check if the users is already logged in ***/
if(isset( $_SESSION['user_id'] ))
{
    $message = 'Users is already logged in';
}
/*** check that both the username, password have been submitted ***/
if(!isset( $_POST['username'], $_POST['password']))
{
    $message = 'Please enter a valid username and password';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4)
{
    $message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['username']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
/*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['password']) != true)
{
        /*** if there is no match ***/
    $message = "Password must be alpha numeric";
}
else
{
    /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    /*** now we can encrypt the password ***/
    $password = sha1( $password );


    try
    {
        include_once 'includes/db.php';

        /*** prepare the select statement ***/
        $stmt = $dbh->prepare("SELECT user_id, username, password FROM USERS
                    WHERE username = :username AND password = :password");

        /*** bind the parameters ***/
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        // $user_id = $stmt->fetchColumn();

              $results = $stmt->fetch(PDO::FETCH_OBJ);
              // print_r($results);
              $user_id = $results->user_id;

        /*** if we have no result then fail boat ***/
        if($user_id == false)
        {
                $message = 'Login Failed';
        }
        /*** if we do have a result, all is well ***/
        else
        {
                /*** set the session user_id variable ***/
                $_SESSION['user_id'] = $user_id;

                /*** tell the user we are logged in ***/
                $_SESSION['login_message'] = "Hello <span id='user'>user id: " . $user_id . "</span> !";
                $_SESSION['update_message'] = "*** you've logged in successfully!";

                function Redirect($url, $user_id, $permanent = false)
                    {
                        header('Location: ' . $url . '?id=' . $user_id, true, $permanent ? 301 : 302);

                        exit();
                    }

                Redirect('/budgetator/public/#/dashboard', $user_id, false);
        }


    }
    catch(Exception $e)
    {
        /*** if we are here, something has gone wrong with the database ***/
        $message = 'We are unable to process your request. Please try again later"';
    }
}

?>


<!-- <!DOCTYPE HTML>
<html ng-app="app">
<head>
<title>PHPRO Login</title>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/application.css" rel="stylesheet">

</head>
<body>
      <div class="container">
        <?php echo $message ?>
      </div>

      <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/angular.min.js"></script>
      <script src="js/angular-route.js"></script>
      <script src="js/app.js"></script>
</body>
</html> -->

