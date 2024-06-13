<?php
session_start(); // Start the PHP session to manage session variables
require('connection.php'); // Include the database connection script

if (empty($_SESSION['csrf_token'])) { // Check if CSRF token is empty in session
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a new CSRF token and store it in session
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if the request method is POST
    if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Check if CSRF token is empty or does not match the one stored in session
        echo "Invalid CSRF token."; // Output an error message for invalid CSRF token
        exit; // Exit the script
    }

    $maxFileSize = 2 * 1024 * 1024;  // Maximum file size allowed (2 MB)
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf']; // Array of allowed file extensions
    $uploadDir = 'uploads/'; // Directory where uploaded files will be stored

    if (!is_dir($uploadDir)) { // Check if the upload directory doesn't exist
        mkdir($uploadDir, 0777, true); // Create the upload directory recursively with full permissions
    }

    if (isset($_FILES['file'])) { // Check if a file has been uploaded
        $file = $_FILES['file']; // Assign uploaded file details to $file variable
        
        if ($file['error'] !== UPLOAD_ERR_OK) { // Check if there was an error during file upload
            echo "An error occurred during file upload."; // Output an error message for file upload error
            exit; // Exit the script
        }

        if ($file['size'] > $maxFileSize) { // Check if file size exceeds the maximum limit
            echo "File size exceeds the maximum limit of 2 MB."; // Output an error message for file size limit exceeded
            exit; // Exit the script
        }

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION); // Get the file extension
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) { // Check if file extension is not in allowed list
            echo "Invalid file type. Only JPG, JPEG, PNG, and PDF files are allowed."; // Output an error message for invalid file type
            exit; // Exit the script
        }

        $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", pathinfo($file['name'], PATHINFO_FILENAME));
        // Generate a safe filename by replacing special characters with underscores

        $filePath = $uploadDir . $fileName . '.' . $fileExtension; // Path where the file will be saved
        
        if (file_exists($filePath)) { // Check if a file with the same name already exists
            $fileName = $fileName . '_' . time(); // Append current timestamp to make filename unique
            $filePath = $uploadDir . $fileName . '.' . $fileExtension; // Update file path with new filename
        }

        if (move_uploaded_file($file['tmp_name'], $filePath)) { // Move uploaded file to the specified directory
            $userId = $_POST['user_id']; // Get user ID from POST data
            $query = "UPDATE user_day2 SET picture='$fileName.$fileExtension' WHERE user_id='$userId'";
            // SQL query to update user's picture filename in the database
            mysqli_query($con, $query); // Execute the SQL query
            echo "File uploaded successfully."; // Output success message for file upload
        } else {
            echo "Failed to upload the file."; // Output error message for failed file upload
        }
    } else {
        echo "No file uploaded."; // Output message when no file is uploaded
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image and Display</title>
</head>
<body>
    <h2>Upload Image and Display</h2>

    <!-- Form to upload an image -->
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <!-- User ID (assuming it's input as well) -->
        <input type="hidden" name="user_id" value="1"> <!-- Example user_id -->

        <!-- File input for image upload -->
        <input type="file" name="file" id="file">

        <!-- Submit button -->
        <input type="submit" value="Upload Image">
    </form>

    <hr>

    <?php
    // Check if the image has been uploaded and display it
    if (isset($_POST['csrf_token']) && isset($_POST['user_id'])) {
        // Assuming you have updated the user's picture in the database,
        // you can display the uploaded image based on the user_id
        $userId = $_POST['user_id'];
        $query = "SELECT picture FROM user_day2 WHERE user_id='$userId'";
        $result = mysqli_query($con, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $picturePath = 'uploads/' . $row['picture'];
            ?>
            <h3>Uploaded Image:</h3>
            <img src="<?php echo $picturePath; ?>" alt="Uploaded Image" style="max-width: 100%; height: auto;">
            <?php
        } else {
            echo "No image uploaded for user ID: $userId";
        }
    }
    ?>

</body>
</html>
