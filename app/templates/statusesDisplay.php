<?php
echo '<h1>Statuses</h1>';
foreach($parameters['status'] as $status){
	echo '<h1>'.$status['id'].'</h1>';
	echo '<h2>'.$status['username'].'</h2>';
	echo '<p>'.$status['Content'].'</p>';
}
