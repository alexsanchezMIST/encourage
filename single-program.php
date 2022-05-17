<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();
$timber_post = new Timber\Post();
$context['post'] = $timber_post;

$query = array(
    'post_type' => 'program',
    'post_status' => 'publish',
);

$args = array(
    'post_type' => 'class',
    'post_status' => 'publish',
);

$vars = array(
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'orderby' => 'rand',
);

$context['programs'] = new Timber\PostQuery($query);
$context['classes'] = new Timber\PostQuery($args);
$context['testimonials'] = new Timber\PostQuery($vars);

Timber::render(array ( 
    'posts/' . $timber_post->ID . '.twig',
    'posts/' . $timber_post->post_type . '.twig',
    'posts/' . $timber_post->slug . '.twig',
    'single.twig' ),
    $context );
