<!-- navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img alt="Brand" src="assets/img/logo.png" height="40px"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
            <ul class="nav navbar-nav navbar-right">
                
                <!-- <li><a href="adminlogin.php">Admin</a></li> -->
                <li><a href="#" data-toggle="modal" data-target="#myModal">Sign Up</a></li>
            
                <li>
                    <p class="navbar-text">Already have an account?</p>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
                    <ul id="login-dp" class="dropdown-menu">
                        <li>
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <form class="form" role="form" method="POST" accept-charset="UTF-8" >
                                        <div class="form-group">
                                            <label class="sr-only" for="username">Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="User Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="login" id="login" class="btn btn-primary btn-block">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- navigation -->