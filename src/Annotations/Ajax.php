<?php
declare( strict_types=1 );

namespace PluginNamespace\Annotations;

use ReflectionMethod;

/**
 * @Annotation
 * @Target({"METHOD"})
 * @since 1.0.0
 */
final class Ajax extends Action {
	/**
	 * Whether the ajax request can be accessed via a logged in user
	 *
	 * @var bool
	 */
	public bool $logged_in = false;

	/**
	 * Whether the ajax request can be access via a guest user
	 *
	 * @var bool
	 */
	public bool $guest = false;

	/**
	 * Add action to perform the ajax request
	 *
	 * @param object           $instance Instance of the object containing the method.
	 * @param ReflectionMethod $method The method with the annotation.
	 *
	 * @return void
	 */
	public function on_method( object $instance, ReflectionMethod $method ) {
		if ( is_admin() ) {
			/** @var callable */
			$callable = [ $instance, $method->getName() ];

			if ( $this->logged_in ) {
				add_action(
					'wp_ajax_' . $this->hook,
					$callable,
					$this->priority,
					$method->getNumberOfParameters()
				);
			}

			if ( $this->guest ) {
				add_action(
					'wp_ajax_nopriv_' . $this->hook,
					$callable,
					$this->priority,
					$method->getNumberOfParameters()
				);
			}
		}
	}
}
