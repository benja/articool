<?php

class SettingsController extends ControllerBase
{
    
    public function profileAction()
    {
        $this->restrictAccess('user'); // restrict access to user only
    	$this->view->user = $this->_user; // pass user information to view
    }

    public function securityAction()
    {
        $this->restrictAccess('user'); // restrict access to user only
    	$this->view->user = $this->_user; // pass user information to view
    }

}

