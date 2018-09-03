<?php

class LoginController extends ControllerBase
{
    
    public function indexAction()
    {
    	$this->restrictAccess('guest'); // restrict access to guest only
    }

}