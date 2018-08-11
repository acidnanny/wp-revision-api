<?php
/**
 * @package DPress
 */
/*
Plugin Name: DPress Revisions
Text Domain: dpress
*/

spl_autoload_register(function($class) {
	$namespace = 'DPress\\Revisions\\';
	$path = __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR;

	if (substr($class, 0, strlen($namespace)) != $namespace)
		return false;

	$rel = substr($class, strlen($namespace));
	$rel = strtolower(strtr($rel, array('\\' => DIRECTORY_SEPARATOR))).'.php';
	$path = $path.$rel;
	if (!file_exists($path))
		return false;

	require_once($path);
	return true;
});

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