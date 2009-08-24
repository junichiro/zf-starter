<?php
/**
 * My new Zend Framework project
 *
 * @author
 * @version
 */
set_include_path(
                 '.' . PATH_SEPARATOR
                 . '../library/'. PATH_SEPARATOR
                 . '../application/default/models/'. PATH_SEPARATOR
                 . '../application/api/models/'    . PATH_SEPARATOR
                 . '../application/api/services/'  . PATH_SEPARATOR
                 . get_include_path()
);

require_once 'Initializer.php';
require_once('Zend/Version.php');

// Set up autoload.
if(Zend_Version::compareVersion('1.8.0') <= 0) {
    require_once 'Zend/Loader/Autoloader.php';
    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->setFallbackAutoloader(true);
}
else {
    require_once('Zend/Loader.php');
    Zend_Loader::registerAutoload();
}

// Prepare the front controller.
$frontController = Zend_Controller_Front::getInstance();

// Change to 'production' parameter under production environemtn
$frontController->registerPlugin(new Initializer('development'));

// Dispatch the request using the front controller.
$frontController->dispatch();
?>
