<?php
class Zend_View_Helper_Dummy extends Zend_View_Helper_Abstract {
    public $view;
    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }

    public function dummy($str) {
        return $str;
    }
}