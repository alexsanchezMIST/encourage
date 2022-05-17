<?php

$args = array(
    'post_type' => 'program',
    'post_status' => 'publish',
    'perm' => 'readable',
    'nopaging' => true,
    'meta_key' => 'weight',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
);

$query = array(
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'orderby' => 'rand',
);


$context = Timber::context();
$context['posts'] = new Timber\PostQuery($args);
$context['testimonials'] = new Timber\PostQuery($query);

$timber_post = new Timber\Post();
$context['post'] = $timber_post;

Timber::render(array ( 'pages/' . $timber_post->post_name . '.twig', 'page.twig' ), $context );

?>