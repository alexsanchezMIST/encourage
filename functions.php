<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */

$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
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

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
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

	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = new Timber\Menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
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

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();
