<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/2016_07_project">Theater Booker</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


            <ul class="nav navbar-nav navbar-right">
                <?php
                    if ( $username = user_logged_in() ) {
                        echo "
                                  <li>
                                        <p class=\"navbar-text\">Signed in as ".$username."</p>                              
                                  </li>
                                    <a href=\"auth_logout.php\">
                                        <button type=\"button\" class=\"btn btn-default navbar-btn\">
                                            <span class=\"glyphicon glyphicon-log-out\" aria-hidden=\"true\"> Logout</span>
                                        </button>
                                    </a>";
                    }
                    else{
                        echo "  <a href=\"auth_login.php\">
                                    <button type=\"button\" class=\"btn btn-default navbar-btn\">
                                        <span class=\"glyphicon glyphicon-log-in\" aria-hidden=\"true\"> Login</span>
                                    </button>
                                </a>";
                    }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>