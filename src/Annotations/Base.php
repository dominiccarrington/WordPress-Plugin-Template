<?php
declare( strict_types=1 );

namespace Plugin\Annotations;

use ReflectionClass;
use ReflectionMethod;
use RuntimeException;
use ReflectionProperty;
use PluginNamespace\Controller\Controller;

/**
 * Base class for all annotations
 */
abstract class Base {

	/**
	 * Run on an annotated class
	 *
	 * @param Plugin|Controller           $instance Instance of the object containing the method.
	 * @param ReflectionClass<Controller> $class The class with the annotation.
	 *
	 * @throws RuntimeException When method is called but not defined by the child class.
	 *
	 * @return void
	 */
	public function on_class( object $instance, ReflectionClass $class ) {
		throw new RuntimeException( 'No action defined on annotation on class' );
	}

	/**
	 * Run on an annotated method
	 *
	 * @param Plugin|Controller  $instance Instance of the object containing the method.
	 * @param ReflectionMethod   $method The method with the annotation.
	 *
	 * @throws RuntimeException When method is called but not defined by the child class.
	 *
	 * @return void
	 */
	public function on_method( object $instance, ReflectionMethod $method ) {
		throw new RuntimeException( 'No action defined on annotation on method' );
	}

	/**
	 * Run on an annotated property
	 *
	 * @param Plugin|Controller  $instance Instance of the object containing the method.
	 * @param ReflectionProperty $property The property with the annotation.
	 *
	 * @throws RuntimeException When method is called but not defined by the child class.
	 *
	 * @return void
	 */
	public function on_property( object $instance, ReflectionProperty $property ) {
		throw new RuntimeException( 'No action defined on annotation on property' );
	}
}
