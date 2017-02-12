<?php
include 'header.php';
?>
<div style="text-align: center;">
<h1>Statuses</h1>
<br>
<div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                    <form class="col-md-9" action="/statuses" method="GET">
                        <label for="limit">Nombre de status:</label>
                        <input type="number" min="0" step="1" name="limit" style="color: black;">
                        <label for="orderBy">Trier par:</label>
                        <select name="orderBy" style="color: black;">
                            <option value="" selected="0">Aucun</option>
                            <option value="id">Id</option>
                            <option value="date DESC">Date old -> recent</option>
                            <option value="date ASC">Date recent -> old</option>
                            <option value="username">Username</option>
                        </select>
                        <input class="btn-default" type="submit" value="filtrer">
                    </form>
                    <a class="col-md-3" href="/statuses"><button>reset</button></a>
                </div>
                </div>
                </div>
                <div class="panel-body" id="statuses" style="background-color: lightgray;overflow-y: scroll; height: 450px;">
                    <ul class="chat" style="list-style: none;">
                        <?php
                        foreach ($parameters['status'] as $status) {
                        ?>
                        <li class="right clearfix">
                            <a href="/statuses/<?php echo $status->getId()?>"<span class="pull-right">
                            <button>Afficher</button>
                            </span></a>
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
                        <hr>
                        <?php } ?>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/statuses" method="POST">
                                <input type="hidden" name="_method" value="POST">
                                <label class="col-md-1" for="username">Username:</label>
                                <?php
                                if(isset($parameters['user']) && $parameters['user'] != 'Unknown user'){
                                    echo'<p class="col-md-2" name="username" value="">'.$parameters['user'].'</p>';
                                }else{
                                    echo'<input class="col-md-2" type="text" name="username">';
                                }
                                echo '<label class="col-md-1">Content:</label>';
                                echo '<input class="col-md-7" id="btn-input" type="text" class="form-control input-sm" 
                                             placeholder="Type your message here..." name="content"/>';
                                echo '<input class="col-md-1" type="submit" value="Tweet!">';
                                echo '</form>';
                                ?>
                        </div>
                    </div>
                </div>
            <?php
            if(isset($parameters['error']) && !empty($parameters['error'])) { ?>
                <br/>
                <div class="row">
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?php echo $parameters['error'] ?>
                    </div>
                </div>
            <?php
            }
            ?>
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
<script>
    var chat = document.getElementById('statuses');
    chat.scrollTop = chat.scrollHeight;
</script>
<?php
include 'footer.php';
?>