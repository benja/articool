<?php

class PostController extends ControllerBase
{

    public function postAction()
    {
        $post_id = $this->dispatcher->getParam('post_id'); //define post_id from url

        // pass data to view
        $this->view->user                = $this->_user;
        $this->view->readTime            = $this->getArticoolReadTime($post_id);
        $this->view->isTrending          = $this->isArticoolTrending($post_id);
        $this->view->getArticoolData     = $this->getArticoolData($post_id);
        $this->view->printAuthorsHtml    = $this->printAuthorsHtml($post_id); // authors printed in html
        $this->view->printAuthorsText    = $this->printAuthorsText($post_id); // authors printed in text (title)

        $this->view->appName             = $_ENV['APP_NAME'];
        $this->view->appUrl              = $_ENV['APP_URL'];
        
        $this->addPostView($post_id); // Add 1+ view to post_views
    }

    public function editPostAction()
    {
        $this->restrictAccess('user'); // restrict access to users
        $post_id = $this->dispatcher->getParam('post_id'); //define post_id
        $post = $this->getArticoolData($post_id); // get post data

        // variables to determine whether or not user should be allowed to edit
        $creator_id = $post[0]->users->user_id;
        $edit_id    = $this->_user->user_id;
        $rank_id    = $this->_user->rank_id; // 1 is user, 2 is approved, 3 is mod, 4 is admin

        // if editor is not creator and editor's rank is less than mod, don't let them edit
        if($edit_id !== $creator_id && $rank_id < 3) {
            return $this->response->redirect($this->request->getHTTPReferer());
        }

        // pass data to view
        $this->view->user                = $this->_user;
        $this->view->getArticoolData     = $this->getArticoolData($post_id);
        $this->view->printAuthorsId      = $this->printAuthorsId($post_id); // in edit articool
        $this->view->printAuthorsText    = $this->printAuthorsText($post_id); // for title
        $this->view->getRegisteredUsers  = $this->getRegisteredUsers();

        // if post is soft-deleted (not active) return editor back to previous page
        if($post[0]->post_active == 0) {
            return $this->response->redirect($this->request->getHTTPReferer());
        }
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

