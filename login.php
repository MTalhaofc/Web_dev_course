<?php
 require('connection.php'); // Include the database connection script to establish a connection with the database

 if(isset($_POST['uname'])) // Check if the 'uname' key is set in the POST request (i.e., form has been submitted with 'uname' field)
 {
     $uname = $_POST['uname']; // Retrieve the value of 'uname' from the POST request and assign it to the $uname variable
     $pas = $_POST['pass']; // Retrieve the value of 'pass' from the POST request and assign it to the $pas variable
     
     $q = "select password from users where users='$uname'"; // Construct a SQL query to select the password for the provided username ($uname) from the 'users' table
     $res = mysqli_query($con, $q); // Execute the SQL query using the database connection ($con) and store the result in $res
 
     if(mysqli_num_rows($res) > 0) { // Check if the query returned any rows (i.e., the username exists in the 'users' table)
         $arr = mysqli_fetch_assoc($res); // Fetch the result row as an associative array and assign it to $arr
         $db_pass = $arr['password']; // Retrieve the 'password' value from the associative array and assign it to $db_pass
 
         if($db_pass == $pas) // Check if the password from the database ($db_pass) matches the password provided by the user ($pas)
         {
             header('location:signup.php'); // Redirect the user to 'signup.php' if the passwords match
         }
         else {
             echo "login failed"; // Output "login failed" if the passwords do not match
         }
     }
     else {
         echo "Invalid user"; // Output "Invalid user" if no rows were returned by the query (i.e., the username does not exist)
     }
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

<br>
    <br>
    <form action="" method="post">
        <input type="text" name="uname" id="" placeholder="User Name">
        <input type="password" name="pass" id="" placeholder="Password">
        <input type="submit" value="Send" name="btn">
        
    </form>    

</body>
</html>