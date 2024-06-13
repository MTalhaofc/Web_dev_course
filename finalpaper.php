<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#signupForm').submit(function(event) {
                // Regular expressions for validation
                const nameRegex = /^[a-zA-Z\s]+$/;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const contactRegex = /^\d{10}$/;
                const dobRegex = /^\d{4}-\d{2}-\d{2}$/; // yyyy-mm-dd format

                let valid = true;
                let errorMessage = '';

                // Validate name
                if (!nameRegex.test($('#name').val())) {
                    valid = false;
                    errorMessage += 'Invalid name. Only letters and spaces are allowed.\n';
                }

                // Validate email
                if (!emailRegex.test($('#email').val())) {
                    valid = false;
                    errorMessage += 'Invalid email address.\n';
                }

                // Validate contact
                if (!contactRegex.test($('#contact').val())) {
                    valid = false;
                    errorMessage += 'Invalid contact number. It must be 10 digits.\n';
                }

                // Validate date of birth
                if (!dobRegex.test($('#dob').val())) {
                    valid = false;
                    errorMessage += 'Invalid date of birth. Use yyyy-mm-dd format.\n';
                }

                // If any field is invalid, prevent form submission and show error messages
                if (!valid) {
                    alert(errorMessage);
                    event.preventDefault();
                }
            });
        });
    </script>
</head>

    <form id="signupForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="contact">Contact Number:</label>
        <input type="text" id="contact" name="contact" required><br>

        <label for="dob">Date of Birth (yyyy-mm-dd):</label>
        <input type="date" id="dob" name="dob" required><br>

        <input type="submit" value="Signup">
    </form>





    <?php
// Database connection parameters
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'test';

// Create connection
$con = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Retrieve query parameter 'q' from GET request
if (isset($_GET['q'])) {
    $query = $_GET['q'];

    // SQL query to search for countries
    $sql = "SELECT country_name FROM countries WHERE country_name LIKE '%$query%'";
    
    // Execute the query
    $result = $con->query($sql);

    // Check if any results were returned
    if ($result->num_rows > 0) {
        // Output matches as list items
        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li>' . htmlspecialchars($row['country_name']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No matches found.';
    }

    // Close the connection
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Search</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle search
            function searchCountries(query) {
                $.ajax({
                    url: 'search_countries.php', // PHP script that handles the search
                    type: 'GET',
                    data: { q: query }, // Data to send to the server
                    success: function(response) {
                        $('#results').html(response); // Update results div with response
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            }

            // Event listener for keyup event on search input
            $('#searchInput').on('keyup', function() {
                var query = $(this).val().trim(); // Get input value and trim whitespace
                if (query.length > 0) {
                    searchCountries(query); // Call search function with query
                } else {
                    $('#results').html(''); // Clear results if search input is empty
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Country Search</h1>
        <input type="text" id="searchInput" placeholder="Search for a country...">
        <div id="results" class="mt-3"></div> <!-- Container to display search results -->
    </div>
</body>
</html>






















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country Search</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to handle search
            function searchCountries(query) {
                $.ajax({
                    url: '<?php echo $_SERVER["PHP_SELF"]; ?>', // Self-referencing URL for AJAX
                    type: 'GET',
                    data: { q: query }, // Data to send to the server
                    success: function(response) {
                        $('#results').html(response); // Update results div with response
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            }

            // Event listener for keyup event on search input
            $('#searchInput').on('keyup', function() {
                var query = $(this).val().trim(); // Get input value and trim whitespace
                if (query.length > 0) {
                    searchCountries(query); // Call search function with query
                } else {
                    $('#results').html(''); // Clear results if search input is empty
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Country Search</h1>
        <input type="text" id="searchInput" placeholder="Search for a country...">
        <div id="results" class="mt-3"></div> <!-- Container to display search results -->
    </div>

    <?php
    // Database connection parameters
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbname = 'test';

    // Create connection
    $con = new mysqli($host, $user, $password, $dbname);

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Retrieve query parameter 'q' from GET request
    if (isset($_GET['q'])) {
        $query = $_GET['q'];

        // SQL query to search for countries
        $sql = "SELECT country_name FROM countries WHERE country_name LIKE '%$query%'";

        // Execute the query
        $result = $con->query($sql);

        // Check if any results were returned
        if ($result->num_rows > 0) {
            // Output matches as list items
            echo '<ul>';
            while ($row = $result->fetch_assoc()) {
                echo '<li>' . htmlspecialchars($row['country_name']) . '</li>';
            }
            echo '</ul>';
        } else {
            echo 'No matches found.';
        }

        // Close the connection
        $con->close();
    }
    ?>
</body>
</html>
