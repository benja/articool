<?php

class ArticoolsController extends ControllerBase
{
    
    public function indexAction()
    {
    	// Pass user information to view
        $this->view->user               =  $this->_user;
        $this->view->getApprovedAuthors = $this->getApprovedAuthors();
        $this->view->getPosts           = $this->getLatestPosts();
        $this->view->getTrendingPosts   = $this->getTrendingPosts();
    }

}

