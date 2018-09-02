<?php
namespace Api\v1;
use Phalcon\Validation;

use Phalcon\Validation\Message;
use Phalcon\Security\Random;

use Phalcon\Validation\Validator\{PresenceOf, StringLength, Email, Alnum};

use \ControllerBase;
use \Sessions;
use \Users;

class LoginController extends ControllerBase {

    public function loginAction()
    {
        $validation = new Validation();

        // check if input is set
        $validation->add(['usernameoremail_address', 'password'], new PresenceOf([
            'message' => [
                'usernameoremail_address' => 'Enter your username or email-address',
                'password' => 'Enter your password'
            ]
        ]));

        // put errors in array
        $messages = $validation->validate($_POST);
    
        // Set values sent from form to variables
        $usernameoremail_address = $this->request->getPost('usernameoremail_address');
        $password = $this->request->getPost('password');
        $remember_me = $this->request->getPost('remember_me');

        // find user
        $user = Users::findFirst([
            'conditions' => 'username = :value: OR email_address = :value:',
            'bind' => [
                'value' => $usernameoremail_address
            ]
        ]);

        // check if account is active
        if($user->active == 0 && !empty($user)) {
            $messages->appendMessage( new Message('This account has been deactivated, or deleted') );
        }

        // if user was not found
        if(empty($user) && count($messages) == 0) {
            $messages->appendMessage( new Message('The user was not found in our database') );
            $this->security->hash(rand());
        }

        // check if password matches
        if(!$this->security->checkHash($password, $user->password) && !empty($user)) {
            $messages->appendMessage( new Message('Password does not match with the registered credentials') );
        }

        // if no errors
        if(count($messages) == 0) {
            //if user checked remember me
            if($remember_me == "on") {
                // generate token
                $random = new Random();
                $bytes = $random->bytes();
                $session_token = $this->security->hash($bytes . $user->username);

                // generate identifier
                $hex = $random->hex(10);
                $session_identifier = $this->security->hash($hex . $user->username);

                // input data to database
                $session = new Sessions();
                $session->user_id = $user->user_id;
                $session->session_ip = $this->request->getClientAddress();
                $session->session_token = $session_token;
                $session->session_identifier = $session_identifier;
                $session->save();

                // set cookie with token so we can get user info
                $this->cookies->set('session_token', $session_token, time() + 3600 * 24 * 30);
            } else {
                // generate token
                $random = new Random();
                $bytes = $random->bytes();
                $session_token = $this->security->hash($bytes . $user->username);

                // generate identifier
                $hex = $random->hex(10);
                $session_identifier = $this->security->hash($hex . $user->username);

                // input data to database
                $session = new Sessions();
                $session->user_id = $user->user_id;
                $session->session_ip = $this->request->getClientAddress();
                $session->session_token = $session_token;
                $session->session_identifier = $session_identifier;
                $session->save();

                // set session with token so we can get user info
                $this->session->set('session_token', $session_token);
            }

            $this->checkLogin(); // UNSURE WHAT THIS DOES YET
            return $this->ajaxResponse(true, ['Successfully logged in'], 'ajax', $user->toArray());
        }
        return $this->ajaxResponse(false, $messages, 'ajax');
    }

}