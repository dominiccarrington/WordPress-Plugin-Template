<?php
declare( strict_types=1 );

namespace Plugin\Annotations;

use ReflectionMethod;

/**
 * Annotation to define a hook into an action
 *
 * @Annotation
 * @Target({"METHOD"})
 * @since 1.0.0
 */
class Action extends Base {
	/**
	 * Hook's name which the method that the annotation is defined against will be hooked into
	 *
	 * @var string
	 */
	public string $hook;

	/**
	 * The priority which the method will be hooked into.
	 * Default is 10, larger is fired first
	 *
	 * @var integer
	 */
	public int $priority = 10;

	/**
	 * Hook the method to the action
	 *
	 * @param object            $instance Instance of the object containing the method.
	 * @param ReflectionMethod $method The method with the annotation.
	 *
	 * @return void
	 */
	public function on_method( object $instance, ReflectionMethod $method ) {
		/** @var callable */
		$callable = [ $instance, $method->getName() ];

		add_action( $this->hook, $callable, $this->priority, $method->getNumberOfParameters() );
	}
}
