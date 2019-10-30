<?php
    //connect to database
 $connect = mysqli_connect('localhost', 'ryan', 'test1234', 'bets');
    //check connection
if (!$connect) {
    echo 'Connection Error: ' . mysqli_connect_error();
}

?>