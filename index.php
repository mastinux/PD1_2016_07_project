<?php
    include 'global_functions.php';
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
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
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
    </noscript>

    <?php manage_messages(); ?>

    <div class="row col-lg-12">

        <div class="col-lg-4" id="booking-details-panel">
            <div id="booking-panel" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Booking details</h3>
                </div>

                <div class="panel-body">
                    Selected seats :
                        <span id="selected-seats" class="label selected">
                            0
                        </span>
                    <br>
                    Free seats :
                        <span id="free-seats" class="label free">
                            <?php echo ROWS*COLUMNS; ?>
                        </span><br>
                    Total seats :
                        <span id="total-seats" class="label label-primary">
                            <?php echo ROWS*COLUMNS; ?>
                        </span><br>
                    Booked seats :
                        <span id="booked-seats" class="label booked">
                            0
                        </span><br>
                    Taken seats :
                        <span id="taken-seats" class="label taken">
                            0
                        </span><br>
                    <br>
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" onclick="clearToBookSeats()">Clear</button>
                        </div>
                        <?php
                        if ($username) {
                            echo "<div class=\"btn-group\" role=\"group\">
                                        <button type=\"button\" class=\"btn btn-default\" onclick=\"releaseSelectedSeats()\">
                                            Release
                                        </button>
                                      </div>";
                        }
                        ?>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" onclick="bookSeats()">Book</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8" id="theater-seats-panel">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Theater seats</div>
                <div class="panel-body">
                    <div class="col-lg-12">
                        <div id="theater-map"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">

        var cols = "<?php print(COLUMNS) ?>";
        var rows = "<?php print(ROWS) ?>";
        
        initTheaterMap(cols, rows);

        var non_user_seats = <?php echo format_as_json(get_non_user_taken_seat($username)); ?>;
        setTakenSeats(non_user_seats);
        var user_seats = <?php echo format_as_json(get_user_taken_seat($username)); ?>;
        setBookedSeats(user_seats);
        
        setToBookSeats();

        if (navigator.cookieEnabled == false){
            // preventing site usage
            removeElementById("navbar-buttons-list");
            removeElementById("theater-seats-panel");
            removeElementById("booking-details-panel");
            printCookieDisabledMessage();
        }

    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>