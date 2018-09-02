<?php

class LoginController extends ControllerBase
{

    public function indexAction()
    {
    	$this->restrictAccess('guest');
    }

}

