<?php

class SettingsController extends ControllerBase
{
    
    public function profileAction()
    {
        $this->restrictAccess('user'); // restrict access to user only
        $this->view->user = $this->_user; // pass user information to view

        // extra data
        if($this->_user) {
            $this->view->getPeopleReached  = $this->getPeopleReached($this->_user->user_id);
        }
    }

    public function securityAction()
    {
        $this->restrictAccess('user'); // restrict access to user only
        $this->view->user = $this->_user; // pass user information to view

        // extra data
        if($this->_user) {
            $this->view->getPeopleReached  = $this->getPeopleReached($this->_user->user_id);
        }
    }

    public function extensionAction()
    {
        $this->restrictAccess('user'); // restrict access to user only
        $this->view->user = $this->_user; // pass user information to view

        // extra data
        if($this->_user) {
            $this->view->getPeopleReached  = $this->getPeopleReached($this->_user->user_id);
        
            if($this->getPeopleReached($this->_user->user_id) <= 1000) {
                return $this->response->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

}

