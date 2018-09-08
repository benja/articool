<?php

class ArticoolsController extends ControllerBase
{
    
    public function indexAction()
    {
    	// Pass user information to view
        $this->view->user                =  $this->_user;
        $this->view->getApprovedAuthors  = $this->getApprovedAuthors();
        $this->view->getPosts            = $this->getLatestPosts();
        $this->view->getTrendingPosts    = $this->getTrendingPosts();
        
        $this->view->appName             = $_ENV['APP_NAME'];
        $this->view->appUrl              = $_ENV['APP_URL'];
        $this->view->appDescription      = $_ENV['APP_DESCRIPTION'];
    }

}

