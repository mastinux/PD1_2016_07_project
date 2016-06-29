<?php
    include 'functions.php';
    include 'functions_database.php';
    include 'functions_messages.php';

    session_start();
    if ( $username = user_logged_in() ){
        include 'auth_sessions.php';
        set_https();
    }
    else{
        unset_https();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Theater Booker</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="bootstrap/html5shiv.min.js"></script>
    <script type="text/javascript" src="bootstrap/respond.min.js"></script>
    <![endif]-->

    <link href="tb_style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="theater_map_functions.js"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <noscript>
        <div class="no-script-warning">
            Sorry: Your browser does not support or has disabled javascript.
        </div>
        <br>
        <div class="no-script-info">
            Please use a different browser or enabled javascript.
        </div>
        <br>
    </noscript>

    <?php
        $non_user_taken_seats = get_non_user_taken_seat($username);
        $user_taken_seats = get_user_taken_seat($username);
    ?>

    <?php manage_messages(); ?>

    <div class="row col-lg-12">

        <div class="col-lg-4 col-md-4">

            <div class="panel panel-default" id="session-details-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Session details</h3>
                </div>
                <div class="panel-body">
                    <?php
                        if ( $username ) {
                            echo "<p>Signed in as <b>".$username."</b></p>                                                                 
                                  <a href=\"auth_logout.php\">
                                    <button type=\"button\" class=\"btn btn-default btn-lg\" onclick=\"clearSelectedSeats()\">
                                        <span class=\"glyphicon glyphicon-log-out\" aria-hidden=\"true\"></span> Logout                                                
                                    </button>                                                                                                                                                                    
                                  </a>";
                        }
                        else{
                            echo "<a href=\"auth_login.php\">
                                    <button type=\"button\" class=\"btn btn-default btn-lg\">
                                        <span class=\"glyphicon glyphicon-log-in\" aria-hidden=\"true\"></span> Login                                                
                                    </button>                                                                                                                                                                    
                                  </a>";
                        }
                    ?>
                </div>
            </div>

            <div class="panel panel-default" id="booking-details-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Booking details</h3>
                </div>
                <div class="panel-body">
                    Selected seats : <span id="selected-seats" class="label selected visible">0</span><br>
                    <?
                        if ($username)
                            echo "Booked seats : <span id=\"booked-seats\" class=\"label booked visible\">0</span><br>";
                    ?>
                    Free seats : <span id="free-seats" class="label free visible"><?php echo ROWS*COLUMNS; ?></span><br>
                    Taken seats : <span id="taken-seats" class="label taken visible">0</span><br>
                    Total seats : <span id="total-seats" class="label label-primary visible"><?php echo ROWS*COLUMNS; ?></span><br><br>
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-lg" onclick="clearSelectedSeats()">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Clear
                            </button>
                        </div>
                        <?php
                        if ($username) {
                            echo "<div class=\"btn-group\" role=\"group\">
                                    <button type=\"button\" class=\"btn btn-default btn-lg\" onclick=\"releaseSelectedSeats()\">
                                        <span class=\"glyphicon glyphicon-minus\" aria-hidden=\"true\"></span> Release
                                    </button>
                                  </div>";
                        }
                        ?>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default btn-lg" onclick="bookSelectedSeats()">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Book
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-8" id="theater-seats-panel">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Theater seats</h3>
                </div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div id="theater-map"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script type="text/javascript">
        if (navigator.cookieEnabled  == true) {
            var cols = "<?php print(COLUMNS) ?>";
            var rows = "<?php print(ROWS) ?>";

            initTheaterMap(cols, rows);

            var non_user_seats = <?php echo format_as_json($non_user_taken_seats); ?>;
            if (non_user_seats.length > 0)
                setTakenSeats(non_user_seats);

            var user_seats = <?php echo format_as_json($user_taken_seats); ?>;
            if (user_seats.length > 0)
                setBookedSeats(user_seats);

            setToBookSeats();
        }
        else{
            // preventing site usage
            removeElementById("theater-seats-panel");
            removeElementById("booking-details-panel");
            removeElementById("session-details-panel");
            printCookieDisabledMessage();
        }
    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="bootstrap/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>