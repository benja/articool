<?php

class ProfileController extends ControllerBase
{

    public function getProfileAction()
    {
        if($this->_profile == NULL) {
            return $this->ajaxResponse(true, $errors, '');
        }

    	// Pass profile information to view
    	$this->view->profile =  $this->_profile;
    	$this->view->registered =  $this->_profile->created_at;
        $this->view->user =  $this->_user;

        $this->view->getUsers = Users::getUsers();
        $this->view->getPosts = Users::getPosts($this->_profile->user_id);

    }
}

