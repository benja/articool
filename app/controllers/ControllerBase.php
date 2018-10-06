<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Url;
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
        $this->assets->addCss("//use.fontawesome.com/releases/v5.3.1/css/all.css", false);


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
	public function isArticoolTrending(int $post_id)
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
                    return $this->response->redirect('explore'/*$this->request->getHTTPReferer()*/);
                }
                break;

            case 'user':
                if(empty($this->_user)) {
                    return $this->response->redirect('explore'/*$this->request->getHTTPReferer()*/);
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

    /*
    *   Get last 10 posts to display on index
    */
    public static function getLatestPosts(string $genre)
    {
        $posts = Posts::find([
            'conditions' => 'post_active = :post_active: AND post_genre = :post_genre:',
            'limit' => 10,
            'order' => 'created_at DESC',
            'bind' => [
                'post_active' => 1,
                'post_genre' => $genre
            ]
        ]);

        return $posts;
    }

    /*
    *   Get trending articools to display on index
    */
    public static function getTrendingPosts()
    {
        $posts = PostTrending::find([
            'order' => 'created_at DESC',
        ]);

        return $posts;
    }

    /*
    *   Get users that have rank 2 or higher
    */
    public static function getApprovedAuthors()
    {
        $users = Users::find([
            'conditions' => 'rank_id >= :rank_id: AND active = :active:',
            'bind' => [
                'rank_id' => 2,
                'active' => 1
            ]
        ]);

        

        return $users;
    }

    /*
    *   Get all user posts by id
    */
    public static function getUserPosts(int $user_id)
    {
        $user_id;
        $posts = Posts::find([
            'type'  => 'user_id',
            'order' => 'created_at DESC',
            'conditions' => 'user_id = :user_id: AND post_active = :post_active:',
            'bind' => [
                'user_id' => $user_id,
                'post_active' => 1
            ]
        ]);

        return $posts;
    }

    /*
    *   Get user total people reached
    */
    public static function getPeopleReached(int $user_id)
    {
        $user_id;
        $posts = Posts::find([
            'type'  => 'user_id',
            'order' => 'created_at DESC',
            'conditions' => 'user_id = :user_id: AND post_active = :post_active:',
            'bind' => [
                'user_id' => $user_id,
                'post_active' => 1
            ]
        ]);

        $postsviews = []; // create empty array
        foreach($posts as $post) { //push each post_views value into postviews array
            array_push($postsviews, $post->post_views);
        }

        $views = array_sum($postsviews); // sum up all values
        return $views;
    }

    /*
    *   Get all user popular posts by id
    */
    public static function getUserPopularPosts(int $user_id)
    {
        $user_id;
        $posts = Posts::find([
            'type'  => 'user_id',
            'order' => 'post_views DESC',
            'conditions' => 'user_id = :user_id: AND post_active = :post_active:',
            'bind' => [
                'user_id' => $user_id,
                'post_active' => 1
            ],
            'limit' => 10
        ]);

        return $posts;
    }

    /*
    *   Get user specific post by id
    */
    public static function getPost(int $post_id)
    {
        $post_id;
        $post = Posts::find([
            'type'  => 'user_id',
            'conditions' => 'post_id = ' . $post_id,
            'order' => 'created_at DESC'
        ]);
        
        return $post;
    }

    /*
    *   Get registered users
    */
    public static function getRegisteredUsers()
    {
        return Users::find();
    }

    /*
    *   Get articool data
    */
    public static function getArticoolData(int $post_id)
    {
        $post_id;
        $post = Posts::find([
            'type'  => 'user_id',
            'conditions' => 'post_id = ' . $post_id,
            'order' => 'created_at DESC'
        ]);
        
        return $post;
    }

    /*
    *   Get total read time for an articool
    */
    public static function getArticoolReadTime($post_id)
    {
        $post = Posts::findFirst($post_id);

        $text = str_word_count($post->post_body); // Get the text wordcount
        $wordperminute = 200; // Average words per minute for a slow reader
        $readtime = floor( ($text / $wordperminute) ); // Wordcount / average words per minute, then we round it down using floor.

        if($readtime == 0) {
            $readtime = "1"; // instead of saying 0 minute 
        }

        return $readtime;
    }

    /*
    *   Get articool authors and print
    */
    public static function printAuthorsHtml($post_id)
    {
        $url = new Url();
        $url->setBaseUri($_ENV['APP_DIR']);

        $author = Posts::findFirst($post_id);
        $contributor = PostAuthor::find([
            'conditions' => 'post_id = :post_id:',
            'limit' => 10,
            'order' => 'created_at DESC',
            'bind' => [
                'post_id' => $post_id
            ]
        ]);

        foreach($contributor as $helper) {
            $contributors[] = '<a href="'. $url->get('author/' . $helper->users->username) .'">' . $helper->users->first_name . " " . $helper->users->last_name .'</a>';
        }

        // get the last element in array, push in "and" before the last element, add an empty array before the front to add comma, authorlist is the list with all of the contributors
        $last_element = array_pop($contributors);
        array_push($contributors, 'and ' . $last_element);
        array_unshift($contributors, '');
        $authorlist = implode(', ', $contributors);

        return 'Written by <a href="'. $url->get('author/' . $author->users->username) .'">'. $author->users->first_name . " " . $author->users->last_name .'</a>' . $authorlist;
    }

    /*
    *   Get post authors in a string rather than with HTML output
    */
    public static function printAuthorsText($post_id)
    {
        $author = Posts::findFirst($post_id);
        $contributor = PostAuthor::find([
            'conditions' => 'post_id = :post_id:',
            'limit' => 10,
            'order' => 'created_at DESC',
            'bind' => [
                'post_id' => $post_id
            ]
        ]);

        foreach($contributor as $helper) {
            $contributors[] =  $helper->users->first_name . " " . $helper->users->last_name;
        }

        // get the last element in array, push in "and" before the last element, add an empty array before the front to add comma, authorlist is the list with all of the contributors
        $last_element = array_pop($contributors);
        array_push($contributors, 'and ' . $last_element);
        array_unshift($contributors, '');
        $authorlist = implode(', ', $contributors);

        return $author->users->first_name . " " . $author->users->last_name . "" . $authorlist;
    }

    /**
     * Put all authors connected to a post in an array
     */
    public static function printAuthorsId($post_id)
    {
        $post_id;
        $authors = PostAuthor::find([
            'type'  => 'user_id',
            'conditions' => 'post_id = ' . $post_id
        ]);
        return $authors;
    }

    /*
    *   Check if token exists for user
    */
    public static function findToken(string $token)
    {
        $token;
        $user = Users::findFirst([
            'conditions' => 'token = :token:',
            'bind' => [
                'token' => $token
            ]
        ]);
        return $user;
    }

    /*
    *   Get all written articools on the entire platform
    */
    public static function getWrittenArticools()
    {
        $posts = Posts::find([
            /*
            'conditions' => 'post_active = :post_active:',
            'bind' => [
                'post_active' => 1
            ]*/
        ]);

        return count($posts); // count all rows
    }


    /*
    *   Get all articool's views, put them into one array, and add them, return total
    */
    public static function getAllArticoolViews()
    {
        $posts = Posts::find();

        $postsviews = [];
        foreach($posts as $post) {
            array_push($postsviews, $post->post_views);
        }

        $views = number_format( array_sum($postsviews) );
        return $views;
    }

}


