<?php
include 'header.php';
?>
<div style="text-align: center;">
    <h1>Status</h1>
    <br>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <ul class="chat" style="list-style: none;">
                                <li class="right clearfix">
                                    <span class="pull-right">
                                    <?php
                                    if(isset($parameters['user']) && $parameters['user'] == $parameters['status']->getUsername()){
                                        echo '<form action="/statuses/'.$status->getId().'" method="POST">';
                                        echo '<input type="hidden" name="_method" value="DELETE">';
                                        echo '<input type="submit" value="Delete">';
                                        echo '</form>';
                                    }?>
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>
                                                <?php echo $status->getDate() ?></small>
                                            <strong class="pull-left primary-font">username : <?php echo $status->getUsername() ?></strong>
                                        </div>
                                        <div>
                                            <?php
                                            echo '<p>Content : '.$status->getContent().'</p>';
                                            ?>
                                        </div>
                                    </div>
                                </li>
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="/statuses"><button>Retour</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php
    if(isset($parameters['user']) && $parameters['user'] != 'Unknown user'){
        echo'<div><a href="/logout"><button>Disconnect</button></a></div>';
    }else{
        echo '<div><a href="/login"><button>Connect</button></a></div>';
    }
    ?>

</div>
<?php
include 'footer.php';
?>

