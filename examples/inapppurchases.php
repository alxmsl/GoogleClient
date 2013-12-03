<?php
/**
 *
 * @author alxmsl
 * @date 1/24/13
 */

include '../source/Autoloader.php';
include '../lib/Network/source/Autoloader.php';

// Check subscription
const   PACKAGE_NAME    = 'com.myapp',
        PRODUCT         = 'myapp.product.1',
        INAPP           = 'my inapp token';

$shortOptions = 't::';
$longOptions = array(
    'token::',
);
$options = getopt($shortOptions, $longOptions);
$token = null;
if (isset($options['t'])) {
    $token = $options['t'];
} else if (isset($options['token'])) {
    $token = $options['token'];
}

if (!is_null($token)) {
    $Purchases = new \Google\Client\InAppPurchases\InAppPurchases();
    $Purchases->setPackage(PACKAGE_NAME)
        ->setAccessToken($token);
    $Resource = $Purchases->get(PRODUCT, INAPP);
    var_dump($Resource);
} else {
    die ('required parameter \'token\' not present' . "\n");
}