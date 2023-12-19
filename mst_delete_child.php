<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <title>Delete Child - MST Child Sponsorship</title>
</head>

<body class="bg-light">
    <div class="container mt-4">
        <h2 class="text-center mb-2 pt-4">Delete Child</h2>

        <!-- Alert for Success Message -->
        <div id="successAlert" class="alert alert-success alert-dismissible fade" role="alert">
            <span id="successMessage"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- Card Wrapper -->
        <div class="card">
            <div class="card-body">

                <!-- Child List Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Your PHP code to fetch and display child records in the table
                        global $wpdb;

                        // Fetch and display child records
                        $table_name = $wpdb->prefix . 'children';
                        $children = $wpdb->get_results("SELECT id, name, age FROM $table_name");

                        if ($children) {
                            foreach ($children as $child) {
                                echo "<tr>
                                        <td>{$child->id}</td>
                                        <td>{$child->name}</td>
                                        <td>{$child->age}</td>
                                        <td>
                                            <form method='post'>
                                                <input type='hidden' name='child_id' value='{$child->id}'>
                                                <button type='submit' class='btn btn-link' name='delete_child'>Delete</button>
                                            </form>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

        <?php
        // Check if delete action is requested
        if (isset($_POST['delete_child'])) {
            $childId = intval($_POST['child_id']);

          
                // Delete the child from the database
                $wpdb->delete($table_name, array('id' => $childId), array('%d'));

                // Display success alert using Bootstrap
                echo '<div class="alert alert-success mt-3">Child deleted successfully! Please refresh the page to update list</div>';

                // Optionally, you can remove the alert after a few seconds
                echo '<script>
                        setTimeout(function () {
                            document.querySelector(".alert").remove();
                        }, 4000);
                      </script>';
           
        }
        ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

