<?php
/**
 * Plugin Name: Background Color Changer
 * Plugin URI: https://wordpress.org/plugins/background-color-changer/
 * Description: This is a simple plugin to change the background color, text color, and heading color.
 * Version: 1.0.1
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Stable tag: 1.0.1
 * Author: Deboraj Datta
 * Author URI: https://www.buymeacoffee.com/raj009
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: bcc
 */

// Add custom class to body element
function bcc_activate_plugin() {
    // Add the custom class to the body element
    add_filter('body_class', 'bcc_add_custom_body_class');
}

function bcc_add_custom_body_class($classes) {
    $classes[] = 'bcc-custom-background';
    return $classes;
}

register_activation_hook(__FILE__, 'bcc_activate_plugin');

function bcc_customize_register($wp_customize) {
    // Add a section for background customization
    $wp_customize->add_section('bcc_background', array(
        'title' => __('Background Customization', 'bcc'),
        'priority' => 30,
    ));

    // Background Color Setting
    $wp_customize->add_setting('bcc_background_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Background Color Control
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bcc_background_color', array(
        'label' => __('Background Color', 'bcc'),
        'section' => 'bcc_background',
        'settings' => 'bcc_background_color',
    )));

    // Text Color Setting
    $wp_customize->add_setting('bcc_text_color', array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Text Color Control
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bcc_text_color', array(
        'label' => __('Text Color', 'bcc'),
        'section' => 'bcc_background',
        'settings' => 'bcc_text_color',
    )));

    // Heading Color Setting
    $wp_customize->add_setting('bcc_heading_color', array(
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    // Heading Color Control
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bcc_heading_color', array(
        'label' => __('Heading Color', 'bcc'),
        'section' => 'bcc_background',
        'settings' => 'bcc_heading_color',
    )));
}

add_action('customize_register', 'bcc_customize_register');

function bcc_apply_background_color() {
    $background_color = get_theme_mod('bcc_background_color', '#ffffff');
    $text_color = get_theme_mod('bcc_text_color', '#000000');
    $heading_color = get_theme_mod('bcc_heading_color', '#333333');

    echo '<style>';
    echo 'body:not(.bcc-custom-background) {';
    echo 'background-color: ' . esc_attr($background_color) . ';';
    echo 'color: ' . esc_attr($text_color) . ';';
    echo '}';
    echo 'h1, h2, h3, h4, h5, h6 {';
    echo 'color: ' . esc_attr($heading_color) . ';';
    echo '}';
    echo '</style>';
}

add_action('wp_head', 'bcc_apply_background_color');
?>