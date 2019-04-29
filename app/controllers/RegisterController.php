<?php

class RegisterController extends ControllerBase
{
    
    public function indexAction()
    {
        // pass data to view
        $this->view->registeredUsers = count($this->getRegisteredUsers()); // getRegisteredUsers is an object containing all the registered users, so we need to get the count
    	$this->restrictAccess('guest'); // restrict access to guests only
    }
    
}

