<?php

namespace alxmsl\Google;

// append autoloader
spl_autoload_register(array('\alxmsl\Google\Autoloader', 'autoload'));

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
        'alxmsl\\Google\\Autoloader'                    => 'Autoloader.php',
        'alxmsl\\Google\\InitializationInterface'       => 'InitializationInterface.php',
        'alxmsl\\Google\\OAuth2'                => 'OAuth2/Client.php',
        'alxmsl\\Google\\OAuth2\\WebServerApplication'  => 'OAuth2/WebServerApplication.php',
        'alxmsl\\Google\\OAuth2\\Response\\Token'       => 'OAuth2/Response/Token.php',
        'alxmsl\\Google\\OAuth2\\Response\\Error'       => 'OAuth2/Response/Error.php',
        'alxmsl\\Google\\Purchases\\Purchases'          => 'Purchases/Purchases.php',
        'alxmsl\\Google\\Purchases\\Response\\Resource' => 'Purchases/Response/Resource.php',
        'alxmsl\\Google\\Purchases\\Response\\Error'    => 'Purchases/Response/Error.php',
        'alxmsl\\Google\\GCM'                   => 'GCM/Client.php',
        'alxmsl\\Google\\GCM\\Exportable'               => 'GCM/Exportable.php',
        'alxmsl\\Google\\GCM\\Response\\Response'       => 'GCM/Response/Response.php',
        'alxmsl\\Google\\GCM\\Response\\Status'         => 'GCM/Response/Status.php',
        'alxmsl\\Google\\GCM\\Message\\PayloadData'     => 'GCM/Message/PayloadData.php',
        'alxmsl\\Google\\GCM\\Message\\PayloadMessage'  => 'GCM/Message/PayloadMessage.php',
        'alxmsl\\Google\\GCM\\Message\\SyncMessage'          => 'GCM/Message/SyncMessage.php',

        'alxmsl\\Google\\GCM\\Exception\\GCMException'          => 'GCM/Exception/GCMException.php',
        'alxmsl\\Google\\GCM\\Exception\\GCMFormatException'          => 'GCM/Exception/GCMFormatException.php',
        'alxmsl\\Google\\GCM\\Exception\\GCMUnauthorizedException'          => 'GCM/Exception/GCMUnauthorizedException.php',
        'alxmsl\\Google\\GCM\\Exception\\GCMUnrecoverableError'          => 'GCM/Exception/GCMUnrecoverableError.php',

        'alxmsl\\Google\\InAppPurchases\\InAppPurchases'     => 'InAppPurchases/InAppPurchases.php',
        'alxmsl\\Google\\InAppPurchases\\Response\\Resource' => 'InAppPurchases/Response/Resource.php',
        'alxmsl\\Google\\InAppPurchases\\Response\\Error'    => 'InAppPurchases/Response/Error.php',
    );

    /**
     * Component autoloader
     * @param string $className claass name
     */
    public static function autoload($className) {
        if (array_key_exists($className, self::$classes)) {
            $fileName = realpath(dirname(__FILE__)) . '/' . self::$classes[$className];
            if (file_exists($fileName)) {
                include $fileName;
            }
        }
    }
}
