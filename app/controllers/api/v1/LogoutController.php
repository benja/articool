<?php
namespace Api\v1;

use Phalcon\Validation\Message;
use Phalcon\Validation\Message\Group as MessageGroup;

use \ControllerBase;
use \Sessions;

class LogoutController extends ControllerBase {

    public function logoutAction() {

        $auth = $this->checkAuth(1); // has to be registered to do this

        if($auth) {

            // find token from session or cookies
            $token = ($this->session->get('session_token') ?: $this->cookies->get('session_token'));
            
            // error array
            $messages = new MessageGroup;

            // if token doesn't exist
            if(!$token) {
                $messages->appendMessage( new Message('Token not found') );
                return $this->ajaxResponse(false, $messages, 'ajax');
            }

            // find session in db
            $sessions = Sessions::find([
                'conditions' => 'session_token = :session_token:',
                'bind'  =>  [
                    'session_token' => $token
                ]
            ]);

            // delete session
            foreach($sessions as $session) {
                $session->delete();
            }

            // remove cookies and session
            $this->cookies->delete('session_token');
            unset($_COOKIE['session_token']); //delete func doesn't remove from superglobal, so manually remove
            setcookie('session_token', '', time() - 3600); // incase unset doesn't work, set the cookie backwards in time, should be removed on page load
            $this->session->remove('session_token');

            return $this->ajaxResponse(true, ['Sucessfully logged out'], 'ajax');
        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');

    }

}