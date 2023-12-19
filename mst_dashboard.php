<?php
// Query to get the total number of children
global $wpdb;
$table_name = $wpdb->prefix . 'children';
$totalChildrenQuery = "SELECT COUNT(id) as totalChildren FROM $table_name";
$totalChildrenResult = $wpdb->get_row($totalChildrenQuery);

// Check if the query was successful
if ($totalChildrenResult) {
    $totalChildren = $totalChildrenResult->totalChildren;
} else {
    // Handle the error (you can customize this part)
    $totalChildren = "N/A";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Dashboard</title>
</head>

<body class="bg-success">

    <div class="container mt-5">
        <h2 class="text-center mb-4">Dashboard</h2>
        <div class="alert alert-success" role="alert">
            To Embed The Child List On You Page Use Short Code "[mst_child_list]"
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-success"><?php echo $totalChildren; ?></h3>
                                <p class="mb-0">Total Children</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-child text-success fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-success">3</h3>
                                <p class="mb-0">Total Sponsors</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users text-success fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-success">$310</h3>
                                <p class="mb-0">Amount Collected</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-money-bill-alt text-success fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Children</h5>
                        <p class="card-text">Add children to the database.</p>
                        <a href="admin.php?page=add_child" class="btn btn-primary">Add Child</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Children</h5>
                        <p class="card-text">View and update child information.</p>
                        <a href="admin.php?page=edit_child" class="btn btn-primary">Edit Children</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Delete Children</h5>
                        <p class="card-text">Remove children from the database.</p>
                        <a href="admin.php?page=delete_child" class="btn btn-primary">Delete child</a>
                    </div>
                </div>
            </div>

            

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
