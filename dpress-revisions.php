<?php
/**
 * @package DPress
 */
/*
Plugin Name: DPress Revisions
Text Domain: dpress
*/

DPressAutoload("DPress\\Revisions\\", __DIR__.'/classes/');
/**
 * @return \DPress\Revisions\RevisionsAPI
 */
function Revisions() {
	static $instance;

	if (empty($instance)) {
		$instance = new \DPress\Revisions\RevisionsAPI();
	}

	return $instance;
}