<?php

$args = array(
    'post_type' => 'testimonial',
    'post_status' => 'publish',
    'orderby' => 'rand',
);

$context = Timber::context();
$context['testimonials'] = new Timber\PostQuery($args);

$timber_post = new Timber\Post();
$context['post'] = $timber_post;

Timber::render(array ( 'pages/' . $timber_post->post_name . '.twig', 'page.twig' ), $context );

?>