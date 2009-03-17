<?php
class ErrorController extends Zend_Controller_Action {
    public function init() {
        $errors = $this->_getParam('error_handler');
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        $this->view->env       = $this->getInvokeArg('env');
        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
    }

    public function errorAction() {
        $this->view->assign('errortype', $this->_getParam('error_handler')->type);
    }
}
