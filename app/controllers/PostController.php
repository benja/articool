<?php

class PostController extends ControllerBase
{
    
    // Post page
    public function postAction()
    {
        // Pass profile information to view
        $this->view->user =  $this->_user;
        $this->view->getPost = Users::getPost($this->dispatcher->getParam('post_id'));
        $this->view->isTrending = $this->isTrending($this->dispatcher->getParam('post_id'));
        $this->view->readTime = Posts::getPostReadTime($this->dispatcher->getParam('post_id'));
        $this->view->postAuthors = Posts::getPostAuthors($this->dispatcher->getParam('post_id'));
        $this->view->postAuthorsTitle = Posts::getPostAuthorsTitle($this->dispatcher->getParam('post_id'));
        

        // Add 1+ view to post_views
        $this->addPostView($this->dispatcher->getParam('post_id'));
    }

    public function editPostAction()
    {
        // Restrict guests from viewing this page
        $this->restrictAccess('user');
        $this->view->getUsers = Users::getUsers();
        $post = Users::getPost($this->dispatcher->getParam('post_id'));
        
        // variables for allow edit
        $creator_id = $post[0]->users->user_id;
        $edit_id = $this->_user->user_id;
        $rank_id = $this->_user->rank_id; //3 or higher is mod+admin

        // if editor is not creator AND editor's rank is less than mod
        if($edit_id !== $creator_id && $rank_id < 3) {
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        // Pass profile information to view
        $this->view->user =  $this->_user;
        $this->view->getPost = Users::getPost($this->dispatcher->getParam('post_id'));
        $this->view->getAuthors = Users::getAuthors($this->dispatcher->getParam('post_id'));
        $this->view->postAuthorsTitle = Posts::getPostAuthorsTitle($this->dispatcher->getParam('post_id'));

        if($post[0]->post_active == 0) {
            return $this->response->redirect($this->request->getHTTPReferer());
        }
    }

    public function deletePostAction()
    {
        // Restrict guests from viewing this page
        $this->restrictAccess('user');
        $post = Users::getPost($this->dispatcher->getParam('post_id'));

        // If user's rank is under moderator, restrict access
        if($this->_user->rank_id < 3) {
            return $this->response->redirect($this->request->getHTTPReferer());
        }
    }

}

