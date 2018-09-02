<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        // Restrict users from viewing this page
        $this->restrictAccess('guest');
    }

}

