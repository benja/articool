<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        // Analytics on landing page
        $this->view->allArticoolViews = $this->getAllArticoolViews();
        $this->view->writtenArticools = $this->getWrittenArticools();
        $this->view->registeredUsers  = count($this->getRegisteredUsers());
        
        $this->view->appName             = $_ENV['APP_NAME'];
        $this->view->appUrl              = $_ENV['APP_URL'];
        $this->view->appDescription      = $_ENV['APP_DESCRIPTION'];
        

        $this->restrictAccess('guest'); // restrict access to guest only
    }

}

