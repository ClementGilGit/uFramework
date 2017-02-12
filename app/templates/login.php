<?php
/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 07/02/2017
 * Time: 14:02
 */
include 'header.php';

?>
<div class="container">
<div class="row">
    <h1>Logging Page</h1>
</div>
<br/>
<br/>
</div>
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please sign in</h3>
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" role="form" action="/login" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="login" name="login" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                        </fieldset>
                    </form>
                    <?php
                    if (isset($parameters['error']) && !empty($parameters['error']!="")) {
                    ?>
                    <br/>
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?php echo $parameters['error'] ?>
                    </div>
                    <?php
                    }
                    ?>
                    <hr>
                    <a href="/register" style="text-decoration: none;">Register</a>
                    <hr>
                    <a href="/statuses"><button>Continue offline</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php';?>