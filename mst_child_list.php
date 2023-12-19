<?php
/*
Template Name: Child List Page
*/

get_header(); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
        /* Custom CSS for modal header and footer with gradient border lines */
        .modal-header {
            border-bottom: 6px solid;
            border-image: linear-gradient(to right, yellow, green, lightgreen, blue);
            border-image-slice: 1;
        }

        .modal-footer {
            border-top: 6px solid;
            border-image: linear-gradient(to right, yellow, green, lightgreen, blue);
            border-image-slice: 1;
        }

        /* Circular mask for images in modal header */
        .modal-header img {
            border-radius: 50%;
            border: 2px solid white;
            width: 95px; /* Adjust size as needed */
            height: 95px; /* Adjust size as needed */
        }

        /* Increase the size of the modal */
        .modal-content {
            width: 100%;
            margin: auto;
        }
	.modal-backdrop{
		z-index:0!important;
	}
</style>
   
        <div class="container">
            <!-- <h2 class="text-center mb-5">Children List</h2> -->
            <div class="row">
                <?php
                global $wpdb;
                $table_name = $wpdb->prefix . 'children';
                $children = $wpdb->get_results("SELECT id, name, age, image, biography, location FROM $table_name");

                if ($children) {
                    foreach ($children as $child) {
                        $im = explode('/', $child->image);
                        $imgg = end($im);
                        $image_url = site_url('/wp-content/uploads/child_images/' . $imgg);

                        ?>
                        <div class="col-md-3 mb-4">
                            <div class="card text-center">
                                <img src="<?php echo esc_url($image_url); ?>" class="card-img-top rounded-circle mx-auto" alt="<?php echo esc_attr($child->name); ?>" style="width: 220px; height: 220px; position: relative; top: -20px;">


                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <h5 class="card-title font-weight-bold"><?php echo esc_html($child->name); ?></h5>
                                    <p class="card-text">Age: <?php echo esc_html($child->age); ?> years</p>
                                    <a href="#" data-toggle="modal" data-target="#biographyModal<?php echo esc_attr($child->id); ?>">Brief Story</a>

                                    <!-- Biography Modal -->
                                    <div class="modal fade remove-backdrop" id="biographyModal<?php echo esc_attr($child->id); ?>" tabindex="-1" role="dialog" aria-labelledby="biographyModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <img src="<?php echo esc_url($image_url); ?>">
                                                    <div class="text-center"><br>
                                                        <h5 class="modal-title ml-3"><?php echo esc_html($child->name); ?></h5>
                                                        <p class="text-center text-success">Location: <?php echo esc_html($child->location); ?></p>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><?php echo esc_html($child->biography); ?></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="mx-auto">
                                                        <button class="btn btn-primary" onclick="openSponsorForm('<?php echo esc_js($child->name); ?>', <?php echo esc_js($child->id); ?>)">Sponsor</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary mt-4" onclick="openSponsorForm('<?php echo esc_js($child->name); ?>', <?php echo esc_js($child->id); ?>)">Sponsor</button>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No records found</p>";
                }
                ?>
            </div>
        </div>
    
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function openSponsorForm(childName, childId) {
        // Redirect to the WordPress page with the form
        window.location.href = '<?php echo esc_url(home_url('/sponser-form')); ?>?childName=' + encodeURIComponent(childName) + '&childId=' + childId;
    }
</script>








