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

$args = array(
    'post_type' => 'post',
    'orderby' => 'ID',
    'order' => 'DESC',
    'posts_per_page' => '2',
    'post_status' => 'publish',
    'perm' => 'readable',
    'paged' => $paged
);

$query = array(
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'orderby' => 'rand',
);

$context['posts'] =  new Timber\PostQuery($args);
$context['testimonials'] = new Timber\PostQuery($query);

$timber_post = new Timber\Post();
$context['post'] = $timber_post;

Timber::render(array ( 'pages/' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
