<?php

// Include WordPress database class
global $wpdb;

// Function to sanitize input data
function sanitize_input($input) {
    return sanitize_text_field($input);
}

// Function to get child information by ID
function get_child_by_id($child_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'children';
    $child = $wpdb->get_row($wpdb->prepare("SELECT id, name, age, image, biography, location FROM $table_name WHERE id = %d", $child_id), ARRAY_A);
    return $child;
}

// Initialize variables
$selected_child = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selectChild'])) {
    $child_id = intval($_POST['child_id']);
    $selected_child = get_child_by_id($child_id);
}

// Update child information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $child_id = intval($_POST['child_id']);
    $name = sanitize_input($_POST['name']);
    $age = intval($_POST['age']);
    $biography = sanitize_input($_POST['biography']);
    $location = sanitize_input($_POST['location']);

    // Use $wpdb->update() for updating records in the database.
    // See: https://developer.wordpress.org/reference/classes/wpdb/#update-row
    $table_name = $wpdb->prefix . 'children';
    $wpdb->update(
        $table_name,
        array(
            'name' => $name,
            'age' => $age,
            'biography' => $biography,
            'location' => $location,
        ),
        array('id' => $child_id),
        array('%s', '%d', '%s', '%s'),
        array('%d')
    );

    // File upload handling using WordPress functions...
    if ($_FILES['image']['size'] > 0) {
        $image = $_FILES['image'];
        $image_file_name = $child_id . '_' . $image['name'];
        $upload_dir = wp_upload_dir(); // Get WordPress upload directory
        $target_dir = $upload_dir['basedir'] . '/child_images/'; // Set the target directory

        // Upload the new image
        move_uploaded_file($image['tmp_name'], $target_dir . $image_file_name);

        // Update the image filename in the database
        $wpdb->update(
            $table_name,
            array('image' => $image_file_name),
            array('id' => $child_id),
            array('%s'),
            array('%d')
        );
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Child - MST Child Sponsorship</title>
</head>

<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center mb-5 pt-4">Edit Child Information</h2>

        <!-- Child Selection Form -->
        <form action="" method="post">
            <div class="form-group">
                <label for="childSelect">Select Child:</label>
                <select class="form-control" id="childSelect" name="child_id" required>
                    <?php
                    // Fetch all children for listing
                    $table_name = $wpdb->prefix . 'children';
                    $children = $wpdb->get_results("SELECT id, name FROM $table_name", ARRAY_A);

                    foreach ($children as $child) {
                        echo '<option value="' . esc_attr($child['id']) . '">' . esc_html($child['name']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="selectChild">Select Child</button>
        </form>

        <?php if ($selected_child): ?>
            <!-- Child Edit Form -->
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="child_id" value="<?php echo esc_attr($selected_child['id']); ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo esc_attr($selected_child['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" class="form-control" id="age" name="age" value="<?php echo esc_attr($selected_child['age']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="biography">Biography:</label>
                    <textarea class="form-control" id="biography" name="biography" rows="4" required><?php echo esc_textarea($selected_child['biography']); ?></textarea>
                </div>
                <!-- Added location field -->
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo esc_attr($selected_child['location']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="image">New Image:</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <button type="submit" class="btn btn-primary" name="update">Update Information</button>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
