<?php
/*
Plugin Name:MST Child Sponsorship 
Description: This is a custom plugin for managing child sponsorships.
Version: 2.1
Author: Mycosoft Technologies (+256(0) 750 501151)
*/

// Function to display content in the admin dashboard
function custom_plugin_content() {
    include(plugin_dir_path(__FILE__) . 'mst_dashboard.php');
}

// Activation hook to create the database table
function custom_plugin_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'children';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        age int NOT NULL,
        image varchar(255) NOT NULL,
        biography text,
        location varchar(255),
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    $page_exists = get_page_by_title('Sponser Form');

    if (!$page_exists) {
        $page = array(
            'post_title' => 'Sponser Form',
            'post_content' => '[sponser_child_form]',
            'post_status' => 'publish',
            'post_type' => 'page',
        );

        // Insert the page into the database
        wp_insert_post($page);
    }

    $upload_dir = wp_upload_dir();
    $targetDir = $upload_dir['basedir'] . '/child_images/';

    // Check if the directory already exists
    if (!file_exists($targetDir)) {
        // Create the directory
        wp_mkdir_p($targetDir);
    }
}

// Hook to activate the plugin
register_activation_hook(__FILE__, 'custom_plugin_activate');

function add_custom_menu_item() {
    add_menu_page(
        'MST Child Sponsorship',   // Page title
        'MST Child Sponsorship',   // Menu title
        'manage_options',          // Capability required to access the menu
        'sponsorship_dashboard',   // Menu slug
        'custom_plugin_content',   // Callback function to display content
        'dashicons-star-half',     // Icon for the menu item
        30                         // Menu position
    );

    // Add a submenu item for the Add Child page
    add_submenu_page(
        'sponsorship_dashboard',   // Parent slug
        'Add Child',               // Page title
        'Add Child',               // Menu title
        'manage_options',          // Capability required to access the menu
        'add_child',               // Menu slug
        'custom_add_child_page'    // Callback function to display content
    );

    add_submenu_page(
        'sponsorship_dashboard',   // Parent slug
        'Edit Child',               // Page title
        'Edit Child',               // Menu title
        'manage_options',          // Capability required to access the menu
        'edit_child',               // Menu slug
        'custom_edit_child_page'    // Callback function to display content
    );

    add_submenu_page(
        'sponsorship_dashboard',   // Parent slug
        'Delete Child',               // Page title
        'Delete Child',               // Menu title
        'manage_options',          // Capability required to access the menu
        'delete_child',               // Menu slug
        'custom_delete_child_page'    // Callback function to display content
    );
}


// Hook to add the menu item
add_action('admin_menu', 'add_custom_menu_item');

function custom_add_child_page() {
    // Include the content for the Add Child page
    include(plugin_dir_path(__FILE__) . 'mst_add_child.php');
}

function custom_edit_child_page() {
    // Include the content for the Add Child page
    include(plugin_dir_path(__FILE__) . 'mst_edit_child.php');
}

function custom_delete_child_page() {
    // Include the content for the Add Child page
    include(plugin_dir_path(__FILE__) . 'mst_delete_child.php');
}

function custom_sponser_child_page() {
    // Include the content for the Add Child page
    include(plugin_dir_path(__FILE__) . 'sponser_form.php');
}

// Function to display the child list on the website
function child_list_shortcode() {
    ob_start(); // Start output buffering

    // Include the child list page
    include(plugin_dir_path(__FILE__) . 'mst_child_list.php');

    return ob_get_clean(); // Return the buffered content
}

// Register the shortcode
add_shortcode('mst_child_list', 'child_list_shortcode');

// Function to display the child list on the website
function sponser_child_shortcode() {
    ob_start(); // Start output buffering

    // Include the child list page
    include(plugin_dir_path(__FILE__) . 'sponser_form.php');

    return ob_get_clean(); // Return the buffered content
}

// Register the shortcode
add_shortcode('sponser_child_form', 'sponser_child_shortcode');
