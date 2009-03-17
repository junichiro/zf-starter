<?php
class E3_Mail extends Zend_Mail{

    private $_view;

    function __construct(){
        parent::__construct('ISO-2022-JP');
    }

    function setView($view) {
        $this->_view = $view;
    }

    function getView() {
        return $this->_view;
    }

    function setBodyText( $txt , $charset = null , $encoding = Zend_Mime::ENCODING_QUOTEDPRINTABLE ){
        parent::setBodyText( mb_convert_encoding($txt, 'ISO-2022-JP', mb_detect_encoding($txt)) , $charset , $encoding );
    }

    function setSubject( $txt ){
        parent::setSubject( mb_convert_encoding($txt, 'ISO-2022-JP', mb_detect_encoding($txt)) );
    }
}