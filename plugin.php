<?php
/**
 * Plugin Name:         [PLUGIN_NAME]
 * Version:             1.0.0
 * Plugin URI:          https://github.com/dominiccarrington/WordPress-Plugin-Template
 * Description:         [PLUGIN_DESC]
 * Author:              [PLUGIN_AUTHOR]
 * Author URI:          http://dominiccarrington.github.io
 * Requires at least:   5.5
 * Tested up to:        5.5
 * Requires PHP:        7.4
 *
 * @package WordPress
 * @author [PLUGIN_AUTHOR]
 * @copyright [YEAR] [PLUGIN_AUTHOR]
 * @since 1.0.0
 */

declare( strict_types=1 );

use Plugin\Annotations\Base;
use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'vendor/autoload.php';

AnnotationRegistry::registerLoader( 'class_exists' );

/**
 * Main Plugin Class
 *
 * @since 1.0.0
 */
final class Plugin {
	/**
	 * Static instance of the plugin
	 *
	 * @var self|null
	 */
	private static ?self $instance = null;

	public const VERSION = '1.0.0';

	/**
	 * Directory name of the plugin
	 *
	 * @var string
	 */
	public string $dirname;

	/**
	 * Controllers for different areas of the plugin.
	 * Loosely based on MVC definition of Controller
	 *
	 * @var Controller[]
	 */
	private array $controllers = [];

	/**
	 * URL for plugin assets
	 *
	 * @var string
	 */
	private string $assets_url;

	/**
	 * Plugin Constructor!
	 * Read the annotations in this file and all controllers defined
	 */
	private function __construct() {
		$this->dirname = dirname( __FILE__ );

		$reader = new CachedReader(
			new AnnotationReader(),
			new PhpFileCache(__DIR__ . '/cache')
		);

		foreach ( [ $this, ...array_values( $this->controllers ) ] as $instance ) {
			try {
				$reflection_class = new ReflectionClass( $instance );

				foreach ($reader->getClassAnnotations($reflection_class) as $annotation) {
					/** @var Base $annotation */
					$annotation->on_class($instance, $reflection_class);
				}

				foreach ( $reflection_class->getMethods() as $method ) {
					foreach ($reader->getMethodAnnotations( $method ) as $annotation) {
						/** @var Base $annotation */
						$annotation->on_method( $instance, $method );
					}
				}

				foreach ( $reflection_class->getProperties() as $property ) {
					foreach ($reader->getPropertyAnnotations($property) as $annotation) {
						/** @var Base $annotation */
						$annotation->on_property($instance, $property);
					}
				}
			} catch ( ReflectionException $e ) {
				// NO-OP; Class doesn't exist.
			}
		}

		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets', __FILE__ ) ) );
	}

	/**
	 * Enqueue styles for wp-admin
	 *
	 * @Action(hook="admin_enqueue_scripts")
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_admin_styles(): void {
	}

	/**
	 * Enqueue scripts for wp-admin
	 *
	 * @Action(hook="admin_enqueue_scripts")
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_admin_scripts(): void {
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html( 'Cloning ' . self::class . ' is forbidden' ), esc_attr( self::VERSION ) );
	}

	/**
	 * Deserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html( 'Deserializing ' . self::class . ' is forbidden' ), esc_attr( self::VERSION ) );
	}

	/**
	 * Get the instance of the plugin
	 *
	 * @since 1.0.0
	 * @return self
	 */
	public static function get_instance(): self {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Plugin::get_instance();
