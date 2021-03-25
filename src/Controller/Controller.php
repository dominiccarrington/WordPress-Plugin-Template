<?php
declare( strict_types=1 );

namespace PluginNamespace\Controller;

use PluginTemplate;

/**
 * Parent class for all controllers
 */
abstract class Controller {
	/**
	 * The main plugin instance
	 *
	 * @var PluginTemplate
	 */
	private PluginTemplate $plugin;

	/**
	 * @param PluginTemplate $plugin The main plugin instance.
	 */
	public function __construct( PluginTemplate $plugin ) {
		$this->plugin = $plugin;
	}
}
