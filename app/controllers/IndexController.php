<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        // Analytics on landing page
        $this->view->getAllArticoolViews = $this->getAllArticoolViews();
        $this->view->getWrittenArticools = $this->getWrittenArticools();
        $this->view->getRegisteredUsers  = count($this->getRegisteredUsers());
        
        $this->view->appName             = $_ENV['APP_NAME'];
        $this->view->appUrl              = $_ENV['APP_URL'];
        $this->view->appDescription      = $_ENV['APP_DESCRIPTION'];
        

        $this->restrictAccess('guest'); // restrict access to guest only
    }

}

