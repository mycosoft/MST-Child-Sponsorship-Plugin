<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add Child - MST Child Sponsorship</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .center-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80vh;
        }

        .custom-card {
            max-width: 900px;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php 
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
                    // echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        
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

    <div class="center-container">
        <div class="card bg-light custom-card">
            <div class="card-body">
                <h2 class="card-title text-center">Add a New Child</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Age:</label>
                        <input type="number" class="form-control" id="age" name="age" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/jpeg, image/png" required>
                    </div>
                    <!-- New Biography Field -->
                    <div class="form-group">
                        <label for="biography">Biography:</label>
                        <textarea class="form-control" id="biography" name="biography" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add Child</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
