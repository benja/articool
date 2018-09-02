<?php
namespace Api\v1;
use Phalcon\Validation;

use Phalcon\Validation\Message;
use Phalcon\Security\Random;

use Phalcon\Validation\Validator\{PresenceOf, StringLength, Email, Alnum};

use \ControllerBase;
use \Sessions;
use \Users;

class ForgotController extends ControllerBase {

    public function forgotPasswordAction()
    {
        $validation = new Validation();

        // check if input is set
        $validation->add(['usernameoremail_address'], new PresenceOf([
            'message' => [
                'usernameoremail_address' => 'Enter your username or email-address'
            ]
        ]));

        // put errors in array
        $messages = $validation->validate($_POST);

        // set values sent from form to variables
        $usernameoremail_address = $this->request->getPost('usernameoremail_address');

        // find user
        $user = Users::findFirst([
            'conditions' => 'username = :value: OR email_address = :value:',
            'bind' => [
                'value' => $usernameoremail_address
            ]
        ]);

        // if user is not found
        if(empty($user) && count($messages) == 0) {
            $messages->appendMessage( new Message('The user was not found in our database') );
            $this->security->hash(rand());
        }

        // if no errors
        if(count($messages) == 0) {

            // generate token
            $token = bin2hex(openssl_random_pseudo_bytes(16));

            // save token to user
            $user->token = $token;
            $user->save();

            // send token mail to user
            $mail = $this->phpmailer;
            $mail->setFrom('no-reply@benjaminakar.com', $this->appName);
            $mail->addAddress($user->email_address, $user->first_name . ' ' . $user->last_name);
            $mail->isHTML(true);

            // get html template
            $resetpasswordtemplate = file_get_contents(APP_PATH . '/emails/resetpassword.html');
            $resetpasswordtemplate = str_replace('{first_name}', $user->first_name, $resetpasswordtemplate);
            $resetpasswordtemplate = str_replace('{last_name}', $user->last_name, $resetpasswordtemplate);
            $resetpasswordtemplate = str_replace('{appName}', $this->appName, $resetpasswordtemplate);
            $resetpasswordtemplate = str_replace('{appURL}', $this->appURL, $resetpasswordtemplate);
            $resetpasswordtemplate = str_replace('{token}', $token, $resetpasswordtemplate);

            $mail->Subject = 'Reset Password';
            $mail->Body = $resetpasswordtemplate;
            $mail->send();
            
            return $this->ajaxResponse(true, ['Instructions on how to reset your password have been sent to your email-address'], 'ajax', $user->toArray());

        }
        return $this->ajaxResponse(false, $messages, 'ajax');
    }

    public function setNewPasswordAction()
    {
        $validation = new Validation();

        // check if input is set
        $validation->add(['password', 'confirm_password'], new PresenceOf([
            'message' => [
                'password'         => 'Please enter a new password',
                'confirm_password' => 'Please confirm your new password'
            ]
        ]));

        // put errors in array
        $messages = $validation->validate($_POST);

        // set values sent from form to variables
    	$password = $this->request->getPost('password');
    	$confirm_password = $this->request->getPost('confirm_password');
        $token = $this->dispatcher->getParam('token');
        
        // find user by token
        $user = Users::findFirst([
            'conditions' => 'token = :token:',
            'bind' => [
                'token' => $token
            ]
        ]);

        // if user is not found
        if(empty($user) && count($messages) == 0) {
            $messages->appendMessage( new Message('The token is invalid, try requesting a new one') );
            $this->security->hash(rand());
        }

        // if passwords dont match
        if($password != $confirm_password) {
            $messages->appendMessage( new Message('The passwords do not match') );
        }

        // if no errors
        if(count($messages) == 0) {
            // set user's new password, remove token and update
            $user->password = $this->security->hash($password);
            $user->token = NULL;
            $user->update();

            // function from logincontroller (rememberme checked) to log user in
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

            return $this->ajaxResponse(true, ['Successfully updated password'], 'ajax', $user->toArray());
        }
        return $this->ajaxResponse(false, $messages, 'ajax');
    }

}