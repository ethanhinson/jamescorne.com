<?php

/**
 * Implementation hooks for JamesCorne.com
 * 
 * These functions are called in header.php and footer.php of the child theme
 * This allows for easy theming without implementing tons of template files
 * 
 * - For Instance - In the functions.php file of the Child Theme - 
 * 
 * function print_foo_bar() {
 *   print '<span>Foo Bar</span>';
 * }
 * 
 * add_action('jamesc_before_container', 'print_foo_bar');
 * 
 * - This code will print Foo Bar in a span element at the top of every page.
 * add_action() also takes a 3rd, 'weight', argument which will affect
 * the order in which functions on the hook are fired.
 * 
 */

function jamesc_before_container() {
    do_action('jamesc_before_container');
}

function jamesc_begin_container() {
    do_action('jamesc_begin_container');
}

function jamesc_after_header() {
    do_action('jamesc_after_header');
}

function jamesc_before_content() {
    do_action('jamesc_before_content');
}

function jamesc_after_content() {
    do_action('jamesc_after_content');
}

function jamesc_end_container() {
    do_action('jamesc_end_container');
}

function jamesc_after_container() {
    do_action('jamesc_after_container');
}

?>
