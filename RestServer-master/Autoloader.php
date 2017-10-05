<?php
/**
 *  Class for autoloading classes
 */
class Autoloader
{
    
	/**
	 *  convert namespace to full file path
	 * @param  STRING $class string of namespace
	 * 
	 */
    public static function loadPackages($class)
    {
		$class = '' . str_replace('\\', '/', $class) . '.php';
		require_once($class);
	
    }
}