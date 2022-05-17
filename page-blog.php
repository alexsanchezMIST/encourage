<?php

$context = Timber::context();

global $paged;
if (!isset($paged) || $paged) {
    $paged = 1;
}

$args = array(
    'post_type' => 'post',
    'orderby' => 'ID',
    'order' => 'DESC',
    'posts_per_page' => '9',
    'post_status' => 'publish',
    'perm' => 'readable',
    'paged' => $paged
);

$context['posts'] = new Timber\PostQuery($args);

$context['categories'] = get_terms(array('taxonomy' => 'category'));
$context['tags'] = get_terms(array('taxonomy' => 'post_tag'));

$timber_post = new Timber\Post();
$context['post'] = $timber_post;

Timber::render( array( 'pages/' . $timber_post->post_name . '.twig', 'page.twig' ), $context );

?>