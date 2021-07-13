<?php
declare( strict_types=1 );

namespace Plugin\Annotations;

use ReflectionMethod;

/**
 * Annotation to add a method to the activation action
 *
 * @Annotation
 * @Target({"METHOD"})
 */
final class Activation extends Base {

	/**
	 * Add the annotated method to the activation hook for this function
	 *
	 * @param object            $instance Instance of the object containing the method.
	 * @param ReflectionMethod $method The method with the annotation.
	 *
	 * @return void
	 */
	public function on_method( object $instance, ReflectionMethod $method ) {
		/** @var callable */
		$callable = [ $instance, $method->getName() ];
		$file = $method->getFileName();

		if ( $file ) {
			register_activation_hook( $file, $callable );
		}
	}
}
