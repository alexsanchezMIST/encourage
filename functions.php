<?php

$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

Timber::$dirname = array( 'templates', 'views' );

Timber::$autoescape = false;

class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'acf/init', [$this, 'my_acf_init'] );
		parent::__construct();
	}

	public function my_acf_init() {
		if ( ! function_exists( 'acf_register_block' ) ) {
			return;
		}

		$hero = [
			'name' => 'hero_block',
			'title' => __('Hero'),
			'description' => __('A custom hero block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('hero', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$hero_alt = [
			'name' => 'hero_alt_block',
			'title' => __('Hero Alt'),
			'description' => __('A custom hero block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('hero', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$content = [
			'name' => 'content_block',
			'title' => __('Content'),
			'description' => __('A custom content block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$download = [
			'name' => 'download_block',
			'title' => __('Download'),
			'description' => __('A custom download block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('download', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$callout = [
			'name' => 'callout_block',
			'title' => __('Callout'),
			'description' => __('A custom callout block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('callout', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$testimonials = [
			'name' => 'testimonial_block',
			'title' => __('Testimonials'),
			'description' => __('A custom testimonial carousel block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('testimonial', 'carousel', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$optin = [
			'name' => 'optin_block',
			'title' => __('Optin'),
			'description' => __('A custom optin block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('optin', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$image = [
			'name' => 'image_block',
			'title' => __('Image'),
			'description' => __('A custom image block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('image', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$cards = [
			'name' => 'cards_block',
			'title' => __('Cards'),
			'description' => __('A custom cards block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('cards', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$columns = [
			'name' => 'columns_block',
			'title' => __('Columns'),
			'description' => __('A custom columns block.'),
			'render_callback' => [$this, 'my_acf_block_render_callback'],
			'category' => 'formatting',
			'icon' => 'superhero-alt',
			'keywords' => array('columns', 'content'),
			'mode' => 'edit',
			'supports' => array('mode' => false),
		];

		$blocks = [
			$hero,
			$hero_alt,
			$content,
			$download,
			$callout,
			$testimonials,
			$optin,
			$image,
			$cards,
			$columns,
		];

		foreach ($blocks as $block) {
			acf_register_block_type($block);
		}

	}

	public function my_acf_block_render_callback( $block, $content = '', $is_preview = false ) {

		$context = Timber::context();
		$context['block'] = $block;
		$context['fields'] = get_fields();
		$context['is_preview'] = $is_preview;

		Timber::render('blocks/' .strtolower($block['title']) . 'twig', $context );

	}

	public function register_post_types() {

	}

	public function register_taxonomies() {

	}

	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = new Timber\Menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

}

new StarterSite();
