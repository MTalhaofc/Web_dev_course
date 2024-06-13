<?php
    require('connection.php');

    if(isset($_POST['uname']))
    {
    $uname=$_POST['uname'];
    $pass=$_POST['pass'];


    $q="insert into users (users,password) values ('$uname','$pass')";
    $r= mysqli_query($con,$q);
    if($r==1)
        echo "User Registered";
    else
        echo "Registration Failed";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="signup.php" method="post">
        <input type="text" name="uname" id="" placeholder="User Name">
        <input type="password" name="pass" id="">
        <input type="submit" name="signup" value="Signup">
    </form>
    
</body>
</html>

