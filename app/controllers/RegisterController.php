<?php

class RegisterController extends ControllerBase
{
    public function indexAction()
    {
    	$this->restrictAccess('guest');
    }
    
}

