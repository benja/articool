<?php

use Phalcon\Mvc\Controller;
use Phalcon\Validation\Message\Group as MessageGroup;

class ControllerBase extends Controller
{
    protected $_user;
    protected $_profile;

    /*
    *   Function is always called once meaning the checkLogin() function is only called
    *   once, so I don't have to call it everytime I Wanna get info from _user
    */
    public function initialize()
    {
        $this->checkLogin();
        $this->getProfile();
        $this->deleteOldSessions();

        // CSS and Javascript files that are necessary
        $this->assets->addJs("//code.jquery.com/jquery-3.2.1.min.js", false);

        $this->assets->addCss("css/chosen.css");
        $this->assets->addCss("css/style.css");
        $this->assets->addCss("css/grid.css");
        $this->assets->addCss("//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css", false);
        $this->assets->addJs("js/libraries/chosen.js");
        $this->assets->addJs("ckeditor/build/ckeditor.js");

        // access user tokens on page
        if($this->_user) {
            $this->view->tokens = Users::getAuthTokens($this->_user->user_id);
        }
    }

    // Send auth along with API
    public function checkAuth($rank = false)
    {
        $auth = str_replace('Basic ', '', $this->request->getHeader('Authorization'));
        $decode = base64_decode($auth);
        $split = explode(':', $decode);

        $token = $split[1];
        $identifier = $split[0]; 

        $sessions = Sessions::findFirst([
            'conditions' => 'session_token = :session_token: AND session_identifier = :session_identifier:',
            'bind' => [
                'session_token' => $token,
                'session_identifier' => $identifier
            ]
        ]);

        if(!empty($sessions)) {
            if($sessions->users->rank_id < $rank) {
                return false;
            }
            return $sessions->users;
        }
        return false;
    }

	/*
	*	Check if post is trending
	*/
	public function isTrending(int $post_id)
	{

        $post = PostTrending::findFirst([
            'conditions' => 'post_id = :post_id:',
            'bind' => [
                'post_id' => $post_id,
            ]
        ]);
        
        if(isset($post) && $post != NULL) {
            return true;
        }
        return false;
	}

	/*
	*	Function to add one view to an article when viewed
	*/
	public function addPostView(int $post_id)
	{
        // Check if the cookie has previously set
        if (!$this->cookies->has('post_view_'.$post_id)) {
            $post = Posts::findFirst([
                'conditions' => 'post_id = :post_id:',
                'bind' => [
                    'post_id' => $post_id,
                ]
            ]);
            
            // If there's no post, return to home
            if(!$post) {
                return $this->response->redirect('');
            }

            $post->post_views++;
            $post->update();
            $this->cookies->set('post_view_'.$post_id, '1', time() + 3600 * 24 * 30 * 12);
        }
	}

    /*
    *   This function deletes sessions that are older than 30 days old
    *   made so old sessions that are not used are removed from the database
    */
    public function deleteOldSessions()
    {
        return false;
        $sessions = Sessions::find('created_at');
        foreach($sessions as $session) {
            $old = strtotime($session->created_at);
            $now = time();
            if((round(abs($now - $old) / 60,2)) > 43200) {
                $session->delete();
            }
        }
        

        /*
         *  Delete session if your account is deactivated
         */
         if($this->_user->active == 0) {

            $usersessions = Sessions::find([
                'conditions' => 'user_id = :user_id:',
                'bind' => [
                    'user_id' => $this->_user->user_id
                ]
             ]);

             $token = $this->cookies->has('session_token') ? $this->cookies->get('session_token') : $this->session->get('session_token', false);

             foreach($usersessions as $usersession) {
                $usersession->delete(); // delete every session from db
                $token->delete();
            }
        }
    }

    /*
    *   Function to get information from router param 'username' and search database
    *   to find information about the user so we can display it
    */
    public function getProfile()
    {
        // Grab the username from the URL parameter
        $username = $this->dispatcher->getParam('username');
        $profiles = Users::find([
            'conditions' => 'username = :username: AND active = :active:',
            'bind' => [
                'username' => $username,
                'active' => 1
            ]
        ]);
        
        if(!empty($profiles)) {
            foreach($profiles as $profile) {
                $this->_profile = $profile;
                $this->_profile->created_at = date('dS F Y', strtotime($this->_profile->created_at));
                break;
            }
        }
    }

    /*
    *   Function to restrict access to certain pages if you're logged in
    *   returns redirect back/false
    */
    public function restrictAccess(string $type)
    {

        switch ($type) {

            case 'guest':
                if(!empty($this->_user)) {
                    return $this->response->redirect('articools'/*$this->request->getHTTPReferer()*/);
                }
                break;

            case 'user':
                if(empty($this->_user)) {
                    return $this->response->redirect('articools'/*$this->request->getHTTPReferer()*/);
                }
                break;

            default:
                break;
        }
    }

    /*
    *   Function to check the session/cookie to fetch whether an account is logged in or not
    *   returns with data of user
    */
    public function checkLogin()
    {
        if(!isset($this->_user)) {
            $token = $this->cookies->has('session_token') ? $this->cookies->get('session_token') : $this->session->get('session_token', false);
            $sessions = Sessions::findBySessionToken($token);
            //check for session user_id

            foreach($sessions as $session) {
                $users = Users::findByUserId($session->user_id);
                foreach($users as $user) {
                    $this->_user = $user;
                    // This gets the created_at value and makes it look nicer, "14th August 2017" instead of "2017-08-14 00:29:10"
                    $this->_user->created_at = date('dS F Y', strtotime($this->_user->created_at));
                    break 2;
                }
            }
        }
        return $this->_user;
    }

    /*
    *   Function to send ajax-responses
    *   returns with errors
    */
    public function ajaxResponse(bool $success, $messages, string $url, array $data = [])
    {
        // Liam stuff
        $msgs = [];
        if(is_array($messages)) {
            $msgs = $messages;
        } else if($messages instanceof MessageGroup) {
            foreach($messages as $k => $m) {
                $msgs[$k] = $m->getMessage();
            }
        }

        if($this->request->isAjax() || $url == 'ajax') {
            $this->response->setContentType("application/json");
            $this->response->setContent(json_encode([
                'success' => $success,
                'messages' => $msgs,
                'data' => $data
            ]));
            $this->view->disable();
            return $this->response;
        } else {
            if($success == false) {
                foreach($msgs as $msg) {
                    $this->flash->error($msg);
                }
            } else {
                $this->flash->success("Everything went smoothly!");
            }
            $this->response->redirect($url);
        }
    }

}


