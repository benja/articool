<?php

class PostController extends ControllerBase
{

    public function postAction()
    {
        $post_id   = $this->dispatcher->getParam('post_id'); //define post_id from url

        // pass data to view
        $this->view->user                = $this->_user;
        $this->view->readTime            = $this->getArticoolReadTime($post_id);
        $this->view->isTrending          = $this->isArticoolTrending($post_id);
        $this->view->getArticoolData     = $this->getArticoolData($post_id);
        $this->view->printAuthorsHtml    = $this->printAuthorsHtml($post_id); // authors printed in html
        $this->view->printAuthorsText    = $this->printAuthorsText($post_id); // authors printed in text (title)

        $this->view->appName             = $_ENV['APP_NAME'];
        $this->view->appUrl              = $_ENV['APP_URL'];
        
        $this->addPostView($post_id); // Add 1+ view to 

        /* EDIT POST */
        $post = $this->getArticoolData($post_id); // get post data

        // pass data to view
        $this->view->printAuthorsId      = $this->printAuthorsId($post_id); // in edit articool
        $this->view->getRegisteredUsers  = $this->getRegisteredUsers();
    }

    public function deletePostAction()
    {
        $this->restrictAccess('user'); // restrict access to user only

        // if user is not moderator, don't give access to delete
        $rank_id    = $this->_user->rank_id; // 1 is user, 2 is approved, 3 is mod, 4 is admin
        if($rank_id < 3) {
            return $this->response->redirect($this->request->getHTTPReferer());
        }
    }

}

