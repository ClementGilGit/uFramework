<?php
/**
 * Created by PhpStorm.
 * UserDB: Rémi
 * Date: 07/02/2017
 * Time: 15:00
 */
include 'header.php';
?>
<div class="container">
    <div class="row">
        <h1>Register Page</h1>
    </div>
    <br/>
    <br/>
</div>
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Create an account</h3>
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" role="form" action="/register" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label class="control-label">Login:</label>
                                <input class="form-control" placeholder="" name="login" type="text">
                            </div>
                            <?php
                                if (isset($parameters['user']) && !empty($parameters['user'])) {
                            ?>
                            <br/>
                            <div class="alert alert-danger fade in">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <strong>Error!</strong> <?php echo $parameters['user'] ?>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label">Password:</label>
                                <input class="form-control" placeholder="" name="password" type="password" value="">
                            </div>
                            <?php
                            if (isset($parameters['password']) && !empty($parameters['password'])) {
                                ?>
                                <br/>
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Error!</strong> <?php echo $parameters['password'] ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="control-label">Confirm:</label>
                                <input class="form-control" placeholder="" name="passwordCheck" type="password" value="">
                            </div>
                            <?php
                            if (isset($parameters['passwordCheck']) && !empty($parameters['passwordCheck'])) {
                                ?>
                                <br/>
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <strong>Error!</strong> <?php echo $parameters['passwordCheck'] ?>
                                </div>
                            <?php } ?>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Register">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php';?>

