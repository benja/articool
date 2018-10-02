<?php
namespace Api\v1;

use Phalcon\Validation;
use Phalcon\Image\Factory;

use Phalcon\Validation\Message;

use Phalcon\Validation\Validator\{PresenceOf, StringLength, Email, Alnum, Alpha, Uniqueness as UniquenessValidator, File as FileValidator};

use \ControllerBase;
use \Users;

class SettingsController extends ControllerBase {

    public function removeAvatarAction()
    {
        $auth = $this->checkAuth(1); // has to be registered user to do this

        if($auth) {

            // find in trending, if trending
            $user = Users::findFirst([
                'conditions'    =>  'user_id = :user_id:',
                'bind'  => [
                    'user_id' => $auth->user_id
                ]
            ]);

            // delete from trending before we delete post
            if($user) {
                $user->avatar = 'default.jpg';
            }
            $user->save();

            $messages[] = 'Avatar successfully removed';
            return $this->ajaxResponse(true, $messages, 'ajax');

        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function profileSettingsAction()
    {
        $auth = $this->checkAuth(1); // user has to be registered

        if($auth) {

            $validation = new Validation();

            //validate if inputs are there
            $validation->add(['username', 'first_name', 'last_name', 'email_address', 'description'], new PresenceOf([
                'message' => [
                    'username'      => 'You cannot leave username blank',
                    'first_name'    => 'You cannot leave first name blank',
                    'last_name'     => 'You cannot leave last name blank',
                    'email_address' => 'You cannot leave email-address blank',
                    'description'   => 'You cannot leave description blank'
                ]
            ]));

            //validate lengths of input
            $validation->add(['username', 'first_name', 'last_name', 'email_address', 'description'], new StringLength([
                'max' => [
                    'username'      => 25,
                    'first_name'    => 25,
                    'last_name'     => 25,
                    'email_address' => 255,
                    'description'   => 255
                ],
                'messageMaximum' => [
                    'username'      => 'That username is too long',
                    'first_name'    => 'That first name is too long',
                    'last_name'     => 'That last name is too long',
                    'email_address' => 'That email-address is too long',
                    'description'   => 'That description is too long'
                ]
            ]));
            
            // check if email is valid (regex)
            $validation->add('email_address', new Email([
                'message'   =>  'Your email-address is not valid'
            ]));

            // verify username
            $validation->add('username', new Alnum([
                'message'   =>  'Username can only contain letters and numbers'
            ]));

            // validate first and last name
            $validation->add(['first_name', 'last_name'], new Alpha([
                'message'   =>  [
                    'first_name'    =>  'Your first name can only contain letters',
                    'last_name'     =>  'Your last name can only contain letters'
                ]
            ]));

            // get input from post request
            $username = $this->request->getPost('username');
            $first_name = $this->request->getPost('first_name');
            $last_name = $this->request->getPost('last_name');
            $email_address = $this->request->getPost('email_address');
            $avatar = $this->request->getPost('avatar');
            $description = strip_tags($this->request->getPost('description'));

            // check if username is taken by another user
            if($username != $auth->username) {
                $validation->add('username', new UniquenessValidator([
                    'model'     =>  new Users(),
                    'message'   =>  'Username already in use by another user'
                ]));
            }

            // check if email-address is taken by another user
            if($email_address != $auth->email_address) {
                $validation->add(['email_address'], new UniquenessValidator([
                    'model'     =>  new Users(),
                    'message'   =>  'Email-address already in use by another user'
                ]));
            }

            /*
            *   Validating the avatar uploaded
            */
            $filemessages = []; // define before
            if($this->request->hasFiles() == true) {
                $filevalidation = new Validation();
                $file = new \Phalcon\Validation\Validator\File([
                    'maxSize'      => '2M',
                    'messageSize'  => 'Your avatar is too big. Max file size :max',
                    'allowedTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'messageType'   => 'Allowed file types are JPEG, JPG, and PNG.',
                    //'maxResolution' => '1000x1000',
                    //'messageMaxResolution' => 'Max resolution of avatar is :max',
                ]);

                // then we add it to the validation list
                $filevalidation->add('avatar', $file);
                $filemessages = $filevalidation->validate($_FILES);
            }

            // put errors in array
            $messages = $validation->validate($_POST);
            $messages->appendMessages($filemessages); // append the filevalidation messages to main messages array

            // if user email_address is not set, user has not confirmed email
            if($auth->email_address == NULL) {
                $messages->appendMessage( new Message('You have to confirm your email-address before you can edit any settings') );
            }

            if(count($messages) == 0) {

                // if new email
                if($email_address !== $auth->email_address) {
                    // generate token
                    $token = bin2hex(openssl_random_pseudo_bytes(16));


                    //send email
					$mail = $this->phpmailer;
					$mail->setFrom('no-reply@benjaminakar.com', $this->appName);
					$mail->addAddress($email_address, $first_name . ' ' . $last_name);
					$mail->isHTML(true);

					// Get html template
					$newemailtemplate = file_get_contents(APP_PATH . '/emails/newemail.html');
					$newemailtemplate = str_replace('{first_name}', $first_name, $newemailtemplate);
					$newemailtemplate = str_replace('{last_name}', $last_name, $newemailtemplate);
					$newemailtemplate = str_replace('{appName}', $this->appName, $newemailtemplate);
					$newemailtemplate = str_replace('{appURL}', $this->appURL, $newemailtemplate);
					$newemailtemplate = str_replace('{token}', $token, $newemailtemplate);
					$newemailtemplate = str_replace('{old_email_address}', $auth->email_address, $newemailtemplate);
					$newemailtemplate = str_replace('{new_email_address}', $email_address, $newemailtemplate);

					$mail->Subject = 'Confirm email-address changes';
                    $mail->Body = $newemailtemplate;
					$mail->send();
                }

                $user = Users::findFirst([
                    'conditions' => 'user_id = :user_id:',
                    'bind'       => [
                        'user_id'  =>  $auth->user_id
                    ]
                ]);

                $user->username = $username;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->description = $description;
                $user->email_address = $auth->email_address;

                if($email_address !== $auth->email_address) {
                    $user->new_email_address = $email_address;
                    $user->token = $token;
                }

                // check if files are uploaded
                if($this->request->hasFiles() == true) {
                    foreach($this->request->getUploadedFiles() as $file) {
                        if($file->getSize() > 0) {

                            // unique new filename for user
                            $newfilename = hash('sha1', $file->getName() . $user->username) . '.jpg';

                            // Set user's avatar to filename in database
                            $user->avatar = $newfilename;
                            // Move the file to the application
                            $file->moveTo('img/avatars/' . $newfilename);

                            /* Changes to the image */
                            $image = new \Phalcon\Image\Adapter\Gd('img/avatars/' . $newfilename);
                            $image->resize(300, null, \Phalcon\Image::WIDTH);
                            $image->save('img/avatars/' . $newfilename, 80);
                        }
                    }
                }
                
                $user->save(); // finally save the changes
                return $this->ajaxResponse(true, ['Profile settings updated'], 'ajax', $user->toArray());
            }
            return $this->ajaxResponse(false, $messages, 'ajax');

        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

    public function securitySettingsAction()
    {
        $auth = $this->checkAuth(1); // user has to be registered

        if($auth) {

            $validation = new Validation();

            // check if inputs are there
            $validation->add(['old_password', 'new_password', 'repeat_newpassword'], new PresenceOf([
                'message' => [
                    'old_password'       => 'Please enter your old password',
                    'new_password'       => 'Please enter a new password',
                    'repeat_newpassword' => 'Please repeat your new password'
                ]
            ]));

            // put errors into array
            $messages = $validation->validate($_POST);

            // Get form values and set them to variables
            $old_password = $this->request->getPost('old_password');
            $new_password = $this->request->getPost('new_password');
            $repeat_newpassword = $this->request->getPost('repeat_newpassword');

            // if new password do not match with repeat new password
            if($new_password != $repeat_newpassword) {
                $messages->appendMessage( new Message('New password and repeat password do not match') );
            }

            // if old password is set, but does not match with user password
            if(isset($old_password) && !empty($old_password)) {
                if(!$this->security->checkHash($old_password, $auth->password)) {
                    $messages->appendMessage( new Message('Old password was incorrect') );
                }
            }

            if(count($messages) == 0) {
                //get user info
                $user = Users::findFirst([
                    'conditions' => 'user_id = :user_id:',
                    'bind'       => [
                        'user_id'  =>  $auth->user_id
                    ]
                ]);
                
                // hash new password and update
                $user->password = $this->security->hash($new_password);
                $user->save();

				// send email
				$mail = $this->phpmailer;
				$mail->setFrom('no-reply@benjaminakar.com', $this->appName);
				$mail->addAddress($auth->email_address, $auth->first_name . ' ' . $auth->last_name);
				$mail->isHTML(true);

				// get html template
				$newpasswordtemplate = file_get_contents(APP_PATH . '/emails/newpassword.html');
				$newpasswordtemplate = str_replace('{first_name}', $auth->first_name, $newpasswordtemplate);
				$newpasswordtemplate = str_replace('{last_name}', $auth->last_name, $newpasswordtemplate);
				$newpasswordtemplate = str_replace('{appName}', $this->appName, $newpasswordtemplate);
				$newpasswordtemplate = str_replace('{appURL}', $this->appURL, $newpasswordtemplate);

				$mail->Subject = 'Your password has been changed.';
				$mail->Body = $newpasswordtemplate;
                $mail->send();
                
                return $this->ajaxResponse(true, ['Security settings updated'], 'ajax');
            }
            return $this->ajaxResponse(false, $messages, 'ajax');
            
        }
        return $this->ajaxResponse($auth, ['No authorization'], 'ajax');
    }

}