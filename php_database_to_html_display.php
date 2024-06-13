<?php
// Include the database connection script
require('connection.php');

// SQL query to select user details from the 'user_day2' table, ordered by 'user_id'
$q = "SELECT user_id, user_name, full_name, email, picture FROM user_day2 ORDER BY user_id";
$res = mysqli_query($con, $q); // Execute the SQL query and store the result in $res
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"> <!-- Link to Bootstrap CSS -->
    <script src="assets/js/jquery.js"></script> <!-- Link to jQuery -->
    <script src="assets/js/bootstrap.bundle.js"></script> <!-- Link to Bootstrap JS bundle -->
</head>
<body>
    <!-- Table to display user details -->
    <table class="table table-bordered">
        <tr>
            <th>User Id</th>
            <th>User Name</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Profile Picture</th>
        </tr>
    <?php
    // Check if there are any rows returned from the query
    if (mysqli_num_rows($res) > 0) { 
        // Fetch each row as an associative array and display it in the table
        while ($arr = mysqli_fetch_assoc($res)) {
    ?>
        <tr>
            <td><?php echo $arr['user_id']; ?></td> <!-- Display user ID -->
            <td><?php echo $arr['user_name']; ?></td> <!-- Display user name -->
            <td><?php echo $arr['full_name']; ?></td> <!-- Display full name -->
            <td><?php echo $arr['email']; ?></td> <!-- Display email -->
            <td><img src="assets/img/<?php echo $arr['picture']; ?>" style="height:80px"></td> <!-- Display profile picture -->
        </tr>
    <?php
        }
    }        
    ?>
    </table>
</body>
</html>
