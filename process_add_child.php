<?php
// Include WordPress database class
global $wpdb;

// Function to sanitize input data
function sanitize_input($input) {
    return sanitize_text_field($input);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get sanitized form data
    $name = sanitize_input($_POST['name']);
    $age = intval($_POST['age']); // Ensure age is an integer
    $biography = sanitize_input($_POST['biography']);
    $location = sanitize_input($_POST['location']); // Added location field

    // File upload handling
    $upload_dir = wp_upload_dir(); // Get WordPress upload directory
    $targetDir = $upload_dir['basedir'] . '/child_images/'; // Set the target directory
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file was uploaded successfully
    if (empty($_FILES["image"]["tmp_name"])) {
        echo "Error: File not uploaded.";
        $uploadOk = 0;
    }

    // Check if file is an image (only if uploaded successfully)
    if ($uploadOk && getimagesize($_FILES["image"]["tmp_name"]) === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if ($uploadOk && file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($uploadOk && $_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if ($uploadOk && !in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Attempt to move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

            // Insert new child into the database with biography and location using prepared statement
            $table_name = $wpdb->prefix . 'children';
            $wpdb->insert(
                $table_name,
                array(
                    'name' => $name,
                    'age' => $age,
                    'image' => $targetFile,
                    'biography' => $biography,
                    'location' => $location,
                ),
                array(
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                )
            );

            echo " Child added successfully!";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!-- Rest of your HTML form goes here -->
