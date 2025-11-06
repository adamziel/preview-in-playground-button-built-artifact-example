<?php
/*
Plugin Name: Built Artifact Demo Plugin
Description: A demo WordPress plugin that demonstrates the Preview in Playground button with build artifacts
Version: 1.0.0
Author: Automattic
Text Domain: built-artifact-demo
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add admin notice to show this is the built version
add_action( 'admin_notices', function() {
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p><strong>Built Artifact Demo Plugin is active!</strong></p>';
    echo '<p>This plugin was built from source code and deployed via a GitHub Actions artifact.</p>';
    echo '<p>Build timestamp: <code>' . esc_html( BUILT_ARTIFACT_DEMO_BUILD_TIME ) . '</code></p>';
    echo '</div>';
} );

// Add a simple meta box to demonstrate functionality
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'built_artifact_demo',
        'Built Artifact Demo',
        function( $post ) {
            echo '<p>This is a demo plugin built from source code.</p>';
            echo '<p>Build version: <strong>' . esc_html( BUILT_ARTIFACT_DEMO_VERSION ) . '</strong></p>';
            echo '<p>Your post ID is: <strong>' . esc_html( $post->ID ) . '</strong></p>';
        },
        'post',
        'side'
    );
} );

// Add some JavaScript to the head
add_action( 'wp_head', function() {
    echo '<script>';
    echo 'console.log("Built Artifact Demo Plugin loaded!");';
    echo 'console.log("Version: ' . esc_js( BUILT_ARTIFACT_DEMO_VERSION ) . '");';
    echo 'console.log("Build time: ' . esc_js( BUILT_ARTIFACT_DEMO_BUILD_TIME ) . '");';
    echo '</script>';
} );
