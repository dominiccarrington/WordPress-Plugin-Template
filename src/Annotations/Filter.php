<?php
declare( strict_types=1 );

namespace Plugin\Annotations;

use ReflectionMethod;

/**
 * @Annotation
 */
final class Filter extends Action {

	/**
	 * Add filter on annotated method
	 *
	 * @param object           $instance Instance of the object containing the method.
	 * @param ReflectionMethod $method The method with the annotation.
	 *
	 * @return void
	 */
	public function on_method( object $instance, ReflectionMethod $method ) {
		/** @var callable */
		$callable = [ $instance, $method->getName() ];

		add_filter(
			$this->hook,
			$callable,
			$this->priority,
			$method->getNumberOfParameters()
		);
	}
}
