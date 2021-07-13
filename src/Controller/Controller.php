<?php
declare( strict_types=1 );

namespace Plugin\Controller;

use Plugin;

/**
 * Parent class for all controllers
 */
abstract class Controller {
	/**
	 * The main plugin instance
	 *
	 * @var Plugin
	 */
	private Plugin $plugin;

	/**
	 * @param Plugin $plugin The main plugin instance.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}
}
