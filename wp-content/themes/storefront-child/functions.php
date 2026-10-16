<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('storefront-child-style', get_stylesheet_uri());
});
