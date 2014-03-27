<?php
/*** begin our session ***/
session_start();

/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );

/*** set the session form token ***/
$form_token = $_SESSION['form_token'];


?>

<!DOCTYPE HTML>
<html ng-app="app">
<head>
<title>PHPRO Login</title>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/application.css" rel="stylesheet">

</head>

    <body>
      <div class="container">
          <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand" href="#">Budgetator</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li><a href="#dashboard">Dashboard</a></li>
                  <li><a href="#addexpense">Add Expenses</a></li>

                </ul>
              </div><!-- /.navbar-collapse -->

            </div>
          </nav><!--nav end -->

        <div id="view" ng-view>  <!--errythin angular here -->




        </div><!-- end angular div -->

    </div><!--end container, bootstrap -->

      <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/angular.min.js"></script>
      <script src="js/angular-route.js"></script>
      <script src="js/app.js"></script>

<script>

  var user_id = "<?php echo $_SESSION['user_id'] ?>";

  $('#user_id').html(user_id);

</script>

    </body>

</html>
