<?php

class ForgotController extends ControllerBase
{

    public function indexAction()
    {
    	$this->restrictAccess('guest'); // restrict access to guest only
    }

    public function resetPasswordAction()
    {
        // check if token exists
        $token = $this->findToken( $this->dispatcher->getParam('token') );

        // if token doesn't exist, return forgot page
        if($token == NULL) {
            return $this->response->redirect('forgot');
        }
    }

}

