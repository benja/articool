<?php

use \ControllerBase;
use \Users;
use \Posts;
use \PostTrending;

class ArticoolsController extends ControllerBase
{

    public function indexAction()
    {
    	// Pass user information to view
        $this->view->user =  $this->_user;
        $this->view->getApprovedAuthors = Users::getApprovedAuthors();
        $this->view->getPosts = Posts::getPosts();
        $this->view->getTrendingPosts = PostTrending::getPosts();
    }

}

