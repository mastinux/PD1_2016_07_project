<?php include 'settings.php' ?>
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

    <div class="col-lg-8">
        <div id="theater-map"></div>
    </div>
    <div class="col-lg-4">
        <div id="booking-panel">

        </div>
    </div>

    <script type="text/javascript">
        var base = "<?php print(base) ?>";
        var height = "<?php print(height) ?>";

        initTheaterMap(base, height);
    </script>
    <noscript>
        Sorry: Your browser does not support or has disabled javascript
    </noscript>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>