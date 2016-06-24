<?php include 'settings.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="tb_style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="login_functions.js"></script>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="col-lg-12">
        <div id="info-message" class="alert alert-info" role="alert">
            Please register or log in to book your seats.
        </div>

        <div id="error-message"></div>

        <div class="col-lg-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Register</h3>
                </div>
                    <div class="panel-body">

                        <form id="register-form">
                            <div class="input-group">
                                <span class="input-group-addon">email</span>
                                <input id="new-email" name="email" type="text" class="form-control" placeholder="email" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon">password</span>
                                <input id="new-password" name="password" type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon">repeat password</span>
                                <input id="new-password-repeated" name="password-repeated" type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <div class="input-group">
                                <button class="btn btn-default" onclick="register()">
                                    Register
                                </button>
                            </div>
                        </form>

                    </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Log in</h3>
                </div>
                <div class="panel-body">
                    <form>
                        <div class="input-group">
                            <span class="input-group-addon" >username</span>
                            <input name="username" type="text" class="form-control" placeholder="username" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon" >password</span>
                            <input name="password" type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group">
                            <button class="btn btn-default"">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
