<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        // Analytics on landing page
        $this->view->getAllArticoolViews = $this->getAllArticoolViews();
        $this->view->getWrittenArticools = $this->getWrittenArticools();
        $this->view->getRegisteredUsers  = count($this->getRegisteredUsers());

        $this->restrictAccess('guest'); // restrict access to guest only
    }

}

