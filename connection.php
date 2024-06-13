<?php
    $server="localhost";
    $user="root";
    $pass="";
    $db_name="testing_data";

    $con=mysqli_connect($server,$user,$pass,$db_name);
    if($con)
        echo "Connected";
    else
        echo "Connection error";

?>
