<?php

class ProfileController extends ControllerBase
{

    public function getProfileAction()
    {
        // if profile doesn't exist, return index
        if($this->_profile == NULL) {
            return $this->response->redirect('');
        }

    	// pass data to view
        $this->view->user               = $this->_user;
        $this->view->profile            = $this->_profile;
        $this->view->getRegisteredUsers = $this->getRegisteredUsers();
        $this->view->getUserPosts       = $this->getUserPosts($this->_profile->user_id);

    }
}

