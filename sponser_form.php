<?php
/*
Template Name: Sponsorship Form Page
*/

get_header();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
    <title>Sponsor Form</title>

    <script>
        function redirectToPayPal(childName, childId) {
            // Perform client-side validation
            if (validateForm()) {
                // Specify your PayPal business email
                var paypalBusinessEmail = 'info@castdeepf.org';

                // Define the PayPal donation URL with the required parameters
                var paypalURL = 'https://www.paypal.com/donate?business=' + encodeURIComponent(paypalBusinessEmail) + '&item_name=' + encodeURIComponent(childName) + '&item_number=' + childId + '&amount=' + encodeURIComponent(document.getElementById('customAmount').value);

                // Open a new window with the PayPal donation URL
                window.open(paypalURL, '_blank');
            }
        }

        function validateForm() {
            // Validate the form before proceeding
            var isValid = true;

            // Validate Contact Information
            var firstName = document.getElementById('firstName').value.trim();
            var lastName = document.getElementById('lastName').value.trim();
            var email = document.getElementById('email').value.trim();

            if (firstName === '' || lastName === '' || email === '') {
                alert('Please fill in all contact information fields.');
                isValid = false;
            }

            // Add additional validations for Mailing Address if needed

            return isValid;
        }
    </script>
</head>

<div class="container">
    <h4 class="text-center mb-4">Thank you for choosing to sponsor</h4>
    <!-- Child Information Card -->
    <div class="card mb-4 text-center col-md-10 mx-auto "> <!-- Adjusted width -->
        <div class="card-body text-center">
            <?php
            // Retrieve the selected child's name from the query parameter
            $selectedChildName = htmlspecialchars($_GET['childName']);

            global $wpdb;
            $table_name = $wpdb->prefix . 'children';
            $selected_child = $wpdb->get_row($wpdb->prepare("SELECT image FROM $table_name WHERE name = %s", $selectedChildName));

            if ($selected_child) {
                $imageFilename = $selected_child->image;

                // Construct the image URL using WordPress functions
                $image_url = wp_get_upload_dir()['baseurl'] . '/child_images/' . basename($imageFilename);

                // Display circular image with the selected child's name below and centered
                echo '
                <div class="d-flex flex-column align-items-center">
                    <div class="mb-3">
                        <img src="' . esc_url($image_url) . '" class="rounded-circle" alt="Child Image" width="200" height="200">
                    </div>
                    <div>
                        <h4 style="font-size: 28px; color: green;">' . $selectedChildName . '</h4>
                    </div>
                </div>';
            } else {
                echo "Child not found.";
            }
            ?>

            <div class="card-body text-center">
                <!-- Text with increased font size -->
                <p class="card-text" style="font-size: 25px;">Child Sponsorship Plan</p>

                <!-- Custom amount input, label, and button on the same line -->
                <div class="form-inline mb-2">
                    <div class="input-group mr-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" name="customAmount" id="customAmount" placeholder="Custom amount" oninput="selectCustomAmount()">
                    </div>

                    <!-- Button with increased size -->
                    <button type="button" class="btn btn-outline-primary btn-lg" onclick="selectPredefinedAmount(40)"> $40 Monthly</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information Form -->
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">CONTACT INFORMATION</h4>
                    <form>
                        <!-- Child Information -->
                        <div class="form-group">
                            <label for="childPicked">Child Picked</label>
                            <input type="text" class="form-control" id="childPicked" value="<?php echo htmlspecialchars($_GET['childName']); ?>" readonly>
                        </div>
                        <!-- Contact Information -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">First Name*</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastName">Last Name*</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address*</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="tel" class="form-control" id="phoneNumber">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mailing Address Form -->
    <div class="row mt-4">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">MAILING ADDRESS</h4>
                    <form>
                        <!-- Mailing Address fields here -->
                        <div class="form-group">
                            <label for="country">Country*</label>
                            <select class="form-control" id="country" required>
                                <option value="uganda">Uganda</option>
                                <option value="kenya">Kenya</option>
                                <option value="tanzania">Tanzania</option>
                                <option value="burundi">Burundi</option>
                                <option value="rwanda">Rwanda</option>
                                <option value="usa">United States</option>
                                <!-- Add more countries as needed -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="street">Street Address*</label>
                            <input type="text" class="form-control" id="street" required>
                        </div>
                        <div class="form-group">
                            <label for="city">City*</label>
                            <input type="text" class="form-control" id="city" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="state">State*</label>
                                <input type="text" class="form-control" id="state" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="zip">ZIP Code*</label>
                                <input type="text" class="form-control" id="zip" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Continue Payment Button -->
    <div class="row mt-4">
        <div class="col-md-10 mx-auto">
            <button type="button" class="btn btn-primary btn-block mb-5" onclick="redirectToPayPal('<?php echo esc_js($selectedChildName); ?>', <?php echo esc_js($_GET['childId']); ?>)">Continue Payment</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
