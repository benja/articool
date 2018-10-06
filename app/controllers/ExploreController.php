<?php

class ExploreController extends ControllerBase
{
    
    public function indexAction()
    {
    	// Pass user information to view
        $this->view->user                = $this->_user;
        $this->view->getApprovedAuthors  = $this->getApprovedAuthors();
        $this->view->getTrendingPosts    = $this->getTrendingPosts();

        // Get post by genre
        $this->view->getAnalysisPosts       = $this->getLatestPosts("Analysis");
        $this->view->getAutobiographyPosts  = $this->getLatestPosts("Autobiography");
        $this->view->getBiographyPosts      = $this->getLatestPosts("Biography");
        $this->view->getChroniclePosts      = $this->getLatestPosts("Chronicle");
        $this->view->getEssayPosts          = $this->getLatestPosts("Essay");
        $this->view->getFictionPosts        = $this->getLatestPosts("Fiction");
        $this->view->getNonFictionPosts     = $this->getLatestPosts("Non-Fiction");
        $this->view->getPoetryPosts         = $this->getLatestPosts("Poetry");
        $this->view->getPopularSciencePosts = $this->getLatestPosts("Popular-Science");
        $this->view->getShortStoryPosts     = $this->getLatestPosts("Short-Story");
        
        $this->view->appName             = $_ENV['APP_NAME'];
        $this->view->appUrl              = $_ENV['APP_URL'];
        $this->view->appDescription      = $_ENV['APP_DESCRIPTION'];
    }

}

