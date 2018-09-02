<?php

class ForgotController extends ControllerBase
{

    public function indexAction()
    {
    	$this->restrictAccess('guest');
    }

    public function resetPasswordAction()
    {
        
        // If the token isn't valid, send then back to the forgotpassword page
        $token = Users::findToken( $this->dispatcher->getParam('token') );
        if($token == NULL) {
            return $this->response->redirect('forgot');
        }
        
    }

}

