<?php

class RegisterController extends ControllerBase
{
    
    public function indexAction()
    {
    	$this->restrictAccess('guest'); // restrict access to guests only
    }
    
}

