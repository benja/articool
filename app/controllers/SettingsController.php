<?php

class SettingsController extends ControllerBase
{
    
    public function profileAction()
    {
        $this->restrictAccess('user');
    	$this->view->user = $this->_user;
    }

    public function securityAction()
    {
        $this->restrictAccess('user');
    	$this->view->user = $this->_user;
    }

}

