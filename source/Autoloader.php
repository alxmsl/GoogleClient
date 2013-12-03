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
        'Google\\Client\\Autoloader'                    => 'Autoloader.php',
        'Google\\Client\\InitializationInterface'       => 'InitializationInterface.php',
        'Google\\Client\\OAuth2\\Client'                => 'OAuth2/Client.php',
        'Google\\Client\\OAuth2\\WebServerApplication'  => 'OAuth2/WebServerApplication.php',
        'Google\\Client\\OAuth2\\Response\\Token'       => 'OAuth2/Response/Token.php',
        'Google\\Client\\OAuth2\\Response\\Error'       => 'OAuth2/Response/Error.php',
        'Google\\Client\\Purchases\\Purchases'          => 'Purchases/Purchases.php',
        'Google\\Client\\Purchases\\Response\\Resource' => 'Purchases/Response/Resource.php',
        'Google\\Client\\Purchases\\Response\\Error'    => 'Purchases/Response/Error.php',
        'Google\\Client\\GCM\\Client'                   => 'GCM/Client.php',
        'Google\\Client\\GCM\\Exportable'               => 'GCM/Exportable.php',
        'Google\\Client\\GCM\\Response\\Response'       => 'GCM/Response/Response.php',
        'Google\\Client\\GCM\\Response\\Status'         => 'GCM/Response/Status.php',
        'Google\\Client\\GCM\\Message\\PayloadData'     => 'GCM/Message/PayloadData.php',
        'Google\\Client\\GCM\\Message\\PayloadMessage'  => 'GCM/Message/PayloadMessage.php',
        'Google\\Client\\GCM\\Message\\SyncMessage'     => 'GCM/Message/SyncMessage.php',
        'Google\\Client\\InAppPurchases\\InAppPurchases'     => 'InAppPurchases/InAppPurchases.php',
        'Google\\Client\\InAppPurchases\\Response\\Resource' => 'InAppPurchases/Response/Resource.php',
        'Google\\Client\\InAppPurchases\\Response\\Error'    => 'InAppPurchases/Response/Error.php',
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
