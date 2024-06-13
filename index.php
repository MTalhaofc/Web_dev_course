<?php
session_start(); // Start the PHP session to manage session variables
require('connection.php'); // Include the database connection script

// SQL query to select user details from the 'user_day3' table, ordered by 'user_id'
$q = "SELECT user_id, user_name, full_name, email, picture FROM user_day3 ORDER BY user_id"; 
$res = mysqli_query($con, $q); // Execute the SQL query and store the result in $res

// Generate a CSRF token if it doesn't already exist in the session
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a new CSRF token and store it in the session
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List and File Upload</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"> <!-- Link to Bootstrap CSS -->
    <script src="assets/js/jquery.js"></script> <!-- Link to jQuery -->
    <script src="assets/js/bootstrap.bundle.js"></script> <!-- Link to Bootstrap JS bundle -->
    <script>
        // JavaScript function to validate the file upload form
        function validateForm() {
            const fileInput = document.getElementById('file'); // Get the file input element
            const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i; // Define allowed file extensions
            const maxSize = 2 * 1024 * 1024; // 2 MB

            // Check if the file extension is valid
            if (!allowedExtensions.exec(fileInput.value)) {
                alert('Invalid file type. Only JPG, JPEG, PNG, and PDF files are allowed.'); // Show an alert if the file type is invalid
                fileInput.value = ''; // Clear the file input
                return false; // Prevent form submission
            }

            // Check if the file size exceeds the maximum limit
            if (fileInput.files[0].size > maxSize) {
                alert('File size exceeds 2 MB.'); // Show an alert if the file size is too large
                fileInput.value = ''; // Clear the file input
                return false; // Prevent form submission
            }

            return true; // Allow form submission if validation passes
        }
    </script>
</head>
<body>
    <!-- File upload form with CSRF protection and validation -->
    <form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- CSRF token hidden input -->
        <label for="file">Choose file to upload:</label>
        <input type="file" id="file" name="file" required> <!-- File input field -->
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" required> <!-- User ID input field -->
        <input type="submit" value="Upload"> <!-- Submit button -->
    </form>

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
            <td><img src="uploads/<?php echo $arr['picture'] ?>" style="height:80px"></td> <!-- Display profile picture -->
        </tr>
    <?php
        }
    }        
    ?>
    </table>
</body>
</html>
 