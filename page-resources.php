<?php

$args = array(
    'post_type' => 'resources',
    'post_status' => 'publish',
    'perm' => 'readable'
);

$context = Timber::context();
$context['posts'] = new Timber\PostQuery($args);

Timber::render( 'pages/resources.twig', $context );

?>