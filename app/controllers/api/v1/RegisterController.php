<?php

namespace Api\v1;
use Phalcon\Validation;

use Phalcon\Validation\Message;
use Phalcon\Validation\Message\Group as MessageGroup;
use Phalcon\Security\Random;

use Phalcon\Validation\Validator\{PresenceOf, StringLength, Email, Alnum, Alpha, Uniqueness as UniquenessValidator};

use \ControllerBase;
use \Sessions;
use \Users;

class RegisterController extends ControllerBase {

    public function registerAction()
    {
        $validation = new Validation();

        // check if inputs exist
        $validation->add(['username', 'first_name', 'last_name', 'email_address', 'password'], new PresenceOf([
            'message' => [
                'username'      => 'Enter a username',
                'first_name'    => 'Enter your first name',
                'last_name'     => 'Enter your last name',
                'email_address' => 'Enter your email-address',
                'password'      => 'Enter a password',
                'accepttos'     => 'You have to accept the ToS and Privacy Policy to create an account'
            ]
        ]));

        // validate email
        $validation->add('email_address', new Email([
            'message' => 'Your email-address is not valid'
        ]));

        // validate username
        $validation->add('username', new Alnum([
            'message' => 'Username can only contain letters and numbers'
        ]));

        // validate first and last name
        $validation->add(['first_name', 'last_name'], new Alpha([
            'message' => 'Your first and last name can only contain letters'
        ]));

        // validate length of inputs
        $validation->add(['username', 'first_name', 'last_name', 'email_address'], new StringLength([
            'max' => [
                'username'      => 25,
                'first_name'    => 25,
                'last_name'     => 25,
                'email_address' => 255
            ],
            'messageMaximum' => [
                'username'      => 'That username is too long',
                'first_name'    => 'That first name is too long',
                'last_name'     => 'That last name is too long',
                'email_address' => 'That email-address is too long'
            ]
        ]));

        // unique check username
        $validation->add('username', new UniquenessValidator([
            'model' =>  new Users(),
            'message' => 'That username is already in use'
        ]));

        // unique check email
        $validation->add('email_address', new UniquenessValidator([
            'model' => new Users(),
            'message' => 'That email-address is already in use'
        ]));

        // put errors into array
        $messages = $validation->validate($_POST);

        // Get form values and set them to variables
        $username = $this->request->getPost('username');
        $first_name = $this->request->getPost('first_name');
        $last_name = $this->request->getPost('last_name');
        $email_address = $this->request->getPost('email_address');
        $password = $this->request->getPost('password');
        $accepttos = $this->request->getPost('accepttos');
        $captcha = $this->request->getPost('captcha');

        
        // If captcha wasn't validated - source: https://www.bleuken.com/php-demo-using-google-recaptcha-v2-0-sample-php-code/
        $ip = $_SERVER['REMOTE_ADDR'];		
        $secretkey = $_ENV['RECAPTCHA_SECRET_KEY'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response, true);
        
        if(intval($responseKeys["success"]) !== 1) {
            $messages->appendMessage( new Message('Captcha was not validated, refresh and try again'));
            return $this->ajaxResponse(false, $messages, 'ajax');
        }

        // if user has not accepted tos
        if($accepttos == "false") {
            $messages->appendMessage( new Message('You have to accept the ToS and Privacy Policy to register'));
            return $this->ajaxResponse(false, $messages, 'ajax');
        }

        // register allowed
        $registerAllowed = 1;

        // if registering not allowed
        if($registerAllowed == 0) {
            $messages->appendMessage( new Message('Sorry, registering is closed at this time'));
            return $this->ajaxResponse(false, $messages, 'ajax');
        }

        if(count($messages) == 0) {
            //generate token
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            
            // new user
            $user = new Users();
            $user->username = $username;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->new_email_address = $email_address;
            $user->password = $this->security->hash($password);
            $user->token = $token;
            $user->save();

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

            // send welcome mail to user
            $mail = $this->phpmailer;
            $mail->setFrom('no-reply@benjaminakar.com', $this->appName);
            $mail->addAddress($email_address, $first_name . ' ' . $last_name);
            $mail->isHTML(true);

            // get html template
            $registertemplate = file_get_contents(APP_PATH . '/emails/register.html');
            $registertemplate = str_replace('{first_name}', $first_name, $registertemplate);
            $registertemplate = str_replace('{last_name}', $last_name, $registertemplate);
            $registertemplate = str_replace('{appName}', $this->appName, $registertemplate);
            $registertemplate = str_replace('{appURL}', $this->appURL, $registertemplate);
            $registertemplate = str_replace('{token}', $token, $registertemplate);

            $mail->Subject = 'Welcome';
            $mail->Body = $registertemplate;
            $mail->send();
            
            /*
            *   After we send a mail, we also notify that a user has signed up on Slack
            */
            $client = new \Maknz\Slack\Client($_ENV['SLACK_WEBHOOK_URL']);
            $client->attach([
                'color' => 'good',
                'fields' => [
                    [
                        'title' => 'Email',
                        'value' => $email_address,
                        'short' => true
                    ],
                    [
                        'title' => 'Username',
                        'value' => $username,
                        'short' => true
                    ]
                ]
            ])->send('A new user has signed up! :tada:');

            return $this->ajaxResponse(true, ['Successfully registered account, check your email to confirm your email-address.'], 'ajax', $user->toArray());
        }
        return $this->ajaxResponse(false, $messages, 'ajax');
    }

    public function confirmEmailAction()
    {
        // error array
        $messages = new MessageGroup;

        // get token from dispatcher
        $token = $this->dispatcher->getParam('token');

        // find user by token
        $user = Users::findFirst([
            'conditions' => 'token = :token:',
            'bind' => [
                'token' => $token
            ]
        ]);

        // if token is not found
        if(empty($user)) {
            $messages->appendMessage( new Message('The token is invalid') );
            $this->security->hash(rand());

            // redirect user to homepage instead of displaying error message
            return $this->response->redirect('');
        }

        if(count($messages) == 0) {
            // confirm email
            $user->email_address = $user->new_email_address;
            $user->new_email_address = NULL;
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
            
            return $this->ajaxResponse(true, ['Successfully confirmed email-address'], '/', $user->toArray());
        }
        return $this->ajaxResponse(false, $messages, 'ajax');
    }

    public function cookieAcceptAction()
    {
        // if cookie isn't already set & redirect back
        if(!$this->cookies->has('cookie_accept')) {
            $this->cookies->set('cookie_accept', 'User has accepted cookie policy.', time() + 3600 * 24 * 30 * 12);
        }
        return $this->response->redirect($this->request->getHTTPReferer());
    }
}