<?php

namespace Google\Client;

// append autoloader
spl_autoload_register(array('\Google\Client\Autoloader', 'Autoloader'));

/**
 * Google Client classes autoloader
 * @author alxmsl
 * @date 1/13/13
 */ 
final class Autoloader {
    /**
     * @var array array of available classes
     */
    private static $classes = array(
        'Google\\Client\\Autoloader'        => 'Autoloader.php',
        'Google\\Client\\Client'            => 'Client.php',
        'Google\\Client\\WebServerClient'   => 'WebServerClient.php',
        'Google\\Client\\WebServerClientResponse' => 'WebServerClientResponse.php',
        'Google\\Client\\WebServerClientErrorResponse' => 'WebServerClientErrorResponse.php',
    );

    /**
     * Component autoloader
     * @param string $className claass name
     */
    public static function Autoloader($className) {
        if (array_key_exists($className, self::$classes)) {
            $fileName = realpath(dirname(__FILE__)) . '/' . self::$classes[$className];
            if (file_exists($fileName)) {
                include $fileName;
            }
        }
    }
}
