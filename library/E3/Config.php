<?php
class E3_Config {

    protected $_root;
    protected $_env;

    function __construct($env){
        $this->_env = $env;
        $this->_root = realpath(dirname(__FILE__) . '/../../');
    }

    public function load($name) {
        $file = $this->_root. DIRECTORY_SEPARATOR
            . 'application' . DIRECTORY_SEPARATOR
            . 'configs'     . DIRECTORY_SEPARATOR
            . $name.'.ini';
        $config = new Zend_Config_Ini($file, $this->_env, false);
        return $config;
    }
}